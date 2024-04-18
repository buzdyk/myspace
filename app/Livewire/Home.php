<?php

namespace App\Livewire;

use App\Repositories\TimeTrackerRepository;
use App\Services\EverhourAPI;
use App\Services\MayvenAPI;
use Carbon\Carbon;
use Livewire\Component;

class Home extends Component
{
    public function render(TimeTrackerRepository $repository)
    {
        $repository
            ->addTracker(new MayvenAPI())
            ->addTracker(new EverhourAPI());

        return $this->response($repository);
    }

    protected function response(TimeTrackerRepository $repository)
    {
        $rate = (int) env('HOURLY_RATE');

        $runningHours = $repository->runningHours();

        $hours = $repository->hours(Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth());
        $hours += $runningHours; $hours = round($hours, 1);
        $goal = round((($hours / 140) * 100), 1);
        $earned = (int) ($hours * $rate);

        $thours = $repository->hours(Carbon::now(), Carbon::now());
        $thours += $runningHours; $thours = round($thours, 1);

        $tearned = (int) ($thours * $rate);
        $tgoal = (int) (($thours / 7) * 100);

        $isActive = !!$runningHours;

        return view('livewire.home', compact([
            'hours', 'goal', 'earned',
            'thours', 'tearned', 'tgoal',
            'isActive'
        ]));
    }
}
