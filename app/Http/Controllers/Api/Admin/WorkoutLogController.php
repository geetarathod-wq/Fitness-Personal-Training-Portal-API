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
        return response()->json([
            'data' => WorkoutLog::where('user_id', $request->user()->id)->get()
        ]);
    }

    public function store(WorkoutLogRequest $request)
    {
        $log = WorkoutLog::create([
            'user_id'     => $request->user()->id,
            'plan_id'     => $request->plan_id,
            'exercise_id' => $request->exercise_id,
            'sets'        => $request->sets,
            'reps'        => $request->reps,
            'weight'      => $request->weight,
            'duration'    => $request->duration,
            'notes'       => $request->notes,
            'logged_at'   => $request->logged_at ?? now(),
        ]);

        return response()->json([
            'message' => 'Workout log created',
            'data'    => $log
        ], 201);
    }

    public function show(Request $request, $id)
    {
        $log = WorkoutLog::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->first();

        if (!$log) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json(['data' => $log]);
    }

    public function destroy(Request $request, $id)
    {
        $log = WorkoutLog::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->first();

        if (!$log) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $log->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }
}