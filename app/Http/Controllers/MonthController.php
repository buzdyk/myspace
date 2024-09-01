<?php

namespace App\Http\Controllers;

use App\Http\Requests\MonthRequest;
use App\Repositories\MonthMeta;
use App\Repositories\Preferences;
use App\Repositories\Trackers;
use Carbon\Carbon;
use Inertia\Controller;
use Inertia\Inertia;

class MonthController extends Controller
{
    public function index(MonthRequest $request, Trackers $trackers, Preferences $preferences, MonthMeta $monthMeta)
    {
        if ($preferences->valid() === false) {
            return redirect('/settings');
        }

        $dayOfMonth = $request->dayOfMonth();

        $dailyHours = $trackers->getDailyHours($dayOfMonth);
        foreach ($dailyHours as $date => $hours) {
            $carbon = new Carbon($date);
            $dailyHours[$date] = [
                'hours' => $hours ? number_format($hours, 1) : '',
                'day' => $carbon->format('d'),
                'dow' => $carbon->format('l')
            ];
        }

        $projects = $trackers->getMonthlyTimeByProject($dayOfMonth);
        list (, $weekdays, $weekends) = $monthMeta->getWeekdaysMeta($dayOfMonth);

        return Inertia::render('Month', [
            'projects' => $projects->toArray(),
            'monthHours' => $projects->getHours(),
            'dailyHours' => array_values($dailyHours),
            'dayOfMonth' => $dayOfMonth->format('F, Y'),
            'weekdays' => $weekdays,
            'weekends' => $weekends,
            'links' => $request->getNav(),
        ]);
    }

    public function redirect()
    {
        $date = new Carbon();

        return redirect()->to($date->year . '/' . strtolower($date->monthName) . '/projects');
    }
}
