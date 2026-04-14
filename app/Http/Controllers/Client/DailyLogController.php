<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\DailyLog;
use Illuminate\Http\Request;

class DailyLogController extends Controller
{
    public function create()
    {
        return view('client.logs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'weight' => 'nullable|numeric',
            'calories' => 'nullable|numeric',
            'notes' => 'nullable|string'
        ]);

        DailyLog::create([
            'client_id' => auth()->id(),
            'date' => $request->date,
            'weight' => $request->weight,
            'calories' => $request->calories,
            'notes' => $request->notes,
        ]);

        return redirect()->route('client.dashboard')
            ->with('success', 'Log added successfully!');
    }

    public function index()
    {
        $logs = DailyLog::where('client_id', auth()->id())
            ->latest()
            ->get();

        return view('client.logs.index', compact('logs'));
    }
    public function destroy($id)
    {
        $log = DailyLog::where('client_id', auth()->id())->findOrFail($id);
        $log->delete();

        return back()->with('success', 'Log deleted successfully!');
    }
}