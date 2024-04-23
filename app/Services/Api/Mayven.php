<?php

namespace App\Services\Api;

use App\Interfaces\TimeTracker;
use App\Types\ProjectTimes;
use App\Types\ProjectTime;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class Mayven extends Rest implements TimeTracker
{
    protected Client $client;

    protected function baseUri(): string
    {
        return config('services.mayven.api_url');
    }

    public function headers(): array
    {
        return [
            'Authorization' => config('services.mayven.auth'),
            'Accept' => 'application/json',
        ];
    }

    public function getSeconds(Carbon $from, Carbon $to): int
    {
        $res = $this->get("/api/time-statistics", ['query' => [
            "dateStart" => $from->toDateString() . ' 00:00:00',
            "dateEnd" => $to->toDateString() . ' 23:59:59',
            "users[]" => $this->getUserId(),
        ]]);

        $data = json_decode($res->getBody()->getContents());

        return array_reduce($data->data->chartData, fn ($carry, $item) => $carry + $item->seconds, 0);
    }

    public function getUserId(): ?int
    {
        return Cache::rememberForever('mayven_user_id', function() {
            $res = $this->get("/api/hydrate");
            $data = json_decode($res->getBody()->getContents());
            return $data->data->me->data->id;
        });
    }

    public function getRunningSeconds(): int
    {
        $res = $this->get("/api/timer");
        $current = json_decode($res->getBody()->getContents());

        $now = new Carbon();
        $then = new Carbon($current?->data?->started_at);

        return $now->diffInSeconds($then, true);
    }

    public function getMonthlyTimeByProject(Carbon $dayOfMonth): ProjectTimes
    {
        $res = $this->get("/api/time-statistics", ['query' => [
            "dateStart" => $dayOfMonth->copy()->startOfMonth()->toDateString() . ' 00:00:00',
            "dateEnd" => $dayOfMonth->copy()->endOfMonth()->toDateString() . ' 23:59:59',
            "users[]" => $this->getUserId(),
            "groupByPrimaryValue" => "project_id",
            "groupBySecondValue" => "todo_id",
            "groupBy" => "project_id",
            "orderBy" => "seconds:desc"
        ]]);

        $map = new ProjectTimes();
        foreach (json_decode($res->getBody()->getContents())->data->aggregatedIntervals as $item) {
            $map->add(new ProjectTime('mayven', $item->item_id, $item->title, $item->seconds));
        }

        return $map;
    }
}
