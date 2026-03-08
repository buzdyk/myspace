<?php

namespace App\Repositories;

use Carbon\Carbon;

class MonthMeta
{
    public function getWeekdaysMeta(Carbon $dayOfMonth): array
    {
        $month = $dayOfMonth->month;

        $weekdays = $remaining = $weekend = 0;

        $som = $dayOfMonth->copy()->startOfMonth();
        while ($som->month === $month) {
            $som->isWeekday() && $weekdays++;
            $som->isWeekday() && $som->isAfter($dayOfMonth) && $remaining++;
            $som->isWeekend() && $weekend++;

            $som->addDay();
        }

        return [$remaining, $weekdays, $weekend];
    }

}
