<?php

namespace App\Http\Controllers;

use App\Repositories\Preferences;
use App\Repositories\Trackers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Controller;
use Inertia\Inertia;

class SettingsController extends Controller
{
    public function index(Request $request, Preferences $settings)
    {
        return Inertia::render('settings/General', [
            'hourlyRate' => $settings->getHourlyRate(),
            'monthlyGoal' => $settings->getMonthlyGoal(),
            'dailyGoal' => $settings->getDailyGoal(),
        ]);
    }

    public function store(Request $request, Preferences $settings)
    {
        $request->validate([
            'hourlyRate' => 'required|numeric',
            'dailyGoal' => 'required|numeric:0',
            'monthlyGoal' => 'required|numeric:0,'
        ]);

        $settings->setHourlyRate($request->hourlyRate);
        $settings->setDailyGoal($request->dailyGoal);
        $settings->setMonthlyGoal($request->monthlyGoal);

        return response('', 200);
    }
}
