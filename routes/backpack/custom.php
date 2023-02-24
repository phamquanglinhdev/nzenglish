<?php

use App\Http\Controllers\Admin\StudentCrudController;
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
    Route::crud('invoice', 'InvoiceCrudController');
    Route::crud('old', 'OldCrudController');
}); // this should be the absolute last line of this file
