<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exercise;
use Illuminate\Http\Request;

class ExerciseController extends Controller
{
    // LIST
    public function index()
    {
        $exercises = Exercise::latest()->get();
        return view('admin.exercises.index', compact('exercises'));
    }

    // CREATE FORM
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

        Exercise::create($request->all());

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

        $exercise->update($request->all());

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
}