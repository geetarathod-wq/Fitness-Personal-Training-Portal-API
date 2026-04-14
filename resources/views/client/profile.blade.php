@extends('layouts.app')

@section('content')

<div class="card p-4">
  <h4 class="mb-4">My Profile</h4>

  @if(session('success'))
    <div class="alert alert-success">
      {{ session('success') }}
    </div>
  @endif

  <form method="POST" action="{{ route('client.profile.update') }}">
    @csrf

    <div class="mb-3">
      <label>Name</label>
      <input type="text"
             name="name"
             value="{{ auth()->user()->name }}"
             class="form-control"
             required>
    </div>

    <div class="mb-3">
      <label>Email</label>
      <input type="email"
             name="email"
             value="{{ auth()->user()->email }}"
             class="form-control"
             required>
    </div>

    <div class="mb-3">
      <label>New Password (optional)</label>
      <input type="password"
             name="password"
             class="form-control">
    </div>

    <button class="btn btn-primary">
      Update Profile
    </button>

  </form>
</div>

@endsection