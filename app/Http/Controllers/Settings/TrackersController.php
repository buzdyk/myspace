<?php

namespace App\Http\Controllers\Settings;

use App\Repositories\Preferences;
use Illuminate\Http\Request;
use Inertia\Controller;
use Inertia\Inertia;

class TrackersController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('settings/Trackers', []);
    }

    public function store(Request $request, Preferences $settings)
    {
        $request->validate([]);

        return response('', 200);
    }
}
