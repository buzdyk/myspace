<?php

namespace App\Enums;

enum SettingKey: string
{
    case hourlyRate = 'hourlyRate';
    case dailyGoal = 'dailyGoal';
    case monthlyGoal = 'monthlyGoal';
}
