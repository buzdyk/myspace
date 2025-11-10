<?php

namespace App\Trackers;

use App\Interfaces\TimeTracker;
use App\TrackerConfigs\MayvenConfig;
use App\Types\ProjectTimes;
use App\Types\ProjectTime;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Support\Facades\Cache;

class Mayven extends Rest implements TimeTracker
{
    protected Client $client;

    public function __construct(
        protected MayvenConfig $config
    ) {}

    protected function baseUri(): string
    {
        return $this->config->api_url;
    }

    public function headers(): array
    {
        return [
            'Authorization' => $this->config->token,
            'Accept' => 'application/json',
        ];
    }

    public function getMonthIntervals(Carbon $dayOfMonth): PromiseInterface
    {
        $som = $dayOfMonth->copy()->startOfMonth();
        $eom = $dayOfMonth->copy()->endOfMonth();

        return $this->get("/api/time-statistics", ['query' => [
            "dateStart" => $som->toDateString() . ' 00:00:00',
            "dateEnd" => $eom->toDateString() . ' 23:59:59',
            "users[]" => $this->getUserId(),
        ]])->then(function($res) {
            $items = json_decode($res->getBody()->getContents());
            $times = new ProjectTimes();

            foreach ($items->data->chartData as $item) {
                $times->add(new ProjectTime('x', 'x', 'x', (int) $item->seconds, new Carbon($item->_date)));
            }

            return $times;
        });
    }

    public function getSeconds(Carbon $from, Carbon $to): PromiseInterface
    {
        return $this->get("/api/time-statistics", ['query' => [
            "dateStart" => $from->toDateString() . ' 00:00:00',
            "dateEnd" => $to->toDateString() . ' 23:59:59',
            "users[]" => $this->getUserId(),
        ]])->then(function($res) {
            $data = json_decode($res->getBody()->getContents());
            return array_reduce($data->data->chartData, fn ($carry, $item) => $carry + $item->seconds, 0);
        });
    }

    public function getUserId(): ?int
    {
        return Cache::rememberForever($this->config->api_url . '_user_id', function() {
            $res = $this->get("/api/hydrate")->wait(); // Wait for promise since this is cached
            $data = json_decode($res->getBody()->getContents());
            return $data->data->me->data->id;
        });
    }

    public function getRunningSeconds(): PromiseInterface
    {
        return $this->get("/api/timer")->then(function($res) {
            $current = json_decode($res->getBody()->getContents());

            $now = new Carbon();
            $then = new Carbon($current?->data?->started_at);

            return $now->diffInSeconds($then, true);
        });
    }

    public function getMonthlyTimeByProject(Carbon $dayOfMonth): PromiseInterface
    {
        return $this->get("/api/time-statistics", ['query' => [
            "dateStart" => $dayOfMonth->copy()->startOfMonth()->toDateString() . ' 00:00:00',
            "dateEnd" => $dayOfMonth->copy()->endOfMonth()->toDateString() . ' 23:59:59',
            "users[]" => $this->getUserId(),
            "groupByPrimaryValue" => "project_id",
            "groupBySecondValue" => "todo_id",
            "groupBy" => "project_id",
            "orderBy" => "seconds:desc"
        ]])->then(function($res) {
            $map = new ProjectTimes();
            foreach (json_decode($res->getBody()->getContents())->data->aggregatedIntervals as $item) {
                $map->add(new ProjectTime('mayven', $item->item_id, $item->title, $item->seconds));
            }
            return $map;
        });
    }
}
