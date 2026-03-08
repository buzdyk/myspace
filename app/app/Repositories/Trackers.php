<?php

namespace App\Repositories;

use App\Enums\TrackerStatus;
use App\Enums\TrackerType;
use App\Interfaces\TimeTracker;
use App\Models\Tracker;
use App\Trackers\Clockify;
use App\Trackers\Everhour;
use App\Trackers\Mayven;
use App\Trackers\Placeholder;
use App\Types\ProjectTimes;
use Carbon\Carbon;
use GuzzleHttp\Promise\Utils;
use Illuminate\Support\Collection;

class Trackers
{
    protected Collection $trackers;

    public function __construct()
    {
        $this->trackers = new Collection();
        $this->hydrate();
    }

    public function hydrate(): void
    {
        // Load active trackers from database
        $dbTrackers = Tracker::where('status', TrackerStatus::Active)->get();

        foreach ($dbTrackers as $dbTracker) {
            $trackerInstance = match($dbTracker->type) {
                TrackerType::Mayven => new Mayven($dbTracker->config),
                TrackerType::Clockify => new Clockify($dbTracker->config),
                TrackerType::Everhour => new Everhour($dbTracker->config),
                TrackerType::Placeholder => new Placeholder(),
                // TrackerType::Dota2 => new Dota2($dbTracker->config), // TODO: Update Dota2 to accept config
                default => null,
            };

            if ($trackerInstance) {
                $this->addTracker($trackerInstance);
            }
        }
    }

    public function addTracker(TimeTracker $tracker): self
    {
        $this->trackers->add($tracker);

        return $this;
    }

    public function hours(Carbon $from, Carbon $to): float
    {
        // Collect all promises
        $promises = $this->trackers->map(fn(TimeTracker $tracker) => $tracker->getSeconds($from, $to));

        // Execute concurrently and sum results
        $results = Utils::settle($promises->toArray())->wait();

        $totalSeconds = 0;
        foreach ($results as $result) {
            if ($result['state'] === 'fulfilled') {
                $totalSeconds += $result['value'];
            }
        }

        return $totalSeconds / 3600;
    }

    public function runningHours(): float
    {
        // Collect all promises
        $promises = $this->trackers->map(fn(TimeTracker $tracker) => $tracker->getRunningSeconds());

        // Execute concurrently and sum results
        $results = Utils::settle($promises->toArray())->wait();

        $totalSeconds = 0;
        foreach ($results as $result) {
            if ($result['state'] === 'fulfilled') {
                $totalSeconds += $result['value'];
            }
        }

        return $totalSeconds / 3600;
    }

    public function getMonthlyTimeByProject(Carbon $dayOfMonth, bool $singleDay = false): ProjectTimes
    {
        // Collect all promises
        $promises = $this->trackers->map(fn(TimeTracker $tracker) => $tracker->getMonthlyTimeByProject($dayOfMonth));

        // Execute concurrently and merge results
        $results = Utils::settle($promises->toArray())->wait();

        $map = new ProjectTimes();
        foreach ($results as $result) {
            if ($result['state'] === 'fulfilled' && $result['value'] instanceof ProjectTimes) {
                $map->merge($result['value']);
            }
        }

        return $map;
    }

    public function getDailyHours(Carbon $dayOfMonth): array
    {
        // Collect all promises
        $promises = $this->trackers->map(fn(TimeTracker $tracker) => $tracker->getMonthIntervals($dayOfMonth));

        // Execute concurrently and merge results
        $results = Utils::settle($promises->toArray())->wait();

        $map = new ProjectTimes();
        foreach ($results as $result) {
            if ($result['state'] === 'fulfilled' && $result['value'] instanceof ProjectTimes) {
                $map->merge($result['value']);
            }
        }

        return $map->getDailyHours($dayOfMonth);
    }
}
