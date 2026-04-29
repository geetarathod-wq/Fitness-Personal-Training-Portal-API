@extends('layouts.app')

@section('content')

@php
$today=date('Y-m-d');
@endphp

<div class="card p-4">
<h4 class="mb-4">Add Weekly Log</h4>

@if($errors->any())
<div class="alert alert-danger">
<ul class="mb-0">
@foreach($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</ul>
</div>
@endif

<form method="POST" action="{{ route('client.logs.store') }}">
@csrf

<div class="mb-3">
<label>Date</label>
<input type="date" name="date" class="form-control" min="{{ $today }}" value="{{ old('date') }}" required>
@error('date')
<small class="text-danger">{{ $message }}</small>
@enderror
</div>

<div class="mb-3">
<label>Weight (kg)</label>
<input type="number" name="weight" class="form-control" value="{{ old('weight') }}" required min="1">
@error('weight')
<small class="text-danger">{{ $message }}</small>
@enderror
</div>

<div class="mb-3">
<label>Calories</label>
<input type="number" name="calories" class="form-control" value="{{ old('calories') }}" required min="1">
@error('calories')
<small class="text-danger">{{ $message }}</small>
@enderror
</div>

<div class="mb-3">
<label>Notes</label>
<textarea name="notes" class="form-control">{{ old('notes') }}</textarea>
</div>

<button class="btn btn-primary">Save Log</button>

</form>
</div>

@endsection