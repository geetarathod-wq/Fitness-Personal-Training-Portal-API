<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('layout');
});

// Home → Login page
Route::get('/', function () {
    return view('auth.login');
});

// Login Page
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// Register Page
Route::get('/register', function () {
    return view('auth.register');
})->name('register');

// Dashboard Page
Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->name('dashboard');