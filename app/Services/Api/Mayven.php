<?php

namespace App\Services\Api;

use App\Interfaces\TimeTracker;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Cache;

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
}
