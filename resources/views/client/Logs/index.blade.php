@extends('layouts.app')

@section('content')

<div class="container mt-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>My Weekly Logs</h4>

        <a href="{{ route('client.logs.create') }}" class="btn btn-primary">
            + Add Log
        </a>
    </div>

    {{-- SUCCESS --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- DATATABLE --}}
    <table id="logsTable" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Date</th>
                <th>Weight</th>
                <th>Calories</th>
                <th>Notes</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            @forelse($logs as $log)
            <tr>
                <td>{{ $log->date }}</td>
                <td>{{ $log->weight ?? '-' }} kg</td>
                <td>{{ $log->calories ?? '-' }}</td>
                <td>{{ $log->notes ?? '-' }}</td>

                <td>
                    <form method="POST"
                          action="{{ route('client.logs.delete', $log->id) }}"
                          onsubmit="return confirm('Delete this log?')">
                        @csrf
                        @method('DELETE')

                        <button class="btn btn-sm btn-outline-danger">
                            🗑 Delete
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5">No logs found</td>
            </tr>
            @endforelse
        </tbody>
    </table>

</div>

@endsection


{{-- ✅ IMPORTANT: PUSH SCRIPT (NOT NORMAL SCRIPT) --}}
@push('scripts')
<script>
$(document).ready(function () {
    $('#logsTable').DataTable({
        pageLength: 10,
        lengthMenu: [10, 20, 50, 100],
        ordering: true,
        searching: true,
        paging: true,
        info: true,
        responsive: true,
        columnDefs: [
            { orderable: false, targets: 4 }
        ]
    });
});
</script>
@endpush