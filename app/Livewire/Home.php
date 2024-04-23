<?php

namespace App\Livewire;

use App\Repositories\TimeTrackerRepository;
use App\Services\Api\Everhour;
use App\Services\Api\Mayven;
use Carbon\Carbon;
use Illuminate\View\View;
use Livewire\Component;

class Home extends Component
{
    public bool $isActive = false;

    public function render(TimeTrackerRepository $repository)
    {
        $repository
            ->addTracker(new Mayven())
            ->addTracker(new Everhour());

        return $this->response($repository);
    }

    protected function response(TimeTrackerRepository $repository): View
    {
        $rate = (int) env('HOURLY_RATE');

        $runningHours = $repository->runningHours();

        $hours = $repository->hours(Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth());
        $hours += $runningHours; $hours = round($hours, 1);
        $goal = round((($hours / env('MONTHLY_GOAL', 140)) * 100), 1);
        $earned = (int) ($hours * $rate);

        $thours = $repository->hours(Carbon::now(), Carbon::now());
        $thours += $runningHours; $thours = round($thours, 1);

        $tearned = (int) ($thours * $rate);
        $tgoal = (int) (($thours / env('DAILY_GOAL', 7)) * 100);

        $isActive = !!$runningHours;
        $this->isActive = $isActive;

        return view('livewire.home', compact([
            'hours', 'goal', 'earned',
            'thours', 'tearned', 'tgoal',
            'isActive'
        ]));
    }
}
