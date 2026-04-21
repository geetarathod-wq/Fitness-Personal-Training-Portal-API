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

    {{-- SUCCESS MESSAGE --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- TABLE --}}
    <table id="logsTable" class="table table-bordered">
        <thead>
            <tr>
                <th>Date</th>
                <th>Weight</th>
                <th>Calories</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            @foreach($logs as $log)
                <tr>
                    <td>{{ $log->date }}</td>
                    <td>{{ $log->weight }}</td>
                    <td>{{ $log->calories }}</td>
                    <td>
                        <form method="POST" action="{{ route('client.logs.delete', $log->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>

@endsection

{{-- DATATABLE SCRIPT --}}
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
            { orderable: false, targets: 3 }
        ]
    });

});
</script>
@endpush