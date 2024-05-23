<?php

class Match {
    private Element $element;
    private WinCondition $winCondition;

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
}
