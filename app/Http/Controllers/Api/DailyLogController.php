<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DailyLog;
use Illuminate\Http\Request;
use App\Http\Requests\Api\DailyLogRequest;

class DailyLogController extends Controller
{
    public function index(Request $request)
    {
        return response()->json([
            'data' => DailyLog::where('client_id', $request->user()->id)
                ->orderBy('date', 'desc')
                ->get()
        ]);
    }

    public function store(DailyLogRequest $request)
    {
        $log = DailyLog::create([
            'client_id' => $request->user()->id,
            'weight'    => $request->weight,
            'calories'  => $request->calories,
            'date'      => $request->date,
        ]);

        return response()->json([
            'message' => 'Log saved successfully',
            'data'    => $log
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

        return response()->json(['message' => 'Deleted successfully']);
    }
}