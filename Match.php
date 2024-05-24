<?php

class Match
{
    private Element $element;
    private WinCondition $winCondition;
    private int $payout = 0;

    public function __construct(Element $element, WinCondition $winCondition)
    {
        $this->element = $element;
        $this->winCondition = $winCondition;
    }

    public function condition(): WinCondition
    {
        return $this->winCondition;
    }

    public function element(): Element
    {
        return $this->element;
    }

    public function payout(): int
    {
        return $this->payout;
    }
    public function setPayout(int $payout): void
    {
        $this->payout = $payout;
    }
}
