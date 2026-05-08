@extends('layouts.admin')
@section('content')
<div class="container mt-4">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">
            {{ $client->name }} - Progress Graph
        </h3>
        <a href="{{ route('admin.clients.index') }}"
           class="btn btn-secondary">
            ⬅ Back
        </a>
    </div>

    <!-- GRAPH CARD -->
    <div class="card shadow-sm">
        <div class="card-body">
            @if($logs->isEmpty())
                <div class="alert alert-warning mb-0">
                    No progress data available.
                </div>
            @else
                <canvas id="progressChart" height="100"></canvas>
            @endif
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
@if(!$logs->isEmpty())
const labels = @json($logs->pluck('date'));
const weightData = @json($logs->pluck('weight'));
const caloriesData = @json(
    $logs->pluck('calories')->map(fn($c) => $c ?? 0)
);

const ctx = document
    .getElementById('progressChart')
    .getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: labels,
        datasets: [
            {
                label: 'Weight (kg)',
                data: weightData,
                borderWidth: 2,
                tension: 0.4,
                fill: false
            },
            {
                label: 'Calories',
                data: caloriesData,
                borderWidth: 2,
                tension: 0.4,
                fill: false
            }
        ]
    },

    options: {
        responsive: true,
        plugins: {
            legend: {
                display: true
            }
        }
    }
});
@endif
</script>
@endpush