<?php

namespace App\Repositories;

use App\Interfaces\TimeTracker;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class TimeTrackerRepository
{
    protected Collection $trackers;

    public function __construct()
    {
        $this->trackers = new Collection();
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
}
