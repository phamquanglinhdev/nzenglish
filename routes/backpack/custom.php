<?php

use App\Http\Controllers\Admin\StudentCrudController;
use App\Http\Controllers\OriginController;
use Illuminate\Support\Facades\Route;

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix' => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array)config('backpack.base.web_middleware', 'web'),
        (array)config('backpack.base.middleware_key', 'admin')
    ),
    'namespace' => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('student', 'StudentCrudController');
    Route::get('student/{id}/old', [StudentCrudController::class, "old", "id"])->name("student.old");
    Route::get('origin', [OriginController::class, "select"])->name("origin");
    Route::crud('invoice', 'InvoiceCrudController');
    Route::crud('old', 'OldCrudController');
    Route::crud('grade', 'GradeCrudController');
    Route::crud('logs', 'LogCrudController');
    Route::crud('user', 'UserCrudController');
    Route::get('charts/weekly-users', 'Charts\WeeklyUsersChartController@response')->name('charts.weekly-users.index');
    Route::get('charts/daily-log', 'Charts\DailyLogChartController@response')->name('charts.daily-log.index');
    Route::crud('work', 'WorkCrudController');
    Route::crud('document', 'DocumentCrudController');
    Route::crud('basket', 'BasketCrudController');
    Route::crud('book', 'BookCrudController');
}); // this should be the absolute last line of this file