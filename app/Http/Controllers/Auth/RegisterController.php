<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;

class RegisterController extends Controller
{
    // =========================
    // SHOW REGISTER PAGE
    // =========================
    public function show()
    {
        return view('auth.register');
    }

    // =========================
    // HANDLE REGISTER
    // =========================
    public function store(RegisterRequest $request)
    {
        $data = $request->validated(); // ✅ request dictionary

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role_id' => User::ROLE_CLIENT,
        ]);

        return redirect()->route('login')
            ->with('success', 'Registered successfully!');
    }
}