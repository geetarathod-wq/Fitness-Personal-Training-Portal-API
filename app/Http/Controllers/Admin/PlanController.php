<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Exercise;
use App\Models\User;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    // 📋 LIST ALL PLANS
    public function index()
    {
        $plans = Plan::with(['client', 'exercises'])
            ->latest()
            ->get();

        return view('admin.plans.index', compact('plans'));
    }

    // ➕ CREATE PAGE
    public function create()
    {
        // ✅ FIX: removed pagination
        $exercises = Exercise::latest()->get();

        $clients = User::where('role_id', User::ROLE_CLIENT)->get();

        return view('admin.plans.create', compact('exercises', 'clients'));
    }

    // 💾 STORE PLAN
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'client_id' => 'required',
            'assigned_date' => 'required',
        ]);

        $plan = Plan::create([
            'name' => $request->name,
            'trainer_id' => auth()->id(),
            'client_id' => $request->client_id,
            'assigned_date' => $request->assigned_date,
        ]);

        if (!empty($request->exercises)) {
            foreach ($request->exercises as $exerciseId) {
                if (!$exerciseId) continue;

                $plan->exercises()->attach($exerciseId, [
                    'sets' => $request->sets[$exerciseId] ?? 1,
                    'reps_min' => $request->reps_min[$exerciseId] ?? 0,
                    'reps_max' => $request->reps_max[$exerciseId] ?? 0,
                ]);
            }
        }

        return redirect()->route('admin.plans.index')
            ->with('success', 'Plan created successfully');
    }

    // ✏️ EDIT PAGE
    public function edit($id)
    {
        $plan = Plan::with('exercises')->findOrFail($id);
        $exercises = Exercise::latest()->get();
        $clients = User::where('role_id', User::ROLE_CLIENT)->get();

        return view('admin.plans.edit', compact('plan', 'exercises', 'clients'));
    }

    // 🔄 UPDATE PLAN
    public function update(Request $request, $id)
    {
        $plan = Plan::findOrFail($id);

        $plan->update([
            'name' => $request->name,
            'client_id' => $request->client_id,
            'assigned_date' => $request->assigned_date,
        ]);

        $plan->exercises()->detach();

        if ($request->exercises) {
            foreach ($request->exercises as $exerciseId) {
                $plan->exercises()->attach($exerciseId, [
                    'sets' => $request->sets[$exerciseId] ?? 1,
                    'reps_min' => $request->reps_min[$exerciseId] ?? 0,
                    'reps_max' => $request->reps_max[$exerciseId] ?? 0,
                ]);
            }
        }

        return redirect()->route('admin.plans.index')
            ->with('success', 'Plan updated successfully');
    }

    // 🗑 DELETE
    public function destroy($id)
    {
        Plan::findOrFail($id)->delete();

        return redirect()->route('admin.plans.index')
            ->with('success', 'Plan deleted successfully');
    }

    // 🔍 CLIENT SEARCH
    public function searchClients(Request $request)
    {
        return User::where('role_id', User::ROLE_CLIENT)
            ->where('name', 'like', '%' . $request->search . '%')
            ->limit(10)
            ->get();
    }

    // 🔍 EXERCISE SEARCH (unused now but kept)
    public function searchExercises(Request $request)
    {
        $exercises = Exercise::where('name', 'LIKE', '%' . $request->search . '%')
            ->limit(10)
            ->get();

        return response()->json($exercises);
    }
}