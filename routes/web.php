<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\ModuleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ModuleTypeController;

Route::get('/modules', [ModuleController::class, 'index'])->name('modules.index');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/modules/create', [ModuleController::class, 'create']);
Route::post('/modules', [ModuleController::class, 'store'])->name('modules.store');


Route::get('/module-types', [ModuleTypeController::class, 'index'])->name('module-types.index');
Route::post('/module-types',[ModuleTypeController::class, 'store'])->name('module-types.store');
Route::delete('/module-types/{id}', [ModuleTypeController::class, 'destroy'])->name('module-types.destroy');
