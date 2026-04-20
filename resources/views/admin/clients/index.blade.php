@extends('layouts.admin')

@section('content')

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Clients</h2>
    </div>

    {{-- SUCCESS --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- DATATABLE --}}
    <table id="clientsTable" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Joined</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            @forelse($clients as $client)
            <tr>
                <td>{{ $client->name }}</td>
                <td>{{ $client->email }}</td>
                <td>{{ $client->created_at->format('d M Y') }}</td>

                <td>
                    <div class="d-flex gap-2">

                        <a href="{{ route('admin.clients.graph', $client->id) }}"
                           class="btn btn-sm btn-outline-info">📊</a>

                        <a href="{{ route('admin.clients.edit', $client->id) }}"
                           class="btn btn-sm btn-outline-warning">✏️</a>

                        <form action="{{ route('admin.clients.destroy', $client->id) }}"
                              method="POST"
                              onsubmit="return confirm('Delete this client?')">
                            @csrf
                            @method('DELETE')

                            <button class="btn btn-sm btn-outline-danger">🗑</button>
                        </form>

                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4">No clients found</td>
            </tr>
            @endforelse
        </tbody>
    </table>

</div>

{{-- DATATABLE SCRIPT --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    $('#clientsTable').DataTable({
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

@endsection