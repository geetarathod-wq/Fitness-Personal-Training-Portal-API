<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Http\Requests\ForgotPasswordRequest;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.password.email');
    }

    public function sendResetLinkEmail(ForgotPasswordRequest $request)
    {
        $data = $request->validated();

        $status = Password::sendResetLink(
            ['email' => $data['email']]
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with('success', 'Reset link sent!')
            : back()->withErrors(['email' => __($status)]);
    }
}