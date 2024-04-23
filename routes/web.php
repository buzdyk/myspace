<?php

use Illuminate\Support\Facades\Route;

Route::get('/', \App\Livewire\DailyAndMonthlyGoals::class);
Route::get('/month-review', \App\Livewire\MonthlyTimeByProject::class);
