<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PlanController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\WorkoutLogController;
use App\Http\Controllers\Api\WorkoutTemplateController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES (NO LOGIN)
|--------------------------------------------------------------------------
*/

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


/*
|--------------------------------------------------------------------------
| PROTECTED ROUTES (TOKEN REQUIRED)
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {

    // LOGOUT
    Route::post('/logout', [AuthController::class, 'logout']);

    /*
    |--------------------------------------------------------------------------
    | TRAINER ONLY ROUTES
    |--------------------------------------------------------------------------
    */
    Route::middleware('trainer')->group(function () {

        // PLAN MANAGEMENT
        Route::post('/plans', [PlanController::class, 'store']);
        Route::put('/plans/{id}', [PlanController::class, 'update']);
        Route::delete('/plans/{id}', [PlanController::class, 'destroy']);
        Route::post('/plans/{id}/exercises', [PlanController::class, 'addExercises']);

        // CLIENT MANAGEMENT
        Route::get('/clients', [ClientController::class, 'index']);
        Route::post('/clients', [ClientController::class, 'store']);
        Route::delete('/clients/{id}', [ClientController::class, 'destroy']);
    });


    /*
    |--------------------------------------------------------------------------
    | CLIENT ONLY ROUTES
    |--------------------------------------------------------------------------
    */
    Route::middleware('client')->group(function () {

        // VIEW PLANS
        Route::get('/plans', [PlanController::class, 'index']);
        Route::get('/plans/{id}', [PlanController::class, 'show']);

        // WORKOUT LOGS
        Route::get('/logs', [WorkoutLogController::class, 'index']);
        Route::post('/logs', [WorkoutLogController::class, 'store']);
        Route::get('/logs/{id}', [WorkoutLogController::class, 'show']);
        Route::delete('/logs/{id}', [WorkoutLogController::class, 'destroy']);

        // WORKOUT TEMPLATES
        Route::get('/templates', [WorkoutTemplateController::class, 'index']);
    });
});