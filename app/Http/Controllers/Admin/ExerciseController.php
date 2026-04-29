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
        $exercises = Exercise::select(['id', 'name', 'type', 'description']);

        return DataTables::of($exercises)

            ->addColumn('action', function ($row) {

                return '
                    <a href="'.route('admin.exercises.edit', $row->id).'" 
                    class="btn btn-sm btn-warning">
                        Edit
                    </a>

                    <button class="btn btn-sm btn-danger deleteBtn"
                            data-id="'.$row->id.'">
                        Delete
                    </button>
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

        return response()->json([
            'success' => true,
            'message' => 'Exercise deleted successfully'
        ]);
    }
}