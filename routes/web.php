<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function() {
    return redirect()->to('/today');
});
Route::get('/today', \App\Livewire\Goals::class);
Route::get('/month-review', \App\Livewire\MonthReview::class);
Route::get('/wishlist', \App\Livewire\Wishlist::class);
