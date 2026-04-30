@extends('layouts.admin')

@section('content')

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">✏️ Edit Client</h2>

        <a href="{{ route('admin.clients.index') }}" class="btn btn-secondary">
            ⬅ Back
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.clients.update', $client->id) }}">
        @csrf
        @method('PUT')

        <div class="card shadow-sm p-4">

            <!-- NAME -->
            <div class="mb-3">
                <label class="form-label">Client Name</label>
                <input type="text"
                       name="name"
                       class="form-control"
                       value="{{ old('name', $client->name) }}"
                       required>
            </div>

            <!-- EMAIL -->
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email"
                       name="email"
                       class="form-control"
                       value="{{ old('email', $client->email) }}"
                       required>
            </div>

        </div>

        <div class="mt-3">
            <button type="submit" class="btn btn-primary">
                Update Client
            </button>
        </div>

    </form>

</div>

@endsection