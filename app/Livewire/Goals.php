<?php

namespace App\Livewire;

use App\Repositories\Preferences;
use App\Repositories\Trackers;
use App\Services\Api\Everhour;
use App\Services\Api\Mayven;
use Carbon\Carbon;
use Illuminate\View\View;
use Livewire\Component;

class Goals extends Component
{
    public bool $isActive = false;

    public function render(Trackers $trackers, Preferences $preferences)
    {
        return $this->response($trackers, $preferences);
    }

    protected function response(Trackers $trackers, Preferences $preferences): View
    {
        $rate = $preferences->getHourlyRate();

        $runningHours = $trackers->runningHours();

        // monthly values
        $hours = $trackers->hours(Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth());
        $hours += $runningHours; $hours = round($hours, 1);
        $earned = (int) ($hours * $rate);
        $goal = round((($hours / $preferences->getMonthlyGoal()) * 100), 1);

        // today values
        $thours = $trackers->hours(Carbon::now(), Carbon::now());
        $thours += $runningHours; $thours = round($thours, 1);
        $tearned = (int) ($thours * $rate);
        $tgoal = (int) (($thours / $preferences->getDailyGoal()) * 100);

        // todo add a link to the active task
        $this->isActive = $runningHours;

        return view('livewire.goals', compact([
            'hours', 'goal', 'earned',
            'thours', 'tearned', 'tgoal',
        ]));
    }
}
