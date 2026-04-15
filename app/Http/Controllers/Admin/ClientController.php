<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    // 📋 LIST CLIENTS
    public function index(Request $request)
    {
        $query = User::where('role_id', User::ROLE_CLIENT);

        // SEARCH
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'LIKE', $request->search . '%')
                  ->orWhere('email', 'LIKE', $request->search . '%');
            });
        }

        // ✅ PER PAGE (allowed values only)
        $allowedPerPage = [10, 20, 50, 100];
        $perPage = $request->get('per_page', 10);

        if (!in_array($perPage, $allowedPerPage)) {
            $perPage = 10;
        }

        $clients = $query->latest()->paginate($perPage);

        return view('admin.clients.index', compact('clients', 'perPage'));
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
}