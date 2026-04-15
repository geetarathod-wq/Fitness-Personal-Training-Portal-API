@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
@extends('layouts.admin')

@section('content')

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-bold">🏋️ Fitness Plans</h2>

        <a href="{{ route('admin.plans.create') }}" class="btn btn-primary">
            + Create Plan
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">

        @forelse($plans as $plan)

            <div class="col-md-6 mb-4">

                <div class="card shadow-sm border-0">

                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0">{{ $plan->name }}</h5>
                    </div>

                    <div class="card-body">

                        <p>
                            <strong>👤 Client:</strong>
                            {{ $plan->client->name ?? 'N/A' }}
                        </p>

                        <p>
                            <strong>🏋️ Trainer:</strong>
                            {{ $plan->trainer->name ?? 'N/A' }}
                        </p>

                        <p>
                            <strong>📅 Assigned Date:</strong>
                            {{ $plan->assigned_date }}
                        </p>

                        <hr>

                        <h6>Exercises:</h6>

                        @if($plan->exercises->count() > 0)

                            <ul class="list-group">

                                @foreach($plan->exercises as $ex)

                                    <li class="list-group-item d-flex justify-content-between">

                                        <div>
                                            <strong>{{ $ex->name }}</strong>
                                            <br>
                                            <small class="text-muted">
                                                Sets: {{ $ex->pivot->sets ?? 0 }},
                                                Reps: {{ $ex->pivot->reps_min ?? 0 }} - {{ $ex->pivot->reps_max ?? 0 }}
                                            </small>
                                        </div>

                                    </li>

                                @endforeach

                            </ul>

                        @else
                            <p class="text-muted">No exercises assigned</p>
                        @endif

                    </div>

                    <div class="card-footer">
                    <div class="d-flex gap-2">

                        <!-- EDIT -->
                        <a href="{{ route('admin.plans.edit', $plan->id) }}" 
                        class="btn btn-sm btn-outline-warning">
                            ✏️ Edit
                        </a>

                        <!-- DELETE -->
                        <form action="{{ route('admin.plans.destroy', $plan->id) }}" 
                            method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this plan?')">
                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="btn btn-sm btn-outline-danger">
                                🗑 Delete
                            </button>
                        </form>

                    </div>
                </div>

                </div>

            </div>

        @empty

            <div class="col-12">
                <div class="alert alert-info text-center">
                    No plans found. Create your first plan 🚀
                </div>
            </div>

        @endforelse

    </div>

</div>

@endsection