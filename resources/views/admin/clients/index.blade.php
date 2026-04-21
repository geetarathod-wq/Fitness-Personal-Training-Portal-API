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
    @include('admin.clients.table')

</div>

{{-- DATATABLE SCRIPT --}}
<script
  src="https://code.jquery.com/jquery-4.0.0.min.js"
  integrity="sha256-OaVG6prZf4v69dPg6PhVattBXkcOWQB62pdZ3ORyrao="
  crossorigin="anonymous"></script>
<script>

    $(function () {

        $('#clientsTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.clients.data') }}",

            columns: [
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                { data: 'joined', name: 'joined' },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ]
        });
    });
</script> 

@endsection