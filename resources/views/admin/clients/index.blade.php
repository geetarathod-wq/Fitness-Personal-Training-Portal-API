@extends('layouts.admin')

@section('content')

<div class="d-flex justify-content-between mb-3">
    <h4>Clients</h4>

    <a href="{{ route('admin.clients.create') }}" class="btn btn-primary">
        + Add Client
    </a>
</div>

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<div class="card">
    <div class="card-body">

        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Joined</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse($clients as $client)
                <tr>
                    <td>{{ $client->name }}</td>
                    <td>{{ $client->email }}</td>
                    <td>{{ $client->created_at->format('d M Y') }}</td>
                    <td>

                        <!-- ✏️ EDIT -->
                        <a href="{{ route('admin.clients.edit', $client->id) }}" 
                           class="btn btn-warning btn-sm">
                            Edit
                        </a>

                        <!-- 🗑 DELETE -->
                        <form method="POST" 
                              action="{{ route('admin.clients.destroy', $client->id) }}" 
                              style="display:inline-block;">
                            @csrf
                            @method('DELETE')

                            <button class="btn btn-danger btn-sm"
                                onclick="return confirm('Are you sure?')">
                                Delete
                            </button>
                        </form>

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
</div>

@endsection