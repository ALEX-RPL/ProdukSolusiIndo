<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'KatalogKu') — PT Indonesia Solusindo</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Fraunces:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --primary:    #0f4c81;
            --primary-lt: #1a6db5;
            --accent:     #f0a500;
            --accent-lt:  #ffc233;
            --dark:       #0d1b2a;
            --mid:        #3d5a73;
            --light-bg:   #f4f7fb;
            --card-bg:    #ffffff;
            --border:     #dde4ed;
            --text:       #1e2d3d;
            --muted:      #6b7f93;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--light-bg);
            color: var(--text);
            min-height: 100vh;
        }

        /* ── Navbar ── */
        .navbar-main {
            background: var(--dark);
            padding: 0.75rem 0;
            box-shadow: 0 2px 20px rgba(0,0,0,.25);
            position: sticky; top: 0; z-index: 1030;
        }
        .navbar-brand-text {
            font-family: 'Fraunces', serif;
            font-size: 1.5rem;
            font-weight: 700;
            color: #fff !important;
            letter-spacing: -0.5px;
        }
        .navbar-brand-text span { color: var(--accent); }
        .navbar-main .nav-link {
            color: rgba(255,255,255,.75) !important;
            font-weight: 500;
            font-size: .9rem;
            padding: .5rem .85rem !important;
            border-radius: 8px;
            transition: all .2s;
        }
        .navbar-main .nav-link:hover,
        .navbar-main .nav-link.active {
            color: #fff !important;
            background: rgba(255,255,255,.1);
        }
        .btn-nav-login {
            background: var(--accent);
            color: var(--dark) !important;
            font-weight: 700 !important;
            padding: .45rem 1.1rem !important;
            border-radius: 8px !important;
        }
        .btn-nav-login:hover {
            background: var(--accent-lt) !important;
        }
        .badge-admin {
            background: var(--accent);
            color: var(--dark);
            font-size: .65rem;
            font-weight: 700;
            padding: 2px 7px;
            border-radius: 20px;
            vertical-align: middle;
            margin-left: 4px;
        }

        /* ── Alerts ── */
        .alert-floating {
            position: fixed; top: 80px; right: 20px;
            z-index: 9999; min-width: 300px; max-width: 420px;
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(0,0,0,.15);
            animation: slideIn .4s ease;
        }
        @keyframes slideIn {
            from { transform: translateX(120%); opacity: 0; }
            to   { transform: translateX(0);    opacity: 1; }
        }

        /* ── Cards ── */
        .card { border: 1px solid var(--border); border-radius: 14px; }
        .card-hover {
            transition: transform .25s, box-shadow .25s;
            cursor: pointer;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 35px rgba(15,76,129,.15) !important;
        }

        /* ── Buttons ── */
        .btn-primary-custom {
            background: var(--primary);
            border-color: var(--primary);
            color: #fff;
            font-weight: 600;
            border-radius: 10px;
            transition: all .2s;
        }
        .btn-primary-custom:hover {
            background: var(--primary-lt);
            border-color: var(--primary-lt);
            color: #fff;
            transform: translateY(-1px);
        }
        .btn-accent {
            background: var(--accent);
            border-color: var(--accent);
            color: var(--dark);
            font-weight: 700;
            border-radius: 10px;
            transition: all .2s;
        }
        .btn-accent:hover {
            background: var(--accent-lt);
            border-color: var(--accent-lt);
            color: var(--dark);
        }

        /* ── Form Controls ── */
        .form-control, .form-select {
            border-radius: 10px;
            border-color: var(--border);
            padding: .6rem 1rem;
            font-size: .9rem;
            transition: border-color .2s, box-shadow .2s;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(15,76,129,.12);
        }

        /* ── Page Header ── */
        .page-header {
            background: linear-gradient(135deg, var(--dark) 0%, var(--primary) 100%);
            padding: 3.5rem 0 2.5rem;
            color: #fff;
        }
        .page-header h1 {
            font-family: 'Fraunces', serif;
            font-weight: 700;
        }

        /* ── Footer ── */
        .footer-main {
            background: var(--dark);
            color: rgba(255,255,255,.6);
            padding: 2rem 0;
            font-size: .875rem;
        }
        .footer-main a { color: var(--accent); text-decoration: none; }

        /* ── Product Image ── */
        .product-img-wrap {
            aspect-ratio: 4/3;
            overflow: hidden;
            border-radius: 10px 10px 0 0;
            background: #eef1f5;
        }
        .product-img-wrap img {
            width: 100%; height: 100%;
            object-fit: cover;
            transition: transform .4s;
        }
        .card-hover:hover .product-img-wrap img {
            transform: scale(1.06);
        }

        /* ── Badge Stock ── */
        .badge-stock-ok  { background: #d1fae5; color: #065f46; }
        .badge-stock-low { background: #fef3c7; color: #92400e; }
        .badge-stock-out { background: #fee2e2; color: #991b1b; }

        /* ── Misc ── */
        .text-primary-custom { color: var(--primary) !important; }
        .text-accent { color: var(--accent) !important; }
        .bg-primary-custom { background: var(--primary) !important; }
        .section-title {
            font-family: 'Fraunces', serif;
            font-weight: 700;
            color: var(--dark);
        }

        @yield('extra-css')
    </style>

    @yield('head')
</head>
<body>

{{-- ═══════════════════════════════════ NAVBAR ═══════════════════════════════════ --}}
<nav class="navbar-main">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between w-100">
            {{-- Brand --}}
            <a href="{{ route('home') }}" class="navbar-brand-text text-decoration-none">
                <i class="bi bi-box-seam me-1"></i>Katalog<span>Ku</span>
            </a>

            {{-- Navigation --}}
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                    <i class="bi bi-grid me-1"></i>Produk
                </a>

                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.*') ? 'active' : '' }}">
                            <i class="bi bi-speedometer2 me-1"></i>Dashboard Admin
                        </a>
                    @endif

                    <div class="dropdown ms-2">
                        <button class="nav-link btn btn-link dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle me-1"></i>
                            {{ auth()->user()->name }}
                            @if(auth()->user()->isAdmin())
                                <span class="badge-admin">ADMIN</span>
                            @endif
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><span class="dropdown-item-text text-muted small">{{ auth()->user()->email }}</span></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="nav-link btn-nav-login ms-2">
                        <i class="bi bi-box-arrow-in-right me-1"></i>Login
                    </a>
                    <a href="{{ route('register') }}" class="nav-link" style="color:#fff!important;">
                        Daftar
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>

{{-- ═══════════════════════════════ FLASH MESSAGES ═══════════════════════════════ --}}
@if(session('success'))
<div class="alert alert-success alert-floating alert-dismissible fade show" role="alert">
    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-floating alert-dismissible fade show" role="alert">
    <i class="bi bi-exclamation-circle-fill me-2"></i>{{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

{{-- ═══════════════════════════════════ CONTENT ══════════════════════════════════ --}}
@yield('content')

{{-- ═══════════════════════════════════ FOOTER ═══════════════════════════════════ --}}
<footer class="footer-main mt-5">
    <div class="container text-center">
        <p class="mb-1">
            <strong style="color:#fff;">KatalogKu</strong> — PT Indonesia Solusindo &copy; {{ date('Y') }}
        </p>
        <p class="mb-0">Dibuat oleh Tim Web Developer</p>
    </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Auto dismiss alerts after 4 seconds
    setTimeout(() => {
        document.querySelectorAll('.alert-floating').forEach(el => {
            const bsAlert = bootstrap.Alert.getOrCreateInstance(el);
            bsAlert.close();
        });
    }, 4000);
</script>

@yield('scripts')
</body>
</html>
