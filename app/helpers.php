<?php

function hoursToString($number) {
    $hours = floor($number);
    $minutes = round(($number - $hours) * 60);
    return $hours . 'h ' . str_pad($minutes, 2, '0', STR_PAD_LEFT) . 'm';
}
