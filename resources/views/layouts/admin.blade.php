<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Admin Dashboard</title>

<link rel="icon" type="image/svg+xml" href="{{ asset('assets/images/logos/logo.svg') }}">
<link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}">

<link href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

<style>
.page-wrapper{
    display:flex;
}

.left-sidebar{
    position:fixed;
    top:0;
    left:0;
    height:100vh;
    width:250px;
    z-index:1000;
    display:flex;
    flex-direction:column;
    background:#fff;
    border-right:1px solid #eee;
}

.sidebar-nav{
    flex:1;
    overflow-y:auto;
}

.sidebar-bottom{
    padding:10px;
    border-top:1px solid #eee;
}

/* FIX: REMOVE EXTRA SPACE */
.sidebar-bottom ul{
    margin:0;
    padding:0;
}

.sidebar-bottom .sidebar-item{
    margin:0 !important;   /* removes mb-2 gap */
}

.sidebar-bottom form{
    margin:0;
}

/* keep button aligned properly */
.sidebar-bottom button.sidebar-link{
    width:100%;
    display:flex;
    align-items:center;
    gap:10px;
}

/* layout */
.body-wrapper{
    margin-left:250px;
    width:calc(100% - 250px);
}

.body-wrapper-inner{
    padding-top:10px;
}

/* sidebar link */
.sidebar-link{
    display:flex;
    align-items:center;
    gap:10px;
    padding:10px;
    border-radius:8px;
    color:#333;
    text-decoration:none;
    transition:all 0.2s ease-in-out;
}

/* active */
.sidebar-link.active{
    background:#e7f1ff;
    color:#0d6efd !important;
    font-weight:600;
}

.sidebar-link.active iconify-icon{
    color:#0d6efd !important;
}

.sidebar-link:hover{
    background:#f5f8ff;
    color:#0d6efd;
}
</style>

</head>

<body>

<div class="page-wrapper">

<aside class="left-sidebar">

<div class="brand-logo d-flex align-items-center justify-content-between p-3">
<a href="{{ route('admin.dashboard') }}">
<img src="{{ asset('assets/images/logos/logo.svg') }}" alt="">
</a>
</div>

<nav class="sidebar-nav scroll-sidebar">
<ul>

<li class="nav-small-cap"><span>Admin Panel</span></li>

<li class="sidebar-item">
<a class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
href="{{ route('admin.dashboard') }}">
<iconify-icon icon="solar:home-2-line-duotone"></iconify-icon>
Dashboard
</a>
</li>

<li class="sidebar-item">
<a class="sidebar-link {{ request()->routeIs('admin.clients.*') ? 'active' : '' }}"
href="{{ route('admin.clients.index') }}">
<iconify-icon icon="mdi:account-group-outline"></iconify-icon>
Clients
</a>
</li>

<li class="sidebar-item">
<a class="sidebar-link {{ request()->routeIs('admin.exercises.*') ? 'active' : '' }}"
href="{{ route('admin.exercises.index') }}">
<iconify-icon icon="solar:dumbbell-large-minimalistic-line-duotone"></iconify-icon>
Exercises
</a>
</li>

<li class="sidebar-item">
<a class="sidebar-link {{ request()->routeIs('admin.plans.*') ? 'active' : '' }}"
href="{{ route('admin.plans.index') }}">
<iconify-icon icon="solar:clipboard-list-line-duotone"></iconify-icon>
Plans
</a>
</li>

<li class="sidebar-item">
<a class="sidebar-link {{ request()->routeIs('admin.logs.*') ? 'active' : '' }}"
href="{{ route('admin.logs.index') }}">
<iconify-icon icon="solar:chart-line-duotone"></iconify-icon>
Logs
</a>
</li>

</ul>
</nav>

<div class="sidebar-bottom">
<ul class="list-unstyled mb-0">

<li class="sidebar-item mb-2">
<a class="sidebar-link {{ request()->routeIs('admin.profile') ? 'active' : '' }}"
href="{{ route('admin.profile') }}">
<iconify-icon icon="solar:user-circle-line-duotone"></iconify-icon>
Profile
</a>
</li>

<li class="sidebar-item">
<form method="POST" action="{{ route('logout') }}">
@csrf
<button class="sidebar-link border-0 bg-transparent w-100 text-start">
<iconify-icon icon="solar:logout-2-line-duotone"></iconify-icon>
Logout
</button>
</form>
</li>

</ul>
</div>

</aside>

<div class="body-wrapper">
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

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

@stack('scripts')

</body>
</html>