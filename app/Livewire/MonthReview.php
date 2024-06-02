<?php

namespace App\Livewire;

use App\Repositories\Preferences;
use App\Repositories\Trackers;
use App\Services\Api\Everhour;
use App\Services\Api\Mayven;
use App\Types\ProjectTimes;
use Carbon\Carbon;
use Illuminate\View\View;
use Livewire\Component;

class MonthReview extends Component
{
    protected Trackers $trackers;
    protected Preferences $preferences;

    public Carbon $dayOfMonth;
    public array $projects;
    public float|int $hourlyRate;
    public float $totalHours;
    public array $dailyHours;

    public function __construct()
    {
        $this->dayOfMonth = Carbon::now();
        $this->trackers = app(Trackers::class);
        $this->preferences = app(Preferences::class);
        $this->dailyHours = array();
    }

    public function render()
    {
        $this->hydrate();

        return view('livewire.month-review');
    }

    public function hydrate()
    {
        $dailyHours = $this->trackers->getDailyHours($this->dayOfMonth);
        foreach ($dailyHours as $date => $hours) {
            $carbon = new Carbon($date);
            $dailyHours[$date] = [
                'hours' => hoursToString($hours),
                'day' => $carbon->format('d'),
                'dow' => $carbon->format('l')
            ];
        }
        $this->dailyHours = $dailyHours;

        $projects = $this->trackers->getMonthlyTimeByProject($this->dayOfMonth);
        $this->projects = $projects->toArray();
        $this->totalHours = $projects->getHours();
        $this->hourlyRate = $this->preferences->getHourlyRate();
    }

    public function add()
    {
        $this->dayOfMonth->addMonth();
    }

    public function sub()
    {
        $this->dayOfMonth->subMonth();
    }
}
