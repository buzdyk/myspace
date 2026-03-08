<?php

namespace App\TrackerConfigs;

class EverhourConfig
{
    public function __construct(
        public string $api_url,
        public string $token
    ) {}
}
