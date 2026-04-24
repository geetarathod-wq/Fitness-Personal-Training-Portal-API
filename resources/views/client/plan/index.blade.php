@extends('layouts.app')

@section('content')

<div class="container-fluid pt-2">
    <h4 class="mb-2">📋 Plans List</h4>
    @if(session('success'))
        <div class="alert alert-success py-2 mb-2">
            {{ session('success') }}
        </div>
    @endif
    <div class="card shadow-sm border-0 p-3">
        <div class="table-responsive">
            <table id="planTable" class="table table-bordered table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Plan</th>
                        <th>Trainer</th>
                        <th>Exercises</th>
                        <th>Assigned Date</th>
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
    $('#planTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('client.plan.data') }}",
        columns: [
            { data: 'name', name: 'name' },
            { data: 'trainer', name: 'trainer' },
            { data: 'exercises', name: 'exercises', orderable: false, searchable: false },
            { data: 'assigned_date', name: 'assigned_date' }
        ],
        pageLength: 10,
        lengthMenu: [10, 20, 50, 100],
        responsive: true
    });
});
</script>
@endpush