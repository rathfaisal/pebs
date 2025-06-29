<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    @yield('link')
</head>
<body style="overflow: hidden;">
    <div class="layout d-flex min-vh-100">
        <!-- Sidebar -->
        <nav id="sidebarMenu" class="sidebar p-0 d-flex flex-column justify-content-between border-end position-fixed" style="background:#FDFFFC;color:#1F271B;box-shadow:5px 0 15px 0 #DBE0DA;width:15vw;height:100vh;left:0;top:0;z-index:1040;">
            <div class="sidebar-top d-flex align-items-center ps-3" style="height:5vh;min-height:56px;">
                <a class="navbar-brand fs-4 fw-bold m-0 text-center" style="color:#1F271B;" href="#">SuperAdmin</a>
            </div>
            <div class="sidebar-nav d-flex flex-column flex-grow-1 p-3">
                <ul class="nav nav-pills flex-column mb-auto">
                    @if (Auth::user()->is_super_admin)
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('sa.admin.index') ? 'active' : '' }}" aria-current="page" href="{{ route('sa.admin.index') }}">
                            <i class="bi bi-house-door me-2"></i> Home
                        </a>
                    </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('s.activity.index') ? 'active' : '' }}" href="{{ route('s.activity.index') }}">
                            <i class="bi bi-activity me-2"></i> Activity
                        </a>
                    </li>
                </ul>
                <form method="POST" action="{{ route('logout') }}" class="mt-auto">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger w-100">Logout</button>
                </form>
            </div>
        </nav>
        <div class="sidebar-backdrop" id="sidebarBackdrop"></div>
        <!-- Main Content -->
        <div class="main-content flex-grow-1 d-flex flex-column min-vh-100" style="background:#f0f4f9;color:#1F271B;margin-left:15vw;overflow-y:auto;height:100vh;">
            <div class="main-header d-flex align-items-center ps-3" style="height:5vh;min-height:56px;">
                <h1 class="fs-4 mb-0">@yield('page-title', 'Dashboard')</h1>
            </div>
            <div class="main-content-body flex-grow-1 p-3">
                @yield('content')
            </div>
            <footer class="text-center w-100 mt-auto" style="bottom:0;left:0;z-index:100;">
                <div class="text-center p-3">
                    © 2025 Copyright:
                    <a class="text-dark" href="https://example.com/">Example.com</a>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        @media (max-width: 900px) {
            #sidebarMenu {
                position: static !important;
                width: 100vw !important;
                height: auto !important;
            }
            .main-content {
                margin-left: 0 !important;
            }
        }
    </style>
    @yield('script')
</body>
</html>
