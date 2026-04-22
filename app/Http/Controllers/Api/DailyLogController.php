<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DailyLog;
use Illuminate\Http\Request;
use App\Http\Requests\Api\DailyLogRequest;

class DailyLogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    // 📄 GET ALL LOGS
    public function index(Request $request)
    {
        $logs = DailyLog::where('user_id', $request->user()->id)
            ->orderBy('date', 'desc')
            ->get();

        return response()->json([
            'data' => $logs
        ]);
    }

    // ➕ STORE LOG
    public function store(DailyLogRequest $request)
    {
        $userId = $request->user()->id;

        $log = DailyLog::create([
            'user_id'   => $userId,
            'client_id' => $userId, // keep backward compatibility

            'date'      => $request->date,
            'weight'    => $request->weight,
            'bodyfat'   => $request->bodyfat ?? null,
            'calories'  => $request->calories,
            'notes'     => $request->notes ?? null,
        ]);

        return response()->json([
            'message' => 'Log saved successfully',
            'data' => $log
        ], 201);
    }

    // 🔍 SHOW SINGLE LOG (SECURE)
    public function show(Request $request, $id)
    {
        $log = DailyLog::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->first();

        if (!$log) {
            return response()->json([
                'message' => 'Daily log not found'
            ], 404);
        }

        return response()->json([
            'data' => $log
        ]);
    }

    // ❌ DELETE LOG (SECURE)
    public function destroy(Request $request, $id)
    {
        $log = DailyLog::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->first();

        if (!$log) {
            return response()->json([
                'message' => 'Not found'
            ], 404);
        }

        $log->delete();

        return response()->json([
            'message' => 'Deleted successfully'
        ]);
    }
}