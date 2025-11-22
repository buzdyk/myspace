<?php

namespace App\Trackers;

use App\Interfaces\TimeTracker;
use App\TrackerConfigs\ClockifyConfig;
use App\Types\ProjectTimes;
use App\Types\ProjectTime;
use Carbon\Carbon;
use Faker\Provider\Image;
use GuzzleHttp\Client;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Support\Facades\Cache;

class Clockify extends Rest implements TimeTracker
{
    protected Client $client;

    public function __construct(
        protected ClockifyConfig $config
    ) {}

    protected function baseUri(): string
    {
        return "https://api.clockify.me";
    }

    public function headers(): array
    {
        return [
            'x-api-key' => $this->config->token,
            'Accept' => 'application/json',
        ];
    }

    private function getPathWithWorkspace(string $path = '/'): string
    {
        $wid = $this->config->workspace_id;

        return "/api/v1/workspaces/$wid". $path;
    }

    private function getSecondsForTimeEntry($entry): ?int
    {
        $start = new Carbon($entry->timeInterval->start);
        $end = new Carbon($entry->timeInterval->end);

        return $end->diffInSeconds($start, true);
    }

    public function getMonthIntervals(Carbon $dayOfMonth): PromiseInterface
    {
        $som = $dayOfMonth->copy()->startOfMonth();
        $eom = $dayOfMonth->copy()->endOfMonth();

        $path = $this->getPathWithWorkspace("/user/" . $this->getUserId() . "/time-entries");
        return $this->get($path, ['query' => [
            "start" => $som->toDateString() . 'T00:00:00Z',
            "end" => $eom->toDateString() . 'T23:59:59Z',
        ]])->then(function($res) {
            $items = json_decode($res->getBody()->getContents());
            $times = new ProjectTimes();

            foreach ($items as $item) {
                $seconds = $this->getSecondsForTimeEntry($item);
                $date = new Carbon($item->timeInterval->start);
                $times->add(new ProjectTime('x', 'x', 'x', (int) $seconds, $date));
            }

            return $times;
        });
    }

    public function getSeconds(Carbon $from, Carbon $to): PromiseInterface
    {
        $path = $this->getPathWithWorkspace("/user/" . $this->getUserId() . "/time-entries");
        return $this->get($path, ['query' => [
            "start" => $from->toDateString() . 'T00:00:00Z',
            "end" => $to->toDateString() . 'T23:59:59Z',
        ]])->then(function($res) {
            $items = json_decode($res->getBody()->getContents());
            $reducer = fn ($carry, $item) => $carry + $this->getSecondsForTimeEntry($item);

            return array_reduce($items, $reducer, 0);
        });
    }

    public function getUserId(): ?string
    {
        return $this->config->user_id;
    }

    public function getRunningSeconds(): PromiseInterface
    {
        return \GuzzleHttp\Promise\Create::promiseFor(0);
    }

    public function getMonthlyTimeByProject(Carbon $dayOfMonth): PromiseInterface
    {
        $som = $dayOfMonth->copy()->startOfMonth();
        $eom = $dayOfMonth->copy()->endOfMonth();

        return $this->getSeconds($som, $eom)->then(function($seconds) {
            $projectTimes = new ProjectTimes();
            $projectTimes->add(new ProjectTime('clockify', 'x', generateRandomString(10), $seconds));

            return $projectTimes;
        });
    }
}
