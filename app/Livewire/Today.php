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

        list ($remaining, $total) = $this->getWeekdaysMeta();
        $passed = ($total - $remaining) / $total;
        $passed = (int) ($passed * 100);

        return view('livewire.today', compact([
            'goal', 'tgoal', 'pace', 'paceClass', 'thours', 'hours', 'passed'
        ]));
    }

    private function getPace($hoursTracked, Preferences $preferences)
    {
        list($remaining, ) = $this->getWeekdaysMeta();

        $expectedHours = $remaining * $preferences->getDailyGoal();
        $remainingHours = $preferences->getMonthlyGoal() - $hoursTracked;

        return number_format($expectedHours - $remainingHours, 1);
    }

    private function getWeekdaysMeta(): array
    {
        $today = new Carbon;
        $month = $today->month;
        $total = $remaining = 0;

        $som = $today->copy()->startOfMonth();
        while ($som->month === $month) {
            $som->isWeekday() && $total++;
            $som->isWeekday() && $som->isAfter($today) && $remaining++;

            $som->addDay();
        }

        return [$remaining, $total];
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
