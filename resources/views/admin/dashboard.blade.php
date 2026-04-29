@extends('layouts.admin')

@section('content')

<div class="container-fluid pt-0 mt-0">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">👋 Welcome, {{ auth()->user()->name }}</h3>
            <p class="text-muted mb-0">Manage your gym smartly 💪</p>
        </div>

        <div>
            <a href="{{ route('admin.plans.create') }}" class="btn btn-primary">
                 + Create Plan
            </a>
        </div>
    </div>

    <!-- STATS CARDS -->
    <div class="row g-4">

        <!-- CLIENTS -->
        <div class="col-md-3">
            <a href="{{ route('admin.clients.index') }}" class="card-link-box">
                <div class="card shadow-sm border-0 text-white bg-primary">
                    <div class="card-body">
                        <h6>Total Clients</h6>
                        <h2>{{ $clients }}</h2>
                    </div>
                </div>
            </a>
        </div>

        <!-- PLANS -->
        <div class="col-md-3">
            <a href="{{ route('admin.plans.index') }}" class="card-link-box">
                <div class="card shadow-sm border-0 text-white bg-success">
                    <div class="card-body">
                        <h6>Total Plans</h6>
                        <h2>{{ $plans }}</h2>
                    </div>
                </div>
            </a>
        </div>

        <!-- EXERCISES -->
        <div class="col-md-3">
            <a href="{{ route('admin.exercises.index') }}" class="card-link-box">
                <div class="card shadow-sm border-0 text-white bg-warning">
                    <div class="card-body">
                        <h6>Exercises</h6>
                        <h2>{{ $exercises }}</h2>
                    </div>
                </div>
            </a>
        </div>

        <!-- LOGS -->
        <div class="col-md-3">
            <a href="{{ route('admin.logs.index') }}" class="card-link-box">
                <div class="card shadow-sm border-0 text-white bg-danger">
                    <div class="card-body">
                        <h6>Today's Logs</h6>
                        <h2>{{ $todayLogs }}</h2>
                    </div>
                </div>
            </a>
        </div>

    </div>

    <!-- GRAPH -->
    <div class="card mt-4 shadow-sm">
        <div class="card-body">
            <h5 class="mb-3">📈 Client Growth (Last 7 Days)</h5>
            <div id="clientChart"></div>
        </div>
    </div>

    <!-- SECOND ROW -->
    <div class="row mt-4">

        <div class="col-md-6">
            <div class="card shadow-sm p-3">
                <h5 class="mb-3">🆕 New Clients (Last 7 Days)</h5>
                <h2 class="text-primary">{{ $newClients }}</h2>
                <p class="text-muted">New users joined your gym recently</p>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm p-3">
                <h5 class="mb-3">⚡ Quick Actions</h5>

                <div class="d-flex gap-2 flex-wrap">
                    <a href="{{ route('admin.clients.create') }}" class="btn btn-outline-primary">
                        ➕ Add Client
                    </a>

                    <a href="{{ route('admin.exercises.create') }}" class="btn btn-outline-success">
                        ➕ Add Exercise
                    </a>

                    <a href="{{ route('admin.plans.create') }}" class="btn btn-outline-warning">
                        ➕ Create Plan
                    </a>
                </div>
            </div>
        </div>

    </div>

    <!-- RECENT ACTIVITY -->
 <div class="card mt-4 shadow-sm">
    <div class="card-body">
        <h5 class="mb-3">📊 Recent Activity</h5>

        <ul class="list-group list-group-flush">

            <li class="list-group-item p-0">
                <a href="{{ route('admin.clients.index') }}" class="d-block p-3 text-decoration-none text-dark">
                    🧑 New client joined
                </a>
            </li>

            <li class="list-group-item p-0">
                <a href="{{ route('admin.plans.index') }}" class="d-block p-3 text-decoration-none text-dark">
                    📋 New plan created
                </a>
            </li>

            <li class="list-group-item p-0">
                <a href="{{ route('admin.exercises.index') }}" class="d-block p-3 text-decoration-none text-dark">
                    🏋️ Exercise added
                </a>
            </li>

            <li class="list-group-item p-0">
                <a href="{{ route('admin.logs.index') }}" class="d-block p-3 text-decoration-none text-dark">
                    📈 Client updated progress
                </a>
            </li>

        </ul>

    </div>
</div>
</div>

<!-- CHART -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    var options = {
        chart: {
            type: 'line',
            height: 300
        },
        series: [{
            name: 'New Clients',
            data: @json($clientCounts)
        }],
        xaxis: {
            categories: @json($dates)
        },
        stroke: {
            curve: 'smooth'
        },
        markers: {
            size: 5
        }
    };

    var chart = new ApexCharts(document.querySelector("#clientChart"), options);
    chart.render();

});
</script>

@endsection