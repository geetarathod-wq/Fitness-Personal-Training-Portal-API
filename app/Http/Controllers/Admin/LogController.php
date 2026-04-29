<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DailyLog;
use Yajra\DataTables\Facades\DataTables;

class LogController extends Controller
{
    public function index()
    {
        return view('admin.logs.index');
    }

    public function getData(Request $request)
    {
        $logs = DailyLog::with('client')
            ->select('daily_logs.*');

        return DataTables::of($logs)
            ->filter(function ($query) use ($request) {
                if ($request->has('search') && $request->search['value']) {
                    $search = $request->search['value'];
                    $query->where(function ($q) use ($search) {
                        $q->where('date', 'like', "%{$search}%")
                        ->orWhere('weight', 'like', "%{$search}%")
                        ->orWhere('calories', 'like', "%{$search}%")
                        ->orWhereHas('client', function ($q2) use ($search) {
                            $q2->where('name', 'like', "%{$search}%");
                        });
                    });
                }
            })
            
            ->orderColumn('client_name', function ($query, $order) {
                $query->join('users', 'users.id', '=', 'daily_logs.client_id')
                    ->orderBy('users.name', $order);
            })
            
            ->addColumn('client_name', function ($log) {
                return $log->client->name ?? '-';
            })

            ->addColumn('action', function ($log) {

                $csrf = csrf_token();

                return '
                    <form method="POST"
                        action="/admin/logs/'.$log->id.'"
                        style="display:inline;"
                        onsubmit="return confirm(\'Are you sure you want to delete this log?\')">

                        <input type="hidden" name="_token" value="'.$csrf.'">
                        <input type="hidden" name="_method" value="DELETE">

                        <button class="btn btn-sm btn-danger">
                            Delete
                        </button>
                    </form>
                ';
            })

            ->rawColumns(['action'])
            ->make(true);
    }

    public function destroy($id)
    {
        $log = DailyLog::findOrFail($id);
        $log->delete();

        return redirect()->back()->with('success', 'Log deleted successfully');
    }
}