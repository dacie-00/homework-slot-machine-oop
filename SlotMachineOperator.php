<?php

include "config.php";

require_once "Board.php";
require_once "Match.php";
require_once "SlotMachine.php";


class SlotMachineOperator
{
    private int $coins;
    private int $bet;
    private SlotMachine $slotMachine;

    public function __construct($config)
    {
        $this->coins = $this->promptStartingCoins();
        $this->bet = $this->promptBetAmount();
        $this->slotMachine = new SlotMachine($config);
    }

    private function promptStartingCoins(): int
    {
        echo "Enter the total amount of coins you wish to play with!\n";
        while (true) {
            $this->coins = readline("Amount - ");
            if (!is_numeric($this->coins)) {
                echo "Coin amount must be a numeric value!\n";
                continue;
            }
            $this->coins = (int)$this->coins;
            if ($this->coins <= 0) {
                echo "Coin amount must be greater than 0!\n";
                continue;
            }
            if ($this->coins >= 1000000) {
                echo "Coin amount must be less than 1 000 000!\n";
                continue;
            }
            break;
        }
        return $this->coins;
    }

    private function promptBetAmount(): int
    {
        echo "Enter your bet amount\n";
        while (true) {
            $this->bet = readline("Amount - ");
            if (!is_numeric($this->bet)) {
                echo "Bet amount must be a numeric value!\n";
                continue;
            }
            $this->bet = (int)$this->bet;
            if ($this->bet <= 0) {
                echo "Bet amount must be greater than 0!\n";
                continue;
            }
            if ($this->bet > $this->coins) {
                echo "Bet amount must be less than your coin count!\n";
                continue;
            }
            return $this->bet;
        }
    }

    private function displayProfit(int $profit): void
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

    public function start()
    {
        echo "Welcome!\n";
        $this->run();
    }

    private function run()
    {
        while (true) {
            echo "You have $this->coins coins.\n";
            while (true) {
                echo "1) Play with a bet of $this->bet coins\n";
                echo "2) Change bet amount\n";
                echo "3) Exit\n";
                $choice = readline("Choice: ");
                switch ($choice) {
                    case 1:
                        $coinsBeforePlaying = $this->coins;
                        $this->coins -= $this->bet;
                        $this->coins += $this->slotMachine->play($this->bet);
                        $profit = $this->coins - $coinsBeforePlaying;
                        $this->displayProfit($profit);
                        if ($this->coins <= 0) {
                            exit("You ran out of money! Oh well, thanks for playing!\n");
                        }
                        if ($this->bet > $this->coins) {
                            $this->bet = $this->coins;
                        }
                        break 2;
                    case 2:
                        $this->bet = $this->promptBetAmount();
                        break;
                    case 3:
                        echo "Thanks for playing!\n";
                        exit;
                    default:
                        echo "Invalid choice!\n";
                }
            }
        }
    }
}
