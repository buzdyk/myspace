<?php

namespace App\Http\Controllers;

use App\Http\Requests\MonthRequest;
use App\Repositories\Preferences;
use App\Repositories\Today;
use App\Repositories\TodayCache;
use App\Repositories\Trackers;
use Carbon\Carbon;
use Inertia\Controller;
use Inertia\Inertia;

class TodayController extends Controller
{
    public function redirect()
    {
        $path = now()->format('Y/F/d');
        $path = strtolower($path);

        return redirect()->to($path);
    }

    public function index(MonthRequest $request, Trackers $trackers, Preferences $settings, TodayCache $cache, Today $today)
    {
        if ($settings->valid() === false) {
            return redirect('/settings');
        }

        $date = $request->dayOfMonth()->setDay((int) $request->day);
        $this->cacheValues($date, $trackers, $cache);

        return Inertia::render('Today', [
            ...$today->toArray(),
            'nav' => [
                ...$request->getLinks(),
                'caption' => $date->format('F, jS')
            ]
        ]);
    }

    private function cacheValues(Carbon $date, Trackers $trackers, TodayCache $cache)
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
