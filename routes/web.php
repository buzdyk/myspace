<?php

use App\Http\Controllers\Month\{
    CalendarController,
    ProjectsController
};
use App\Http\Controllers\Settings\{
    TrackersController,
    GeneralController
};
use App\Http\Controllers\TodayController;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

Route::get('/', function() {
    return redirect()->to('/today');
});


Route::get('/settings/trackers', [TrackersController::class, 'index']);
Route::get('/settings', [GeneralController::class, 'index']);
Route::post('/settings', [GeneralController::class, 'store']);

Route::middleware(\App\Http\Middleware\RedirectIfSettingsNotValid::class)->group(function(Router $router) {
    $router->get('/month', [ProjectsController::class, 'redirect']);
    $router->get('/{year}/{month}/calendar', [CalendarController::class, 'index']);
    $router->get('/{year}/{month}/projects', [ProjectsController::class, 'index']);

    $router->get('/today', [TodayController::class, 'redirect']);
    $router->get('/{year}/{month}/{day}', [TodayController::class, 'index']);
});
