<?php

namespace App\Types;

use Carbon\Carbon;

class ProjectTimes
{
    protected array $items = [];
    protected int $currentIndex = 0;

    public function add(ProjectTime $time): self
    {
        $this->items[] = $time;
        return $this;
    }

    public function merge(ProjectTimes $items): self
    {
        $items->rewind();
        while ($item = $items->next()) {
            $this->add($item);
        }

        return $this;
    }

    public function rewind(): void
    {
        $this->currentIndex = 0;
    }

    public function next(): ?ProjectTime
    {
        $this->currentIndex = $this->currentIndex + 1;
        return $this->items[$this->currentIndex - 1] ?? null;
    }

    public function count(): int
    {
        return count($this->items);
    }

    public function getHours(): float
    {
        $reducer = fn ($carry, ProjectTime $item) => $item->getHours() + $carry;
        return array_reduce($this->items, $reducer, 0);
    }

    public function getDailyHours(Carbon $dayOfMonth): array
    {
        $som = $dayOfMonth->copy()->startOfMonth();
        $eom = $dayOfMonth->copy()->endOfMonth();
        $days = [];

        while ($som->isBefore($eom)) {
            $days[$som->toDateString()] = null;
            $som->addDay(1);
        }

        $this->rewind();

        while ($item = $this->next()) {
            $day = $item->datetime->toDateString();
            $days[$day] += $item->getHours();
        }

        return $days;
    }

    public function toArray(): array
    {
        return array_map(fn (ProjectTime $pt) => $pt->toArray(), $this->items);
    }
}
