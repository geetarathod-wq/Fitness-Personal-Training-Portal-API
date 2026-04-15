<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginRequest;

class LoginController extends Controller
{
    // =========================
    // SHOW LOGIN PAGE
    // =========================
    public function showLoginForm()
    {
        // ✅ AUTO REDIRECT IF ALREADY LOGGED IN
        if (auth()->check()) {
            if (auth()->user()->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('client.dashboard');
        }

        return view('auth.login');
    }

    // =========================
    // HANDLE LOGIN
    // =========================
    public function login(LoginRequest $request)
    {
        $data = $request->validated(); // ✅ request dictionary

        if (Auth::attempt([
            'email' => $data['email'],
            'password' => $data['password']
        ])) {

            $request->session()->regenerate();

            if (auth()->user()->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->route('client.dashboard');
        }

        return back()->withErrors([
            'email' => 'Email or password is incorrect',
        ]);
    }
    // =========================
    // LOGOUT
    // =========================
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}