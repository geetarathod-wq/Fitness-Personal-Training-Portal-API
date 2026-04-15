<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Plan;
use App\Models\Exercise;
use App\Models\DailyLog;
use Carbon\Carbon;

class DashboardController extends Controller
{
    // ---------------- ADMIN DASHBOARD ----------------
    public function index()
    {
        // STATS (UNCHANGED)
        $clients = User::where('role_id', User::ROLE_CLIENT)->count();
        $plans = Plan::count();
        $exercises = Exercise::count();
        $todayLogs = DailyLog::whereDate('created_at', today())->count();

        $newClients = User::where('role_id', User::ROLE_CLIENT)
            ->whereDate('created_at', '>=', now()->subDays(7))
            ->count();

        // ✅ GRAPH DATA (LAST 7 DAYS)
        $dates = [];
        $clientCounts = [];

        for ($i = 6; $i >= 0; $i--) {

            $date = Carbon::now()->subDays($i);

            $dates[] = $date->format('D'); // Mon, Tue

            $count = User::where('role_id', User::ROLE_CLIENT)
                ->whereDate('created_at', $date->toDateString())
                ->count();

            $clientCounts[] = $count;
        }

        return view('admin.dashboard', compact(
            'clients',
            'plans',
            'exercises',
            'todayLogs',
            'newClients',
            'dates',
            'clientCounts'
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