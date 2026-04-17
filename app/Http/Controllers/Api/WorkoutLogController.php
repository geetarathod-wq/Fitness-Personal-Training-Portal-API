<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DailyLog;
use Illuminate\Http\Request;

class WorkoutLogController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => DailyLog::latest()->get()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required|integer',
            'notes' => 'nullable|string',
            'date' => 'required|date',
        ]);

        $log = DailyLog::create($request->all());

        return response()->json([
            'message' => 'Log created',
            'data' => $log
        ], 201);
    }

    public function show($id)
    {
        $log = DailyLog::find($id);

        if (!$log) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json(['data' => $log]);
    }

    public function destroy($id)
    {
        $log = DailyLog::find($id);

        if (!$log) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $log->delete();

        return response()->json(['message' => 'Deleted']);
    }
}