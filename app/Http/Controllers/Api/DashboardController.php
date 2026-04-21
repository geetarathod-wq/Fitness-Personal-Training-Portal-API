<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Plan;
use App\Models\Exercise;
use App\Models\WorkoutLog;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
public function trainer(Request $request)
{
    return response()->json([
        'user' => $request->user(),
        'auth_check' => auth()->check(),

        'total_clients' => Client::count(),
        'total_plans' => Plan::count(),
        'total_exercises' => Exercise::count(),

        'recent_workouts' => WorkoutLog::latest()->take(10)->get()
    ]);
}
}