<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function() {
    return redirect()->to('/today');
});

Route::get('/today', [\App\Http\Controllers\TodayController::class, 'index']);
Route::get('/{year}/{month}', [\App\Http\Controllers\MonthController::class, 'index']);
Route::get('/month', [\App\Http\Controllers\MonthController::class, 'redirect']);
Route::get('/settings', [\App\Http\Controllers\SettingsController::class, 'index']);

Route::post('/settings', [\App\Http\Controllers\SettingsController::class, 'store']);
Route::get('/{year}/{month}/calendar', [\App\Http\Controllers\DraftController::class, 'index']);
