<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Plan;
use App\Models\Exercise;
use App\Models\DailyLog;

class DashboardController extends Controller
{
    // ---------------- ADMIN DASHBOARD ----------------
    public function index()
    {
        $users=User::all();
        // echo"<pre>";print_r($users->toArray());die();
        // ✅ FIXED
        $clients = User::where('role_id', User::ROLE_CLIENT)->count();

        $plans = Plan::count();

        $exercises = Exercise::count();

        $todayLogs = DailyLog::whereDate('created_at', today())->count();

        // ✅ FIXED
        $newClients = User::where('role_id', User::ROLE_CLIENT)
            ->where('created_at', '>=', now()->subDays(7))
            ->count();

        return view('admin.dashboard', compact(
            'clients',
            'plans',
            'exercises',
            'todayLogs',
            'newClients'
        ));
    }

    // ---------------- CLIENT DASHBOARD ----------------
    public function clientDashboard()
    {
        $userId = auth()->id();

        $recentLogs = DailyLog::where('client_id', $userId)
            ->latest()
            ->take(5)
            ->get();

        $lastLog = DailyLog::where('client_id', $userId)
            ->latest()
            ->first();

        $totalLogs = DailyLog::where('client_id', $userId)->count();

        return view('client.dashboard', [
            'recentLogs' => $recentLogs,
            'lastWeight' => $lastLog->weight ?? 0,
            'lastCalories' => $lastLog->calories ?? 0,
            'totalLogs' => $totalLogs,
        ]);
    }
}