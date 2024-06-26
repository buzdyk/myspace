<?php

namespace App\Types;

use Carbon\Carbon;

class ProjectTime
{
    public function __construct(
        public string $source,
        public string $projectId,
        public string $projectTitle,
        public int $seconds,
        public null|Carbon $datetime = null
    ) {}

    public function getHours(): float
    {
        return round(($this->seconds / 3600), 2);
    }

    public function toArray(): array
    {
        return [
            'source' => $this->source,
            'projectId' => $this->projectId,
            'projectTitle' => $this->projectTitle,
            'seconds' => $this->seconds,
            'hours' => $this->getHours(),
            'datetime' => $this->datetime
        ];
    }

}
