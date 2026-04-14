<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Support\Facades\Auth;

class PlanController extends Controller
{
    public function index()
    {
        $plans = Plan::where('client_id', Auth::id())
            ->latest()
            ->get();

        return view('client.plan.index', compact('plans'));
    }
}