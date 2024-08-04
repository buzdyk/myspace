<?php

namespace App\Http\Controllers;

use App\Repositories\Preferences;
use App\Repositories\Trackers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Controller;
use Inertia\Inertia;

class MonthController extends Controller
{
    public function index(Request $request, Trackers $trackers, Preferences $preferences)
    {
        if ($preferences->valid() === false) {
            return redirect('/settings');
        }

        $dayOfMonth = $this->getDayOfMonth($request);

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

        return Inertia::render('Month', [
            'projects' => $projects->toArray(),
            'monthHours' => $projects->getHours(),
            'dailyHours' => array_values($dailyHours),
            'dayOfMonth' => $dayOfMonth->format('F, Y'),
            'prevMonthLink' => '/' . strtolower($dayOfMonth->copy()->subMonth()->format('Y/F')),
            'nextMonthLink' => '/' . strtolower($dayOfMonth->copy()->addMonth()->format('Y/F')),
        ]);
    }

    private function getDayOfMonth(Request $request)
    {
        $month = match($request->month) {
            'january' => 1,
            'february' => 2,
            'march' => 3,
            'april' => 4,
            'may' => 5,
            'june' => 6,
            'july' => 7,
            'august' => 8,
            'september' => 9,
            'october' => 10,
            'november' => 11,
            'december' => 12,
        };

        return (new Carbon())->setMonth($month)->setYear((int) $request->year);
    }

    public function redirect()
    {
        $date = new Carbon();

        return redirect()->to($date->year . '/' . strtolower($date->monthName));
    }
}
