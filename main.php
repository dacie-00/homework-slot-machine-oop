<?php

require_once "config.php";
require_once "SlotMachineOperator.php";

$game = new SlotMachineOperator($config);
$game->start();
