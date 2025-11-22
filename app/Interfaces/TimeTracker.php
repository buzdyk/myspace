<?php

namespace App\Interfaces;

use App\Types\ProjectTimes;
use Carbon\Carbon;
use GuzzleHttp\Promise\PromiseInterface;

interface TimeTracker
{
    public function getUserId(): null|int|string;
    public function getSeconds(Carbon $from, Carbon $to): PromiseInterface;
    public function getRunningSeconds(): PromiseInterface;
    public function getMonthlyTimeByProject(Carbon $dayOfMonth): PromiseInterface;
    public function getMonthIntervals(Carbon $dayOfMonth): PromiseInterface;
}
