<?php

namespace App\Http\Controllers;

use App\Jobs\CacheToday;
use App\Repositories\Preferences;
use App\Repositories\Today;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Queue;
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
        $noPendingJob = Queue::size('default') === 0;

        if ($today->hasData() === false) {
            dispatch_sync($job);
        }

        if ($noPendingJob) {
            dispatch($job);
        }

        return Inertia::render('Today', $today->toArray());
    }

//        list ($remaining, $total) = $this->getWeekdaysMeta();
//        $passed = ($total - $remaining) / $total;
//        $passed = (int) ($passed * 100);
}
