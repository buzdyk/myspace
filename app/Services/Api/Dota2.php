<?php

namespace App\Services\Api;

use App\Interfaces\TimeTracker;
use App\Types\ProjectTimes;
use App\Types\ProjectTime;
use Carbon\Carbon;
use GuzzleHttp\Client;
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

    public function getSeconds(Carbon $from, Carbon $to): int
    {
        $matches = collect($this->getMatches());
        $reject = fn ($match) => $match->start_time < $from->timestamp || $match->start_time > $to->timestamp;
        $matches = $matches->reject($reject);

        return $matches->sum('duration');
    }

    public function getRunningSeconds(): int
    {
        return 0;
    }

    public function getUserId(): ?int
    {
        return config('services.steam.account_id');
    }

    public function getMonthlyTimeByProject(Carbon $dayOfMonth): ProjectTimes
    {
        $som = $dayOfMonth->copy()->startOfMonth();
        $eom = $dayOfMonth->copy()->endOfMonth();

        $map = new ProjectTimes();

        if ($seconds = $this->getSeconds($som, $eom)) {
            $map->add(new ProjectTime(
                'dota2',
                'dota2',
                'Dota 2',
                $seconds
            ));
        }

        return $map;
    }

    public function getMatches()
    {
        return cache()->remember('dota_2_matches', 3600, function() {
            $res = $this->get("/api/players/141077610/matches");
            return json_decode($res->getBody()->getContents());
        });
    }

    public function getMonthIntervals(Carbon $dayOfMonth): ProjectTimes
    {
        return new ProjectTimes();
    }
}
