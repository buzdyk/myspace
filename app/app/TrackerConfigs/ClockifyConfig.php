<?php

namespace App\TrackerConfigs;

class ClockifyConfig
{
    public function __construct(
        public string $token,
        public string $workspace_id,
        public string $user_id
    ) {}
}
