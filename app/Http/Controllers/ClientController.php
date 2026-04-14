<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DailyLog;
use App\Models\Plan;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function dashboard()
    {
        $userId = Auth::id();

        // ✅ RECENT LOGS
        $recentLogs = DailyLog::where('client_id', $userId)
            ->latest()
            ->take(5)
            ->get();

        // ✅ LAST LOG (FIXED - YOU MISSED THIS)
        $lastLog = DailyLog::where('client_id', $userId)
            ->latest()
            ->first();

        $lastWeight = $lastLog->weight ?? 0;
        $lastCalories = $lastLog->calories ?? 0;

        // ✅ TOTAL LOGS
        $totalLogs = DailyLog::where('client_id', $userId)->count();

        // ✅ LOAD PLANS WITH EXERCISES + TRAINER (YOUR REQUIREMENT)
        $plans = Plan::with(['exercises', 'trainer'])
            ->where('client_id', $userId)
            ->latest()
            ->get();

        // ✅ RETURN ALL DATA TO VIEW
        return view('client.dashboard', compact(
            'lastWeight',
            'lastCalories',
            'totalLogs',
            'recentLogs',
            'plans'
        ));
    }
}