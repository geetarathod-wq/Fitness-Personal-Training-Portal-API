<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Http\Requests\Api\PlanRequest;

class PlanController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => Plan::with(['client', 'exercises'])->latest()->get()
        ]);
    }

    public function store(PlanRequest $request)
    {
        $plan = Plan::create($request->validated());

        return response()->json([
            'message' => 'Plan created',
            'data' => $plan
        ], 201);
    }

    public function update(PlanRequest $request, $id)
    {
        $plan = Plan::findOrFail($id);
        $plan->update($request->validated());

        return response()->json([
            'message' => 'Plan updated',
            'data' => $plan
        ]);
    }

    public function destroy($id)
    {
        Plan::findOrFail($id)->delete();

        return response()->json([
            'message' => 'Plan deleted'
        ]);
    }

    public function searchClients($search)
    {
        return response()->json(
            \App\Models\User::where('role_id', 2)
                ->where('name', 'like', "%$search%")
                ->limit(10)
                ->get()
        );
    }

    public function searchExercises($search)
    {
        return response()->json(
            \App\Models\Exercise::where('name', 'like', "%$search%")
                ->limit(10)
                ->get()
        );
    }
}