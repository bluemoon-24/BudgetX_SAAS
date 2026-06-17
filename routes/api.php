<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\BudgetApiController;
use App\Http\Controllers\Api\ExpenseApiController;
use App\Http\Controllers\Api\CategoryApiController;
use App\Http\Controllers\Api\IncomeApiController;
use App\Http\Controllers\Api\SavingsGoalApiController;

// Public API routes
Route::post('/register', [AuthApiController::class, 'register']);
Route::post('/login',    [AuthApiController::class, 'login']);

// Protected API routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout',     [AuthApiController::class, 'logout']);
    Route::post('/logout-all', [AuthApiController::class, 'logoutAll']);
    Route::get('/user',        [AuthApiController::class, 'profile']);

    Route::name('api.')->group(function () {
        Route::apiResource('budgets',       BudgetApiController::class);
        Route::apiResource('expenses',      ExpenseApiController::class);
        Route::apiResource('incomes',       IncomeApiController::class);
        Route::apiResource('categories',    CategoryApiController::class);
        Route::apiResource('savings-goals', SavingsGoalApiController::class);
    });

    // Admin routes
    Route::prefix('admin')->middleware('admin')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Api\Admin\DashboardController::class, 'index']);
    });
});