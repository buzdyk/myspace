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
        $reducer = fn ($carry, TimeTracker $tracker) => $carry + $tracker->getSeconds($from, $to);

        return $this->trackers->reduce($reducer, 0) / 3600;
    }

    public function runningHours(): float
    {
        $reducer = fn ($carry, TimeTracker $tracker) => $carry + $tracker->getRunningSeconds();

        return $this->trackers->reduce($reducer, 0) / 3600;
    }

    public function getMonthlyTimeByProject(Carbon $dayOfMonth, bool $singleDay = false): ProjectTimes
    {
        $map = new ProjectTimes();

        /** @var TimeTracker $tracker */
        foreach ($this->trackers as $tracker) {
            $map->merge($tracker->getMonthlyTimeByProject($dayOfMonth));
        }

        return $map;
    }

    public function getDailyHours(Carbon $dayOfMonth): array
    {
        $map = new ProjectTimes();

        /** @var TimeTracker $tracker */
        foreach ($this->trackers as $tracker) {
            $map->merge($tracker->getMonthIntervals($dayOfMonth));
        }

        return $map->getDailyHours($dayOfMonth);
    }
}
