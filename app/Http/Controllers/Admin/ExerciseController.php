<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exercise;
use Illuminate\Http\Request;

class ExerciseController extends Controller
{
    // 📋 LIST
    public function index(Request $request)
    {
        $query = Exercise::query();

        // SEARCH
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('type', 'LIKE', '%' . $request->search . '%');
            });
        }

        // ✅ PER PAGE CONTROL
        $allowedPerPage = [10, 20, 50, 100];
        $perPage = $request->get('per_page', 10);

        if (!in_array($perPage, $allowedPerPage)) {
            $perPage = 10;
        }

        $exercises = $query->latest()->paginate($perPage);

        return view('admin.exercises.index', compact('exercises', 'perPage'));
    }

    // CREATE
    public function create()
    {
        return view('admin.exercises.create');
    }

    // STORE
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'type' => 'nullable',
            'description' => 'nullable',
        ]);

        Exercise::create($request->only(['name', 'type', 'description']));

        return redirect()->route('admin.exercises.index')
            ->with('success', 'Exercise created successfully');
    }

    // EDIT
    public function edit($id)
    {
        $exercise = Exercise::findOrFail($id);
        return view('admin.exercises.edit', compact('exercise'));
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $exercise = Exercise::findOrFail($id);

        $exercise->update($request->only(['name', 'type', 'description']));

        return redirect()->route('admin.exercises.index')
            ->with('success', 'Exercise updated successfully');
    }

    // DELETE
    public function destroy($id)
    {
        Exercise::findOrFail($id)->delete();

        return redirect()->route('admin.exercises.index')
            ->with('success', 'Exercise deleted successfully');
    }

    // AJAX SEARCH
    public function search(Request $request)
    {
        $search = $request->search;

        $exercises = Exercise::where(function ($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search . '%')
                  ->orWhere('type', 'LIKE', '%' . $search . '%');
            })
            ->limit(10)
            ->get();

        return response()->json($exercises);
    }
}