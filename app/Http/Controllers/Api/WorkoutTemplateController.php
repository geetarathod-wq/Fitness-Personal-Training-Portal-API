<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WorkoutTemplateController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => [
                ['name' => 'Full Body Beginner'],
                ['name' => 'Push Pull Legs'],
                ['name' => 'Fat Loss Circuit']
            ]
        ]);
    }

    public function store(Request $request)
    {
        return response()->json([
            'message' => 'Template created (static for now)',
            'data' => $request->all()
        ]);
    }
}