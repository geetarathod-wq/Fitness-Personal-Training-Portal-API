@extends('layouts.admin')

@section('content')

<div class="container mt-4">

    <h2 class="mb-4">➕ Create Fitness Plan</h2>

    <form method="POST" action="{{ route('admin.plans.store') }}">
        @csrf

        {{-- PLAN DETAILS --}}
        <div class="card p-3 mb-4">

            <div class="mb-3">
                <label>Plan Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            {{-- CLIENT SEARCH --}}
            <div class="mb-3 position-relative">
                <label>Assign Client</label>

                <input type="text" id="clientSearch" class="form-control" placeholder="Type client name...">

                <input type="hidden" name="client_id" id="client_id">

                <div id="clientResults"
                     class="list-group mt-2 position-absolute w-100"
                     style="z-index:1000; display:none;"></div>
            </div>

            <div class="mb-3">
                <label>Assigned Date</label>
                <input type="date" name="assigned_date" class="form-control" required>
            </div>

        </div>

        {{-- EXERCISES --}}
        <div class="card p-3">

            <h5>Select Exercises</h5>

            {{-- ❌ REMOVED: Exercise Search Bar --}}

            {{-- EXERCISE LIST --}}
            <div id="exerciseContainer">

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

            {{-- PAGINATION --}}
            <div class="d-flex justify-content-between align-items-center mt-3">

                <div>
                    Showing {{ $exercises->firstItem() ?? 0 }}
                    to {{ $exercises->lastItem() ?? 0 }}
                    of {{ $exercises->total() }} exercises
                </div>

                <div>
                    {{ $exercises->links('pagination::bootstrap-5') }}
                </div>

            </div>

        </div>

        <button class="btn btn-success mt-4 w-100">
            💾 Save Plan
        </button>

    </form>

</div>

{{-- ================= JS ================= --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    // ================= CLIENT SEARCH =================
    const searchInput = document.getElementById('clientSearch');
    const resultsBox = document.getElementById('clientResults');
    const hiddenInput = document.getElementById('client_id');

    let debounceTimer;

    searchInput.addEventListener('keyup', function () {

        let query = this.value.trim();

        if (query.length === 0) {
            resultsBox.style.display = 'none';
            resultsBox.innerHTML = '';
            hiddenInput.value = '';
            return;
        }

        clearTimeout(debounceTimer);

        debounceTimer = setTimeout(() => {

            fetch(`/admin/search-clients?search=${query}`)
                .then(res => res.json())
                .then(data => {

                    resultsBox.innerHTML = '';

                    if (data.length === 0) {
                        resultsBox.style.display = 'block';
                        resultsBox.innerHTML =
                            '<div class="list-group-item text-muted">No clients found</div>';
                        return;
                    }

                    data.forEach(client => {

                        let item = document.createElement('div');
                        item.className = 'list-group-item list-group-item-action';
                        item.style.cursor = 'pointer';

                        item.innerHTML = `
                            <strong>${client.name}</strong><br>
                            <small class="text-muted">${client.email}</small>
                        `;

                        item.addEventListener('click', function () {
                            searchInput.value = client.name;
                            hiddenInput.value = client.id;
                            resultsBox.style.display = 'none';
                        });

                        resultsBox.appendChild(item);
                    });

                    resultsBox.style.display = 'block';

                });

        }, 300);

    });

    document.addEventListener('click', function (e) {
        if (!searchInput.contains(e.target) && !resultsBox.contains(e.target)) {
            resultsBox.style.display = 'none';
        }
    });

    // ================= EXERCISE TOGGLE ONLY =================
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