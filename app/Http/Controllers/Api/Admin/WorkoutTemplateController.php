<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WorkoutTemplate;

class WorkoutTemplateController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => WorkoutTemplate::latest()->paginate(10)
        ]);
    }

    public function show($id)
    {
        $template = WorkoutTemplate::find($id);

        if (!$template) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json(['data' => $template]);
    }
}