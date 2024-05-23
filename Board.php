<?php

class Board
{
    private array $cells;
    private int $width;
    private int $height;

    public function __construct(int $width, int $height)
    {
        $this->width = $width;
        $this->height = $height;
        $this->clear();
    }

    private function clear()
    {
        for ($row = 0; $row < $this->height; $row++) {
            for ($cell = 0; $cell < $this->width; $cell++) {
                $this->cells[$row][$cell] = null;
            }
        }
    }

    public function display(): void
    {
        $matchSymbols = [" ", "*", "&"]; // & gets drawn when two matches are overlapping
        $horizontalLine = str_repeat("+---", $this->width) . "+\n";
        foreach ($this->cells as $row) {
            echo $horizontalLine;
            foreach ($row as $element) {
                echo "|";
                echo " $element ";
//                $matchSymbol = $matchSymbols[min($element->matchCount, 2)];
//                echo $matchSymbol . $element->symbol . $matchSymbol;
            }
            echo "|";
            echo "\n";
        }
        echo $horizontalLine;
    }

    public function cells(): array
    {
        return $this->cells;
    }

    public function map(Closure $function): void
    {
        foreach ($this->cells as $rowIndex => $row) {
            foreach ($row as $colIndex => $cell) {
                $this->cells[$rowIndex][$colIndex] = $function($cell, $rowIndex, $colIndex);
            }
        }
    }

    public function iterate(Closure $function): void
    {
        foreach ($this->cells as $rowIndex => $row) {
            foreach ($row as $colIndex => $cell) {
                $function($cell, $rowIndex, $colIndex);
            }
        }
    }

    public function width(): int
    {
        return $this->width;
    }

    public function height(): int
    {
        return $this->height;
    }
}
