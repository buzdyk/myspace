<?php

namespace App\Enums;

enum TrackerStatus: string
{
    case Disconnected = 'disconnected';
    case Active = 'active';
    case Paused = 'paused';
}
