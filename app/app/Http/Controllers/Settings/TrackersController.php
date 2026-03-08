<?php

namespace App\Http\Controllers\Settings;

use App\Enums\TrackerStatus;
use App\Enums\TrackerType;
use App\Models\Tracker;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Controller;
use Inertia\Inertia;

class TrackersController extends Controller
{
    public function index(Request $request)
    {
        $trackers = Tracker::all();

        return Inertia::render('settings/Trackers', [
            'trackers' => $trackers,
            'navigation' => [
                'thisLink' => '/settings'
            ]
        ]);
    }

    public function create(Request $request)
    {
        return Inertia::render('settings/TrackersCreate', [
            'trackerTypes' => array_map(fn($case) => $case->value, TrackerType::cases()),
            'trackerStatuses' => array_map(fn($case) => $case->value, TrackerStatus::cases()),
            'navigation' => [
                'thisLink' => '/settings'
            ]
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => ['required', Rule::enum(TrackerType::class)],
            'status' => ['required', Rule::enum(TrackerStatus::class)],
            'config' => 'nullable|array',
        ]);

        Tracker::create($validated);

        return redirect()->back();
    }

    public function edit(Request $request, Tracker $tracker)
    {
        return Inertia::render('settings/TrackersEdit', [
            'tracker' => $tracker,
            'navigation' => [
                'thisLink' => '/settings'
            ]
        ]);
    }

    public function update(Request $request, Tracker $tracker)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'status' => ['required', Rule::enum(TrackerStatus::class)],
        ]);

        $tracker->update($validated);

        return redirect('/settings/trackers');
    }

    public function destroy(Tracker $tracker)
    {
        $tracker->delete();

        return redirect('/settings/trackers');
    }
}
