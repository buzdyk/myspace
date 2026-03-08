<?php

namespace App\TrackerConfigs;

class MayvenConfig
{
    public function __construct(
        public string $api_url,
        public string $token
    ) {}
}
