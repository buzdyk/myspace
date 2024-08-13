<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function() {
    return redirect()->to('/today');
});


Route::get('/settings', [\App\Http\Controllers\SettingsController::class, 'index']);
Route::post('/settings', [\App\Http\Controllers\SettingsController::class, 'store']);

Route::get('/month', [\App\Http\Controllers\MonthController::class, 'redirect']);
Route::get('/{year}/{month}/calendar', [\App\Http\Controllers\DraftController::class, 'index']);
Route::get('/{year}/{month}/projects', [\App\Http\Controllers\MonthController::class, 'index']);

Route::get('/today', [\App\Http\Controllers\TodayController::class, 'redirect']);
Route::get('/{year}/{month}/{day}', [\App\Http\Controllers\TodayController::class, 'index']);
