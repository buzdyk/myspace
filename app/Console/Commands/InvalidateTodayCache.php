<?php

namespace App\Console\Commands;

use App\Repositories\TodayCache;
use App\Repositories\Trackers;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class InvalidateTodayCache extends Command
{
    protected $signature = 'today:invalidate-cache';
    protected $description = 'Command description';

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
}
