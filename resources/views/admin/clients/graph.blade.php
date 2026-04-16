@extends('layouts.admin')

@section('content')

<div class="container mt-4">

    <h3>📊 Client Progress: {{ $client->name }}</h3>

    <div class="card mt-3">
        <div class="card-body">

            @if($logs->count() > 0)
                <canvas id="clientChart" height="100"></canvas>
            @else
                <p class="text-muted">No data available</p>
            @endif

        </div>
    </div>

</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    let logs = @json($logs);

    if (!logs || logs.length === 0) return;

    let labels = logs.map(l => l.date ?? (l.created_at ? l.created_at.split('T')[0] : ''));

    let weights = logs.map(l => Number(l.weight) || 0);
    let calories = logs.map(l => Number(l.calories) || 0);

    new Chart(document.getElementById('clientChart'), {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Weight (kg)',
                    data: weights,
                    borderColor: '#0d6efd',
                    backgroundColor: 'rgba(13,110,253,0.1)',
                    tension: 0.4
                },
                {
                    label: 'Calories',
                    data: calories,
                    borderColor: '#198754',
                    backgroundColor: 'rgba(25,135,84,0.1)',
                    tension: 0.4
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top'
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

});
</script>

@endsection