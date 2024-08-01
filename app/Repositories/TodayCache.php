<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Cache;

class TodayCache
{
    private const RUNNING_HOURS = 'running_hours';
    private const TODAY_HOURS = 'today_hours';
    private const MONTH_HOURS = 'month_hours';

    public function getRunningHours(): int|float
    {
        return Cache()->get(static::RUNNING_HOURS) ?? 0;
    }

    public function getTodayHours(): int|float
    {
        return Cache()->get(static::TODAY_HOURS) ?? 0;
    }

    public function getMonthHours(): int|float
    {
        return Cache()->get(static::MONTH_HOURS) ?? 0;
    }

    public function setRunningHours(float|int $hours): static
    {
        return tap($this, fn () => Cache::set(static::RUNNING_HOURS, $hours, $this->getTtl()));
    }

    public function setTodayHours(float|int $hours): static
    {
        return tap($this, fn () => Cache::set(static::TODAY_HOURS, $hours, $this->getTtl()));
    }

    public function setMonthHours(float|int $hours): static
    {
        return tap($this, fn () => Cache::set(static::MONTH_HOURS, $hours, $this->getTtl()));
    }

    private function getTtl(): int
    {
        // todo should be dynamic depending on end of day
        return 3600;
    }
}
