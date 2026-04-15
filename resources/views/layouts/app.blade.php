<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Fitness Dashboard</title>

  <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}">

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

    .app-header {
        position: sticky;
        top: 0;
        z-index: 999;
        background: #fff;
    }

    .body-wrapper-inner {
        padding-top: 10px;
    }
  </style>
</head>

<body>

<div class="page-wrapper" id="main-wrapper">

  <!-- SIDEBAR -->
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

    <!-- HEADER -->
    <header class="app-header shadow-sm">
      <nav class="navbar navbar-expand-lg navbar-light px-3">

        <div class="d-flex flex-column">
          <h5 class="mb-0 fw-semibold">
            👋 Welcome, {{ auth()->user()->name ?? 'User' }}
          </h5>
          <small class="text-muted">Track your fitness journey 💪</small>
        </div>

        <div class="ms-auto">
          <img src="{{ asset('assets/images/profile/user-1.jpg') }}"
               class="rounded-circle"
               width="35">
        </div>

      </nav>
    </header>

    <!-- CONTENT -->
    <div class="body-wrapper-inner">
      <div class="container-fluid pt-3">
        @yield('content')
      </div>
    </div>

  </div>
</div>

<script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/sidebarmenu.js') }}"></script>
<script src="{{ asset('assets/js/app.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>

</body>
</html>