<?php

namespace App\Http\Controllers;

use App\Repositories\Today;
use Illuminate\Support\Facades\Artisan;
use Inertia\Controller;
use Inertia\Inertia;

class TodayController extends Controller
{
    public function index(Today $today)
    {
        // todo change to a job, setup docker with job workers...
        Artisan::call('today:invalidate-cache');
        return Inertia::render('Today', $today->toArray());
    }

//        list ($remaining, $total) = $this->getWeekdaysMeta();
//        $passed = ($total - $remaining) / $total;
//        $passed = (int) ($passed * 100);
}
