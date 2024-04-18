<?php

namespace App\Interfaces;

use Carbon\Carbon;

interface TimeTracker
{
    public function getUserId(): ?int;
    public function getSeconds(Carbon $from, Carbon $to): int;
    public function getRunningSeconds(): int;
}
