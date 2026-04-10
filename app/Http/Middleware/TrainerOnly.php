<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TrainerOnly
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        // ✅ Check using role relationship
        if (!$user || !$user->role || $user->role->name !== 'trainer') {
            return redirect('/')->with('error', 'Access denied');
        }

        return $next($request);
    }
}