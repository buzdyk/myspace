<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tracker extends Model
{
    protected $casts = [
        'token' => 'encrypted',
    ];
}
