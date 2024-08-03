<?php

namespace App\Jobs;

use App\Repositories\TodayCache;
use App\Repositories\Trackers;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class CacheToday implements ShouldQueue, ShouldBeUnique
{
    use Queueable, Dispatchable;

    public int $uniqueFor = 120;

    public function __construct()
    {
        //
    }

    public function handle(Trackers $trackers, TodayCache $cache)
    {
        $value = $trackers->runningHours();
        $cache->setRunningHours($value);

        $value = $trackers->hours(now()->startOfDay(), now()->endOfDay());
        $value += $cache->getRunningHours();
        $cache->setTodayHours($value);

        $som = now()->startOfMonth(); $eom = now()->endOfMonth();
        $value = $trackers->hours($som, $eom) + $cache->getRunningHours();
        $cache->setMonthHours($value);
    }

    public function uniqueId()
    {
        return 'today_cache_job';
    }
}
