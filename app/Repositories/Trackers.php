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

        if (config('services.mayven.auth')) {
            $this->addTracker(new Mayven());
        }

        if (config('services.everhour.token')) {
            $this->addTracker(new Everhour());
        }

        if (config('services.clockify.token')) {
            $this->addTracker(new Clockify());
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

    public function getMonthlyTimeByProject(Carbon $dayOfMonth): ProjectTimes
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
