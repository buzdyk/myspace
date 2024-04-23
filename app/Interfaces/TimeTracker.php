<?php

namespace App\Interfaces;

use App\Types\ProjectTimes;
use Carbon\Carbon;

interface TimeTracker
{
    public function getUserId(): ?int;
    public function getSeconds(Carbon $from, Carbon $to): int;
    public function getRunningSeconds(): int;
    public function getMonthlyTimeByProject(Carbon $dayOfMonth): ProjectTimes;
}
