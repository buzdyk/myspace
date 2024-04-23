<?php

namespace App\Livewire;

use App\Repositories\PreferencesRepository;
use App\Repositories\TimeTrackerRepository;
use App\Services\Api\Everhour;
use App\Services\Api\Mayven;
use Carbon\Carbon;
use Illuminate\View\View;
use Livewire\Component;

class Home extends Component
{
    public bool $isActive = false;

    public function render(TimeTrackerRepository $trackers, PreferencesRepository $preferences)
    {
        $trackers
            ->addTracker(new Mayven())
            ->addTracker(new Everhour());

        return $this->response($trackers, $preferences);
    }

    protected function response(TimeTrackerRepository $trackers, PreferencesRepository $preferences): View
    {
        $rate = $preferences->getHourlyRate();

        $runningHours = $trackers->runningHours();

        $hours = $trackers->hours(Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth());
        $hours += $runningHours; $hours = round($hours, 1);
        $earned = (int) ($hours * $rate);
        $goal = round((($hours / $preferences->getMonthlyGoal()) * 100), 1);

        $thours = $trackers->hours(Carbon::now(), Carbon::now());
        $thours += $runningHours; $thours = round($thours, 1);
        $tearned = (int) ($thours * $rate);
        $tgoal = (int) (($thours / $preferences->getDailyGoal()) * 100);

        // todo add active task link
        $this->isActive = $runningHours;

        return view('livewire.home', compact([
            'hours', 'goal', 'earned',
            'thours', 'tearned', 'tgoal',
        ]));
    }


}
