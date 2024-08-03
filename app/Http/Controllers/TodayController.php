<?php

namespace App\Http\Controllers;

use App\Jobs\CacheToday;
use App\Repositories\Today;
use Inertia\Controller;
use Inertia\Inertia;

class TodayController extends Controller
{
    public function index(Today $today)
    {
        dispatch(new CacheToday())->onQueue('default');

        return Inertia::render('Today', $today->toArray());
    }

//        list ($remaining, $total) = $this->getWeekdaysMeta();
//        $passed = ($total - $remaining) / $total;
//        $passed = (int) ($passed * 100);
}
