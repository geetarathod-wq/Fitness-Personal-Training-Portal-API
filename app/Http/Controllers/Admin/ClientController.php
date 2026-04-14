<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    // 📋 LIST CLIENTS
    public function index()
    {
        $clients = User::whereHas('role', function ($q) {
            $q->where('name', 'customer');
        })->latest()->get();

        return view('admin.clients.index', compact('clients'));
    }

    // ➕ CREATE FORM
    public function create()
    {
        return view('admin.clients.create');
    }

    // 💾 STORE CLIENT
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $role = Role::where('name', 'customer')->first();

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role_id' => $role->id,
        ]);

        return redirect()->route('admin.clients.index')
            ->with('success', 'Client added');
    }

    // ✏️ EDIT PAGE
    public function edit($id)
    {
        $client = User::findOrFail($id);
        return view('admin.clients.edit', compact('client'));
    }

    // 🔄 UPDATE CLIENT
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

    // 🗑 DELETE CLIENT
    public function destroy($id)
    {
        User::findOrFail($id)->delete();

        return back()->with('success', 'Client deleted');
    }
}