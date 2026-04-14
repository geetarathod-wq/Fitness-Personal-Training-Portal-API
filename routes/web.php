<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ClientController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;

use App\Http\Controllers\Client\PlanController;
use App\Http\Controllers\Client\DailyLogController;
use App\Http\Controllers\Client\ProfileController;

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

// Admin Controllers
use App\Http\Controllers\Admin\ClientController as AdminClientController;
use App\Http\Controllers\Admin\ExerciseController;
use App\Http\Controllers\Admin\PlanController as AdminPlanController;
use App\Http\Controllers\Auth\RegisterController;

/*
|--------------------------------------------------------------------------
| HOME
|--------------------------------------------------------------------------
*/
Route::get('/', fn() => redirect()->route('login'));

/*
|--------------------------------------------------------------------------
| REGISTER (FIXED CLEAN WAY)
|--------------------------------------------------------------------------
*/
Route::get('/register', [RegisterController::class, 'show'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'trainer'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        Route::resource('clients', AdminClientController::class);
        Route::resource('exercises', ExerciseController::class);
        Route::resource('plans', AdminPlanController::class);
    });

/*
|--------------------------------------------------------------------------
| CLIENT ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])
    ->group(function () {

        Route::get('/client/dashboard', [ClientController::class, 'dashboard'])
            ->name('client.dashboard');

        Route::get('/client/plan', [PlanController::class, 'index'])
            ->name('client.plan');

        Route::get('/client/logs', [DailyLogController::class, 'index'])
            ->name('client.logs.index');

        Route::get('/client/logs/create', [DailyLogController::class, 'create'])
            ->name('client.logs.create');

        Route::post('/client/logs/store', [DailyLogController::class, 'store'])
            ->name('client.logs.store');

        Route::delete('/client/logs/{id}', [DailyLogController::class, 'destroy'])
            ->name('client.logs.delete');

        Route::get('/client/progress', fn () => view('client.progress'))
            ->name('client.progress');

        Route::get('/client/profile', [ProfileController::class, 'index'])
            ->name('client.profile');

        Route::post('/client/profile/update', [ProfileController::class, 'update'])
            ->name('client.profile.update');
    });

/*
|--------------------------------------------------------------------------
| PASSWORD RESET
|--------------------------------------------------------------------------
*/
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])
    ->name('password.request');

Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])
    ->name('password.email');

Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])
    ->name('password.reset');

Route::post('/reset-password', [ResetPasswordController::class, 'reset'])
    ->name('password.update');