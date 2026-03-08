<?php

namespace App\Trackers;

use App\Interfaces\TimeTracker;
use App\Types\ProjectTimes;
use App\Types\ProjectTime;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Support\Facades\Cache;

class Dota2 extends Rest implements TimeTracker
{
    protected Client $client;

    protected function baseUri(): string
    {
        return 'https://api.opendota.com';
    }

    protected function headers(): array
    {
        return [];
    }

    public function getSeconds(Carbon $from, Carbon $to): PromiseInterface
    {
        return $this->get("/api/players/141077610/matches")->then(function($res) use ($from, $to) {
            $matches = collect(json_decode($res->getBody()->getContents()));
            $reject = fn ($match) => $match->start_time < $from->timestamp || $match->start_time > $to->timestamp;
            $matches = $matches->reject($reject);

            return $matches->sum('duration');
        });
    }

    public function getRunningSeconds(): PromiseInterface
    {
        return \GuzzleHttp\Promise\Create::promiseFor(0);
    }

    public function getUserId(): ?int
    {
        return config('services.steam.account_id');
    }

    public function getMonthlyTimeByProject(Carbon $dayOfMonth): PromiseInterface
    {
        $som = $dayOfMonth->copy()->startOfMonth();
        $eom = $dayOfMonth->copy()->endOfMonth();

        return $this->getSeconds($som, $eom)->then(function($seconds) {
            $map = new ProjectTimes();

            if ($seconds) {
                $map->add(new ProjectTime(
                    'dota2',
                    'dota2',
                    'Dota 2',
                    $seconds
                ));
            }

            return $map;
        });
    }

    public function getMatches()
    {
        return cache()->remember('dota_2_matches', 3600, function() {
            $res = $this->get("/api/players/141077610/matches")->wait(); // Wait for promise since this is cached
            return json_decode($res->getBody()->getContents());
        });
    }

    public function getMonthIntervals(Carbon $dayOfMonth): PromiseInterface
    {
        return \GuzzleHttp\Promise\Create::promiseFor(new ProjectTimes());
    }
}
