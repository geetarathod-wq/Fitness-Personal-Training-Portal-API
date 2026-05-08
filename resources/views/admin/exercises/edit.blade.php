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
                    id="name"
                    value="{{ $exercise->name }}"
                    class="form-control"
                    placeholder="Enter exercise name">
                <small id="nameError" class="text-danger"></small>
            </div>
            
            <!-- TYPE -->
            <div class="mb-3">
                <label class="form-label">Exercise Type</label>
                <input type="text"
                    name="type"
                    id="type"
                    value="{{ $exercise->type }}"
                    class="form-control"
                    placeholder="e.g. Strength / Cardio">
                <small id="typeError" class="text-danger"></small>
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

<style>
.is-invalid{
    border:1px solid red !important;
}
</style>
<script>

document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form');
    const type = document.getElementById('type');
    const typeError = document.getElementById('typeError');
    const nameInput = document.getElementById('name');
    const nameError = document.getElementById('nameError');
    function validateType(value) {
        const pattern = /^[A-Za-z\s]+$/;
        return pattern.test(value);
    }

    type.addEventListener('input', function () {
        if (!this.value.trim()) {
            typeError.innerHTML = 'Exercise type is required';
            this.classList.add('is-invalid');
            return;
        }

        if (!validateType(this.value)) {
            typeError.innerHTML = 'Only letters allowed';
            this.classList.add('is-invalid');

        } else {
            typeError.innerHTML = '';
            this.classList.remove('is-invalid');
        }
    });

    function validateName(value) {
        const pattern = /^[A-Za-z\s]+$/;
        return pattern.test(value);
    }

    nameInput.addEventListener('input', function () {
        if (!this.value.trim()) {
            nameError.innerHTML = 'Exercise name is required';
            this.classList.add('is-invalid');
            return;
        }

        if (!validateName(this.value)) {
            nameError.innerHTML = 'Only letters allowed';
            this.classList.add('is-invalid');

        } else {
            nameError.innerHTML = '';
            this.classList.remove('is-invalid');
        }
    });

    form.addEventListener('submit', function (e) {
        let valid = true;
        if (!validateName(nameInput.value)) {
            nameError.innerHTML = 'Enter valid exercise name';
            nameInput.classList.add('is-invalid');
            if (valid) {
                nameInput.focus();
            }
            valid = false;
        }

        if (!validateType(type.value)) {
            typeError.innerHTML = 'Enter valid exercise type';
            type.classList.add('is-invalid');
            if (valid) {
                type.focus();
            }
            valid = false;
        }
        if (!valid) {
            e.preventDefault();
        }
    });
});
</script>
@endsection