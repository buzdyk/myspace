<?php

function hoursToString($number, bool $emptyIfNoMinutes = true) {
    if (!$number) {
        return $emptyIfNoMinutes ? null : '00:00';
    }

    $hours = floor($number);
    $minutes = round(($number - $hours) * 60);

    return $hours . ':' . str_pad($minutes, 2, '0', STR_PAD_LEFT);
}
