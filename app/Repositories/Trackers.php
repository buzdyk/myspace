<?php

namespace App\Repositories;

use App\Interfaces\TimeTracker;
use App\Trackers\Clockify;
use App\Trackers\Dota2;
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
        if (request()->has('placeholder')) {
            $this->addTracker(new Placeholder());
            return; //cheeky
        }

        $mayven1 = config('services.mayven_1');
        if ($mayven1['enabled']) {
            $config = new \App\TrackerConfigs\MayvenConfig(
                $mayven1['api_url'],
                $mayven1['token']
            );
            $this->addTracker(new Mayven($config));
        }

        $mayven2 = config('services.mayven_2');
        if ($mayven2['enabled']) {
            $config = new \App\TrackerConfigs\MayvenConfig(
                $mayven2['api_url'],
                $mayven2['token']
            );
            $this->addTracker(new Mayven($config));
        }

        if (config('services.everhour.token')) {
            $config = new \App\TrackerConfigs\EverhourConfig(
                config('services.everhour.api_url'),
                config('services.everhour.token')
            );
            $this->addTracker(new Everhour($config));
        }

        if (config('services.clockify.token')) {
            $config = new \App\TrackerConfigs\ClockifyConfig(
                config('services.clockify.token'),
                config('services.clockify.workspace_id'),
                config('services.clockify.user_id')
            );
            $this->addTracker(new Clockify($config));
        }

//        if (config('services.steam.account_id')) {
//            $this->addTracker(new Dota2());
//        }
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
