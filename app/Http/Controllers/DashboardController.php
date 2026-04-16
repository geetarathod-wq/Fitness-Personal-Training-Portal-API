<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Plan;
use App\Models\Exercise;
use App\Models\DailyLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    // ---------------- ADMIN DASHBOARD ----------------
    public function index()
    {
        $clients = User::where('role_id', User::ROLE_CLIENT)->count();
        $plans = Plan::count();
        $exercises = Exercise::count();
        $todayLogs = DailyLog::whereDate('created_at', today())->count();

        $newClients = User::where('role_id', User::ROLE_CLIENT)
            ->whereDate('created_at', '>=', now()->subDays(7))
            ->count();

        $dates = [];
        $clientCounts = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);

            $dates[] = $date->format('D');

            $clientCounts[] = User::where('role_id', User::ROLE_CLIENT)
                ->whereDate('created_at', $date->toDateString())
                ->count();
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

    // ---------------- ADMIN PROFILE ----------------
    public function adminProfile()
    {
        return view('admin.profile', [
            'user' => auth()->user()
        ]);
    }

    // ---------------- UPDATE PROFILE ----------------
    public function updateAdminProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'nullable|min:6'
        ]);

        $user = auth()->user();

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return back()->with('success', 'Profile updated successfully');
    }

    // ---------------- CLIENT DASHBOARD ----------------
    public function clientDashboard()
    {
        $userId = auth()->id();

        $allLogs = DailyLog::where('client_id', $userId)
            ->orderBy('date', 'asc')
            ->get();

        $recentLogs = DailyLog::where('client_id', $userId)
            ->latest()
            ->take(5)
            ->get();

        $lastLog = DailyLog::where('client_id', $userId)->latest()->first();

        $totalLogs = DailyLog::where('client_id', $userId)->count();

        return view('client.dashboard', [
            'recentLogs' => $recentLogs,
            'allLogs' => $allLogs,
            'lastWeight' => $lastLog->weight ?? 0,
            'lastCalories' => $lastLog->calories ?? 0,
            'totalLogs' => $totalLogs,
        ]);
    }
}