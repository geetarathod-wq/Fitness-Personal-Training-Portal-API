<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Dashboard</title>

  <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}">

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

<div class="page-wrapper">

  <!-- SIDEBAR -->
  <aside class="left-sidebar">
    <div>

      <div class="brand-logo d-flex align-items-center justify-content-between">
        <a href="{{ route('admin.dashboard') }}" class="text-nowrap logo-img">
          <img src="{{ asset('assets/images/logos/logo.svg') }}" alt="">
        </a>
      </div>

      <nav class="sidebar-nav scroll-sidebar">
        <ul id="sidebarnav">

          <li class="nav-small-cap"><span class="hide-menu">Admin Panel</span></li>

          <li class="sidebar-item">
            <a class="sidebar-link" href="{{ route('admin.dashboard') }}">
              <iconify-icon icon="solar:home-2-line-duotone"></iconify-icon>
              <span class="hide-menu">Dashboard</span>
            </a>
          </li>

          <li class="sidebar-item">
            <a class="sidebar-link" href="{{ route('admin.clients.index') }}">
              <iconify-icon icon="mdi:account-group-outline"></iconify-icon>
              <span class="hide-menu">Clients</span>
            </a>
          </li>

          <li class="sidebar-item">
            <a class="sidebar-link" href="{{ route('admin.exercises.index') }}">
              <iconify-icon icon="solar:dumbbell-large-minimalistic-line-duotone"></iconify-icon>
              <span class="hide-menu">Exercises</span>
            </a>
          </li>

          <li class="sidebar-item">
            <a class="sidebar-link" href="{{ route('admin.plans.index') }}">
              <iconify-icon icon="solar:clipboard-list-line-duotone"></iconify-icon>
              <span class="hide-menu">Plans</span>
            </a>
          </li>

          <li class="nav-small-cap"><span class="hide-menu">Account</span></li>

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
      <nav class="navbar px-3">

        <div class="d-flex flex-column">
          <h5 class="mb-0 fw-semibold">👋 Trainer Dashboard</h5>
          <small class="text-muted">Manage your gym 💪</small>
        </div>

        <div class="ms-auto">
          {{-- SAFE USER DISPLAY --}}
          <span class="fw-semibold">
            {{ auth()->user()->name ?? 'Admin' }}
          </span>
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

</body>
</html>