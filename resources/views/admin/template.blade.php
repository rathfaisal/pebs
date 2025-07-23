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
        /* Mobile Responsiveness */
        @media (max-width: 991.98px) {
            .fixed-layout {
                height: 100vh;
                overflow: hidden;
            }
            .fixed-header {
                flex: 0 0 auto;
                min-height: 50px;
            }
            .fixed-header .navbar {
                padding: 0.375rem 0.5rem;
            }
            .fixed-header img {
                height: 30px !important;
            }
            .fixed-main-row {
                flex-direction: row;
                flex: 1 1 auto;
                height: calc(100vh - 85px); /* Header + Footer */
            }
            .fixed-sidebar {
                display: none; /* Hide desktop sidebar on mobile */
            }
            .fixed-content {
                max-width: 100vw;
                flex: 1 1 auto;
                padding: 0.5rem;
                overflow-y: auto;
                height: 100%;
            }
            .fixed-footer {
                flex: 0 0 35px;
                padding: 0.375rem 0 !important;
                font-size: 0.7rem;
            }
            .mobile-header-text {
                font-size: 0.75rem !important;
            }
            .navbar-nav .nav-link {
                padding: 0.375rem 0.5rem;
                font-size: 0.8rem;
            }
            .navbar-nav .nav-link.active {
                background: #6c757d;
                color: #fff !important;
                font-weight: bold;
                border-radius: 0.25rem;
            }
            .navbar-nav .nav-link.disabled {
                opacity: 0.5;
                pointer-events: none;
            }
            .navbar-toggler {
                padding: 0.25rem 0.375rem;
                font-size: 0.75rem;
            }
            .dropdown-menu {
                font-size: 0.8rem;
            }
            .dropdown-item {
                padding: 0.375rem 0.75rem;
                font-size: 0.8rem;
            }
            h1 {
                font-size: 1.25rem !important;
                margin-bottom: 0.5rem !important;
            }
            h2 {
                font-size: 1.1rem !important;
                margin-bottom: 0.5rem !important;
            }
            h3 {
                font-size: 1rem !important;
            }
            .btn {
                padding: 0.25rem 0.5rem;
                font-size: 0.75rem;
            }
            .btn-sm {
                padding: 0.125rem 0.25rem;
                font-size: 0.65rem;
            }
            .form-control, .form-select {
                padding: 0.25rem 0.5rem;
                font-size: 0.8rem;
            }
            .form-label {
                font-size: 0.8rem;
                margin-bottom: 0.25rem;
            }
            .table {
                font-size: 0.7rem;
            }
            .table th, .table td {
                padding: 0.25rem 0.125rem;
            }
            .alert {
                padding: 0.5rem;
                font-size: 0.8rem;
            }
        }
        
        @media (max-width: 767.98px) {
            .fixed-header {
                min-height: 45px;
            }
            .fixed-header .navbar {
                padding: 0.25rem 0.375rem;
            }
            .fixed-header img {
                height: 25px !important;
            }
            .fixed-main-row {
                height: calc(100vh - 75px); /* Smaller header + footer */
            }
            .fixed-content {
                padding: 0.375rem;
            }
            .fixed-footer {
                flex: 0 0 30px;
                font-size: 0.65rem;
            }
            .mobile-header-text {
                font-size: 0.65rem !important;
            }
            .navbar-nav .nav-link {
                padding: 0.25rem 0.375rem;
                font-size: 0.7rem;
            }
            .navbar-toggler {
                padding: 0.125rem 0.25rem;
                font-size: 0.65rem;
            }
            .dropdown-item {
                padding: 0.25rem 0.5rem;
                font-size: 0.7rem;
            }
            h1 {
                font-size: 1.1rem !important;
                margin-bottom: 0.375rem !important;
            }
            h2 {
                font-size: 1rem !important;
                margin-bottom: 0.375rem !important;
            }
            h3 {
                font-size: 0.9rem !important;
            }
            .btn {
                padding: 0.1875rem 0.375rem;
                font-size: 0.65rem;
            }
            .btn-sm {
                padding: 0.0625rem 0.1875rem;
                font-size: 0.55rem;
            }
            .form-control, .form-select {
                padding: 0.1875rem 0.375rem;
                font-size: 0.7rem;
            }
            .form-label {
                font-size: 0.7rem;
                margin-bottom: 0.1875rem;
            }
            .table {
                font-size: 0.6rem;
            }
            .table th, .table td {
                padding: 0.1875rem 0.0625rem;
            }
            .alert {
                padding: 0.375rem;
                font-size: 0.7rem;
            }
            .badge {
                font-size: 0.55rem;
                padding: 0.125rem 0.25rem;
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
            <nav class="navbar navbar-expand-lg px-4">
                <div class="container-fluid">
                    <div class="d-flex align-items-center gap-2">
                        <img src="{{ asset('images/pebs-logo.png') }}" alt="Logo" height="40" class="me-2" style="border-radius: 6px; padding: 2px;">
                        <span class="text-uppercase fw-semibold fs-6 mb-0 mobile-header-text">Admin Panel</span>
                    </div>
                    
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0 d-lg-none">
                            <li class="nav-item">
                                <a class="nav-link text-dark fw-bold disabled">Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-dark fw-semibold {{ request()->routeIs('s.activity.index') ? 'active' : '' }}" href="{{ route('s.activity.index') }}">Activities</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-dark fw-semibold {{ request()->routeIs('announcements.index') ? 'active' : '' }}" href="{{ route('announcements.index') }}">Announcements</a>
                            </li>
                        </ul>
                        
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle d-flex align-items-center text-dark" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="me-2"><i class="bi bi-person-circle"></i> {{ auth()->user()->name }}</span>
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
                </div>
            </nav>
        </header>

        <!-- Main Section -->
        <div class="fixed-main-row">
            <!-- Sidebar (Left) -->
            <nav class="fixed-sidebar p-0 text-dark bg-light d-none d-lg-flex">
                <ul class="nav flex-column p-4">
                    <li class="nav-item mb-2">
                        <a class="nav-link sidebar-animate-link text-dark fw-bold rounded disabled">Dashboard</a>
                    </li>
                    <li class="nav-item mb-2">
                        {{-- <a class="nav-link sidebar-animate-link text-dark fw-semibold rounded" href="{{ route('s.activity.index') }}">Activities</a> --}}
                        <a class="nav-link sidebar-animate-link text-dark fw-semibold rounded {{ request()->routeIs('s.activity.index') ? 'active' : '' }}" href="{{ route('s.activity.index') }}">Activities</a>
                    </li>
                    <li class="nav-item mb-2">
                        {{-- <a class="nav-link sidebar-animate-link text-dark fw-semibold rounded" href="{{ route('announcements.index') }}">Announcements</a> --}}
                        <a class="nav-link sidebar-animate-link text-dark fw-semibold rounded {{ request()->routeIs('announcements.index') ? 'active' : '' }}" href="{{ route('announcements.index') }}">Announcements</a>
                    </li>
                </ul>
            </nav>
            <!-- Main Content (Right) -->
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
