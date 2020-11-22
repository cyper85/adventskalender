<?php

// Config laden
include(__DIR__ . "/Advent.php");

$monthday = filter_input(INPUT_GET, 'monthday', FILTER_VALIDATE_INT);
$download = filter_input(INPUT_GET, 'download', FILTER_VALIDATE_BOOLEAN);

(new Advent())->open_door($monthday, $download);
