@extends('layouts.admin')

@section('content')

<div class="container mt-4">

    <h2>Exercises</h2>

    <a href="{{ route('admin.exercises.create') }}" class="btn btn-primary mb-3">
        + Add Exercise
    </a>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered">

        <tr>
            <th>Name</th>
            <th>Type</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>

        @foreach($exercises as $exercise)
        <tr>
            <td>{{ $exercise->name }}</td>
            <td>{{ $exercise->type }}</td>
            <td>{{ $exercise->description }}</td>
        <td>
            <div class="d-flex gap-2">

                <!-- EDIT -->
                <a href="{{ route('admin.exercises.edit', $exercise->id) }}" 
                class="btn btn-sm btn-outline-warning">
                    ✏️ Edit
                </a>

                <!-- DELETE -->
                <form action="{{ route('admin.exercises.destroy', $exercise->id) }}" 
                    method="POST">
                    @csrf
                    @method('DELETE')

                    <button type="submit"
                            class="btn btn-sm btn-outline-danger"
                            onclick="return confirm('Are you sure you want to delete this exercise?')">
                        🗑 Delete
                    </button>
                </form>

            </div>
        </td>
        </tr>
        @endforeach

    </table>

</div>

@endsection