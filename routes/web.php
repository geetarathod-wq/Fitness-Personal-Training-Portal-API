<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Role;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Password;

// ----------------- HOME -----------------
Route::get('/', function () {
    return redirect()->route('login');
});

// ----------------- LOGIN -----------------
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function (Request $request) {
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        return redirect('/dashboard');
    }

    return back()->with('error', 'Invalid email or password');
});

// ----------------- LOGOUT -----------------
Route::post('/logout', function (Request $request) {
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login');
})->name('logout');

// ----------------- REGISTER -----------------

// Show register form
Route::get('/register', function () {
    return view('auth.register');
})->name('register');

// Handle register
Route::post('/register', function (Request $request) {

    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6',
    ]);

    $customerRole = \App\Models\Role::firstOrCreate(['name' => 'customer']);

    \App\Models\User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role_id' => $customerRole->id,
    ]);

    return redirect()->route('login')->with('success', 'Registered successfully!');
});

// ----------------- DASHBOARD -----------------
Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth', \App\Http\Middleware\TrainerOnly::class]);

// ================= PASSWORD RESET =================

// Show forgot password form
Route::get('/forgot-password', function () {
    return view('auth.password.email'); // ✅ use existing file
})->name('password.request');

// Send reset link
Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => 'required|email']);

    $status = Password::sendResetLink($request->only('email'));

    return $status === Password::RESET_LINK_SENT
        ? back()->with('success', 'Reset link sent!')
        : back()->withErrors(['email' => __($status)]);
})->name('password.email');

// Show reset password form
Route::get('/reset-password/{token}', function ($token) {
    return view('auth.password.reset', ['token' => $token]); // ✅ existing file
})->name('password.reset');

// Handle reset
Route::post('/reset-password', function (Request $request) {

    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:6|confirmed',
    ]);

    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user, $password) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])->save();
        }
    );

    return $status === Password::PASSWORD_RESET
        ? redirect()->route('login')->with('success', 'Password reset successful!')
        : back()->withErrors(['email' => [__($status)]]);
})->name('password.update');