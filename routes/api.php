<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PlanController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\WorkoutLogController;
use App\Http\Controllers\Api\WorkoutTemplateController;
use App\Http\Controllers\Api\ExerciseController;
use App\Http\Controllers\Api\DailyLogController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES (NO AUTH)
|--------------------------------------------------------------------------
*/

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


/*
|--------------------------------------------------------------------------
| PROTECTED ROUTES (SANCTUM)
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | AUTH
    |--------------------------------------------------------------------------
    */
    Route::post('/logout', [AuthController::class, 'logout']);


    /*
    |--------------------------------------------------------------------------
    | TRAINER ROUTES
    |--------------------------------------------------------------------------
    */
    Route::middleware('trainer')->group(function () {

        /*
        |-----------------------------
        | CLIENTS (RESOURCE ROUTE)
        |-----------------------------
        */
        Route::apiResource('clients', ClientController::class)
            ->only(['index', 'store', 'destroy']);

        /*
        |-----------------------------
        | PLANS
        |-----------------------------
        */
        Route::apiResource('plans', PlanController::class)
            ->only(['store', 'update', 'destroy']);

        Route::post('/plans/{id}/exercises', [PlanController::class, 'addExercises']);
    });


    /*
    |--------------------------------------------------------------------------
    | CLIENT ROUTES
    |--------------------------------------------------------------------------
    */
    Route::middleware('client')->group(function () {

        /*
        |-----------------------------
        | PLANS (READ ONLY)
        |-----------------------------
        */
        Route::apiResource('plans', PlanController::class)
            ->only(['index', 'show']);

        /*
        |-----------------------------
        | WORKOUT LOGS
        |-----------------------------
        */
        Route::apiResource('logs', WorkoutLogController::class)
            ->only(['index', 'store', 'show', 'destroy']);

        /*
        |-----------------------------
        | WORKOUT TEMPLATES
        |-----------------------------
        */
        Route::get('/templates', [WorkoutTemplateController::class, 'index']);
    });


    /*
    |--------------------------------------------------------------------------
    | EXERCISES (COMMON FOR AUTH USERS)
    |--------------------------------------------------------------------------
    */
    Route::apiResource('exercises', ExerciseController::class)
        ->only(['index', 'store']);
});