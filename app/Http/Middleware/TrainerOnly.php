<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrainerOnly
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if (!$user || (int)$user->role_id !== 1) {
            return response()->json([
                'message' => 'Unauthorized (Trainer only access)'
            ], 403);
        }

        return $next($request);
    }
}