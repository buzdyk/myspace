<?php

namespace App\Livewire;

use App\Repositories\Preferences;
use App\Repositories\Trackers;
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

    public function __construct()
    {
        $this->dayOfMonth = Carbon::now();
        $this->trackers = app(Trackers::class);
        $this->preferences = app(Preferences::class);
    }

    public function render()
    {
        $this->hydrate();

        return view('livewire.month-review');
    }

    public function hydrate()
    {
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
