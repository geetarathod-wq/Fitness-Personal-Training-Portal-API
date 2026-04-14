@extends('layouts.admin')

@section('content')

<div class="container mt-4">

    <h2>Add Exercise</h2>

    <form method="POST" action="{{ route('admin.exercises.store') }}">
        @csrf

        <input type="text" name="name" class="form-control mb-2" placeholder="Name" required>

        <input type="text" name="type" class="form-control mb-2" placeholder="Type">

        <textarea name="description" class="form-control mb-2" placeholder="Description"></textarea>

        <button class="btn btn-success">Save</button>

    </form>

</div>

@endsection