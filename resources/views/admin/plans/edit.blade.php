@extends('layouts.admin')

@section('content')

<div class="container mt-4">

    <h2 class="mb-4">✏️ Edit Plan</h2>

    <form method="POST" action="{{ route('admin.plans.update', $plan->id) }}">
        @csrf
        @method('PUT')

        {{-- PLAN DETAILS --}}
        <div class="card p-3 mb-4">

            <div class="mb-3">
                <label>Plan Name</label>
                <input type="text" name="name" class="form-control" value="{{ $plan->name }}" required>
            </div>

            <div class="mb-3">
                <label>Assign Client</label>
                <select name="client_id" class="form-control" required>
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}"
                            {{ $plan->client_id == $client->id ? 'selected' : '' }}>
                            {{ $client->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Assigned Date</label>
                <input type="date" name="assigned_date" class="form-control"
                       value="{{ $plan->assigned_date }}" required>
            </div>

        </div>

        {{-- EXERCISES --}}
        <div class="card p-3">

            <h5>Edit Exercises</h5>

            @foreach($exercises as $exercise)

                @php
                    $selected = $plan->exercises->contains($exercise->id);
                    $pivot = $selected ? $plan->exercises->find($exercise->id)->pivot : null;
                @endphp

                <div class="border p-2 mb-3 rounded">

                    <label>
                        <input type="checkbox"
                               class="exercise-checkbox"
                               data-id="{{ $exercise->id }}"
                               name="exercises[]"
                               value="{{ $exercise->id }}"
                               {{ $selected ? 'checked' : '' }}>
                        <strong>{{ $exercise->name }}</strong>
                    </label>

                    <div class="row mt-2 exercise-fields {{ $selected ? '' : 'd-none' }}"
                         id="exercise-{{ $exercise->id }}">

                        <div class="col-md-4">
                            <input type="number"
                                   name="sets[{{ $exercise->id }}]"
                                   value="{{ $pivot->sets ?? '' }}"
                                   placeholder="Sets"
                                   class="form-control">
                        </div>

                        <div class="col-md-4">
                            <input type="number"
                                   name="reps_min[{{ $exercise->id }}]"
                                   value="{{ $pivot->reps_min ?? '' }}"
                                   placeholder="Min Reps"
                                   class="form-control">
                        </div>

                        <div class="col-md-4">
                            <input type="number"
                                   name="reps_max[{{ $exercise->id }}]"
                                   value="{{ $pivot->reps_max ?? '' }}"
                                   placeholder="Max Reps"
                                   class="form-control">
                        </div>

                    </div>

                </div>

            @endforeach

        </div>

        <button class="btn btn-primary mt-4 w-100">
            🔄 Update Plan
        </button>

    </form>

</div>

{{-- JS --}}
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