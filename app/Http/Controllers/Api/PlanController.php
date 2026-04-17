<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => Plan::latest()->get()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'trainer_id' => 'required|integer',
            'client_id' => 'required|integer',
            'name' => 'required|string',
            'assigned_date' => 'required|date',
        ]);

        $plan = Plan::create($request->all());

        return response()->json([
            'message' => 'Plan created',
            'data' => $plan
        ], 201);
    }

    public function show($id)
    {
        $plan = Plan::find($id);

        if (!$plan) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json(['data' => $plan]);
    }

    public function update(Request $request, $id)
    {
        $plan = Plan::find($id);

        if (!$plan) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $plan->update($request->all());

        return response()->json([
            'message' => 'Updated',
            'data' => $plan
        ]);
    }

    public function destroy($id)
    {
        $plan = Plan::find($id);

        if (!$plan) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $plan->delete();

        return response()->json(['message' => 'Deleted']);
    }

    public function addExercises(Request $request, $id)
    {
        $plan = Plan::find($id);

        if (!$plan) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $request->validate([
            'exercises' => 'required|array'
        ]);

        return response()->json([
            'message' => 'Exercises added (pending relation)',
            'data' => $request->exercises
        ]);
    }
}