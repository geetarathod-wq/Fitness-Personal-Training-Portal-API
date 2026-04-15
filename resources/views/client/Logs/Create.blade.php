@extends('layouts.app')

@section('content')

<div class="card p-4">
  <h4 class="mb-4">Add Weekly Log</h4>

  <form method="POST" action="{{ route('client.logs.store') }}">
    @csrf

    <div class="mb-3">
      <label>Date</label>
      <input type="date" name="date" class="form-control" required>
    </div>

    <div class="mb-3">
      <label>Weight (kg)</label>
      <input type="number" name="weight" class="form-control">
    </div>

    <div class="mb-3">
      <label>Calories</label>
      <input type="number" name="calories" class="form-control">
    </div>

    <div class="mb-3">
      <label>Notes</label>
      <textarea name="notes" class="form-control"></textarea>
    </div>

    <button class="btn btn-primary">Save Log</button>
  </form>
</div>

@endsection