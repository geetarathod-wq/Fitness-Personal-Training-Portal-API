<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\DailyLog;

class ClientController extends Controller
{
    // 📋 LIST CLIENTS
    public function index()
    {
        $clients = User::where('role_id', User::ROLE_CLIENT)
            ->latest()
            ->get(); 

        return view('admin.clients.index', compact('clients'));
    }
    // CREATE
    public function create()
    {
        return view('admin.clients.create');
    }

    // STORE
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role_id' => User::ROLE_CLIENT,
        ]);

        return redirect()->route('admin.clients.index')
            ->with('success', 'Client added');
    }

    // EDIT
    public function edit($id)
    {
        $client = User::findOrFail($id);
        return view('admin.clients.edit', compact('client'));
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $client = User::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $client->id,
        ]);

        $client->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('admin.clients.index')
            ->with('success', 'Client updated successfully');
    }

    // DELETE
    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return back()->with('success', 'Client deleted');
    }

    // AJAX SEARCH 
    public function search(Request $request)
    {
        $search = $request->search;

        $clients = User::where('role_id', User::ROLE_CLIENT)
            ->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search . '%')
                  ->orWhere('email', 'LIKE', '%' . $search . '%');
            })
            ->limit(10)
            ->get();

        return response()->json($clients);
    }

    public function graph($id)
    {
        $client = User::findOrFail($id);

        $logs = DailyLog::where('client_id', $id)
            ->orderBy('date')
            ->get();

        return view('admin.clients.graph', compact('client', 'logs'));
    }
}