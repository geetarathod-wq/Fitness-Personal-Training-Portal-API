<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\ClientController as AdminClientController;
use App\Http\Controllers\Admin\ExerciseController;
use App\Http\Controllers\Admin\PlanController as AdminPlanController;
use App\Http\Controllers\Client\PlanController;
use App\Http\Controllers\Client\DailyLogController;
use App\Http\Controllers\Client\ProfileController;

Route::get('/',function(){return redirect()->route('login');});

Route::middleware('guest')->group(function(){
Route::get('/register',[RegisterController::class,'show'])->name('register');
Route::post('/register',[RegisterController::class,'store'])->name('register.store');
Route::get('/login',[LoginController::class,'showLoginForm'])->name('login');
Route::post('/login',[LoginController::class,'login'])->name('login.post');
Route::get('/forgot-password',[ForgotPasswordController::class,'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password',[ForgotPasswordController::class,'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}',[ResetPasswordController::class,'showResetForm'])->name('password.reset');
Route::post('/reset-password',[ResetPasswordController::class,'reset'])->name('password.update');
});

Route::middleware('auth')->group(function(){
Route::post('/logout',[LoginController::class,'logout'])->name('logout');
Route::get('/admin/dashboard',[DashboardController::class,'index'])->middleware('trainer')->name('admin.dashboard');
Route::get('/client/dashboard',[DashboardController::class,'clientDashboard'])->name('client.dashboard');

Route::prefix('admin')->name('admin.')->middleware('trainer')->group(function(){
Route::resource('clients',AdminClientController::class)->except(['show']);
Route::resource('exercises',ExerciseController::class)->except(['show']);
Route::resource('plans',AdminPlanController::class);
Route::get('/clients/data',[AdminClientController::class,'getData'])->name('clients.data');
Route::get('/exercises/data',[ExerciseController::class,'getData'])->name('exercises.data');
Route::get('/search-clients',[AdminClientController::class,'search'])->name('search.clients');
Route::get('/search-exercises',[ExerciseController::class,'search'])->name('search.exercises');
Route::get('/clients/{id}/graph',[AdminClientController::class,'graph'])->name('clients.graph');
Route::get('/profile',[DashboardController::class,'adminProfile'])->name('profile');
Route::post('/profile/update',[DashboardController::class,'updateAdminProfile'])->name('profile.update');
});

Route::prefix('client')->name('client.')->group(function(){
Route::get('/plan',[PlanController::class,'index'])->name('plan');
Route::get('/plan/data',[PlanController::class,'getData'])->name('plan.data');
Route::get('/logs',[DailyLogController::class,'index'])->name('logs.index');
Route::get('/logs/create',[DailyLogController::class,'create'])->name('logs.create');
Route::post('/logs/store',[DailyLogController::class,'store'])->name('logs.store');
Route::delete('/logs/{id}',[DailyLogController::class,'destroy'])->name('logs.delete');
Route::get('/profile',[ProfileController::class,'index'])->name('profile');
Route::post('/profile/update',[ProfileController::class,'update'])->name('profile.update');
});
});