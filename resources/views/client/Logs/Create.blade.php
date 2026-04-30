@extends('layouts.app')

@section('content')

@php
    $today = date('Y-m-d');
@endphp

<div class="container mt-4">
    <div class="card p-4">

        <h4 class="mb-4">Add Weekly Log</h4>

        {{-- GLOBAL ERROR --}}
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('client.logs.store') }}" id="logForm">
            @csrf

            <!-- DATE -->
            <div class="mb-3">
                <label>Date</label>
                <input type="date"
                       id="date"
                       name="date"
                       class="form-control">

                <div id="dateError" class="text-danger mt-1" style="display:none;">
                    Please select a valid date (no past date allowed)
                </div>
            </div>

            <!-- WEIGHT -->
            <div class="mb-3">
                <label>Weight (kg)</label>
                <input type="text"
                       id="weight"
                       name="weight"
                       class="form-control"
                       placeholder="Enter weight">

                <div id="weightError" class="text-danger mt-1" style="display:none;">
                    Please enter weight (e.g. 70 or 70.5)
                </div>
            </div>

            <!-- CALORIES -->
            <div class="mb-3">
                <label>Calories</label>
                <input type="text"
                       id="calories"
                       name="calories"
                       class="form-control"
                       placeholder="Enter calories">

                <div id="caloriesError" class="text-danger mt-1" style="display:none;">
                    Please enter calories (numbers only)
                </div>
            </div>

            <!-- NOTES -->
            <div class="mb-3">
                <label>Notes</label>
                <textarea id="notes" name="notes" class="form-control"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">
                Save Log
            </button>

        </form>

    </div>
</div>

<style>
.is-invalid {
    border: 2px solid red !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const form = document.getElementById('logForm');

    const dateInput = document.getElementById('date');
    const weightInput = document.getElementById('weight');
    const caloriesInput = document.getElementById('calories');

    const dateError = document.getElementById('dateError');
    const weightError = document.getElementById('weightError');
    const caloriesError = document.getElementById('caloriesError');

    const today = new Date().toISOString().split('T')[0];
    dateInput.setAttribute('min', today);

    function scrollToError(el) {
        el.scrollIntoView({ behavior: 'smooth', block: 'center' });
        el.classList.add('is-invalid');
        el.focus();
    }

    function reset() {
        document.querySelectorAll('.is-invalid').forEach(el => {
            el.classList.remove('is-invalid');
        });

        dateError.style.display = 'none';
        weightError.style.display = 'none';
        caloriesError.style.display = 'none';
    }

    form.addEventListener('submit', function (e) {

        reset();

        // DATE
        if (!dateInput.value) {
            e.preventDefault();
            dateError.style.display = 'block';
            scrollToError(dateInput);
            return;
        }

        if (dateInput.value < today) {
            e.preventDefault();
            dateError.innerText = "Past dates are not allowed";
            dateError.style.display = 'block';
            scrollToError(dateInput);
            return;
        }

        // WEIGHT
        if (!weightInput.value.trim()) {
            e.preventDefault();
            weightError.style.display = 'block';
            scrollToError(weightInput);
            return;
        }

        if (!/^[0-9]*\.?[0-9]+$/.test(weightInput.value)) {
            e.preventDefault();
            weightError.innerText = "Enter valid weight (70 or 70.5)";
            weightError.style.display = 'block';
            scrollToError(weightInput);
            return;
        }

        // CALORIES
        if (!caloriesInput.value.trim()) {
            e.preventDefault();
            caloriesError.style.display = 'block';
            scrollToError(caloriesInput);
            return;
        }

        if (!/^[0-9]+$/.test(caloriesInput.value)) {
            e.preventDefault();
            caloriesError.innerText = "Calories must be numbers only";
            caloriesError.style.display = 'block';
            scrollToError(caloriesInput);
            return;
        }

    });

});
</script>

@endsection