<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeCrudController;
use App\Http\Controllers\OOPDemoController;

Route::prefix('employees')->group(function () {
    Route::get('/', [EmployeeCrudController::class, 'index']);
    Route::post('/', [EmployeeCrudController::class, 'store']);
    Route::get('/statistics', [EmployeeCrudController::class, 'statistics']);
    Route::get('/{id}', [EmployeeCrudController::class, 'show']);
    Route::put('/{id}', [EmployeeCrudController::class, 'update']);
    Route::delete('/{id}', [EmployeeCrudController::class, 'destroy']);
});

