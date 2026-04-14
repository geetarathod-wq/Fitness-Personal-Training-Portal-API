@extends('layouts.admin')

@section('content')

<div class="container mt-4">

    <h2 class="mb-4">➕ Create Fitness Plan</h2>

    <form method="POST" action="{{ route('admin.plans.store') }}">
        <input type="hidden" name="exercises[]" value="">
        @csrf

        {{-- PLAN DETAILS --}}
        <div class="card p-3 mb-4">

            <div class="mb-3">
                <label>Plan Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Assign Client</label>
                <select name="client_id" class="form-control" required>
                    <option value="">Select Client</option>
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}">{{ $client->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Assigned Date</label>
                <input type="date" name="assigned_date" class="form-control" required>
            </div>

        </div>

        {{-- EXERCISES --}}
        <div class="card p-3">

            <h5>Select Exercises</h5>

            @foreach($exercises as $exercise)

                <div class="border p-2 mb-3 rounded">

                    <label>
                        <input type="checkbox"
                               class="exercise-checkbox"
                               data-id="{{ $exercise->id }}"
                               name="exercises[]"
                               value="{{ $exercise->id }}">
                        <strong>{{ $exercise->name }}</strong>
                    </label>

                    <div class="row mt-2 exercise-fields d-none" id="exercise-{{ $exercise->id }}">

                        <div class="col-md-4">
                            <input type="number"
                                   name="sets[{{ $exercise->id }}]"
                                   placeholder="Sets"
                                   class="form-control">
                        </div>

                        <div class="col-md-4">
                            <input type="number"
                                   name="reps_min[{{ $exercise->id }}]"
                                   placeholder="Min Reps"
                                   class="form-control">
                        </div>

                        <div class="col-md-4">
                            <input type="number"
                                   name="reps_max[{{ $exercise->id }}]"
                                   placeholder="Max Reps"
                                   class="form-control">
                        </div>

                    </div>

                </div>

            @endforeach

        </div>

        <button class="btn btn-success mt-4 w-100">
            💾 Save Plan
        </button>

    </form>

</div>

{{-- JS SECTION --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.exercise-checkbox').forEach(function (checkbox) {

        checkbox.addEventListener('change', function () {

            let id = this.getAttribute('data-id');
            let section = document.getElementById('exercise-' + id);

            if (this.checked) {
                section.classList.remove('d-none');
            } else {
                section.classList.add('d-none');
            }

        });

    });

});
</script>

@endsection