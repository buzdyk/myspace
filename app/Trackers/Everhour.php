<?php

namespace App\Trackers;

use App\Interfaces\TimeTracker;
use App\Types\ProjectTimes;
use App\Types\ProjectTime;
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

    public function getMonthIntervals(Carbon $dayOfMonth): ProjectTimes
    {
        $som = $dayOfMonth->copy()->startOfMonth();
        $eom = $dayOfMonth->copy()->endOfMonth();

        $query = [
            'from' => $som->toDateString(),
            'to' => $eom->toDateString(),
        ];

        $res = $this->get("/users/{$this->getUserId()}/time", ['query' => $query]);
        $items = json_decode($res->getBody()->getContents());

        $times = new ProjectTimes();

        foreach ($items as $item) {
            $times->add(new ProjectTime('x', 'x', 'x', (int) $item->time, new Carbon($item->createdAt)));
        }

        return $times;
    }

    public function getMonthlyTimeByProject(Carbon $dayOfMonth): ProjectTimes
    {
        $som = $dayOfMonth->copy()->startOfMonth();
        $eom = $dayOfMonth->copy()->endOfMonth();

        $map = new ProjectTimes();

        /**
         * the sum of items returned is incorrect (eg 35 hours instead of 62 hours)
         * it's either me missing something or a bug on the everhour side
         * temporary solution: we assume a user has only one project in everhour
         */

        if ($seconds = $this->getSeconds($som, $eom)) {
            $map->add(new ProjectTime(
                'everhour',
                'one-and-only',
                $this->getProjectName('one-and-only'),
                $seconds
            ));
        }

        return $map;
    }

    private function getProjectName(string|int $projectId): string
    {
        $key = 'everhour_project_name_' . $projectId;

        return Cache::rememberForever($key, function() {
            $res = $this->get("/projects");
            $projects = json_decode($res->getBody()->getContents());
            return $projects[0]->name;
        });
    }
}
