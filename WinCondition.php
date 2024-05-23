<?php

class WinCondition
{
    private array $positions;

    public function __construct(array $positions)
    {
        $this->positions = $positions;
    }

    public function positions(): array
    {
        return $this->positions;
    }
}