<?php

namespace App\Http\Requests;

use Carbon\Carbon;

class DayRequest extends MonthRequest
{
    public function dayOfMonth(): Carbon
    {
        return parent::dayOfMonth()->setDay((int) $this->day);
    }

    public function getNav(): array
    {
        $route = fn (Carbon $day) => '/' . strtolower($day->format('Y/F/d'));

        $date = $this->dayOfMonth();

        return [
            'thisLink' => $route($date),
            'prevLink' => $route($date->copy()->subDay()),
            'nextLink' => $route($date->copy()->addDay()),
            'monthLink' => strtolower($date->format('/Y/F') . '/calendar'),

            'day' => $date->format('jS'),
            'month' => $date->format('F'),
            'year' => $date->isSameYear(now()) ? '' : $date->format('Y'),
        ];
    }
}
