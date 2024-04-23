<?php

use Illuminate\Support\Facades\Route;

Route::get('/', \App\Livewire\DailyAndMonthlyGoals::class);
Route::get('/monthly-by-project', \App\Livewire\MonthlyTimeByProject::class);
