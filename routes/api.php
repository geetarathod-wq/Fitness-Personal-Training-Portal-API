<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ExerciseController;
use App\Http\Controllers\Api\PlanController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\WorkoutLogController;
use App\Http\Controllers\Api\WorkoutTemplateController;
use App\Http\Controllers\Api\DailyLogController;
use App\Http\Controllers\Api\DashboardController;

Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);

Route::get('/exercises/search',[ExerciseController::class,'search']);

Route::middleware('auth:sanctum')->group(function(){

Route::post('/logout',[AuthController::class,'logout']);

Route::get('/plans',[PlanController::class,'index']);
Route::get('/plans/{plan}',[PlanController::class,'show']);

Route::get('/logs/weekly',[WorkoutLogController::class,'weekly']);
Route::get('/logs/monthly',[WorkoutLogController::class,'monthly']);
Route::get('/logs/calories',[WorkoutLogController::class,'calories']);

Route::get('/dashboard/graph/weekly',[DashboardController::class,'weeklyGraph']);
Route::get('/dashboard/graph/weight',[DashboardController::class,'weightGraph']);
Route::get('/dashboard/graph/calories',[DashboardController::class,'caloriesGraph']);

Route::middleware('trainer')->group(function(){
Route::apiResource('clients',ClientController::class)->only(['index','store','destroy']);
Route::apiResource('plans',PlanController::class)->only(['store','update','destroy']);
Route::post('/plans/{id}/exercises',[PlanController::class,'addExercises']);
Route::get('/dashboard/trainer',[DashboardController::class,'trainer']);
});

Route::middleware('client')->group(function(){
Route::apiResource('logs',WorkoutLogController::class)->only(['index','store','show','destroy']);
Route::get('/templates',[WorkoutTemplateController::class,'index']);
});

Route::apiResource('exercises',ExerciseController::class);
Route::apiResource('daily-logs',DailyLogController::class)->only(['index','store','show','destroy']);

});