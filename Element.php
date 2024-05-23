<?php

class Element
{
    private string $symbol;
    private int $chance;
    private int $value;
    private int $matchCount;

    public function __construct(string $symbol, int $chance, int $value)
    {
        $this->symbol = $symbol;
        $this->chance = $chance;
        $this->matchCount = 0;
        $this->value = $value;
    }

    public function symbol(): string
    {
        return $this->symbol;
    }

    public function chance(): int
    {
        return $this->chance;
    }

    public function value(): int
    {
        return $this->value;
    }

    public function matchCount(): int
    {
        return $this->matchCount;
    }

    public function incrementMatchCount(): void
    {
        $this->matchCount++;
    }
}