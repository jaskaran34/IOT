<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ModuleController;

Route::get('/modules', [ModuleController::class, 'index']);
Route::get('/modules/create', [ModuleController::class, 'create']);
Route::post('/modules', [ModuleController::class, 'store']);
