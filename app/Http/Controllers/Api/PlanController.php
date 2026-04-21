<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;
use App\Http\Requests\Api\PlanRequest;

class PlanController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => Plan::with(['client', 'exercises'])->latest()->get()
        ]);
    }

public function store(Request $request)
{
    $request->validate([
        'name' => 'required',
        'client_id' => 'required',
        'assigned_date' => 'required',
    ]);

    $plan = Plan::create([
        'name' => $request->name,
        'client_id' => $request->client_id,
        'assigned_date' => $request->assigned_date,
        'trainer_id' => auth()->id(),
    ]);

    return response()->json($plan, 201);
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