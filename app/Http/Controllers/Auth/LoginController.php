<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // ✅ IMPORTANT

class LoginController extends Controller
{
    // =========================
    // SHOW LOGIN PAGE
    // =========================
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // =========================
    // HANDLE LOGIN (FIXED)
    // =========================
    public function login(Request $request)
    {
        
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ])) {

            $request->session()->regenerate();

            $user = Auth::user();

            // ✅ FIXED USING CONSTANT
            if ($user->role_id == User::ROLE_TRAINER) {
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