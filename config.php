<?php

require_once "WinCondition.php";
require_once "Element.php";

$config = [
    "width" => 5,
    "height" => 3,
    "winConditions" => [
        new WinCondition([[0, 0], [1, 0], [2, 0], [3, 0], [4, 0]]),
        new WinCondition([[0, 0], [0, 1], [0, 2]]),
        new WinCondition([[1, 1], [2, 1], [3, 1]]),
        new WinCondition([[0, 2], [1, 1], [2, 0], [3, 1], [4, 2]]),
        new WinCondition([[0, 2], [1, 1], [2, 0], [3, 1], [4, 2]])
    ],
    "baseBet" => 5,
    "elements" => [
        new Element("A", 7, 1),
        new Element("B", 1, 5),
        new Element("C", 3, 2),
        new Element("D", 4, 1)
    ]
];
