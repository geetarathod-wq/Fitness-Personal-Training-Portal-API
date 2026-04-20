<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard</title>

    {{-- MAIN CSS --}}
    <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}">

    {{-- ICON --}}
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>

    {{-- ✅ DATATABLE BOOTSTRAP CSS (IMPORTANT FOR CLIENT-LIKE UI) --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

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
            padding-top: 10px;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 10px;
        }
    </style>
</head>

<body>

<div class="page-wrapper">

    <!-- SIDEBAR -->
    <aside class="left-sidebar">
        <div>

            <div class="brand-logo d-flex align-items-center justify-content-between">
                <a href="{{ route('admin.dashboard') }}">
                    <img src="{{ asset('assets/images/logos/logo.svg') }}" alt="">
                </a>
            </div>

            <nav class="sidebar-nav scroll-sidebar">
                <ul>

                    <li class="nav-small-cap"><span>Admin Panel</span></li>

                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('admin.dashboard') }}">
                            <iconify-icon icon="solar:home-2-line-duotone"></iconify-icon>
                            Dashboard
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('admin.clients.index') }}">
                            <iconify-icon icon="mdi:account-group-outline"></iconify-icon>
                            Clients
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('admin.exercises.index') }}">
                            <iconify-icon icon="solar:dumbbell-large-minimalistic-line-duotone"></iconify-icon>
                            Exercises
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('admin.plans.index') }}">
                            <iconify-icon icon="solar:clipboard-list-line-duotone"></iconify-icon>
                            Plans
                        </a>
                    </li>

                    <li class="nav-small-cap"><span>Account</span></li>

                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('admin.profile') }}">
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
            </nav>
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

{{-- ================= SCRIPTS ================= --}}

{{-- ✅ ONLY ONE JQUERY --}}
<script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>

{{-- BOOTSTRAP --}}
<script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>

{{-- THEME --}}
<script src="{{ asset('assets/js/sidebarmenu.js') }}"></script>
<script src="{{ asset('assets/js/app.min.js') }}"></script>

{{-- ✅ DATATABLE CORE --}}
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

{{-- ✅ DATATABLE BOOTSTRAP --}}
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

{{-- ✅ DATATABLE RESPONSIVE --}}
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

{{-- ✅ PAGE-SPECIFIC SCRIPTS --}}
@stack('scripts')

</body>
</html>