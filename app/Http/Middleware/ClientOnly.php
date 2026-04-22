<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ClientOnly
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || Auth::user()->role_id != User::ROLE_CLIENT) {
            return response()->json([
                'message' => 'Unauthorized (Client only access)'
            ], 403);
        }

        return $next($request);
    }
}