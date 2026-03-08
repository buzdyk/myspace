<?php

namespace App\Http\Middleware;

use App\Repositories\Preferences;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'app';

    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    public function share(Request $request): array
    {
        /** @var Preferences $preferences */
        $preferences = app(Preferences::class);
        return array_merge(parent::share($request), [
            'monthlyGoal' => $preferences->getMonthlyGoal(),
            'dailyGoal' => $preferences->getDailyGoal(),
            'hourlyRate' => $preferences->getHourlyRate(),
        ]);
    }
}
