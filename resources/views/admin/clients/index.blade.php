@extends('layouts.admin')

@section('content')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Clients</h2>
    </div>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @include('admin.clients.table')
</div>

@endsection
@push('scripts')
<script>
    $(function () {
        $('#clientsTable').DataTable({
            processing: true,
            serverSide: true,
            deferRender: true,
            pageLength: 25,
            order: [[2, 'desc']],
            ajax: "{{ route('admin.clients.data') }}",
            columns: [
                { data: 'name',       name: 'name' },
                { data: 'email',      name: 'email' },
                { data: 'created_at', name: 'created_at' },
                { data: 'action',     name: 'action', orderable: false, searchable: false },
            ]
        });
    });
</script>
@endpush