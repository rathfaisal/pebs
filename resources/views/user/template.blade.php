<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('images/pebs-logo.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

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
        .nav-hover-black:hover, .nav-hover-black:focus {
            color: #000 !important;
        }
        .footer-user .footer-hover-black:hover,
        .footer-user .footer-hover-black:focus {
            color: #000 !important;
        }
    </style>
    @yield('link')
</head>
<body>
    <nav class="navbar navbar-expand-lg w-100 bg-transparent">
        <div class="container-fluid px-4">
            <a class="navbar-brand d-flex align-items-center text-white" href="{{ route('home') }}">
                <img src="{{ asset('images/pebs-logo.png') }}" alt="PEBS Logo" width="60" height="60" class="me-2">
                {{-- <span class="fw-bold text-white">PEBS<br><span style="font-size:0.8rem;font-weight:normal;">Management System</span></span> --}}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link text-black-50 nav-hover-black" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-black-50 nav-hover-black" href="#">News</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-black-50 nav-hover-black" href="#">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-black-50 nav-hover-black" href="#">Programs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-black-50 nav-hover-black" href="#">Gallery</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-black-50 nav-hover-black" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle"></i> {{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li>
                                <a class="dropdown-item" href="{{ route('shared.profile.edit') }}" style="display:flex;align-items:center;gap:8px;">
                                    
                                    <span style="line-height:1;">Profile</span>
                                </a>
                            </li>
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

    <main class="flex-fill">
        <div class="container-fluid">
            @yield('content')
        </div>
    </main>

<footer class="footer-user mt-auto w-100 pt-5 mb-4 bg-white text-black-50">
        <div class="container-fluid px-4">
            <div class="row align-items-start justify-content-between">
                <div class="col-md-3 text-start text-md-start mb-md-0 d-flex flex-column align-items-center align-items-md-start justify-content-center gap-2">
                    <img src="{{ asset('images/pebs-logo.png') }}" alt="PEBS Logo" width="100" height="100">
                    <div class="text-center text-md-start w-100">
                        <div class="fw-bold">Management System</div>
                        <div class="small">Zon 20 MBSA</div>
                    </div>
                </div>
                <div class="col-md-6 mb-3 mb-md-0">
                    <ul class="nav justify-content-center">
                        <li class="nav-item"><a class="nav-link px-2 text-black-50 footer-hover-black" href="{{ route('home') }}">Home</a></li>
                        <li class="nav-item"><a class="nav-link px-2 text-black-50 footer-hover-black" href="#">News</a></li>
                        <li class="nav-item"><a class="nav-link px-2 text-black-50 footer-hover-black" href="#">About</a></li>
                        <li class="nav-item"><a class="nav-link px-2 text-black-50 footer-hover-black" href="#">Programs</a></li>
                        <li class="nav-item"><a class="nav-link px-2 text-black-50 footer-hover-black" href="#">Gallery</a></li>
                    </ul>
                </div>
                <div class="col-md-3 text-center text-md-end">
                    <div class="small">Contact: info@pebs.com</div>
                    <div class="small">Phone: +60 12-345 6789</div>
                    <div class="mb-2">
                        <a href="#" class="text-black-50 footer-hover-black me-2 fs-4" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="text-black-50 footer-hover-black me-2 fs-4" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="text-black-50 footer-hover-black fs-4" aria-label="Email"><i class="bi bi-envelope"></i></a>
                    </div>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col text-center small">
                    © 2025 PEBS Management System. All rights reserved.
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('script')
</body>
</html>
