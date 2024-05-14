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
        $goal = round((($hours / $preferences->getMonthlyGoal()) * 100), 1);

        // today values
        $thours = $trackers->hours(Carbon::now(), Carbon::now());
        $thours += $runningHours; $thours = round($thours, 1);
        $tgoal = (int) (($thours / $preferences->getDailyGoal()) * 100);

        // todo add a link to the active task
        $this->isActive = $runningHours;
        $pace = $this->getPace($hours);

        return view('livewire.goals', compact([
            'goal', 'tgoal', 'pace'
        ]));
    }

    private function getPace($hoursTracked)
    {
        $dayOfMonth = (new Carbon())->addDay();
        $month = $dayOfMonth->month;
        $weekdays = 0;

        while ($dayOfMonth->month === $month) {
            if ($dayOfMonth->isWeekday()) $weekdays++;
            $dayOfMonth->addDay();
        }

        $expectedHours = $weekdays * env('DAILY_GOAL');
        $remainingHours = env('MONTHLY_GOAL') - $hoursTracked;

        return $expectedHours - $remainingHours;
    }
}