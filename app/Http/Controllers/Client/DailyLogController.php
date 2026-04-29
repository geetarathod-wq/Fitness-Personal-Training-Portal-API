<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\DailyLog;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DailyLogController extends Controller
{
    public function create()
    {
        return view('client.logs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'weight' => 'required|numeric|min:1',
            'calories' => 'required|numeric|min:1',
        ]);

        DailyLog::create([
            'client_id' => auth()->id(),
            'date' => $request->date,
            'weight' => $request->weight,
            'calories' => $request->calories,
            'notes' => $request->notes,
        ]);

        return redirect()->route('client.logs.index')
            ->with('success', 'Log added successfully');
    }

    public function index()
    {
        return view('client.logs.index');
    }

    public function destroy($id)
    {
        $log = DailyLog::where('client_id', auth()->id())
            ->findOrFail($id);

        $log->delete();

        return back()->with('success', 'Log deleted successfully!');
    }

    public function getData()
    {
        $logs = DailyLog::where('client_id', auth()->id());

        return DataTables::of($logs)

            ->editColumn('date', fn($row) => $row->date ?? $row->created_at->format('Y-m-d'))
            ->orderColumn('date', fn($q, $order) => $q->orderBy('date', $order))

            ->editColumn('weight', fn($row) => $row->weight)
            ->orderColumn('weight', fn($q, $order) => $q->orderBy('weight', $order))

            ->editColumn('calories', fn($row) => $row->calories)
            ->orderColumn('calories', fn($q, $order) => $q->orderBy('calories', $order))

            ->editColumn('notes', fn($row) => $row->notes ?? '-')

            ->addColumn('action', function ($row) {
                return '
                    <form method="POST" action="'.route('client.logs.delete', $row->id).'">
                        '.csrf_field().'
                        '.method_field('DELETE').'
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