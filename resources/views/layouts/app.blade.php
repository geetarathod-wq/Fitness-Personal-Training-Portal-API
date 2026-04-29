<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Fitness Dashboard</title>

  <link rel="icon" type="image/svg+xml" href="{{ asset('assets/images/logos/logo.svg') }}">

  <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

  <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>

<style>
.page-wrapper {
    display: flex;
}

.left-sidebar {
    position: fixed;
    top: 0;
    left: 0;
    height: 100vh;
    width: 250px;
    z-index: 1000;
    display: flex;
    flex-direction: column;
    background: #fff;
    border-right: 1px solid #eee;
}

.sidebar-nav {
    flex: 1;
    overflow-y: auto;
}

.sidebar-bottom {
    padding: 10px;
    border-top: 1px solid #eee;
}

/* FIX SPACING ISSUE */
.sidebar-bottom ul{
    margin:0;
    padding:0;
}

.sidebar-bottom .sidebar-item{
    margin:0 !important;
}

.sidebar-bottom form{
    margin:0;
}

.sidebar-bottom button.sidebar-link{
    width:100%;
    display:flex;
    align-items:center;
    gap:10px;
}

/* layout */
.body-wrapper {
    margin-left: 250px;
    width: calc(100% - 250px);
}

.body-wrapper-inner {
    padding-top: 10px;
}

/* links */
.sidebar-link {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px;
    border-radius: 8px;
    color: #333;
    text-decoration: none;
    transition: all 0.2s ease-in-out;
}

.sidebar-link.active {
    background: #e7f1ff;
    color: #0d6efd !important;
    font-weight: 600;
}

.sidebar-link:hover {
    background: #f5f8ff;
    color: #0d6efd;
}

/* ================= LOADER (ADDED ONLY) ================= */
#globalLoader {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.4);
    z-index: 99999;
    align-items: center;
    justify-content: center;
}

.spinner {
    width: 55px;
    height: 55px;
    border: 5px solid #ddd;
    border-top: 5px solid #0d6efd;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    100% { transform: rotate(360deg); }
}
</style>
</head>

<body>

<!-- LOADER (ADDED ONLY) -->
<div id="globalLoader">
    <div class="spinner"></div>
</div>

<div class="page-wrapper" id="main-wrapper">

  <!-- SIDEBAR -->
  <aside class="left-sidebar">
      <div class="brand-logo d-flex align-items-center justify-content-between p-3">
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
        </ul>
      </nav>

      <div class="sidebar-bottom">
        <ul class="list-unstyled mb-0">

          <li class="sidebar-item mb-2">
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
      </div>
  </aside>

  <!-- MAIN -->
  <div class="body-wrapper">
    <div class="body-wrapper-inner">
      <div class="container-fluid pt-3">
        @yield('content')
      </div>
    </div>
  </div>

</div>

<!-- SCRIPTS -->
<script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/sidebarmenu.js') }}"></script>
<script src="{{ asset('assets/js/app.min.js') }}"></script>

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<!-- LOADER SCRIPT (ADDED ONLY) -->
<script>
function showLoader() {
    document.getElementById('globalLoader').style.display = 'flex';
}
</script>

@stack('scripts')

</body>
</html>