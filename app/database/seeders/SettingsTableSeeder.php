<?php

namespace Database\Seeders;

use App\Enums\SettingKey;
use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsTableSeeder extends Seeder
{
    public function run()
    {
        $settings = [
            ['key' => SettingKey::hourlyRate->value, 'value' => env('HOURLY_RATE')],
            ['key' => SettingKey::dailyGoal->value, 'value' => env('DAILY_GOAL')],
            ['key' => SettingKey::monthlyGoal->value, 'value' => env('MONTHLY_GOAL')],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], ['value' => $setting['value']]);
        }
    }
}
