<?php

namespace App\Services;

use App\Interfaces\TimeTracker;
use Carbon\Carbon;
use GuzzleHttp\Client;

class MayvenAPI implements TimeTracker
{
    protected Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => config('services.mayven.api_url'),
            'headers' => [
                'Authorization' => config('services.mayven.auth'),
                'Accept' => 'application/json',
            ]
        ]);

    }

    public function getSeconds(Carbon $from, Carbon $to): int
    {
        $res = $this->client->get("/api/time-statistics", ['query' => [
            "dateStart" => $from->toDateString() . ' 00:00:00',
            "dateEnd" => $to->toDateString() . ' 23:59:59',
//            "datePreset" => '{"segment":"month","diff":0}'
        ]]);

        $data = json_decode($res->getBody()->getContents());

        return array_reduce($data->data->chartData, fn ($carry, $item) => $carry + $item->seconds, 0);
    }

    public function getRunningSeconds(): int
    {
        $res = $this->client->get("/api/timer");
        $current = json_decode($res->getBody()->getContents());

        $now = new Carbon();
        $then = new Carbon($current?->data?->started_at);

        return $now->diffInSeconds($then, true);
    }
}
