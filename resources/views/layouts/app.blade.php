<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Fitness Dashboard</title>

  {{-- MAIN CSS --}}
  <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}">

  {{-- DATATABLE CSS --}}
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

  {{-- ICON --}}
  <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>

  <style>
    .page-wrapper { display: flex; }

    .left-sidebar {
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh;
        width: 250px;
        z-index: 1000;
    }

    .body-wrapper {
        margin-left: 250px;
        width: calc(100% - 250px);
    }

    .body-wrapper-inner {
        padding-top: 0; /* FIXED TOP SPACE */
    }

    .top-header {
        background: #fff;
        padding: 12px 20px;
        border-bottom: 1px solid #eee;
    }
  </style>
</head>

<body>

<div class="page-wrapper" id="main-wrapper">

  <!-- SIDEBAR (UNCHANGED) -->
  <aside class="left-sidebar">
    <div>

      <div class="brand-logo d-flex align-items-center justify-content-between">
        <a href="{{ route('client.dashboard') }}" class="text-nowrap logo-img">
          <img src="{{ asset('assets/images/logos/logo.svg') }}" alt="">
        </a>
      </div>

      <nav class="sidebar-nav scroll-sidebar">
        <ul id="sidebarnav">

          <li class="nav-small-cap"><span class="hide-menu">Home</span></li>

          <li class="sidebar-item">
            <a class="sidebar-link" href="{{ route('client.dashboard') }}">
              <iconify-icon icon="solar:home-2-line-duotone"></iconify-icon>
              <span class="hide-menu">Dashboard</span>
            </a>
          </li>

          <li class="sidebar-item">
            <a class="sidebar-link" href="{{ route('client.plan') }}">
              <iconify-icon icon="solar:dumbbell-large-minimalistic-line-duotone"></iconify-icon>
              <span class="hide-menu">My Plan</span>
            </a>
          </li>

          <li class="sidebar-item">
            <a class="sidebar-link" href="{{ route('client.logs.create') }}">
              <iconify-icon icon="solar:add-circle-line-duotone"></iconify-icon>
              <span class="hide-menu">Add Daily Log</span>
            </a>
          </li>

          <li class="sidebar-item">
            <a class="sidebar-link" href="{{ route('client.logs.index') }}">
              <iconify-icon icon="solar:clipboard-list-line-duotone"></iconify-icon>
              <span class="hide-menu">My Logs</span>
            </a>
          </li>

          <li class="nav-small-cap"><span class="hide-menu">Account</span></li>

          <li class="sidebar-item">
            <a class="sidebar-link" href="{{ route('client.profile') }}">
              <iconify-icon icon="solar:user-line-duotone"></iconify-icon>
              <span class="hide-menu">Profile</span>
            </a>
          </li>

          <li class="sidebar-item">
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button class="sidebar-link border-0 bg-transparent w-100 text-start">
                <iconify-icon icon="solar:logout-2-line-duotone"></iconify-icon>
                <span class="hide-menu">Logout</span>
              </button>
            </form>
          </li>

        </ul>
      </nav>
    </div>
  </aside>

  <!-- MAIN -->
  <div class="body-wrapper">

    {{-- ✅ HEADER (NEW ADDED) --}}
    @php
        $hour = now()->format('H');

        if ($hour < 12) {
            $greeting = 'Good Morning';
        } elseif ($hour < 17) {
            $greeting = 'Good Afternoon';
        } else {
            $greeting = 'Good Evening';
        }
    @endphp

    <div class="top-header d-flex justify-content-between align-items-center">

        <h5 class="mb-0">
            {{ $greeting }}, {{ auth()->user()->name ?? 'User' }} 👋
        </h5>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn btn-sm btn-outline-danger">Logout</button>
        </form>

    </div>

    <!-- CONTENT -->
    <div class="body-wrapper-inner">
      <div class="container-fluid pt-3">
        @yield('content')
      </div>
    </div>

  </div>

</div>

{{-- SCRIPTS --}}

<!-- jQuery (ONLY ONCE) -->
<script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>

<!-- Bootstrap -->
<script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>

<!-- THEME -->
<script src="{{ asset('assets/js/sidebarmenu.js') }}"></script>
<script src="{{ asset('assets/js/app.min.js') }}"></script>

<!-- DATATABLE -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

{{-- PAGE SCRIPTS --}}
@stack('scripts')

</body>
</html>