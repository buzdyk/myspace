<?php

namespace App\Livewire;

use App\Repositories\Preferences;
use App\Repositories\Trackers;
use App\Services\Api\Everhour;
use App\Services\Api\Mayven;
use Carbon\Carbon;
use Illuminate\View\View;
use Livewire\Component;

class Today extends Component
{
    public bool $isActive = false;

    public function render(Trackers $trackers, Preferences $preferences)
    {
        return $this->response($trackers, $preferences);
    }

    protected function response(Trackers $trackers, Preferences $preferences): View
    {
        $runningHours = $trackers->runningHours();

        // monthly values
        $hours = $trackers->hours(Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth());
        $hours += $runningHours; $hours = round($hours, 1);
        $goal = round((($hours / $preferences->getMonthlyGoal()) * 100), 1);

        // today values
        $thours = $trackers->hours(Carbon::now(), Carbon::now());
        $thours += $runningHours; $thours = round($thours, 1);
        $tgoal = (int) (($thours / $preferences->getDailyGoal()) * 100);

        $this->isActive = $runningHours;
        $pace = $this->getPace($hours, $preferences);
        $paceClass = $this->getPaceClass($pace, $preferences->getDailyGoal());

        return view('livewire.today', compact([
            'goal', 'tgoal', 'pace', 'paceClass', 'thours', 'hours'
        ]));
    }

    private function getPace($hoursTracked, Preferences $preferences)
    {
        $dayOfMonth = (new Carbon())->addDay();
        $month = $dayOfMonth->month;
        $weekdays = 0;

        while ($dayOfMonth->month === $month) {
            if ($dayOfMonth->isWeekday()) $weekdays++;
            $dayOfMonth->addDay();
        }

        $expectedHours = $weekdays * $preferences->getDailyGoal();
        $remainingHours = $preferences->getMonthlyGoal() - $hoursTracked;

        return number_format($expectedHours - $remainingHours, 1);
    }

    private function getPaceClass($pace, $dailyGoal)
    {
        switch ($pace) {
            case $pace < -$dailyGoal:
                return 'text-red-600';
            case $pace > 0:
                return 'text-green-600';
            default:
                return '';
        }
    }
}
