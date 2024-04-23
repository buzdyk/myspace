<?php

namespace App\Types;

class ProjectTime
{
    public function __construct(
        public string $source,
        public string $projectId,
        public string $projectTitle,
        public int $seconds,
    ) {}

    public function getHours(): float
    {
        return round(($this->seconds / 3600), 2);
    }
}
