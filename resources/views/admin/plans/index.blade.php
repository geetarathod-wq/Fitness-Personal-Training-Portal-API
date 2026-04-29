@extends('layouts.admin')

@section('content')

<div class="container mt-4">

    <div class="d-flex justify-content-between mb-3">
        <h2>🏋️ Fitness Plans</h2>

        <a href="{{ route('admin.plans.create') }}" class="btn btn-primary">
            + Create Plan
        </a>
    </div>

    <table id="plansTable" class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Plan Name</th>
                <th>Client</th>
                <th>Trainer</th>
                <th>Assigned Date</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>

</div>

@endsection

@push('scripts')
<script>
$(document).ready(function () {

    $('#plansTable').DataTable({
        processing: true,
        serverSide: true,

        // ✅ DO NOT disable searching

        ajax: "{{ route('admin.plans.data') }}",

        columns: [
            { data: 'id', name: 'plans.id' },
            { data: 'name', name: 'plans.name' },
            { data: 'client', name: 'clients.name' },   // 🔥 critical
            { data: 'trainer', name: 'trainers.name' }, // 🔥 critical
            { data: 'assigned_date', name: 'plans.assigned_date' },
            { data: 'action', orderable: false, searchable: false }
        ]
    });

});
</script>
@endpush