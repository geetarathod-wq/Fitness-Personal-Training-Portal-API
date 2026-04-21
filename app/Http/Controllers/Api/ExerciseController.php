<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Exercise;
use Illuminate\Http\Request;
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

public function search(Request $request)
{
    $search = $request->query('search');

    if (!$search) {
        return response()->json([
            'message' => 'Search keyword required'
        ], 400);
    }

    $exercises = Exercise::where('name', 'LIKE', "%{$search}%")
        ->orWhere('type', 'LIKE', "%{$search}%")
        ->orWhere('description', 'LIKE', "%{$search}%")
        ->get();

    if ($exercises->count() === 0) {
        return response()->json([
            'message' => 'No exercises found',
            'data' => []
        ]);
    }

    return response()->json([
        'data' => $exercises
    ]);
}
    public function show($id)
    {
        $exercise = Exercise::find($id);

        if (!$exercise) {
            return response()->json([
                'message' => 'Exercise not found'
            ], 404);
        }

        return response()->json([
            'data' => $exercise
        ]);
    }
}