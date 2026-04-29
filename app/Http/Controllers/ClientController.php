<?php

namespace App\Http\Controllers;

use App\Models\DailyLog;
use App\Models\Plan;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function dashboard()
    {
        $userId = Auth::id();

        $recentLogs = DailyLog::where('client_id', $userId)
            ->latest()
            ->take(5)
            ->get();

        $lastLog = DailyLog::where('client_id', $userId)->latest()->first();

        $plans = Plan::with(['exercises', 'trainer'])
            ->where('client_id', $userId)
            ->latest()
            ->get();

        return view('client.dashboard', [
            'lastWeight' => $lastLog->weight ?? 0,
            'lastCalories' => $lastLog->calories ?? 0,
            'totalLogs' => DailyLog::where('client_id', $userId)->count(),
            'recentLogs' => $recentLogs,
            'plans' => $plans,
        ]);
    }
}