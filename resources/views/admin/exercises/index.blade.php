@extends('layouts.admin')

@section('content')

<div class="container mt-4">

    <h2>Exercises</h2>

    <a href="{{ route('admin.exercises.create') }}" class="btn btn-primary mb-3">
        + Add Exercise
    </a>

    {{-- SUCCESS --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- FILTERS --}}
    <form method="GET" action="{{ route('admin.exercises.index') }}" class="mb-3">

        <div class="row g-2 align-items-center">

            {{-- SEARCH --}}
            <div class="col-md-6 position-relative">
                <input type="text"
                       name="search"
                       id="exerciseSearch"
                       class="form-control"
                       placeholder="Search exercises..."
                       value="{{ request('search') }}"
                       autocomplete="off">

                <div id="exerciseResults"
                     class="list-group position-absolute w-100"
                     style="z-index:1000; display:none;"></div>
            </div>

            {{-- PER PAGE --}}
            <div class="col-md-3">
                <select name="per_page" class="form-select" onchange="this.form.submit()">
                    <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10 / page</option>
                    <option value="20" {{ $perPage == 20 ? 'selected' : '' }}>20 / page</option>
                    <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50 / page</option>
                    <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100 / page</option>
                </select>
            </div>

            {{-- BUTTONS --}}
            <div class="col-md-3 d-flex gap-2">

                <button class="btn btn-outline-primary w-100">
                    Search
                </button>

                @if(request('search'))
                    <a href="{{ route('admin.exercises.index') }}" class="btn btn-outline-danger">
                        Clear
                    </a>
                @endif

            </div>

        </div>
    </form>

    {{-- TABLE --}}
    <table class="table table-bordered">

        <tr>
            <th>Name</th>
            <th>Type</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>

        @forelse($exercises as $exercise)
        <tr>
            <td>{{ $exercise->name }}</td>
            <td>{{ $exercise->type }}</td>
            <td>{{ $exercise->description }}</td>

            <td class="d-flex gap-2">

                <a href="{{ route('admin.exercises.edit', $exercise->id) }}"
                   class="btn btn-sm btn-outline-warning">
                    ✏️ Edit
                </a>

                <form action="{{ route('admin.exercises.destroy', $exercise->id) }}"
                      method="POST">
                    @csrf
                    @method('DELETE')

                    <button class="btn btn-sm btn-outline-danger"
                            onclick="return confirm('Delete this exercise?')">
                        🗑 Delete
                    </button>
                </form>

            </td>
        </tr>

        @empty
        <tr>
            <td colspan="4">No exercises found</td>
        </tr>
        @endforelse

    </table>

    {{-- PAGINATION --}}
    <div class="d-flex justify-content-between mt-3">

        <div class="text-muted small">
            Showing {{ $exercises->firstItem() }} to {{ $exercises->lastItem() }}
            of {{ $exercises->total() }}
        </div>

        <div>
            {{ $exercises->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>

    </div>

</div>

{{-- AJAX SEARCH --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    const searchInput = document.getElementById('exerciseSearch');
    const resultsBox = document.getElementById('exerciseResults');

    let timer;

    searchInput.addEventListener('keyup', function () {

        let query = this.value.trim();

        if (!query) {
            resultsBox.style.display = 'none';
            return;
        }

        clearTimeout(timer);

        timer = setTimeout(() => {

            fetch(`/admin/search-exercises?search=${query}`)
                .then(res => res.json())
                .then(data => {

                    resultsBox.innerHTML = '';

                    if (data.length === 0) {
                        resultsBox.style.display = 'block';
                        resultsBox.innerHTML =
                            '<div class="list-group-item text-muted">No exercises found</div>';
                        return;
                    }

                    data.forEach(ex => {
                        let div = document.createElement('div');
                        div.className = 'list-group-item list-group-item-action';
                        div.innerHTML = `<b>${ex.name}</b> <small>(${ex.type ?? ''})</small>`;

                        div.onclick = () => {
                            searchInput.value = ex.name;
                            resultsBox.style.display = 'none';
                        };

                        resultsBox.appendChild(div);
                    });

                    resultsBox.style.display = 'block';

                });

        }, 300);
    });

    document.addEventListener('click', function (e) {
        if (!searchInput.contains(e.target)) {
            resultsBox.style.display = 'none';
        }
    });

});
</script>

@endsection