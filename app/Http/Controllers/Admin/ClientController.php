<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
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

    public function getData(Request $request){
        $clients = User::where('role_id', User::ROLE_CLIENT)->latest()->get();

        return DataTables::of($clients)

            ->addColumn('name', function ($row) {
                return $row->name;
            })
            ->addColumn('email', function ($row) {
                return $row->email;
            })
            ->addColumn('joined', function ($row) {
                return $row->created_at->format('d M Y');
            })
            ->addColumn('action', function ($row) {
                return '
                    <a href="/admin/clients/'.$row->id.'/edit" class="btn btn-sm btn-primary">Edit</a>
                    <form method="POST" action="/admin/clients/'.$row->id.'" style="display:inline;">
                        '.csrf_field().'
                        '.method_field("DELETE").'
                        <button class="btn btn-sm btn-danger">Delete</button>
                    </form>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
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

    public function update(UpdateClientRequest $request, $id)
    {
        $client = User::findOrFail($id);

        $client->update($request->validated());

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
                $q->where('name', 'LIKE', "%$search%")
                  ->orWhere('email', 'LIKE', "%$search%");
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