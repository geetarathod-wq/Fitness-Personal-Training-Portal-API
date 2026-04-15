@extends('layouts.app')

@section('content')

<div class="card p-4">
  <div class="d-flex justify-content-between mb-3">
    <h4>My Weekly Logs</h4>

    <a href="{{ route('client.logs.create') }}" class="btn btn-primary">
      + Add Log
    </a>
  </div>

  @if(session('success'))
    <div class="alert alert-success">
      {{ session('success') }}
    </div>
  @endif

  @if($logs->isEmpty())
    <p>No logs found.</p>
  @else

  <div class="table-responsive">
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Date</th>
          <th>Weight</th>
          <th>Calories</th>
          <th>Notes</th>
          <th>Action</th>
        </tr>
      </thead>

      <tbody>
        @foreach($logs as $log)
        <tr>
          <td>{{ $log->date }}</td>
          <td>{{ $log->weight ?? '-' }} kg</td>
          <td>{{ $log->calories ?? '-' }}</td>
          <td>{{ $log->notes ?? '-' }}</td>

          <td>
            <form method="POST"
                  action="{{ route('client.logs.delete', $log->id) }}"
                  onsubmit="return confirm('Delete this log?')">
              @csrf
              @method('DELETE')

              <button class="btn btn-danger btn-sm">
                Delete
              </button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>

    </table>
  </div>

  @endif
</div>

@endsection