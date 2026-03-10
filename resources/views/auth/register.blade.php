@extends('layouts.app')

@section('title', 'Daftar Akun')

@section('content')
<div class="min-vh-100 d-flex align-items-center justify-content-center py-5"
     style="background: linear-gradient(135deg, #0d1b2a 0%, #0f4c81 60%, #1a6db5 100%);">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">

                {{-- Brand --}}
                <div class="text-center mb-4">
                    <a href="{{ route('home') }}" class="text-decoration-none">
                        <div class="d-inline-flex align-items-center justify-content-center rounded-3 mb-3"
                             style="width:64px;height:64px;background:rgba(255,255,255,.15);">
                            <i class="bi bi-person-plus" style="font-size:2rem;color:#f0a500;"></i>
                        </div>
                        <h1 style="font-family:'Fraunces',serif;color:#fff;font-size:1.75rem;font-weight:700;">
                            Daftar Akun
                        </h1>
                    </a>
                    <p style="color:rgba(255,255,255,.6);font-size:.875rem;">Buat akun baru untuk mulai belanja</p>
                </div>

                <div class="card border-0 shadow-lg" style="border-radius:18px;">
                    <div class="card-body p-4 p-md-5">

                        <h2 class="mb-1 fw-bold" style="color:#0d1b2a;font-size:1.4rem;">Buat Akun Baru</h2>
                        <p class="text-muted mb-4" style="font-size:.875rem;">Lengkapi formulir di bawah ini</p>

                        @if($errors->any())
                        <div class="alert alert-danger rounded-3 py-2 px-3 mb-3" style="font-size:.875rem;">
                            <ul class="mb-0 ps-3">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            {{-- Name --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold small">Nama Lengkap</label>
                                <div class="input-group">
                                    <span class="input-group-text" style="border-radius:10px 0 0 10px;border-color:#dde4ed;">
                                        <i class="bi bi-person text-muted"></i>
                                    </span>
                                    <input type="text" name="name" value="{{ old('name') }}"
                                           class="form-control @error('name') is-invalid @enderror"
                                           style="border-radius:0 10px 10px 0;"
                                           placeholder="Masukkan nama lengkap" required autofocus>
                                </div>
                            </div>

                            {{-- Email --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold small">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text" style="border-radius:10px 0 0 10px;border-color:#dde4ed;">
                                        <i class="bi bi-envelope text-muted"></i>
                                    </span>
                                    <input type="email" name="email" value="{{ old('email') }}"
                                           class="form-control @error('email') is-invalid @enderror"
                                           style="border-radius:0 10px 10px 0;"
                                           placeholder="email@example.com" required>
                                </div>
                            </div>

                            {{-- Password --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold small">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text" style="border-radius:10px 0 0 10px;border-color:#dde4ed;">
                                        <i class="bi bi-lock text-muted"></i>
                                    </span>
                                    <input type="password" name="password"
                                           class="form-control @error('password') is-invalid @enderror"
                                           style="border-radius:0 10px 10px 0;"
                                           placeholder="Minimal 8 karakter" required>
                                </div>
                                <div class="form-text">Password minimal 8 karakter</div>
                            </div>

                            {{-- Confirm Password --}}
                            <div class="mb-4">
                                <label class="form-label fw-semibold small">Konfirmasi Password</label>
                                <div class="input-group">
                                    <span class="input-group-text" style="border-radius:10px 0 0 10px;border-color:#dde4ed;">
                                        <i class="bi bi-shield-lock text-muted"></i>
                                    </span>
                                    <input type="password" name="password_confirmation"
                                           class="form-control"
                                           style="border-radius:0 10px 10px 0;"
                                           placeholder="Ulangi password" required>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary-custom w-100 py-2 fw-bold">
                                <i class="bi bi-person-check me-2"></i>Buat Akun
                            </button>
                        </form>

                        <hr class="my-4">
                        <p class="text-center text-muted small mb-0">
                            Sudah punya akun?
                            <a href="{{ route('login') }}" style="color:#0f4c81;font-weight:600;">Masuk di sini</a>
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
