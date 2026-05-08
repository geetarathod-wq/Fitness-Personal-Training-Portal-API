@extends('layouts.admin')

@section('content')

<div class="container mt-4">

    <div class="card shadow-sm p-4">

        <h2 class="mb-4">Add Exercise</h2>

        <form method="POST" 
              action="{{ route('admin.exercises.store') }}"
              id="exerciseForm">

            @csrf

            <!-- NAME -->
            <div class="mb-3">

                <label class="form-label">Exercise Name</label>

                <input type="text"
                       name="name"
                       id="name"
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
                          placeholder="Write exercise details..."></textarea>
            </div>

            <!-- BUTTONS -->
            <div class="d-flex justify-content-between">
                <button class="btn btn-success">
                    Save
                </button>
                <a href="{{ route('admin.exercises.index') }}"
                class="btn btn-secondary">
                    ⬅ Back
                </a>
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
    const form = document.getElementById('exerciseForm');
    const nameInput = document.getElementById('name');
    const typeInput = document.getElementById('type');
    const nameError = document.getElementById('nameError');
    const typeError = document.getElementById('typeError');

    function validateText(value) {
        const pattern = /^[A-Za-z\s]+$/;
        return pattern.test(value);
    }

    nameInput.addEventListener('input', function () {
        if (!this.value.trim()) {
            nameError.innerHTML = 'Exercise name is required';
            this.classList.add('is-invalid');
            return;
        }

        if (!validateText(this.value)) {
            nameError.innerHTML = 'Only letters allowed';
            this.classList.add('is-invalid');
        } else {
            nameError.innerHTML = '';
            this.classList.remove('is-invalid');
        }
    });

    typeInput.addEventListener('input', function () {
        if (!this.value.trim()) {
            typeError.innerHTML = 'Exercise type is required';
            this.classList.add('is-invalid');
            return;
        }

        if (!validateText(this.value)) {
            typeError.innerHTML = 'Only letters allowed';
            this.classList.add('is-invalid');
        } else {
            typeError.innerHTML = '';
            this.classList.remove('is-invalid');
        }
    });

    form.addEventListener('submit', function (e) {
        let valid = true;

        if (!nameInput.value.trim()) {
            nameError.innerHTML = 'Exercise name is required';
            nameInput.classList.add('is-invalid');
            nameInput.focus();
            valid = false;

        } else if (!validateText(nameInput.value)) {
            nameError.innerHTML = 'Enter valid exercise name';
            nameInput.classList.add('is-invalid');
            nameInput.focus();
            valid = false;
        }

        if (!typeInput.value.trim()) {
            typeError.innerHTML = 'Exercise type is required';
            typeInput.classList.add('is-invalid');

            if (valid) {
                typeInput.focus();
            }
            valid = false;

        } else if (!validateText(typeInput.value)) {
            typeError.innerHTML = 'Enter valid exercise type';
            typeInput.classList.add('is-invalid');
            if (valid) {
                typeInput.focus();
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