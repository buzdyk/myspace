<?php

namespace App\Models;

use App\Casts\TrackerConfigCast;
use App\Enums\TrackerStatus;
use App\Enums\TrackerType;
use Illuminate\Database\Eloquent\Model;

class Tracker extends Model
{
    protected $fillable = [
        'title',
        'type',
        'status',
        'config',
    ];

    protected $casts = [
        'type' => TrackerType::class,
        'status' => TrackerStatus::class,
        'config' => TrackerConfigCast::class,
    ];
}
