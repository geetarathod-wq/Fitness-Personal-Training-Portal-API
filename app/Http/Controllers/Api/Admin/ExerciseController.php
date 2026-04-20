<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exercise;
use App\Http\Requests\Api\ExerciseRequest;

class ExerciseController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => Exercise::latest()->get()
        ]);
    }

    public function store(ExerciseRequest $request)
    {
        $exercise = Exercise::create($request->validated());

        return response()->json([
            'message' => 'Exercise created successfully',
            'data' => $exercise
        ], 201);
    }

    public function update(ExerciseRequest $request, $id)
    {
        $exercise = Exercise::findOrFail($id);
        $exercise->update($request->validated());

        return response()->json([
            'message' => 'Exercise updated successfully',
            'data' => $exercise
        ]);
    }

    public function destroy($id)
    {
        Exercise::findOrFail($id)->delete();

        return response()->json([
            'message' => 'Exercise deleted successfully'
        ]);
    }

    public function search($search)
    {
        $data = Exercise::where('name', 'like', "%$search%")
            ->orWhere('type', 'like', "%$search%")
            ->limit(10)
            ->get();

        return response()->json($data);
    }
}