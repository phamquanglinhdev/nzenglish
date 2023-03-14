<?php

use App\Http\Controllers\Admin\EditableController;
use App\Http\Controllers\Admin\StudentCrudController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect("/admin");
});
Route::post("/editable", [EditableController::class, "update"])->name("editable");
Route::post("/extend", [StudentCrudController::class, "extend"])->name("extend");
