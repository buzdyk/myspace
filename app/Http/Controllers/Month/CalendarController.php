<?php

namespace App\Http\Controllers\Month;

use App\Http\Requests\MonthRequest;
use App\Repositories\Trackers;
use Carbon\Carbon;
use Inertia\Inertia;

class CalendarController
{
    public function index(Trackers $trackers, MonthRequest $request)
    {
        $dayOfMonth = $request->dayOfMonth();

        $days = $this->getDays($dayOfMonth, $trackers);
        $hours = array_reduce($days, fn ($carry, $value) => $carry + ($value && $value['hours'] ? $value['hours'] : 0), 0);

        return Inertia::render('month/Calendar', [
            'days' => array_values($days),
            'hours' => $hours,
            'links' => [
                ...$request->getNav(),
                'caption' => $dayOfMonth->format('F Y'),
            ],
        ]);
    }

    protected function getDays(Carbon $dayOfMonth, Trackers $trackers): array
    {
        $days = $trackers->getDailyHours($dayOfMonth);
        $firstDay = null;

        foreach ($days as $date => $hours) {
            $carbon = new Carbon($date);

            if ($firstDay === null) $firstDay = $carbon;

            $days[$date] = [
                'hours' => $hours,
                'date' => $carbon->format('d'),
                'isWorkday' => $carbon->isWeekday(),
                'isToday' => $carbon->isSameDay(now()),
                'link' => strtolower($carbon->format('/Y/F/d'))
            ];
        }

        $map = [0 => 6, 1 => 0, 2 => 1, 3 => 2, 4 => 3, 5 => 4, 6 => 5];

        return [
            ...array_fill(0, $map[$firstDay->dayOfWeek], null),
            ...$days,
        ];
    }
}
