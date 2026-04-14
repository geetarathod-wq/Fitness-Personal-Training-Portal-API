@extends('layouts.admin')

@section('content')

<div class="container mt-4">

    <h3>Edit Client</h3>

    <form method="POST" action="{{ route('admin.clients.update', $client->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" value="{{ $client->name }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" value="{{ $client->email }}" class="form-control">
        </div>

        <button class="btn btn-success">Update Client</button>

    </form>

</div>

@endsection