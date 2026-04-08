<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\PlanController;

Route::post('/plans', [PlanController::class, 'store']);
Route::post('/plans/{plan}/exercises', [PlanController::class, 'addExercises']);
Route::get('/plans/{plan}', [PlanController::class, 'show']);