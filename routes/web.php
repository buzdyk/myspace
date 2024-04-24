<?php

use Illuminate\Support\Facades\Route;

Route::get('/', \App\Livewire\Goals::class);
Route::get('/month-review', \App\Livewire\MonthReview::class);
