<?php

namespace App\Repositories;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class Today
{
    public function __construct(
        protected Trackers $trackers,
        protected TodayCache $cache,
        protected Preferences $preferences,
    ) {}

    public function toArray(): array
    {
        return [
            'isActive' => $this->isActive(),
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

    public function isActive()
    {
        return !! $this->runningHours();
    }

    public function todayPercent()
    {
        return round(($this->todayHours() / $this->preferences->getDailyGoal()) * 100, 2);
    }

    public function monthPercent()
    {
        return round(($this->monthHours() / $this->preferences->getMonthlyGoal()) * 100, 2);
    }

    public function pace()
    {
        list($remaining, ) = $this->getWeekdaysMeta();

        $expectedHours = $remaining * $this->preferences->getDailyGoal();
        $remainingHours = $this->preferences->getMonthlyGoal() - $this->monthHours();

        return round($expectedHours - $remainingHours, 1);
    }

    private function getWeekdaysMeta(): array
    {
        $today = now();
        $month = $today->month;

        $total = $remaining = 0;

        $som = $today->copy()->startOfMonth();
        while ($som->month === $month) {
            $som->isWeekday() && $total++;
            $som->isWeekday() && $som->isAfter($today) && $remaining++;

            $som->addDay();
        }

        return [$remaining, $total];
    }
}
