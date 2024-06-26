<?php

class SlotMachine
{
    private Board $board;
    private array $winConditions;
    private array $elements;
    private int $baseBet = 5;

    public function __construct($config)
    {
        $this->board = new Board($config["width"], $config["height"]);
        $this->winConditions = $config["winConditions"];
        $this->elements = $config["elements"];
    }

    public function play($bet): array
    {
        $this->fillBoard();
        $matches = $this->findMatches();

        $betRatio = $bet / $this->baseBet;
        foreach ($matches as $match) {
            $this->markMatchedElements($match);
            $match->setPayout($this->calculateMatchPayout($match, $betRatio));
        }
        return $matches;
    }

    private function fillBoard(): void
    {
        $this->board->map(function () {
            return clone $this->getRandomElement();
        });
    }

    private function getRandomElement(): Element
    {
        // weighted random
        $totalChance = 0;
        foreach ($this->elements as $element) {
            $totalChance += $element->chance();
        }
        $randomValue = mt_rand(1, $totalChance);

        foreach ($this->elements as $element) {
            if ($element->chance() < 0) {
                throw new InvalidArgumentException("Element chance cannot be negative");
            }
            $randomValue -= $element->chance();
            if ($randomValue <= 0) {
                return $element;
            }
        }
        return $this->elements[0]; // Code should never get here, but in case it does we just return the first element
    }

    private function findMatches(): array
    {
        $matches = [];

        foreach ($this->winConditions as $winCondition) {
            if ($this->checkMatch($winCondition)) {
                $x = $winCondition->positions()[0][0];
                $y = $winCondition->positions()[0][1];
                $matches[] = new Match($this->board->cells()[$y][$x], $winCondition);
            }
        }
        return $matches;
    }

    private function checkMatch(WinCondition $condition): bool
    {
        $positions = $condition->positions();

        $matchSymbol = $this->board->cells()[$positions[0][1]][$positions[0][0]]->symbol();
        foreach ($positions as $position) {
            $x = $position[0];
            $y = $position[1];
            if ($matchSymbol != $this->board->cells()[$y][$x]->symbol()) {
                return false;
            }
        }
        return true;
    }

    function markMatchedElements(Match $match): void
    {
        foreach ($match->condition()->positions() as $position) {
            $this->board->cells()[$position[1]][$position[0]]->incrementMatchCount();
        }
    }

    private function calculateMatchPayout(Match $match, int $ratio): int
    {
        return (int)($match->element()->value() * count($match->condition()->positions()) * $ratio);
    }

    public function display(): string
    {
        $screen = "";
        $matchSymbols = [" ", "*", "&"]; // symbols to visualize found match locations
        $horizontalLine = "|\n" . str_repeat("+---", $this->board->width()) . "+\n";
        $this->board->iterate(function ($cell, $row, $column) use (&$screen, $matchSymbols, $horizontalLine) {
            if ($column == 0) {
                $screen .= $horizontalLine;
            }
            $matchSymbol = $matchSymbols[min($cell->matchCount(), 2)];
            $screen .= "|" . $matchSymbol . $cell->symbol() . $matchSymbol;
        });
        $screen .= $horizontalLine;
        return $screen;
    }
}
