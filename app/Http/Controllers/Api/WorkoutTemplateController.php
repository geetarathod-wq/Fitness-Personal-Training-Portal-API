<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Plan;

class WorkoutTemplateController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => Plan::with(['exercises', 'trainer'])->get()
        ]);
    }

    public function store(Request $request)
    {
        return response()->json([
            'message' => 'Templates are managed via Plans module'
        ], 200);
    }

    public function show($id)
    {
        $template = Plan::with(['exercises', 'trainer'])->find($id);

        if (!$template) {
            return response()->json([
                'message' => 'Template not found'
            ], 404);
        }

        return response()->json([
            'data' => $template
        ]);
    }

    public function update(Request $request, $id)
    {
        return response()->json([
            'message' => 'Templates are managed via Plans module'
        ], 200);
    }

    public function destroy($id)
    {
        return response()->json([
            'message' => 'Templates cannot be deleted from this endpoint'
        ], 200);
    }
}