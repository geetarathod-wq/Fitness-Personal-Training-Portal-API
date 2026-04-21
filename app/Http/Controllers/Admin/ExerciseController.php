<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exercise;
use App\Http\Requests\Admin\StoreExerciseRequest;
use App\Http\Requests\Admin\UpdateExerciseRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ExerciseController extends Controller
{
    public function index()
    {
        return view('admin.exercises.index');
    }

    public function getData(Request $request)
    {
        $exercises = Exercise::latest()->get();

        return DataTables::of($exercises)
            ->addColumn('name', fn($row) => $row->name)
            ->addColumn('type', fn($row) => $row->type)
            ->addColumn('description', fn($row) => $row->description)
            ->addColumn('action', function ($row) {
                return '
                    <a href="'.route('admin.exercises.edit', $row->id).'" class="btn btn-sm btn-warning">Edit</a>

                    <form method="POST" action="'.route('admin.exercises.destroy', $row->id).'" style="display:inline;">
                        '.csrf_field().'
                        '.method_field("DELETE").'
                        <button class="btn btn-sm btn-danger">Delete</button>
                    </form>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        return view('admin.exercises.create');
    }

    public function store(StoreExerciseRequest $request)
    {
        Exercise::create($request->validated());

        return redirect()->route('admin.exercises.index')
            ->with('success', 'Exercise created');
    }

    public function edit($id)
    {
        $exercise = Exercise::findOrFail($id);
        return view('admin.exercises.edit', compact('exercise'));
    }

    public function update(UpdateExerciseRequest $request, $id)
    {
        $exercise = Exercise::findOrFail($id);
        $exercise->update($request->validated());

        return redirect()->route('admin.exercises.index')
            ->with('success', 'Updated');
    }

    public function destroy($id)
    {
        Exercise::findOrFail($id)->delete();

        return back()->with('success', 'Deleted');
    }
}