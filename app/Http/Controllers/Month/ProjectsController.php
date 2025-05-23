<?php

namespace App\Http\Controllers\Month;

use App\Http\Requests\MonthRequest;
use App\Repositories\MonthMeta;
use App\Repositories\Preferences;
use App\Repositories\Trackers;
use Carbon\Carbon;
use Inertia\Controller;
use Inertia\Inertia;

class ProjectsController extends Controller
{
    public function index(MonthRequest $request, Trackers $trackers, MonthMeta $monthMeta, Preferences $settings)
    {
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

        return Inertia::render('month/Projects', [
            'projects' => $projects->toArray(),

            'projectedIncome' => $settings->getMonthlyGoal() * $settings->getHourlyRate(),
            'projectedHours' => $settings->getMonthlyGoal(),

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
