@extends('layouts.admin')

@section('content')

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Clients</h2>
    </div>

    {{-- FILTERS --}}
    <form method="GET" action="{{ route('admin.clients.index') }}" class="mb-3">

        <div class="row g-2 align-items-center">

            {{-- SEARCH --}}
            <div class="col-md-6 position-relative">
                <input type="text"
                       name="search"
                       id="clientSearch"
                       value="{{ request('search') }}"
                       class="form-control"
                       placeholder="🔍 Search client..."
                       autocomplete="off">

                {{-- KEEP PER PAGE --}}
                <input type="hidden" name="per_page" value="{{ $perPage }}">

                <div id="clientResults"
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

                <button class="btn btn-primary w-100">Search</button>

                @if(request('search'))
                    <a href="{{ route('admin.clients.index') }}"
                       class="btn btn-danger">
                        Clear
                    </a>
                @endif
            </div>

        </div>
    </form>

    {{-- SUCCESS --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- TABLE --}}
    <table class="table table-bordered">

        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Joined</th>
            <th>Actions</th>
        </tr>

        @forelse($clients as $client)
        <tr>
            <td>{{ $client->name }}</td>
            <td>{{ $client->email }}</td>
            <td>{{ $client->created_at->format('d M Y') }}</td>

            <td class="d-flex gap-2">

                <a href="{{ route('admin.clients.graph', $client->id) }}"
                   class="btn btn-sm btn-outline-info">
                    📊 Graph
                </a>

                <a href="{{ route('admin.clients.edit', $client->id) }}"
                   class="btn btn-sm btn-outline-warning">
                    ✏️ Edit
                </a>

                <form action="{{ route('admin.clients.destroy', $client->id) }}"
                      method="POST">
                    @csrf
                    @method('DELETE')

                    <button class="btn btn-sm btn-outline-danger"
                            onclick="return confirm('Delete this client?')">
                        🗑 Delete
                    </button>
                </form>

            </td>
        </tr>
        @empty
        <tr>
            <td colspan="4">No clients found</td>
        </tr>
        @endforelse

    </table>

    {{-- PAGINATION (FIXED ONLY HERE) --}}
    <div class="d-flex justify-content-between mt-3">

        <div class="text-muted small">
            Showing {{ $clients->firstItem() }} to {{ $clients->lastItem() }}
            of {{ $clients->total() }}
        </div>

        <div>
            {{-- ✅ FIX: only preserve required filters --}}
            {{ $clients->appends(request()->only(['search','per_page']))->links('pagination::bootstrap-5') }}
        </div>

    </div>

</div>

{{-- AJAX SEARCH --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    const searchInput = document.getElementById('clientSearch');
    const resultsBox = document.getElementById('clientResults');

    let timer;

    searchInput.addEventListener('keyup', function () {

        let query = this.value.trim();

        if (!query) {
            resultsBox.style.display = 'none';
            return;
        }

        clearTimeout(timer);

        timer = setTimeout(() => {

            fetch(`/admin/search-clients?search=${query}`)
                .then(res => res.json())
                .then(data => {

                    resultsBox.innerHTML = '';

                    if (data.length === 0) {
                        resultsBox.style.display = 'block';
                        resultsBox.innerHTML =
                            '<div class="list-group-item">No clients found</div>';
                        return;
                    }

                    data.forEach(client => {

                        let div = document.createElement('div');
                        div.className = 'list-group-item list-group-item-action';
                        div.innerHTML = `<b>${client.name}</b><br><small>${client.email}</small>`;

                        // ✅ FIX: keep search state properly
                        div.onclick = () => {
                            searchInput.value = client.name;
                            resultsBox.style.display = 'none';

                            // IMPORTANT FIX
                            searchInput.form.submit();
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