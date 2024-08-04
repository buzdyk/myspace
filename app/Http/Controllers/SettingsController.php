<?php

namespace App\Http\Controllers;

use App\Repositories\Trackers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Controller;
use Inertia\Inertia;

class SettingsController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Settings', [
            'hourlyRate' => 65,
            'monthlyGoal' => 154,
            'dailyGoal' => 8,
        ]);
    }
}
