<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Perpus Digital</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        :root {
            --primary-grad: linear-gradient(135deg, rgb(87, 106, 143) 0%, rgb(183, 189, 247) 100%);
            --dark-blue: rgb(87, 106, 143);
            --light-blue: rgb(183, 189, 247);
        }

        body { 
            background-color: #f8f9fa; 
            font-family: 'Inter', sans-serif;
            color: #333;
        }

        /* Navbar Styling */
        .navbar {
            background: var(--primary-grad) !important;
            padding: 1rem 0;
            transition: all 0.3s ease;
        }

        .navbar-brand { 
            font-weight: 800; 
            color: white !important; 
            letter-spacing: 1px;
            font-size: 1.4rem;
        }

        .nav-link {
            color: rgba(255,255,255,0.9) !important;
            font-weight: 500;
            margin: 0 5px;
        }

        .nav-link:hover {
            color: white !important;
            opacity: 1;
        }

        /* Button Styling */
        .btn-auth {
            background: white;
            color: var(--dark-blue) !important;
            border-radius: 50px;
            padding: 0.5rem 1.5rem;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .btn-logout {
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            border-radius: 50px;
            padding: 0.4rem 1.2rem;
            transition: all 0.3s ease;
        }

        .btn-logout:hover {
            background: #ef4444;
            border-color: #ef4444;
            color: white;
            transform: scale(1.05);
        }

        /* Content Area */
        .main-content {
            min-height: 80vh;
            padding-bottom: 3rem;
        }

        /* Card Customization */
        .card-custom {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ Auth::check() ? (Auth::user()->role == 'peminjam' ? route('peminjam.dashboard') : route('admin.dashboard')) : route('welcome') }}">
                <i class="bi bi-book-half me-2"></i>PERPUS<span class="fw-light">DIGITAL</span>
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('welcome') }}">Beranda</a>
                        </li>
                        <li class="nav-item ms-lg-3 mt-2 mt-lg-0">
                            <a class="nav-link btn-auth shadow-sm" href="{{ route('login') }}">Masuk</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link me-lg-3" href="{{ Auth::user()->role == 'peminjam' ? route('peminjam.dashboard') : route('admin.dashboard') }}">
                                <i class="bi bi-grid-fill me-1"></i> Dashboard
                            </a>
                        </li>

                        <li class="nav-item dropdown px-2 py-1 bg-white bg-opacity-10 rounded-pill">
                            <a class="nav-link dropdown-toggle text-white d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle fs-5 me-2"></i>
                                <div class="text-start me-2">
                                    <small class="d-block" style="font-size: 0.7rem; line-height: 1;">{{ Auth::user()->namaLengkap }}</small>
                                    <span class="fw-bold" style="font-size: 0.85rem;">{{ strtoupper(Auth::user()->role) }}</span>
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg mt-3 rounded-3">
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button class="dropdown-item text-danger d-flex align-items-center py-2" type="submit">
                                            <i class="bi bi-box-arrow-right me-2"></i> Keluar Aplikasi
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="container mt-4 main-content">
        @yield('content')
    </main>

    <footer class="bg-white border-top py-4 mt-5">
        <div class="container text-center">
            <p class="text-muted small mb-0">&copy; {{ date('Y') }} PerpusDigital. Dikembangkan dengan <i class="bi bi-heart-fill text-danger"></i> untuk Literasi Indonesia.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>