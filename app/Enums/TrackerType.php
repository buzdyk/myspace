<?php

namespace App\Enums;

enum TrackerType: string
{
    case Mayven = 'mayven';
    case Clockify = 'clockify';
    case Everhour = 'everhour';
    case Dota2 = 'dota2';
    case Placeholder = 'placeholder';
}
