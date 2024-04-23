<?php

namespace App\Livewire;

use App\Repositories\Preferences;
use App\Repositories\Trackers;
use App\Services\Api\Mayven;
use Carbon\Carbon;
use Illuminate\View\View;
use Livewire\Component;

class MonthlyTimeByProject extends Component
{
    public Carbon $dayOfMonth;

    public function render(Trackers $trackers, Preferences $preferences)
    {
        $trackers->hydrate();

        $this->dayOfMonth = Carbon::now();

        $map = $trackers->getMonthlyTimeByProject(Carbon::now());

        return view('livewire.monthly-time-by-project', [
            'projects' => $map,
            'hourlyRate' => $preferences->getHourlyRate(),
            'totalHours' => $map->getHours(),
        ]);
    }
}
