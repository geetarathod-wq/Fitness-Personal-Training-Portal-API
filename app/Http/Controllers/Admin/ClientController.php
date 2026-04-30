<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Validation\Rule;
use App\Models\DailyLog;
use App\Http\Requests\Admin\StoreClientRequest;
use App\Http\Requests\Admin\UpdateClientRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ClientController extends Controller
{
    public function index()
    {
        return view('admin.clients.index');
    }

    public function getData(Request $request)
    {
        $clients = User::query()
            ->where('role_id', User::ROLE_CLIENT)
            ->select(['id', 'name', 'email', 'created_at']);

        $csrf = csrf_token();

        return DataTables::eloquent($clients)
            ->editColumn('created_at', fn ($row) => $row->created_at->format('d M Y'))
            ->addColumn('action', function ($row) use ($csrf) {

                return '
                    <a href="/admin/clients/'.$row->id.'/graph"
                    class="btn btn-sm btn-info">
                        Graph
                    </a>

                    <a href="/admin/clients/'.$row->id.'/edit"
                    class="btn btn-sm btn-warning">
                        Edit
                    </a>

                    <form method="POST"
                        action="/admin/clients/'.$row->id.'"
                        style="display:inline;"
                        onsubmit="return confirm(\'Are you sure?\')">

                        <input type="hidden" name="_token" value="'.$csrf.'">
                        <input type="hidden" name="_method" value="DELETE">

                        <button type="submit" class="btn btn-sm btn-danger">
                            Delete
                        </button>
                    </form>
                ';
            })
            ->rawColumns(['action'])
            ->toJson();
    }
    public function create()
    {
        return view('admin.clients.create');
    }

    public function store(StoreClientRequest $request)
    {
        $data = $request->validated();

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'role_id' => User::ROLE_CLIENT,
        ]);

        return redirect()->route('admin.clients.index')
            ->with('success', 'Client added');
    }

    public function edit($id)
    {
        $client = User::findOrFail($id);
        return view('admin.clients.edit', compact('client'));
    }

    public function update(Request $request, $id)
    {
        $client = User::where('role_id', User::ROLE_CLIENT)
            ->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($client->id),
            ],
        ]);

        $client->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('admin.clients.index')
            ->with('success', 'Client updated successfully');
    }
    public function destroy($id)
    {
        User::findOrFail($id)->delete();

        return back()->with('success', 'Client deleted');
    }

    public function search(Request $request)
    {
        $search = $request->search;

        $clients = User::where('role_id', User::ROLE_CLIENT)
            ->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
            })
            ->limit(10)
            ->get(['id', 'name', 'email']);

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