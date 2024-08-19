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

        try {
            $this->cacheValues($date, $trackers, $cache);
        } catch (\Exception $e) {}

        return Inertia::render('Today', [
            ...$today->setDay($date)->toArray(),
            'projects' => $request->getProjects(),
            'nav' => [
                ...$request->getLinks(),
                'monthLink' => strtolower($date->format('/Y/F') . '/calendar'),
                'day' => $date->format('jS'),
                'month' => $date->format('F'),
                'year' => $date->isSameYear(now()) ? '' : $date->format('Y'),
//                'caption' => $date->format('F, jS')
            ],
            'isToday' => $date->isSameDay(now()),
            'readableDate' => $date->diffForHumans(now())
        ]);
    }

    private function cacheValues(Carbon $date, Trackers $trackers, TodayCache $cache)
    {
        $value = $trackers->runningHours();
        $cache->setRunningHours($value);

        $value = $trackers->hours($date->copy()->startOfDay(), $date->copy()->endOfDay());
        $value += $cache->getRunningHours();
        $cache->setTodayHours($value);

        $som = $date->copy()->startOfMonth(); $eom = $date->copy()->endOfDay();
        $value = $trackers->hours($som, $eom) + ($date->isSameDay(now()) ? $cache->getRunningHours() : 0);
        $cache->setMonthHours($value);
    }
}
