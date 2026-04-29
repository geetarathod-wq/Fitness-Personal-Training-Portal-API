@extends('layouts.admin')

@section('content')

<div class="container mt-4">

    <h2 class="mb-4">➕ Create Fitness Plan</h2>

    <form method="POST" action="{{ route('admin.plans.store') }}" id="planForm" novalidate>
        @csrf

        <div class="card p-3 mb-4">

            <!-- PLAN NAME -->
            <div class="mb-3">
                <label>Plan Name</label>
                <input type="text" name="name" id="plan_name" class="form-control">

                <div id="planError" class="text-danger mt-1" style="display:none;">
                    Please enter plan name
                </div>
            </div>

            <!-- CLIENT -->
            <div class="mb-3 position-relative">
                <label>Assign Client</label>

                <input type="text"
                       id="clientSearch"
                       class="form-control"
                       placeholder="Type client name..."
                       autocomplete="off">

                <input type="hidden" name="client_id" id="client_id">

                <div id="clientResults"
                     class="list-group position-absolute w-100"
                     style="z-index:1000; display:none;"></div>

                <div id="clientError" class="text-danger mt-1" style="display:none;">
                    Please assign a valid client
                </div>
            </div>

            <!-- DATE -->
            <div class="mb-3">
                <label>Assigned Date</label>
                <input type="date" name="assigned_date" id="assigned_date" class="form-control">
            </div>

        </div>

        <!-- EXERCISES -->
        <div class="card p-3" id="exerciseContainer">
            <h5>Select Exercises</h5>

            <div id="exerciseError" class="text-danger mb-2" style="display:none;">
                Please select at least 2 exercises
            </div>

            <div style="max-height: 600px; overflow-y: auto;">

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

                    <div class="row mt-2 exercise-fields d-none"
                         id="exercise-{{ $exercise->id }}">

                        <div class="col-md-4">
                            <input type="number" name="sets[{{ $exercise->id }}]" class="form-control" placeholder="Sets">
                        </div>

                        <div class="col-md-4">
                            <input type="number" name="reps_min[{{ $exercise->id }}]" class="form-control" placeholder="Min Reps">
                        </div>

                        <div class="col-md-4">
                            <input type="number" name="reps_max[{{ $exercise->id }}]" class="form-control" placeholder="Max Reps">
                        </div>

                    </div>
                </div>
                @endforeach

            </div>
        </div>

        <button class="btn btn-success mt-4 w-100">
            💾 Save Plan
        </button>

    </form>

</div>

<style>
.is-invalid {
    border: 2px solid red !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function(){

    const form = document.getElementById('planForm');
    const planName = document.getElementById('plan_name');
    const planError = document.getElementById('planError');

    const searchInput = document.getElementById('clientSearch');
    const clientIdInput = document.getElementById('client_id');
    const clientError = document.getElementById('clientError');
    const resultsBox = document.getElementById('clientResults');

    const dateInput = document.getElementById('assigned_date');

    const exerciseError = document.getElementById('exerciseError');
    const exerciseContainer = document.getElementById('exerciseContainer');

    let today = new Date().toISOString().split('T')[0];
    dateInput.setAttribute('min', today);

    // ✅ SCROLL FUNCTION
    function scrollToError(element) {
        element.scrollIntoView({ behavior: 'smooth', block: 'center' });
        element.classList.add('is-invalid');
        element.focus();
    }

    // RESET CLIENT INPUT
    searchInput.addEventListener('input', function(){
        clientIdInput.value = '';
        clientError.style.display = 'none';
        searchInput.classList.remove('is-invalid');
    });

    // CLIENT SEARCH
    let timer;
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

                        clientError.style.display = 'none';
                        searchInput.classList.remove('is-invalid');

                        resultsBox.style.display = 'none';
                    };

                    resultsBox.appendChild(div);
                });

                resultsBox.style.display = 'block';

            });

        }, 300);

    });

    // CLOSE DROPDOWN
    document.addEventListener('click', function(e){
        if(!searchInput.contains(e.target)){
            resultsBox.style.display = 'none';
        }
    });

    // EXERCISE TOGGLE
    document.querySelectorAll('.exercise-checkbox').forEach(cb => {
        cb.addEventListener('change', function(){
            let section = document.getElementById('exercise-' + this.dataset.id);
            section.classList.toggle('d-none', !this.checked);
        });
    });

    // ✅ FINAL VALIDATION
    form.addEventListener('submit', function(e){

        // RESET ALL
        planError.style.display = 'none';
        planName.classList.remove('is-invalid');

        clientError.style.display = 'none';
        searchInput.classList.remove('is-invalid');

        exerciseError.style.display = 'none';
        exerciseContainer.classList.remove('is-invalid');

        // PLAN NAME
        if(!planName.value.trim()){
            e.preventDefault();
            planError.style.display = 'block';
            scrollToError(planName);
            return false;
        }

        // CLIENT
        if(!clientIdInput.value){
            e.preventDefault();
            clientError.style.display = 'block';
            scrollToError(searchInput);
            return false;
        }

        // ✅ EXERCISES (FINAL FIX)
        const selectedExercises = document.querySelectorAll('.exercise-checkbox:checked');

        if(selectedExercises.length < 2){
            e.preventDefault();
            exerciseError.style.display = 'block';

            exerciseContainer.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });

            return false;
        }

        // DATE
        if(dateInput.value < today){
            e.preventDefault();
            scrollToError(dateInput);
            alert("Past date not allowed");
            return false;
        }

    });

});
</script>

@endsection