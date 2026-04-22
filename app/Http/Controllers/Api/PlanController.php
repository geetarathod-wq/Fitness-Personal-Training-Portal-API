<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;
use App\Http\Requests\Api\PlanRequest;

class PlanController extends Controller
{
    // 📄 Get all plans
    public function index()
    {
        return response()->json([
            'data' => Plan::with(['client', 'exercises'])
                ->latest()
                ->get()
        ]);
    }

    // ➕ Store
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'assigned_date' => 'required',
        ]);

        $userId = $request->user_id ?? $request->client_id;

        if (!$userId) {
            return response()->json([
                'message' => 'user_id or client_id is required'
            ], 422);
        }

        $plan = Plan::create([
            'name' => $request->name,
            'user_id' => $userId,
            'client_id' => $userId, // temporary backward compatibility
            'assigned_date' => $request->assigned_date,
            'trainer_id' => auth()->id(),
        ]);

        return response()->json([
            'message' => 'Plan created successfully',
            'data' => $plan
        ], 201);
    }

    // ✏️ Update
    public function update(PlanRequest $request, $id)
    {
        $plan = Plan::findOrFail($id);
        $plan->update($request->validated());

        return response()->json([
            'message' => 'Plan updated',
            'data' => $plan
        ]);
    }

    // ❌ Delete
    public function destroy($id)
    {
        Plan::findOrFail($id)->delete();

        return response()->json([
            'message' => 'Plan deleted'
        ]);
    }

    // 🔍 Show
    public function show(Request $request, $id)
    {
        $plan = Plan::with(['client', 'exercises'])->find($id);

        if (!$plan) {
            return response()->json([
                'message' => 'Plan not found'
            ], 404);
        }

        return response()->json([
            'data' => $plan
        ]);
    }

    // 🔎 Search Clients
    public function searchClients($search)
    {
        return response()->json(
            \App\Models\User::where('role_id', 2)
                ->where('name', 'like', "%$search%")
                ->limit(10)
                ->get()
        );
    }

    // 🔎 Search Exercises
    public function searchExercises($search)
    {
        return response()->json(
            \App\Models\Exercise::where('name', 'like', "%$search%")
                ->limit(10)
                ->get()
        );
    }

    // ➕ Add Exercises to Plan
    public function addExercises(Request $request, $id)
    {
        $plan = Plan::find($id);

        if (!$plan) {
            return response()->json([
                'message' => 'Plan not found'
            ], 404);
        }

        $request->validate([
            'exercise_ids' => 'required|array',
            'exercise_ids.*' => 'exists:exercises,id'
        ]);

        $plan->exercises()->syncWithoutDetaching($request->exercise_ids);

        return response()->json([
            'message' => 'Exercises added successfully',
            'plan_id' => $plan->id
        ]);
    }
}