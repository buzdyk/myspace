<?php

namespace App\Services\Api;

use App\Interfaces\TimeTracker;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class Everhour extends Rest implements TimeTracker
{
    protected Client $client;

    protected function baseUri(): string
    {
        return config('services.everhour.api_url');
    }

    protected function headers(): array
    {
        return ['X-Api-Key' => config('services.everhour.token')];
    }

    public function getSeconds(Carbon $from, Carbon $to): int
    {
        $res = $this->get("/users/{$this->getUserId()}/time", ['query' => [
            'from' => $from->toDateString(),
            'to' => $to->toDateString(),
        ]]);

        $items = json_decode($res->getBody()->getContents());

        return array_reduce($items, fn ($carry, $item) => $item->time + $carry, 0);
    }

    public function getRunningSeconds(): int
    {
        $res = $this->get("/timers/current");

        $data = json_decode($res->getBody()->getContents());

        if ($data->status !== 'active') {
            return 0;
        }

        return $data->duration;
    }

    public function getUserId(): ?int
    {
        return Cache::rememberForever('everhour_user_id', function() {
            $res = $this->get("/users/me");
            $user = json_decode($res->getBody()->getContents());
            return $user->id;
        });
    }
}
