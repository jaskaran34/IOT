<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\ModuleController;

Route::get('/modules', [ModuleController::class, 'index']);
Route::get('/modules/create', [ModuleController::class, 'create']);
Route::post('/modules', [ModuleController::class, 'store'])->name('modules.store');
