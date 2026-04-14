@extends('layouts.admin')

@section('content')

<h4>Add Client</h4>

@if($errors->any())
<div class="alert alert-danger">
    {{ implode('', $errors->all(':message ')) }}
</div>
@endif

<div class="card">
    <div class="card-body">

        <form method="POST" action="{{ route('admin.clients.store') }}">
            @csrf

            <div class="mb-3">
                <label>Name</label>
                <input type="text" name="name" class="form-control">
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control">
            </div>

            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control">
            </div>

            <button class="btn btn-success">Save</button>

        </form>

    </div>
</div>

@endsection