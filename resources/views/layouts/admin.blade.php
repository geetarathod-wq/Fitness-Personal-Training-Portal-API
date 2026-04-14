<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Dashboard</title>

  <!-- CSS -->
  <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}">
</head>

<body>

<div class="page-wrapper" id="main-wrapper"
     data-layout="vertical"
     data-navbarbg="skin6"
     data-sidebartype="full"
     data-sidebar-position="fixed"
     data-header-position="fixed">

  <!-- ================= SIDEBAR ================= -->
  <aside class="left-sidebar">
    <div>

      <!-- LOGO -->
      <div class="brand-logo d-flex align-items-center justify-content-between">
        <a href="{{ route('admin.dashboard') }}" class="text-nowrap logo-img">
          <img src="{{ asset('assets/images/logos/logo.svg') }}" alt="">
        </a>
      </div>

      <!-- MENU -->
      <nav class="sidebar-nav scroll-sidebar">

        <ul id="sidebarnav" class="mb-0">

          <li class="nav-small-cap">
            <span class="hide-menu">Admin Panel</span>
          </li>

          <!-- DASHBOARD -->
          <li class="sidebar-item">
            <a class="sidebar-link" href="{{ route('admin.dashboard') }}">
              <span>
                <iconify-icon icon="solar:home-2-line-duotone"></iconify-icon>
              </span>
              <span class="hide-menu">Dashboard</span>
            </a>
          </li>

          <!-- CLIENTS -->
          <li class="sidebar-item">
            <a class="sidebar-link" href="{{ route('admin.clients.index') }}">
              <span>
                <iconify-icon icon="solar:users-group-line-duotone"></iconify-icon>
              </span>
              <span class="hide-menu">Clients</span>
            </a>
          </li>

          <!-- EXERCISES -->
          <li class="sidebar-item">
            <a class="sidebar-link" href="{{ route('admin.exercises.index') }}">
              <span>
                <iconify-icon icon="solar:dumbbell-large-minimalistic-line-duotone"></iconify-icon>
              </span>
              <span class="hide-menu">Exercises</span>
            </a>
          </li>

          <!-- PLANS -->
          <li class="sidebar-item">
            <a class="sidebar-link" href="{{ route('admin.plans.index') }}">
              <span>
                <iconify-icon icon="solar:clipboard-list-line-duotone"></iconify-icon>
              </span>
              <span class="hide-menu">Plans</span>
            </a>
          </li>

          <!-- LOGS -->
      

          <li class="nav-small-cap">
            <span class="hide-menu">Account</span>
          </li>

          <!-- LOGOUT -->
          <li class="sidebar-item">
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button class="sidebar-link border-0 bg-transparent w-100 text-start">
                <span>
                  <iconify-icon icon="solar:logout-2-line-duotone"></iconify-icon>
                </span>
                <span class="hide-menu">Logout</span>
              </button>
            </form>
          </li>

        </ul>

      </nav>
    </div>
  </aside>

  <!-- ================= MAIN ================= -->
  <div class="body-wrapper">

    <!-- HEADER -->
    <header class="app-header shadow-sm">
      <nav class="navbar navbar-expand-lg navbar-light px-3">

        <div class="d-flex flex-column">
          <h5 class="mb-0 fw-semibold">
            👋 Trainer Dashboard
          </h5>
          <small class="text-muted">
            Manage your gym 💪
          </small>
        </div>

        <div class="ms-auto">
          <span>{{ auth()->user()->name }}</span>
        </div>

      </nav>
    </header>

    <!-- CONTENT -->
    <div class="body-wrapper-inner">
      <div class="container-fluid mt-3">
        @yield('content')
      </div>
    </div>

  </div>
</div>

<!-- ================= JS ================= -->
<script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/sidebarmenu.js') }}"></script>
<script src="{{ asset('assets/js/app.min.js') }}"></script>

<!-- ICONS -->
<script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>

</body>
</html>