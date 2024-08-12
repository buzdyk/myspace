<?php

namespace App\Repositories;

use Carbon\Carbon;

class Today
{
    private Carbon $day;

    public function __construct(
        protected Trackers $trackers,
        protected TodayCache $cache,
        protected Preferences $preferences,
        protected MonthMeta $monthMeta
    ) {}

    public function hasData(): bool
    {
        return $this->runningHours() || $this->monthHours();
    }

    public function toArray(): array
    {
        return [
            'runningHours' => $this->runningHours(),
            'todayHours' => $this->todayHours(),
            'monthHours' => $this->monthHours(),
            'todayPercent' => $this->todayPercent(),
            'monthPercent' => $this->monthPercent(),
            'pace' => $this->pace(),
        ];
    }

    public function runningHours()
    {
        return $this->cache->getRunningHours();
    }

    public function todayHours()
    {
        return $this->cache->getTodayHours();
    }

    public function monthHours()
    {
        return $this->cache->getMonthHours();
    }

    public function todayPercent()
    {
        return (int) (($this->todayHours() / $this->preferences->getDailyGoal()) * 100);
    }

    public function monthPercent()
    {
        return round(($this->monthHours() / $this->preferences->getMonthlyGoal()) * 100, 1);
    }

    public function pace()
    {
        list($remaining, ) = $this->monthMeta->getWeekdaysMeta(now());

        $expectedHours = $remaining * $this->preferences->getDailyGoal();
        $remainingHours = $this->preferences->getMonthlyGoal() - $this->monthHours();

        return round($expectedHours - $remainingHours, 1);
    }
}
