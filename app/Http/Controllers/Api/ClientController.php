<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        $clients = User::where('role_id', User::ROLE_CLIENT)->get();

        return response()->json([
            'data' => $clients
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $client = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role_id' => User::ROLE_CLIENT,
        ]);

        return response()->json([
            'message' => 'Client created',
            'data' => $client
        ], 201);
    }

    public function show($id)
    {
        $client = User::where('role_id', User::ROLE_CLIENT)->find($id);

        if (!$client) {
            return response()->json(['message' => 'Client not found'], 404);
        }

        return response()->json(['data' => $client]);
    }

    public function destroy($id)
    {
        $client = User::where('role_id', User::ROLE_CLIENT)->find($id);

        if (!$client) {
            return response()->json(['message' => 'Client not found'], 404);
        }

        $client->delete();

        return response()->json(['message' => 'Client deleted']);
    }
}