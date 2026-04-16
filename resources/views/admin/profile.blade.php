@extends('layouts.admin')

@section('content')

<div class="container mt-4">

    <h3 class="mb-4">👤 Admin Profile</h3>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card p-4">

        <form method="POST" action="{{ route('admin.profile.update') }}">
            @csrf

            <div class="mb-3">
                <label>Name</label>
                <input type="text" name="name"
                       value="{{ $user->name }}"
                       class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email"
                       value="{{ $user->email }}"
                       class="form-control" required>
            </div>

            <div class="mb-3">
                <label>New Password (optional)</label>
                <input type="password" name="password"
                       class="form-control"
                       placeholder="Leave blank if not changing">
            </div>

            <button class="btn btn-primary">
                Update Profile
            </button>

        </form>

    </div>

</div>

@endsection