<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PlanController extends Controller
{
    public function index()
    {
        return view('client.plan.index'); 
    }

    public function getData(Request $request)
    {
        $plans = Plan::with(['trainer', 'exercises'])
            ->where('client_id', Auth::id())
            ->latest()
            ->get();

        return DataTables::of($plans)

            ->addColumn('name', fn($row) => $row->name)

            ->addColumn('trainer', fn($row) => $row->trainer->name ?? 'N/A')

            ->addColumn('exercises', function ($row) {

                if ($row->exercises->isEmpty()) {
                    return '<span class="text-muted">No exercises</span>';
                }

                $html = '';

                foreach ($row->exercises as $exercise) {
                    $html .= '
                        <div class="border rounded p-2 mb-2 bg-light">
                            <strong>'.$exercise->name.'</strong><br>
                            <small class="text-muted">
                                Sets: '.($exercise->pivot->sets ?? 0).' |
                                Reps: '.($exercise->pivot->reps_min ?? 0).' - '.($exercise->pivot->reps_max ?? 0).'
                            </small>
                        </div>
                    ';
                }

                return $html;
            })

            ->addColumn('assigned_date', function ($row) {
                return \Carbon\Carbon::parse($row->assigned_date)->format('d M Y');
            })

            ->rawColumns(['exercises'])
            ->make(true);
    }
}