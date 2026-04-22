<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WorkoutLog;
use Illuminate\Http\Request;
use App\Http\Requests\Api\WorkoutLogRequest;

class WorkoutLogController extends Controller
{
    public function index(Request $request)
    {
        return WorkoutLog::where('user_id', $request->user()->id)
            ->latest()
            ->get();
    }

    public function store(WorkoutLogRequest $request)
    {
        $log = WorkoutLog::create([
            'user_id'     => $request->user()->id,

            'plan_id'     => $request->plan_id,
            'exercise_id' => $request->exercise_id,
            'sets'        => $request->sets,
            'reps'        => $request->reps,
            'duration'    => $request->duration,
            'notes'       => $request->notes,

            'weight'      => $request->weight,
            'calories'    => $request->calories,

            'date'        => $request->logged_at ?? now()->toDateString(),
        ]);

        return response()->json([
            'message' => 'Workout log created successfully',
            'data' => $log
        ], 201);
    }

    public function show(Request $request, $id)
    {
        $log = WorkoutLog::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->first();

        if (!$log) {
            return response()->json(['message' => 'Workout log not found'], 404);
        }

        return response()->json(['data' => $log]);
    }

    public function destroy(Request $request, $id)
    {
        $log = WorkoutLog::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->first();

        if (!$log) {
            return response()->json(['message' => 'Workout log not found'], 404);
        }

        $log->delete();

        return response()->json(['message' => 'Workout log deleted successfully']);
    }

    public function weekly(Request $request)
    {
        $logs = WorkoutLog::where('user_id', $request->user()->id)
            ->whereBetween('date', [
                now()->startOfWeek(),
                now()->endOfWeek()
            ])
            ->get();

        return response()->json([
            'week_start' => now()->startOfWeek()->toDateString(),
            'week_end' => now()->endOfWeek()->toDateString(),
            'total_workouts' => $logs->count(),
            'data' => $logs
        ]);
    }

    public function monthly(Request $request)
    {
        $logs = WorkoutLog::where('user_id', $request->user()->id)
            ->whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->get();

        return response()->json([
            'month' => now()->format('F Y'),
            'total_workouts' => $logs->count(),
            'avg_weight' => $logs->avg('weight'),
            'total_calories' => $logs->sum('calories'),
            'data' => $logs
        ]);
    }

    public function calories(Request $request)
    {
        $total = WorkoutLog::where('user_id', $request->user()->id)
            ->sum('calories');

        return response()->json([
            'total_calories_burned' => $total
        ]);
    }
}