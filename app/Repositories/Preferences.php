<?php

namespace App\Repositories;

use App\Enums\SettingKey;
use App\Models\Setting;

class Preferences
{
    private function byKey(SettingKey $key)
    {
        return Setting::where('key', $key->value)->first();
    }

    public function getHourlyRate()
    {
        return ($setting = $this->byKey(SettingKey::hourlyRate)) ? (float) $setting->value : 0;
    }

    public function getMonthlyGoal()
    {
        return ($setting = $this->byKey(SettingKey::monthlyGoal)) ? (float) $setting->value : 0;
    }

    public function getDailyGoal()
    {
        return ($setting = $this->byKey(SettingKey::dailyGoal)) ? (float) $setting->value : 0;
    }

    public function setHourlyRate(int|float $value)
    {
        $key = SettingKey::hourlyRate->value;
        return Setting::createOrUpdate(['key' => $key], ['kee'=> $key, $value]);
    }

    public function setMonthlyGoal(int|float $value)
    {
        $key = SettingKey::monthlyGoal->value;
        return Setting::createOrUpdate(['key' => $key], ['kee'=> $key, $value]);
    }

    public function setDailyGoal(int|float $value)
    {
        $key = SettingKey::dailyGoal->value;
        return Setting::createOrUpdate(['key' => $key], ['kee'=> $key, $value]);
    }
}
