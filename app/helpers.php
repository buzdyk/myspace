<?php

function hoursToString($number) {
    if (!$number) return null;

    $hours = floor($number);
    $minutes = round(($number - $hours) * 60);
    return $hours . ':' . str_pad($minutes, 2, '0', STR_PAD_LEFT);
}
