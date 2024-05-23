<?php

include "config.php";

require_once "Board.php";
require_once "Match.php";
require_once "SlotMachine.php";


function promptStartingCoins(): int
{
    echo "Enter the total amount of coins you wish to play with!\n";
    while (true) {
        $coins = readline("Amount - ");
        if (!is_numeric($coins)) {
            echo "Coin amount must be a numeric value!\n";
            continue;
        }
        $coins = (int)$coins;
        if ($coins <= 0) {
            echo "Coin amount must be greater than 0!\n";
            continue;
        }
        if ($coins >= 1000000) {
            echo "Coin amount must be less than 1 000 000!\n";
            continue;
        }
        break;
    }
    return $coins;
}

function promptBetAmount($coins): int
{
    echo "Enter your bet amount\n";
    while (true) {
        $bet = readline("Amount - ");
        if (!is_numeric($bet)) {
            echo "Bet amount must be a numeric value!\n";
            continue;
        }
        $bet = (int)$bet;
        if ($bet <= 0) {
            echo "Bet amount must be greater than 0!\n";
            continue;
        }
        if ($bet > $coins) {
            echo "Bet amount must be less than your coin count!\n";
            continue;
        }
        return $bet;
    }
}

function displayProfit(int $profit): void
{
    $profitDisplay = abs($profit);
    if ($profit > 0) {
        echo "Nice! You made a profit of $profitDisplay coins!\n";
    }
    if ($profit < 0) {
        echo "Oh no! You made a loss of $profitDisplay coins!\n";
    }
    if ($profit === 0) {
        echo "You broke even!\n";
    }
}

echo "Welcome!\n";
$coins = promptStartingCoins();
$slotMachine = new SlotMachine($config);
$bet = promptBetAmount($coins);

while (true) {
    echo "You have $coins coins.\n";
    while (true) {
        echo "1) Play with a bet of $bet coins\n";
        echo "2) Change bet amount\n";
        echo "3) Exit\n";
        $choice = readline("Choice: ");
        switch ($choice) {
            case 1:
                $coinsBeforePlaying = $coins;
                $coins -= $bet;
                $coins += $slotMachine->play($bet);
                $profit = $coins - $coinsBeforePlaying;
                displayProfit($profit);
                if ($coins <= 0) {
                    exit("You ran out of money! Oh well, thanks for playing!\n");
                }
                if ($bet > $coins) {
                    $bet = $coins;
                }
                break 2;
            case 2:
                $bet = promptBetAmount($coins);
                break;
            case 3:
                echo "Thanks for playing!\n";
                exit;
            default:
                echo "Invalid choice!";
        }
    }
}