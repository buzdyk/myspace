<?php

namespace App\Types;

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
}
