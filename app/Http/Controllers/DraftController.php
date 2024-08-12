<?php

namespace App\Http\Controllers;

use App\Http\Requests\MonthRequest;
use App\Repositories\Trackers;
use Carbon\Carbon;
use Inertia\Inertia;

class DraftController
{
    public function index(Trackers $trackers, MonthRequest $request)
    {
        $days = $trackers->getDailyHours($request->dayOfMonth());

        foreach ($days as $date => $hours) {
            $carbon = new Carbon($date);
            $days[$date] = [
                'hours' => $hours,
                'date' => $carbon->format('d'),
                'isWorkday' => $carbon->isWeekday()
            ];
        }


        return Inertia::render('Draft', [
            'days' => array_values($days),
            'links' => $request->getLinks(),
        ]);
    }
}
