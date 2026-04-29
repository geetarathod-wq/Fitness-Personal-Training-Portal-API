@extends('layouts.admin')

@section('content')

<div class="container mt-4">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">✏️ Edit Plan</h2>

        <a href="{{ route('admin.plans.index') }}" class="btn btn-secondary">
            ⬅ Back
        </a>
    </div>

    <form method="POST" action="{{ route('admin.plans.update', $plan->id) }}">
        @csrf
        <input type="hidden" name="_method" value="PUT">

        <div class="card p-3 mb-4">

            <!-- PLAN NAME -->
            <div class="mb-3">
                <label>Plan Name</label>
                <input type="text" name="name" class="form-control"
                       value="{{ $plan->name }}" required>
            </div>

            <!-- CLIENT SEARCH -->
            <div class="mb-3 position-relative">
                <label>Assign Client</label>

                <input type="text"
                       id="clientSearch"
                       class="form-control"
                       value="{{ $plan->client->name ?? '' }}"
                       placeholder="Type client name..."
                       autocomplete="off">

                <input type="hidden" name="client_id" id="client_id" value="{{ $plan->client_id }}">

                <div id="clientResults"
                     class="list-group position-absolute w-100"
                     style="z-index:1000; display:none;"></div>
            </div>

            <!-- DATE -->
            <div class="mb-3">
                <label>Assigned Date</label>
                <input type="date" name="assigned_date"
                       class="form-control"
                       value="{{ $plan->assigned_date }}" required>
            </div>

        </div>

        <!-- EXERCISES -->
        <div class="card p-3">

            <h5>Edit Exercises</h5>

            @foreach($exercises as $exercise)

            @php
                $exercisePivot = $plan->exercises->firstWhere('id', $exercise->id);
                $pivot = $exercisePivot ? $exercisePivot->pivot : null;
                $selected = $pivot ? true : false;
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

                <div class="row mt-2 {{ $selected ? '' : 'd-none' }}"
                     id="exercise-{{ $exercise->id }}">

                    <div class="col-md-4">
                        <input type="number"
                               name="sets[{{ $exercise->id }}]"
                               value="{{ $pivot->sets ?? '' }}"
                               class="form-control"
                               placeholder="Sets">
                    </div>

                    <div class="col-md-4">
                        <input type="number"
                               name="reps_min[{{ $exercise->id }}]"
                               value="{{ $pivot->reps_min ?? '' }}"
                               class="form-control"
                               placeholder="Min Reps">
                    </div>

                    <div class="col-md-4">
                        <input type="number"
                               name="reps_max[{{ $exercise->id }}]"
                               value="{{ $pivot->reps_max ?? '' }}"
                               class="form-control"
                               placeholder="Max Reps">
                    </div>

                </div>
            </div>

            @endforeach

        </div>

        <button type="submit" class="btn btn-primary mt-4 w-100">
            🔄 Update Plan
        </button>

    </form>
</div>

@endsection

@push('scripts')

<script>
document.addEventListener('DOMContentLoaded', function(){
    const searchInput = document.getElementById('clientSearch');
    const clientIdInput = document.getElementById('client_id');
    const resultsBox = document.getElementById('clientResults');

    let timer;

    searchInput.addEventListener('input', function(){
        clientIdInput.value = '';
    });

    searchInput.addEventListener('keyup', function(){

        let query = this.value.trim();

        if(!query){
            resultsBox.style.display = 'none';
            return;
        }

        clearTimeout(timer);

        timer = setTimeout(() => {

            fetch(`{{ route('admin.clients.search') }}?search=${query}`)
            .then(res => res.json())
            .then(data => {

                resultsBox.innerHTML = '';

                if(data.length === 0){
                    resultsBox.innerHTML = '<div class="list-group-item">No clients found</div>';
                    resultsBox.style.display = 'block';
                    return;
                }

                data.forEach(client => {

                    let div = document.createElement('div');
                    div.className = 'list-group-item list-group-item-action';

                    div.innerHTML = `<b>${client.name}</b><br><small>${client.email}</small>`;

                    div.onclick = function(){
                        searchInput.value = client.name;
                        clientIdInput.value = client.id;
                        resultsBox.style.display = 'none';
                    };

                    resultsBox.appendChild(div);
                });

                resultsBox.style.display = 'block';

            });

        }, 300);

    });

    document.addEventListener('click', function(e){
        if(!searchInput.contains(e.target)){
            resultsBox.style.display = 'none';
        }
    });

    document.querySelectorAll('.exercise-checkbox').forEach(function (checkbox) {

        checkbox.addEventListener('change', function () {

            let id = this.dataset.id;
            let section = document.getElementById('exercise-' + id);

            if (!section) return;

            if (this.checked) {
                section.classList.remove('d-none');
            } else {
                section.classList.add('d-none');
                section.querySelectorAll('input').forEach(input => input.value = '');
            }

        });

    });

});
</script>

@endpush