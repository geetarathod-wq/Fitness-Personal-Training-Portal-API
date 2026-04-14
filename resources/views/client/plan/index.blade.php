@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <h4 class="mb-3">Plans List</h4>

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

        <div class="card p-3">

            <table class="table table-bordered">
    <thead>
        <tr>
            <th>Plan</th>
            <th>Trainer</th>
            <th>Exercises</th>
            <th>Assigned Date</th>
        </tr>
    <table class="table table-bordered">
    <thead>
        <tr>
            <th>Plan</th>
            <th>Trainer</th>
            <th>Exercises</th>
            <th>Assigned Date</th>
        </tr>
    </thead>

    <tbody>
        @foreach($plans as $plan)
        <tr>
            <td>{{ $plan->name }}</td>

            <td>{{ $plan->trainer->name ?? 'N/A' }}</td>

            <td>
                @foreach($plan->exercises as $exercise)
                    <div class="mb-2">
                        <strong>{{ $exercise->name }}</strong><br>

                        Sets: {{ $exercise->pivot->sets }} <br>
                        Reps: {{ $exercise->pivot->reps_min }} - {{ $exercise->pivot->reps_max }}
                    </div>
                @endforeach
            </td>

            <td>{{ $plan->assigned_date }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

        </div>

    @endif

</div>

@endsection