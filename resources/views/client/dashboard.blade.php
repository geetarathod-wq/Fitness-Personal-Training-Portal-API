@extends('layouts.app')

@section('content')

<!-- Stats -->
<div class="row">

  <div class="col-md-4">
    <div class="card bg-primary-subtle">
      <div class="card-body">
        <h6>Last Weight</h6>
        <h3>{{ $lastWeight ?? '0' }} kg</h3>
      </div>
    </div>
  </div>

  <div class="col-md-4">
    <div class="card bg-success-subtle">
      <div class="card-body">
        <h6>Calories</h6>
        <h3>{{ $lastCalories ?? '0' }} kcal</h3>
      </div>
    </div>
  </div>

  <div class="col-md-4">
    <div class="card bg-warning-subtle">
      <div class="card-body">
        <h6>Total Logs</h6>
        <h3>{{ $totalLogs ?? 0 }}</h3>
      </div>
    </div>
  </div>

</div>

<!-- GRAPH -->
<div class="card mt-4">
  <div class="card-body">
    <h5>📊 My Progress</h5>

    @if(isset($allLogs) && $allLogs->count() > 0)
        <canvas id="progressChart" height="100"></canvas>
    @else
        <p class="text-muted">No data available for graph</p>
    @endif

  </div>
</div>

<!-- Plans -->
<div class="card mt-4">
  <div class="card-body">
    <h5>💪 My Fitness Plans</h5>

    @forelse(($plans ?? []) as $plan)

      <div class="border rounded p-3 mt-3">

        <h6 class="fw-bold">{{ $plan->name }}</h6>

        <p class="mb-2">
          👨‍🏫 Trainer: {{ $plan->trainer->name ?? 'N/A' }} <br>
          📅 Assigned: {{ $plan->assigned_date }}
        </p>

        @if($plan->exercises->count())
            @foreach($plan->exercises as $exercise)
                <div class="mb-2">
                    <strong>{{ $exercise->name }}</strong><br>
                    <small>
                        Sets: {{ $exercise->pivot->sets ?? '-' }} |
                        Reps: {{ $exercise->pivot->reps_min ?? '-' }} - {{ $exercise->pivot->reps_max ?? '-' }}
                    </small>
                </div>
            @endforeach
        @else
            <p class="text-muted">No exercises added</p>
        @endif

      </div>

    @empty
        <p class="mt-3">No plans assigned yet.</p>
    @endforelse

  </div>
</div>

<!-- Recent Logs -->
<div class="card mt-4">
  <div class="card-body">
    <h5>📅 My Recent Logs</h5>

    <table class="table mt-3">
      <thead>
        <tr>
          <th>Date</th>
          <th>Weight</th>
          <th>Calories</th>
        </tr>
      </thead>

      <tbody>
        @forelse(($recentLogs ?? []) as $log)
        <tr>
          <td>{{ $log->date ?? $log->created_at }}</td>
          <td>{{ $log->weight }} kg</td>
          <td>{{ $log->calories }}</td>
        </tr>
        @empty
        <tr>
          <td colspan="3">No logs found</td>
        </tr>
        @endforelse
      </tbody>
    </table>

  </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    let logs = @json($allLogs ?? []);
    if (!logs || logs.length === 0) return;

    let labels = logs.map(l => {
        let d = l.date ? new Date(l.date) : new Date(l.created_at);
        return d.toLocaleDateString('en-IN', { day: '2-digit', month: 'short' });
    });

    let weights = logs.map(l => Number(l.weight) || 0);
    let calories = logs.map(l => Number(l.calories) || 0);

    let ctx = document.getElementById('progressChart');
    if (!ctx) return;

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Weight',
                    data: weights,
                    borderColor: '#0d6efd',
                    backgroundColor: 'rgba(13,110,253,0.1)',
                    fill: true,
                    tension: 0.4
                },
                {
                    label: 'Calories',
                    data: calories,
                    borderColor: '#198754',
                    backgroundColor: 'rgba(25,135,84,0.1)',
                    fill: true,
                    tension: 0.4
                }
            ]
        }
    });

});
</script>
@endpush