<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrainerOnly
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        if (Auth::user()->role_id != 1) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}