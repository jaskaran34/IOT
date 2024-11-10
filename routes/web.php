<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\ModuleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ModuleTypeController;



Route::get('/skipped-modules', [ModuleController::class, 'skipped_modules'])->name('skippedModules.index');

Route::get('/skipped-modules/{id}/update-status/{status}', [ModuleController::class, 'updateStatus'])->name('skippedModules.updateStatus');


Route::get('/dashboard', [DashboardController::class, 'showDashboard'])->name('dashboard');
Route::get('/module/dashboard/{id}', [DashboardController::class, 'showModuleDetails'])->name('module.details');


Route::get('/dashboard/combined-data', [DashboardController::class, 'getCombinedData']);
Route::get('/dashboard/module-activity', [DashboardController::class, 'getModuleActivityData'])->name('dashboard.module-activity');


Route::get('/module-measurements/{moduleId}', [ModuleController::class, 'fetchMeasurements']);


Route::post('/simulate-malfunction', [ModuleController::class, 'simulateMalfunction']);
Route::get('/modules/all/{id}', [ModuleController::class, 'getAllModules'])->name('modules.all');


Route::get('/module/status', [ModuleController::class, 'module_stat'])->name('module.status');
Route::get('/module-status/{module_id}', [ModuleController::class, 'showStatus']);
Route::get('/update-module-status', function () {return view('modules.updateStatus');})->name('update.status');
Route::post('/update-module-status', [ModuleController::class, 'updateModuleStatus'])->name('update.module.status');

Route::get('/modules/create', [ModuleController::class, 'create'])->name('modules.index');
Route::post('/modules', [ModuleController::class, 'store'])->name('modules.store');
Route::post('/modules/update/{id}', [ModuleController::class, 'update'])->name('modules.update');
Route::delete('/module/{id}', [ModuleController::class, 'destroy'])->name('module.destroy');


Route::get('/module-types', [ModuleTypeController::class, 'index'])->name('module-types.index');
Route::post('/module-types',[ModuleTypeController::class, 'store'])->name('module-types.store');
Route::post('/measurement-types/update/{id}', [ModuleTypeController::class, 'update'])->name('module-types.update');
Route::delete('/module-types/{id}', [ModuleTypeController::class, 'destroy'])->name('module-types.destroy');
