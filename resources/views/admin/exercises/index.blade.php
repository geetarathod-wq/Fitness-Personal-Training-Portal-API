@extends('layouts.admin')

@section('content')

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Exercises</h2>

        <a href="{{ route('admin.exercises.create') }}" class="btn btn-primary">
            + Add Exercise
        </a>
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
                <th>Type</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            @forelse($exercises as $exercise)
            <tr>
                <td>{{ $exercise->name }}</td>
                <td>{{ $exercise->type }}</td>
                <td>{{ $exercise->description }}</td>

                <td>
                    <div class="d-flex gap-2">

                        <a href="{{ route('admin.exercises.edit', $exercise->id) }}"
                           class="btn btn-sm btn-outline-warning">✏️</a>

                        <form action="{{ route('admin.exercises.destroy', $exercise->id) }}"
                              method="POST"
                              onsubmit="return confirm('Delete this exercise?')">
                            @csrf
                            @method('DELETE')

                            <button class="btn btn-sm btn-outline-danger">🗑</button>
                        </form>

                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4">No exercises found</td>
            </tr>
            @endforelse
        </tbody>
    </table>

</div>

{{-- ✅ EXACT SAME SCRIPT AS CLIENT --}}
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