<?php

namespace App\Trackers;

use App\Interfaces\TimeTracker;
use App\Repositories\Preferences;
use App\Types\ProjectTimes;
use App\Types\ProjectTime;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Support\Facades\Cache;

class Placeholder implements TimeTracker
{
    public function getSeconds(Carbon $from, Carbon $to): PromiseInterface
    {
        return \GuzzleHttp\Promise\Create::promiseFor(9015);
    }

    public function getUserId(): ?int
    {
        return null;
    }

    public function getRunningSeconds(): PromiseInterface
    {
        return \GuzzleHttp\Promise\Create::promiseFor(rand(0, 10000));
    }

    public function getMonthlyTimeByProject(Carbon $dayOfMonth): PromiseInterface
    {
        $projects = [
            ['company', 'xxx', 'Tesla'],
            ['company', 'xxx', 'Apple'],
            ['company', 'xxx', 'Taco Bell'],
        ];

        $map = new ProjectTimes();

        foreach ($projects as $p) {
            $map->add(new ProjectTime($p[0], $p[1], $p[2], random_int(3600, 3600 * 100)));
        }

        return \GuzzleHttp\Promise\Create::promiseFor($map);
    }

    public function getMonthIntervals(Carbon $dayOfMonth): PromiseInterface
    {
        $som = (new Carbon())->startOfMonth();
        $eom = (new Carbon())->endOfMonth()->subDays(11);

        $pt = new ProjectTimes();

        while ($som->lte($eom)) {
            if ($som->isWeekday()) {
                $seconds = random_int(4*60*60, 10*60*60);
                $pt->add(new ProjectTime('x', 'x', 'x', $seconds, $som->copy()));
            }

            $som->addDay();
        }

        return \GuzzleHttp\Promise\Create::promiseFor($pt);
    }
}
