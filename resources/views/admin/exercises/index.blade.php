@extends('layouts.admin')

@section('content')

<div class="container mt-4">

    <div class="d-flex justify-content-between mb-3">
        <h2>🏋️ Exercises</h2>

        <a href="{{ route('admin.exercises.create') }}" class="btn btn-primary">
            + Add Exercise
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table id="exerciseTable" class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Type</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
    </table>

</div>

{{-- JS --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
$(document).ready(function () {

    let table = $('#exerciseTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.exercises.data') }}",
        columns: [
            { data: 'name', name: 'name' },
            { data: 'type', name: 'type' },
            { data: 'description', name: 'description' },
            { data: 'action', orderable: false, searchable: false }
        ]
    });

    // ✅ SAFE DELETE CONFIRMATION
    $(document).on('click', '.deleteBtn', function () {

        let id = $(this).data('id');

        let confirmDelete = confirm(
            "⚠️ Are you sure you want to delete this exercise?\n\nThis action cannot be undone."
        );

        if (!confirmDelete) return;

        $.ajax({
            url: "/admin/exercises/" + id,
            type: "DELETE",
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function (res) {
                alert(res.message);
                table.ajax.reload(null, false);
            },
            error: function () {
                alert("❌ Something went wrong");
            }
        });

    });

});
</script>

@endsection