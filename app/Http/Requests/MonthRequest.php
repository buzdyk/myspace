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
            ->setDay(1);
    }


    public function prevMonthLink()
    {
        return '/' . strtolower($this->dayOfMonth()->subMonth()->format('Y/F'));
    }


    public function nextMonthLink()
    {
        return '/' . strtolower($this->dayOfMonth()->addMonth()->format('Y/F'));
    }

}
