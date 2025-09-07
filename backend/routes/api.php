<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\CompanyController;

// Rotas públicas de Company (sem autenticação)
Route::post('/companies', [CompanyController::class, 'store']);
Route::get('/companies', [CompanyController::class, 'index']);
Route::get('/companies/{id}', [CompanyController::class, 'show']);

// Rotas de autenticação
Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);

    Route::middleware('auth:api')->group(function () {
        Route::get('me', [AuthController::class, 'me']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);
    });
});

// Tarefas (CRUD) protegidas por JWT
Route::middleware('auth:api')->apiResource('tasks', TaskController::class);

// Exportação CSV protegida por JWT
Route::middleware('auth:api')->group(function () {
    Route::post('tasks/export', [ExportController::class, 'export']);
    Route::get('tasks/export/{filename}', [ExportController::class, 'download']);
});
