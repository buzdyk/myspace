<?php

namespace App\Http\Controllers;

use App\Repositories\Preferences;
use App\Repositories\Trackers;
use Carbon\Carbon;
use Inertia\Controller;
use Inertia\Inertia;

class TodayController extends Controller
{
    public function index(Trackers $trackers, Preferences $preferences)
    {
//        list ($remaining, $total) = $this->getWeekdaysMeta();
//        $passed = ($total - $remaining) / $total;
//        $passed = (int) ($passed * 100);

        return Inertia::render('Today', [
            'isActive' => !! ($runningHours = $trackers->runningHours()),
            'todayHours' => ($todayHours = $trackers->hours(Carbon::now(), Carbon::now()) + $runningHours),
            'monthHours' => ($monthHours = $trackers->hours(Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()) + $runningHours),
            'todayPercent' => (int) (($todayHours / $preferences->getDailyGoal()) * 100),
            'monthPercent' => round((($monthHours / $preferences->getMonthlyGoal()) * 100), 1),
            'pace' => (float) $this->getPace($monthHours, $preferences),
        ]);
    }

    private function getPace($hoursTracked, Preferences $preferences)
    {
        list($remaining, ) = $this->getWeekdaysMeta();

        $expectedHours = $remaining * $preferences->getDailyGoal();
        $remainingHours = $preferences->getMonthlyGoal() - $hoursTracked;

        return number_format($expectedHours - $remainingHours, 1);
    }

    private function getWeekdaysMeta(): array
    {
        $today = new Carbon;
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
