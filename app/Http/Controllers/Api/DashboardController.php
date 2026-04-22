<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WorkoutLog;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function trainer(Request $request)
    {
        return response()->json([
            'user' => $request->user(),
            'auth_check' => auth()->check(),
        ]);
    }

  
    public function weeklyGraph(Request $request)
    {
        $data = WorkoutLog::where('user_id', $request->user()->id)
            ->whereBetween('date', [
                now()->startOfWeek(),
                now()->endOfWeek()
            ])
            ->orderBy('date')
            ->get();

        return response()->json([
            'labels' => $data->pluck('date'),
            'workouts' => $data->count(),
        ]);
    }

   
    public function weightGraph(Request $request)
    {
        $data = WorkoutLog::where('user_id', $request->user()->id)
            ->orderBy('date')
            ->get(['date', 'weight']);

        return response()->json([
            'labels' => $data->pluck('date'),
            'data' => $data->pluck('weight')
        ]);
    }

   
    public function caloriesGraph(Request $request)
    {
        $data = WorkoutLog::where('user_id', $request->user()->id)
            ->orderBy('date')
            ->get(['date', 'calories']);

        return response()->json([
            'labels' => $data->pluck('date'),
            'data' => $data->pluck('calories')
        ]);
    }
}