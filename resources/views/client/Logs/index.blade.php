@extends('layouts.app')

@section('content')

<div class="container-fluid pt-2">

    <h4 class="mb-2">📋 My Weekly Logs</h4>

    @if(session('success'))
        <div class="alert alert-success py-2 mb-2">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow-sm border-0 p-3">

        <div class="table-responsive">
            <table id="logsTable" class="table table-bordered table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Date</th>
                        <th>Weight</th>
                        <th>Calories</th>
                        <th>Notes</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>

    </div>

</div>

@endsection

@push('scripts')

<script>
$(document).ready(function () {

    $('#logsTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('client.logs.data') }}",

        columns: [
            { data: 'date', name: 'date' },
            { data: 'weight', name: 'weight' },
            { data: 'calories', name: 'calories' },
            { data: 'notes', name: 'notes', orderable: false, searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],

        pageLength: 10,
        lengthMenu: [10, 20, 50, 100],
        responsive: true
    });

});
</script>

@endpush