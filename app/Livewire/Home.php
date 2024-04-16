<?php

namespace App\Livewire;

use App\Interfaces\TimeTracker;
use App\Services\EverhourAPI;
use App\Services\MayvenAPI;
use Carbon\Carbon;
use Livewire\Component;

class Home extends Component
{
    public function render()
    {
        $trackers = [
            new EverhourAPI(),
            new MayvenAPI(),
        ];

        $seconds = 0; $tseconds = 0;
        $som = Carbon::now()->startOfMonth();
        $eom = Carbon::now()->endOfMonth();
        $today = Carbon::now();

        /** @var TimeTracker $tracker */
        foreach ($trackers as $tracker) {
            $seconds += $tracker->getSeconds($som, $eom);
            $seconds += $tracker->getRunningSeconds();

            $tseconds += $tracker->getSeconds($today, $today);
            $tseconds += $tracker->getRunningSeconds();
        }

        $rate = (int) env('HOURLY_RATE');

        $daysRemaining = 0;
        $daysTotal = 0;

        $yesterday = $today->copy()->subDay();

        do {
            if (false === ($som->isSunday() || $som->isSaturday())) {
                $som->isAfter($yesterday) && $daysRemaining++;
                $daysTotal++;
            }

            $som->addDay();
        } while ($som->month === 4);

        return view('livewire.home', [
            'hours' => round($seconds / 3600, 1),
            'earned' => (int) (($seconds / 3600) * $rate),
            'goal' => (int) ((($seconds / 3600) / 140) * 100),

            'thours' => round($tseconds / 3600, 1),
            'tearned' => (int) (($tseconds / 3600) * $rate),
            'tgoal' => (int) ((($tseconds / 3600) / 7) * 100),

            'daysRemaining' => $daysRemaining,
            'daysTotal' => $daysTotal,
        ]);
    }
}
