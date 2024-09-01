<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\{
    SettingsController, CalendarController, ProjectsController, TodayController
};

Route::get('/', function() {
    return redirect()->to('/today');
});


Route::get('/settings', [SettingsController::class, 'index']);
Route::post('/settings', [SettingsController::class, 'store']);

Route::get('/month', [ProjectsController::class, 'redirect']);
Route::get('/{year}/{month}/calendar', [CalendarController::class, 'index']);
Route::get('/{year}/{month}/projects', [ProjectsController::class, 'index']);

Route::get('/today', [TodayController::class, 'redirect']);
Route::get('/{year}/{month}/{day}', [TodayController::class, 'index']);
