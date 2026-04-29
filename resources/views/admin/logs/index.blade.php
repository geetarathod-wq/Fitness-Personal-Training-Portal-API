@extends('layouts.admin')

@section('content')

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
       <h2>📊 Logs</h2>
       @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
    </div>

    <table id="logsTable" class="table table-bordered">
        <thead>
            <tr>
                <th>Client</th>
                <th>Date</th>
                <th>Weight</th>
                <th>Calories</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>

</div>

@endsection

@push('scripts')
<script>
$(function () {

    let table = $('#logsTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.logs.data') }}",
        columns: [
            { data: 'client_name', name: 'client_name' },
            { data: 'date', name: 'date' },
            { data: 'weight', name: 'weight' },
            { data: 'calories', name: 'calories' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
    });

    // DELETE FUNCTION
    $(document).on('click', '.deleteBtn', function () {
        let id = $(this).data('id');

        if (confirm("Are you sure you want to delete this log?")) {

            $.ajax({
                url: '/admin/logs/' + id,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    alert(response.message);
                    table.ajax.reload();
                },
                error: function () {
                    alert('Something went wrong');
                }
            });
        }
    });

});
</script>
@endpush