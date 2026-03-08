<?php

namespace App\Http\Requests;

use Carbon\Carbon;

class MonthRequest extends PeriodRequest
{
    public function dayOfMonth(): Carbon
    {
        $month = match($this->month) {
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

        return parent::dayOfMonth()->setMonth($month);

    }

    public function getNav(): array
    {
        $route = fn (Carbon $day) => '/' . strtolower($day->format('Y/F'));

        $day = $this->dayOfMonth();

        return [
            'thisLink' => $route($day),
            'prevLink' => $route($day->copy()->subMonth()),
            'nextLink' => $route($day->copy()->addMonth()),

            'caption' => $day->format('F Y'),
        ];
    }
}
