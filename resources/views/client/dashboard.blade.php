@extends('layouts.app')

@section('content')

<!-- Welcome
<div class="card mb-4">
  <div class="card-body">
    <h4>Welcome, {{ auth()->user()->name ?? 'User' }} 👋</h4>
    <p class="mb-0">Track your fitness journey daily 💪</p>
  </div>
</div> -->

<!-- Stats -->
<div class="row">

  <div class="col-md-4">
    <div class="card bg-primary-subtle">
      <div class="card-body">
        <h6>Last Weight</h6>
        <h3>72 kg</h3>
      </div>
    </div>
  </div>

  <div class="col-md-4">
    <div class="card bg-success-subtle">
      <div class="card-body">
        <h6>Calories</h6>
        <h3>2200 kcal</h3>
      </div>
    </div>
  </div>

  <div class="col-md-4">
    <div class="card bg-warning-subtle">
      <div class="card-body">
        <h6>Total Logs</h6>
        <h3>15</h3>
      </div>
    </div>
  </div>

</div>

<!-- Workout -->
<div class="card mt-4">
  <div class="card-body">
    <h5>🏋️ Today’s Workout</h5>

    <table class="table mt-3">
      <thead>
        <tr>
          <th>Exercise</th>
          <th>Sets</th>
          <th>Reps</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Pushups</td>
          <td>3</td>
          <td>10-15</td>
        </tr>
        <tr>
          <td>Squats</td>
          <td>4</td>
          <td>12-20</td>
        </tr>
      </tbody>
    </table>

  </div>
</div>

<!-- Logs -->
<div class="card mt-4">
  <div class="card-body">
    <h5>📅 Recent Logs</h5>

    <table class="table mt-3">
      <thead>
        <tr>
          <th>Date</th>
          <th>Weight</th>
          <th>Calories</th>
          <th>Notes</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>2026-04-09</td>
          <td>72 kg</td>
          <td>2100</td>
          <td>Good workout</td>
        </tr>
      </tbody>
    </table>

  </div>
</div>

@endsection