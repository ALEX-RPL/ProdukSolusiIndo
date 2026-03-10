<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — KatalogKu</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Fraunces:wght@700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --sidebar-w: 260px;
            --primary: #0f4c81;
            --dark: #0d1b2a;
            --accent: #f0a500;
            --border: #dde4ed;
            --light-bg: #f4f7fb;
        }
        * { box-sizing: border-box; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--light-bg);
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            position: fixed; left: 0; top: 0; bottom: 0;
            width: var(--sidebar-w);
            background: var(--dark);
            display: flex; flex-direction: column;
            z-index: 100;
            overflow-y: auto;
        }
        .sidebar-brand {
            padding: 1.5rem 1.25rem 1rem;
            border-bottom: 1px solid rgba(255,255,255,.08);
        }
        .sidebar-brand h4 {
            font-family: 'Fraunces', serif;
            color: #fff; margin: 0;
            font-size: 1.3rem;
        }
        .sidebar-brand h4 span { color: var(--accent); }
        .sidebar-nav { padding: .75rem .75rem; flex: 1; }
        .sidebar-section {
            font-size: .65rem; font-weight: 700; letter-spacing: 1.5px;
            color: rgba(255,255,255,.3); text-transform: uppercase;
            padding: 1rem .5rem .4rem;
        }
        .sidebar-link {
            display: flex; align-items: center; gap: .75rem;
            padding: .6rem .875rem; color: rgba(255,255,255,.7);
            text-decoration: none; border-radius: 10px;
            font-size: .875rem; font-weight: 500;
            transition: all .2s; margin-bottom: 2px;
        }
        .sidebar-link i { font-size: 1.05rem; flex-shrink: 0; }
        .sidebar-link:hover, .sidebar-link.active {
            background: rgba(255,255,255,.1);
            color: #fff;
        }
        .sidebar-link.active { background: var(--primary); color: #fff !important; }

        /* Main */
        .main-wrapper {
            margin-left: var(--sidebar-w);
            min-height: 100vh;
            display: flex; flex-direction: column;
        }
        .topbar {
            background: #fff;
            border-bottom: 1px solid var(--border);
            padding: .875rem 1.5rem;
            display: flex; align-items: center; justify-content: space-between;
            position: sticky; top: 0; z-index: 99;
        }
        .main-content { padding: 2rem 1.5rem; flex: 1; }

        /* Cards */
        .stat-card {
            border: none; border-radius: 16px;
            padding: 1.5rem;
            position: relative; overflow: hidden;
        }
        .stat-card .stat-icon {
            position: absolute; right: 1rem; top: 50%;
            transform: translateY(-50%);
            font-size: 3.5rem; opacity: .12;
        }
        .card { border: 1px solid var(--border); border-radius: 14px; }

        /* Table */
        .table thead th {
            background: var(--light-bg);
            font-size: .8rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: .5px;
            color: #6b7f93; border-bottom: 2px solid var(--border);
        }
        .table td { vertical-align: middle; font-size: .875rem; }

        /* Alerts */
        .alert-floating {
            position: fixed; top: 20px; right: 20px;
            z-index: 9999; min-width: 300px;
            border-radius: 12px; box-shadow: 0 8px 30px rgba(0,0,0,.15);
            animation: slideIn .4s ease;
        }
        @keyframes slideIn {
            from { transform: translateX(120%); opacity: 0; }
            to   { transform: translateX(0);    opacity: 1; }
        }

        /* Form */
        .form-control, .form-select {
            border-radius: 10px; border-color: var(--border);
            padding: .6rem 1rem; font-size: .9rem;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(15,76,129,.12);
        }
        .btn-primary-custom {
            background: var(--primary); border-color: var(--primary);
            color: #fff; font-weight: 600; border-radius: 10px;
        }
        .btn-primary-custom:hover {
            background: #1a6db5; border-color: #1a6db5; color: #fff;
        }
    </style>
</head>
<body>

{{-- Sidebar --}}
<div class="sidebar">
    <div class="sidebar-brand">
        <h4><i class="bi bi-box-seam me-2" style="color:#f0a500;"></i>Katalog<span>Ku</span></h4>
        <small style="color:rgba(255,255,255,.4);font-size:.75rem;">Panel Administrator</small>
    </div>

    <nav class="sidebar-nav">
        <div class="sidebar-section">Menu Utama</div>
        <a href="{{ route('admin.dashboard') }}"
           class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>

        <div class="sidebar-section">Manajemen</div>
        <a href="{{ route('admin.products.index') }}"
           class="sidebar-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
            <i class="bi bi-grid-3x3-gap"></i> Data Produk
        </a>
        <a href="{{ route('admin.products.create') }}"
           class="sidebar-link {{ request()->routeIs('admin.products.create') ? 'active' : '' }}">
            <i class="bi bi-plus-circle"></i> Tambah Produk
        </a>

        <div class="sidebar-section">Lainnya</div>
        <a href="{{ route('home') }}" class="sidebar-link" target="_blank">
            <i class="bi bi-eye"></i> Lihat Website
        </a>

        <div class="mt-3 pt-3" style="border-top:1px solid rgba(255,255,255,.08);">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="sidebar-link w-100 text-start border-0"
                        style="background:transparent;color:rgba(255,255,255,.5);">
                    <i class="bi bi-box-arrow-right" style="color:#ef4444;"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </nav>
</div>

{{-- Main --}}
<div class="main-wrapper">
    <div class="topbar">
        <div>
            <h5 class="mb-0 fw-bold">@yield('page-title', 'Dashboard')</h5>
            <small class="text-muted">@yield('page-subtitle', 'Panel Administrasi KatalogKu')</small>
        </div>
        <div class="d-flex align-items-center gap-2">
            <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold"
                 style="width:36px;height:36px;background:#e8f0fb;color:#0f4c81;font-size:.8rem;">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div>
                <div class="fw-semibold" style="font-size:.875rem;line-height:1.2;">{{ auth()->user()->name }}</div>
                <div class="text-muted" style="font-size:.7rem;">Administrator</div>
            </div>
        </div>
    </div>

    {{-- Flash --}}
    @if(session('success'))
    <div class="alert alert-success alert-floating alert-dismissible fade show">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger alert-floating alert-dismissible fade show">
        <i class="bi bi-exclamation-circle-fill me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="main-content">
        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    setTimeout(() => {
        document.querySelectorAll('.alert-floating').forEach(el => {
            bootstrap.Alert.getOrCreateInstance(el).close();
        });
    }, 4000);
</script>
@yield('scripts')
</body>
</html>
