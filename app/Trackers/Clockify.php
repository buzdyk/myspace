<?php

namespace App\Trackers;

use App\Interfaces\TimeTracker;
use App\Types\ProjectTimes;
use App\Types\ProjectTime;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class Clockify extends Rest implements TimeTracker
{
    protected Client $client;

    protected function baseUri(): string
    {
        return "https://api.clockify.me";
    }

    public function headers(): array
    {
        return [
            'x-api-key' => config('services.clockify.token'),
            'Accept' => 'application/json',
        ];
    }

    private function getPathWithWorkspace(string $path = '/'): string
    {
        $wid = config('services.clockify.workspace_id');

        return "/api/v1/workspaces/$wid". $path;
    }

    private function getSecondsForTimeEntry($entry): ?int
    {
        $start = new Carbon($entry->timeInterval->start);
        $end = new Carbon($entry->timeInterval->end);

        return $end->diffInSeconds($start, true);
    }

    public function getMonthIntervals(Carbon $dayOfMonth): ProjectTimes
    {
        $som = $dayOfMonth->copy()->startOfMonth();
        $eom = $dayOfMonth->copy()->endOfMonth();

        $path = $this->getPathWithWorkspace("/user/" . $this->getUserId() . "/time-entries");
        $res = $this->get($path, ['query' => [
            "start" => $som->toDateString() . 'T00:00:00Z',
            "end" => $eom->toDateString() . 'T23:59:59Z',
        ]]);

        $items = json_decode($res->getBody()->getContents());
        $times = new ProjectTimes();

        foreach ($items as $item) {
            $seconds = $this->getSecondsForTimeEntry($item);
            $date = new Carbon($item->timeInterval->start);
            $times->add(new ProjectTime('x', 'x', 'x', (int) $seconds, $date));
        }

        return $times;
    }

    public function getSeconds(Carbon $from, Carbon $to): int
    {
        $path = $this->getPathWithWorkspace("/user/" . $this->getUserId() . "/time-entries");
        $res = $this->get($path, ['query' => [
            "start" => $from->toDateString() . 'T00:00:00Z',
            "end" => $to->toDateString() . 'T23:59:59Z',
        ]]);

        $items = json_decode($res->getBody()->getContents());
        $reducer = fn ($carry, $item) => $carry + $this->getSecondsForTimeEntry($item);

        return array_reduce($items, $reducer, 0);
    }

    public function getUserId(): ?string
    {
        return "664b5f396c802f039134f95d";

//        return Cache::rememberForever('mayven_user_id', function() {
//            $res = $this->get("/api/hydrate");
//            $data = json_decode($res->getBody()->getContents());
//            return $data->data->me->data->id;
//        });
    }

    public function getRunningSeconds(): int
    {
        return 0;
//        $res = $this->get("/api/timer");
//        $current = json_decode($res->getBody()->getContents());
//
//        $now = new Carbon();
//        $then = new Carbon($current?->data?->started_at);
//
//        return $now->diffInSeconds($then, true);
    }

    public function getMonthlyTimeByProject(Carbon $dayOfMonth): ProjectTimes
    {
        $som = $dayOfMonth->copy()->startOfMonth();
        $eom = $dayOfMonth->copy()->endOfMonth();

        $projectTimes = new ProjectTimes();
        $projectTimes->add(new ProjectTime('clockify', 'x', 'Hello Cake', $this->getSeconds($som, $eom)));

        return $projectTimes;
    }
}
