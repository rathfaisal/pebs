<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/pebs-logo.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { min-height: 100vh;}
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            overflow: hidden;
        }
        .fixed-layout {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .fixed-header {
            flex: 0 0 auto;
            z-index: 1030;
        }
        .fixed-main-row {
            flex: 1 1 auto;
            display: flex;
            width: 100vw;
            overflow: hidden;
        }
        .fixed-sidebar {
            flex: 0 0 15vw;
            max-width: 15vw;
            min-width: 240px;
            display: flex;
            flex-direction: column;
            height: 100%;
        }
        .fixed-content {
            flex: 1 1 85vw;
            max-width: 85vw;
            overflow-y: auto;
            padding: 2rem;
            height: 100%;
        }
        .fixed-footer {
            flex: 0 0 auto;
            width: 100vw;
        }
        @media (max-width: 991.98px) {
            .fixed-sidebar {
                min-width: 0;
                max-width: 100vw;
                flex: 0 0 100vw;
            }
            .fixed-content {
                max-width: 100vw;
            }
        }

        /* Sidebar link hover animation */
        .sidebar-animate-link {
            transition: transform 0.2s cubic-bezier(0, .1, .02, 0), background 0.2s, color 0.2s;
        }
        .sidebar-animate-link:hover, .sidebar-animate-link:focus {
            transform: translateX(12px);
            background: #e2e3e5;
        }
        .sidebar-animate-link.active, .sidebar-animate-link[aria-current="page"] {
            background: #6c757d;
            /* background: linear-gradient(90deg,rgba(108, 117, 125, 1) 80%, rgba(0, 0, 0, 0) 100%); */
            color: #fff !important;
            font-weight: bold;
            /* box-shadow: 0 2px 8px 0 rgba(13,110,253,0.08); */
        }
        .disabled {
            pointer-events: none;
            opacity: 0.5;
        }
    </style>
    @yield('link')
</head>
<body>
    <div class="fixed-layout">
        <!-- Header -->
        <header class="text-dark w-100 fixed-header bg-light">
            <nav class="navbar navbar-expand px-4">
                <div class="container-fluid d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-2">
                        <img src="{{ asset('images/pebs-logo.png') }}" alt="Logo" height="40" class="me-2" style="border-radius: 6px; padding: 2px;">
                        <span class="text-uppercase fw-semibold fs-6 mb-0">SuperAdmin Management Panel</span>
                    </div>
                    <ul class="navbar-nav ms-auto ">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center text-dark" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="me-2 "><i class="bi bi-person-circle"></i> {{ auth()->user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end bg-light border-0" aria-labelledby="profileDropdown">
                                <li><a class="dropdown-item" href="{{ route('shared.profile.edit') }}">Profile</a></li>
                                <li><hr class="dropdown-divider text-black-50"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        <!-- Main Section -->
        <div class="fixed-main-row">
            <!-- Sidebar (Left 30%) -->
            <nav class="fixed-sidebar p-0 text-dark bg-light">
                <ul class="nav flex-column p-4">
                    {{-- <span class="fw-bold fs-6 mb-4">SuperAdmin Panel</span> --}}
                    <li class="nav-item mb-2">
                        {{-- <a class="nav-link sidebar-animate-link text-dark fw-semibold rounded active" aria-current="page" href="{{ route('sa.admin.index') }}">Admin</a> --}}
                        <a class="nav-link sidebar-animate-link text-dark fw-bold rounded disabled">Dashboard</a>
                    </li>
                    <li class="nav-item mb-2">
                        {{-- <a class="nav-link sidebar-animate-link text-dark fw-semibold rounded active" aria-current="page" href="{{ route('sa.admin.index') }}">Admin</a> --}}
                        <a class="nav-link sidebar-animate-link text-dark fw-semibold rounded {{ request()->routeIs('sa.admin.index') ? 'active' : '' }}" href="{{ route('sa.admin.index') }}">Admins</a>
                    </li>
                    <li class="nav-item mb-2">
                        {{-- <a class="nav-link sidebar-animate-link text-dark fw-semibold rounded active" aria-current="page" href="{{ route('s.activity.index') }}">Activity</a> --}}
                        <a class="nav-link sidebar-animate-link text-dark fw-semibold rounded {{ request()->routeIs('s.activity.index') ? 'active' : '' }}" href="{{ route('s.activity.index') }}">Activities</a>
                    </li>
                    <li class="nav-item mb-2">
                        {{-- <a class="nav-link sidebar-animate-link text-dark fw-semibold rounded active" aria-current="page" href="{{ route('announcements.index') }}">Announcement</a> --}}
                        <a class="nav-link sidebar-animate-link text-dark fw-semibold rounded {{ request()->routeIs('announcements.index') ? 'active' : '' }}" href="{{ route('announcements.index') }}">Announcements</a>
                    </li>
                </ul>
            </nav>
            <!-- Main Content (Right 70%) -->
            <section class="fixed-content">
                @yield('content')
            </section>
        </div>
        <!-- Footer -->
        <footer class="text-center py-3 w-100 fixed-footer bg-light">
            <div class="text-black-50">
                © 2025 PEBS Management System. All rights reserved.
            </div>
        </footer>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('script')
</body>
</html>
