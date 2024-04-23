<?php

namespace App\Repositories;

class PreferencesRepository
{
    public function getHourlyRate()
    {
        return (float) env('HOURLY_RATE');
    }

    public function getMonthlyGoal()
    {
        return (float) env('MONTHLY_GOAL');
    }

    public function getDailyGoal()
    {
        return (float) env('DAILY_GOAL');
    }
}
