@extends('layouts.admin')

@section('content')

<div class="container mt-4">

    <div class="card shadow-sm p-4">

        <h4 class="mb-4">✏️ Edit Exercise</h4>

        <form method="POST" action="{{ route('admin.exercises.update', $exercise->id) }}">
            @csrf
            @method('PUT')

            <!-- NAME -->
            <div class="mb-3">
                <label class="form-label">Exercise Name</label>
                <input type="text" 
                       name="name" 
                       value="{{ $exercise->name }}" 
                       class="form-control" 
                       placeholder="Enter exercise name" 
                       required>
            </div>

            <!-- TYPE -->
            <div class="mb-3">
                <label class="form-label">Exercise Type</label>
                <input type="text" 
                       name="type" 
                       value="{{ $exercise->type }}" 
                       class="form-control" 
                       placeholder="e.g. Strength / Cardio">
            </div>

            <!-- DESCRIPTION -->
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" 
                          class="form-control" 
                          rows="4" 
                          placeholder="Write exercise details...">{{ $exercise->description }}</textarea>
            </div>

            <!-- BUTTONS -->
            <div class="d-flex justify-content-between">
                
                <a href="{{ route('admin.exercises.index') }}" 
                   class="btn btn-secondary">
                    ⬅ Back
                </a>

                <button class="btn btn-success">
                    💾 Update Exercise
                </button>

            </div>

        </form>

    </div>

</div>

@endsection