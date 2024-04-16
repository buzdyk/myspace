<?php

namespace App\Services;

use Carbon\Carbon;
use GuzzleHttp\Client;

class EverhourAPI
{
    protected Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => config('services.everhour.api_url'),
            'headers' => [
                'X-Api-Key' => config('services.everhour.token'),
            ]
        ]);
    }

    public function getSeconds(Carbon $from, Carbon $to): int
    {
        $res = $this->client->get("/users/me");
        $user = json_decode($res->getBody()->getContents());

        $res = $this->client->get("/users/{$user->id}/time", ['query' => [
            'from' => $from->toDateString(),
            'to' => $to->toDateString(),
        ]]);

        $items = json_decode($res->getBody()->getContents());

        return array_reduce($items, fn ($carry, $item) => $item->time + $carry, 0);
    }

    public function getRunningSeconds(): int
    {
        $res = $this->client->get("/timers/current");

        $data = json_decode($res->getBody()->getContents());

        if ($data->status !== 'active') {
            return 0;
        }

        return $data->duration;
    }
}