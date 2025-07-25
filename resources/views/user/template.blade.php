<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('images/pebs-logo.png') }}">
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .container {
            flex: 1;
        }
        .navbar-user {
            background-color: #f8f9fa; /* Light gray */
        }
        .navbar-user .navbar-brand {
            color: #000; /* Black */
        }
        .footer-user {
            background-color: #e9ecef; /* Lighter gray */
            text-align: center;
            padding: 10px;
        }
    </style>
    @yield('link')
</head>
<body>
    <nav class="navbar navbar-expand-lg" style="background-color: #22316c;">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                <img src="{{ asset('images/pebs-logo.png') }}" alt="PEBS Logo" width="40" height="40" class="me-2">
                <span class="fw-bold text-white">PEBS<br><span style="font-size:0.8rem;font-weight:normal;">Management System</span></span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#">News</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#">Programs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#">Gallery</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle"></i> {{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="{{ route('shared.profile.show') }}">Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
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

    <div class="container">
        @yield('content')
    </div>

    <footer class="footer-user mt-auto" style="background-color:#22316c;color:#fff;">
        <div class="container py-3">
            <div class="row align-items-center">
                <div class="col-md-2 text-center mb-2 mb-md-0">
                    <img src="{{ asset('images/pebs-logo.png') }}" alt="PEBS Logo" width="50" height="50">
                </div>
                <div class="col-md-10 text-center text-md-start">
                    <div class="fw-bold">PEBS Management System</div>
                    <div style="font-size:0.9rem;">Zon 20 MBSA</div>
                    <div style="font-size:0.85rem;">© 2025 PEBS Management System. All rights reserved.</div>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('script')
</body>
</html>
