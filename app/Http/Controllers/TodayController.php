<?php

namespace App\Http\Controllers;

use App\Jobs\CacheToday;
use App\Repositories\Preferences;
use App\Repositories\Today;
use Inertia\Controller;
use Inertia\Inertia;

class TodayController extends Controller
{
    public function index(Today $today, Preferences $settings)
    {
        if ($settings->valid() === false) {
            return redirect('/settings');
        }

        $job = new CacheToday();
        $today->hasData() ? dispatch($job) : dispatch_sync($job);

        return Inertia::render('Today', $today->toArray());
    }

//        list ($remaining, $total) = $this->getWeekdaysMeta();
//        $passed = ($total - $remaining) / $total;
//        $passed = (int) ($passed * 100);
}
