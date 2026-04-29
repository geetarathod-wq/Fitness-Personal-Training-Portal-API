<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Exercise;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\Api\PlanRequest;
use Yajra\DataTables\Facades\DataTables;

class PlanController extends Controller
{
    public function index()
    {
        return view('admin.plans.index');
    }

    public function show($id)
    {
        return redirect()->route('admin.plans.edit', $id);
    }

    public function create()
    {
        $exercises = Exercise::latest()->get();
        $clients = User::where('role_id', User::ROLE_CLIENT)->get();

        return view('admin.plans.create', compact('exercises', 'clients'));
    }

    public function store(PlanRequest $request)
    {
        $plan = Plan::create([
            'name' => $request->name,
            'trainer_id' => auth()->id(),
            'client_id' => $request->client_id,
            'assigned_date' => $request->assigned_date,
        ]);

        $syncData = [];

        foreach ($request->exercises ?? [] as $exerciseId) {
            $syncData[$exerciseId] = [
                'sets' => $request->sets[$exerciseId] ?? 1,
                'reps_min' => $request->reps_min[$exerciseId] ?? 0,
                'reps_max' => $request->reps_max[$exerciseId] ?? 0,
            ];
        }

        $plan->exercises()->sync($syncData);

        return redirect()->route('admin.plans.index')
            ->with('success', 'Plan created successfully');
    }

    public function edit($id)
    {
        $plan = Plan::with('exercises')->findOrFail($id);

        $exercises = Exercise::latest()->get();
        $clients = User::where('role_id', User::ROLE_CLIENT)->get();

        return view('admin.plans.edit', compact('plan', 'exercises', 'clients'));
    }

    public function update(PlanRequest $request, $id)
    {
 
        // echo"<pre>";print_r($request->all()); die();
        $plan = Plan::findOrFail($id);
        $plan->update([
            'name' => $request->name,
            'client_id' => $request->client_id,
            'assigned_date' => $request->assigned_date,
            'trainer_id' => auth()->id(),
        ]);

        
        $exercises = $request->input('exercises', []);
        $syncData = [];

        foreach ($exercises as $exerciseId) {
            $syncData[$exerciseId] = [
                'sets' => $request->sets[$exerciseId] ?? 1,
                'reps_min' => $request->reps_min[$exerciseId] ?? 0,
                'reps_max' => $request->reps_max[$exerciseId] ?? 0,
            ];
        }

        $plan->exercises()->sync($syncData);

        return redirect()->route('admin.plans.index')
            ->with('success', 'Plan updated successfully');
    }

    public function destroy($id)
    {
        Plan::findOrFail($id)->delete();

        return redirect()->route('admin.plans.index')
            ->with('success', 'Plan deleted successfully');
    }

public function getData(Request $request)
{
    $query = Plan::query()
        ->leftJoin('users as clients', 'clients.id', '=', 'plans.client_id')
        ->leftJoin('users as trainers', 'trainers.id', '=', 'plans.trainer_id')
        ->select([
            'plans.id',
            'plans.name',
            'plans.assigned_date',
            'clients.name as client_name',
            'trainers.name as trainer_name'
        ]);

    return DataTables::of($query)

        ->filter(function ($query) use ($request) {
            if ($request->has('search') && $request->search['value']) {

                $search = $request->search['value'];

                $query->where(function ($q) use ($search) {
                    $q->where('plans.name', 'like', "%{$search}%")
                      ->orWhere('clients.name', 'like', "%{$search}%")
                      ->orWhere('trainers.name', 'like', "%{$search}%")
                      ->orWhere('plans.assigned_date', 'like', "%{$search}%");
                });
            }
        })

        ->addColumn('client', function ($row) {
            return $row->client_name ?? 'N/A';
        })

        ->addColumn('trainer', function ($row) {
            return $row->trainer_name ?? 'N/A';
        })

        ->addColumn('action', function ($row) {
            return '
                <a href="'.url('admin/plans/'.$row->id.'/edit').'" class="btn btn-warning btn-sm">Edit</a>

                <form method="POST" action="'.url('admin/plans/'.$row->id).'" style="display:inline;">
                    '.csrf_field().method_field('DELETE').'
                    <button class="btn btn-danger btn-sm" onclick="return confirm(\'Delete?\')">
                        Delete
                    </button>
                </form>
            ';
        })

        ->rawColumns(['action'])
        ->make(true);
}
}