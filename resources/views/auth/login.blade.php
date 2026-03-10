@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="min-vh-100 d-flex align-items-center justify-content-center py-5"
     style="background: linear-gradient(135deg, #0d1b2a 0%, #0f4c81 60%, #1a6db5 100%);">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4">

                {{-- Logo / Brand --}}
                <div class="text-center mb-4">
                    <a href="{{ route('home') }}" class="text-decoration-none">
                        <div class="d-inline-flex align-items-center justify-content-center rounded-3 mb-3"
                             style="width:64px;height:64px;background:rgba(255,255,255,.15);">
                            <i class="bi bi-box-seam" style="font-size:2rem;color:#f0a500;"></i>
                        </div>
                        <h1 style="font-family:'Fraunces',serif;color:#fff;font-size:1.75rem;font-weight:700;">
                            Katalog<span style="color:#f0a500;">Ku</span>
                        </h1>
                    </a>
                    <p style="color:rgba(255,255,255,.6);font-size:.875rem;">Masuk ke akun Anda</p>
                </div>

                {{-- Card --}}
                <div class="card border-0 shadow-lg" style="border-radius:18px;">
                    <div class="card-body p-4 p-md-5">

                        <h2 class="mb-1 fw-bold" style="color:#0d1b2a;font-size:1.4rem;">Selamat Datang</h2>
                        <p class="text-muted mb-4" style="font-size:.875rem;">Masukkan email dan password Anda</p>

                        @if($errors->any())
                        <div class="alert alert-danger rounded-3 py-2 px-3 mb-3" style="font-size:.875rem;">
                            <i class="bi bi-exclamation-triangle me-1"></i>
                            {{ $errors->first() }}
                        </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            {{-- Email --}}
                            <div class="mb-3">
                                <label class="form-label fw-600 small">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text" style="border-radius:10px 0 0 10px;border-color:#dde4ed;">
                                        <i class="bi bi-envelope text-muted"></i>
                                    </span>
                                    <input type="email" name="email" value="{{ old('email') }}"
                                           class="form-control @error('email') is-invalid @enderror"
                                           style="border-radius:0 10px 10px 0;"
                                           placeholder="email@example.com" required autofocus>
                                </div>
                            </div>

                            {{-- Password --}}
                            <div class="mb-3">
                                <label class="form-label fw-600 small">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text" style="border-radius:10px 0 0 10px;border-color:#dde4ed;">
                                        <i class="bi bi-lock text-muted"></i>
                                    </span>
                                    <input type="password" name="password" id="passwordInput"
                                           class="form-control @error('password') is-invalid @enderror"
                                           style="border-radius:0 0 0 0;"
                                           placeholder="••••••••" required>
                                    <button class="btn btn-outline-secondary" type="button" id="togglePwd"
                                            style="border-color:#dde4ed;border-radius:0 10px 10px 0;">
                                        <i class="bi bi-eye" id="eyeIcon"></i>
                                    </button>
                                </div>
                            </div>

                            {{-- Remember --}}
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                    <label class="form-check-label small" for="remember">Ingat saya</label>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary-custom w-100 py-2 fw-bold">
                                <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
                            </button>
                        </form>

                        <hr class="my-4">
                        <p class="text-center text-muted small mb-0">
                            Belum punya akun?
                            <a href="{{ route('register') }}" style="color:#0f4c81;font-weight:600;">Daftar sekarang</a>
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('togglePwd').addEventListener('click', function() {
    const input = document.getElementById('passwordInput');
    const icon  = document.getElementById('eyeIcon');
    if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'bi bi-eye-slash';
    } else {
        input.type = 'password';
        icon.className = 'bi bi-eye';
    }
});
</script>
@endsection
