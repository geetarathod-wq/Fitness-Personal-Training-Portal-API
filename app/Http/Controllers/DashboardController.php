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

    public function adminProfile()
    {
        return view('admin.profile', [
            'user' => auth()->user()
        ]);
    }

    public function updateAdminProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'nullable|min:6|confirmed',
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

        public function clientDashboard()
    {
        $clientId = auth()->id();

        $today = date('Y-m-d');

        $plans = Plan::where('client_id', $clientId)
            ->whereDate('assigned_date', $today)
            ->with(['trainer', 'exercises'])
            ->get();

        $recentLogs = DailyLog::where('client_id', $clientId)
            ->latest()
            ->take(5)
            ->get();

        $allLogs = DailyLog::where('client_id', $clientId)
            ->orderBy('date')
            ->get();

        $lastLog = DailyLog::where('client_id', $clientId)->latest()->first();

        return view('client.dashboard', [
            'plans' => $plans,
            'recentLogs' => $recentLogs,
            'allLogs' => $allLogs,
            'lastWeight' => $lastLog->weight ?? 0,
            'lastCalories' => $lastLog->calories ?? 0,
            'totalLogs' => $allLogs->count(),
        ]);
    }
}