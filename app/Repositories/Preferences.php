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

    public function getHourlyRate(): int|float|null
    {
        return ($setting = $this->byKey(SettingKey::hourlyRate)) ? (float) $setting->value : null;
    }

    public function getMonthlyGoal(): int|float|null
    {
        return ($setting = $this->byKey(SettingKey::monthlyGoal)) ? (float) $setting->value : null;
    }

    public function getDailyGoal(): int|float|null
    {
        return ($setting = $this->byKey(SettingKey::dailyGoal)) ? (float) $setting->value : null;
    }

    public function setHourlyRate(int|float $value)
    {
        $key = SettingKey::hourlyRate->value;
        return Setting::updateOrCreate(['key' => $key], ['value' => $value]);
    }

    public function setMonthlyGoal(int|float $value)
    {
        $key = SettingKey::monthlyGoal->value;
        return Setting::updateOrCreate(['key' => $key], ['value' => $value]);
    }

    public function setDailyGoal(int|float $value)
    {
        $key = SettingKey::dailyGoal->value;
        return Setting::updateOrCreate(['key' => $key], ['value' => $value]);
    }

    public function valid()
    {
        return $this->getHourlyRate() && $this->getMonthlyGoal() && $this->getDailyGoal();
    }
}
