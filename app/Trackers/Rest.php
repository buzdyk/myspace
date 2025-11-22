<?php

namespace App\Trackers;

use GuzzleHttp\Client;
use GuzzleHttp\Promise\PromiseInterface;

abstract class Rest
{
    private static Client $client;

    /**
     * Make an async GET request that returns a promise.
     * The promise resolves to a PSR-7 ResponseInterface.
     */
    protected function get($path, array $params = []): PromiseInterface
    {
        $params['headers'] = $this->headers();
        $uri = $this->baseUri() . $path;

        return $this->client()->getAsync($uri, $params);
    }

    private function client(): Client
    {
        if (!isset(self::$client)) {
            self::$client = new Client();
        }

        return self::$client;
    }

    abstract protected function baseUri(): string;
    abstract protected function headers(): array;
}
