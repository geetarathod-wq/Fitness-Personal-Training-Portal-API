@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <h4 class="mb-3">📋 Plans List</h4>

    {{-- SUCCESS MESSAGE --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- NO DATA --}}
    @if($plans->isEmpty())
        <div class="alert alert-warning">
            No plans assigned yet.
        </div>
    @else

        <div class="card shadow-sm border-0 p-3">

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-dark">
                        <tr>
                            <th>Plan</th>
                            <th>Trainer</th>
                            <th style="width: 40%;">Exercises</th>
                            <th>Assigned Date</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($plans as $plan)
                        <tr>

                            <td class="fw-bold">
                                {{ $plan->name }}
                            </td>

                            <td>
                                {{ $plan->trainer->name ?? 'N/A' }}
                            </td>

                            <td>
                                @forelse($plan->exercises as $exercise)

                                    <div class="border rounded p-2 mb-2 bg-light">

                                        <strong>{{ $exercise->name }}</strong><br>

                                        <small class="text-muted">
                                            Sets: {{ $exercise->pivot->sets ?? 0 }} |
                                            Reps: {{ $exercise->pivot->reps_min ?? 0 }} - {{ $exercise->pivot->reps_max ?? 0 }}
                                        </small>

                                    </div>

                                @empty
                                    <span class="text-muted">No exercises</span>
                                @endforelse
                            </td>

                            <td>
                                {{ \Carbon\Carbon::parse($plan->assigned_date)->format('d M Y') }}
                            </td>

                        </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>

        </div>

    @endif

</div>

@endsection