<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Router;
use \App\Http\Controllers\{
    SettingsController, CalendarController, ProjectsController, TodayController
};

Route::get('/', function() {
    return redirect()->to('/today');
});


Route::get('/settings', [SettingsController::class, 'index']);
Route::post('/settings', [SettingsController::class, 'store']);

Route::middleware(\App\Http\Middleware\RedirectIfSettingsNotValid::class)->group(function(Router $router) {
    $router->get('/month', [ProjectsController::class, 'redirect']);
    $router->get('/{year}/{month}/calendar', [CalendarController::class, 'index']);
    $router->get('/{year}/{month}/projects', [ProjectsController::class, 'index']);

    $router->get('/today', [TodayController::class, 'redirect']);
    $router->get('/{year}/{month}/{day}', [TodayController::class, 'index']);
});
