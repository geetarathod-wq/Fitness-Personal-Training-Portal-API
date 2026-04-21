<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\Api\ClientRequest;
use App\Http\Requests\Api\UpdateClientRequest;
class ClientController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => User::where('role_id', User::ROLE_CLIENT)->get()
        ]);
    }

    public function store(ClientRequest $request)
    {
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

    public function update(UpdateClientRequest $request, $id)
    {
        $client = User::where('role_id', User::ROLE_CLIENT)->findOrFail($id);

        $client->update($request->validated());

        return response()->json([
            'message' => 'Client updated',
            'data' => $client
        ]);
    }

    public function destroy($id)
    {
        User::where('role_id', User::ROLE_CLIENT)->findOrFail($id)->delete();

        return response()->json([
            'message' => 'Client deleted'
        ]);
    }

    public function search($search)
    {
        $clients = User::where('role_id', User::ROLE_CLIENT)
            ->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%");
            })
            ->limit(10)
            ->get();

        return response()->json($clients);
    }

    public function graph($id)
    {
        $client = User::findOrFail($id);

        $logs = \App\Models\DailyLog::where('client_id', $id)
            ->orderBy('date')
            ->get();

        return response()->json([
            'client' => $client,
            'logs' => $logs
        ]);
    }
}