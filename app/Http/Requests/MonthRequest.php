<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class MonthRequest extends FormRequest
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

        return (new Carbon())
            ->setMonth($month)
            ->setYear((int) $this->year)
            ->setDay($this->day ? (int) $this->day : 1);

    }


    public function getLinks(): array
    {
        $hasDay = (bool) $this->day;
        $route = fn (Carbon $day) => '/' . strtolower($day->format($hasDay ? 'Y/F/d' : 'Y/F'));

        $day = $this->dayOfMonth();

        return [
            'thisLink' => $route($day),
            'prevLink' => $route($hasDay ? $day->copy()->subDay() : $day->copy()->subMonth()),
            'nextLink' => $route($hasDay ? $day->copy()->addDay() : $day->copy()->addMonth()),
        ];
    }
}
