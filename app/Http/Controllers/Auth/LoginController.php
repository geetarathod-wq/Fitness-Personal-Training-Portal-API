<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // ✅ Show login page
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // ✅ Handle login
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();

            $user = Auth::user();

            // 🔥 ROLE BASED REDIRECT
            if ($user->role_id == 1) {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->route('client.dashboard');
        }

        return back()->with('error', 'Invalid email or password');
    }

    // ✅ Logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}