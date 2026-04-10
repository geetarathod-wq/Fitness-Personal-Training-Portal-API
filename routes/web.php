<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use Illuminate\Support\Facades\Route;

// HOME
Route::get('/', fn() => redirect()->route('login'));

// LOGIN
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');

// LOGOUT
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ADMIN DASHBOARD
Route::middleware(['auth', 'trainer'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'admin'])
        ->name('admin.dashboard');
});

// CLIENT DASHBOARD
Route::middleware(['auth'])->group(function () {

    Route::get('/client/dashboard', function () {
        return view('client.dashboard');
    })->name('client.dashboard');

    Route::get('/client/plan', function () {
        return view('client.plan');
    })->name('client.plan');

    Route::get('/client/logs/create', function () {
        return view('client.add-log');
    })->name('client.logs.create');

    Route::get('/client/progress', function () {
        return view('client.progress');
    })->name('client.progress');

    Route::get('/client/profile', function () {
        return view('client.profile');
    })->name('client.profile');

});

// FORGOT PASSWORD
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])
    ->name('password.request');

Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])
    ->name('password.email');

// RESET PASSWORD
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])
    ->name('password.reset');

Route::post('/reset-password', [ResetPasswordController::class, 'reset'])
    ->name('password.update');