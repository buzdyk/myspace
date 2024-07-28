<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function() {
    return redirect()->to('/today');
});
Route::get('/month-review', \App\Livewire\MonthReview::class);
Route::get('/wishlist', \App\Livewire\Wishlist::class);

Route::get('/today', [\App\Http\Controllers\TodayController::class, 'index']);
Route::get('/{year}/{month}', [\App\Http\Controllers\MonthController::class, 'index']);
Route::get('/month', [\App\Http\Controllers\MonthController::class, 'redirect']);

