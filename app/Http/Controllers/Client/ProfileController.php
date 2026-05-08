<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function index()
    {
        return view('client.profile');
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'name' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->id),
            ],
            'current_password' => 'nullable|required_with:password',
            'password' => 'nullable|min:6|confirmed',
        ], [
            'current_password.required_with' => 'Current password is required.',
            'password.confirmed' => 'The password confirmation does not match.',
        ]);
        if ($request->filled('password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                if ($request->ajax()) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Current password is incorrect.'
                    ], 422);
                }
                return back()
                    ->withErrors([
                        'current_password' => 'Current password is incorrect.'
                    ])
                    ->withInput();
            }
            $user->password = Hash::make($request->password);
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        if ($request->ajax()) {
            return response()->json([
                'status' => true,
                'message' => 'Profile updated successfully!'
            ]);
        }
        return back()->with('success', 'Profile updated successfully!');
    }
}