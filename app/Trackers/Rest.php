<?php

namespace App\Trackers;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

abstract class Rest
{
    private static Client $client;

    protected function get($path, array $params = []): ResponseInterface
    {
        $params['headers'] = $this->headers();
        $uri = $this->baseUri() . $path;

        return $this->client()->get($uri, $params);
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
