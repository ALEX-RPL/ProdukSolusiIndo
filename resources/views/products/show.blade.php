@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="container py-5">

    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" style="color:#0f4c81;">Katalog</a></li>
            <li class="breadcrumb-item active">{{ Str::limit($product->name, 40) }}</li>
        </ol>
    </nav>

    <div class="row g-5">

        {{-- ── Left: Photo ── --}}
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm" style="border-radius:18px;overflow:hidden;">
                @if($product->photo)
                    <img src="{{ asset('storage/products/' . $product->photo) }}"
                         alt="{{ $product->name }}"
                         style="width:100%;aspect-ratio:4/3;object-fit:cover;">
                @else
                    <div style="aspect-ratio:4/3;background:#eef1f5;display:flex;align-items:center;justify-content:center;">
                        <i class="bi bi-image" style="font-size:5rem;color:#c5d0db;"></i>
                    </div>
                @endif
            </div>
        </div>

        {{-- ── Right: Info ── --}}
        <div class="col-lg-7">

            <span class="badge rounded-pill mb-3"
                  style="background:#e8f0fb;color:#0f4c81;font-weight:600;font-size:.8rem;">
                <i class="bi bi-tag me-1"></i>{{ $product->category }}
            </span>

            <h1 class="section-title mb-2" style="font-size:1.85rem;">{{ $product->name }}</h1>

            <p class="mb-4" style="font-size:1.75rem;font-weight:800;color:#0f4c81;">
                Rp {{ number_format($product->price, 0, ',', '.') }}
            </p>

            <div class="card border-0 mb-4" style="background:#f4f7fb;border-radius:12px;">
                <div class="card-body">
                    <h6 class="fw-bold mb-2 text-dark">Deskripsi Produk</h6>
                    <p class="text-muted mb-0" style="line-height:1.7;">{{ $product->description }}</p>
                </div>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-6">
                    <div class="d-flex align-items-center gap-2 p-3 rounded-3"
                         style="background:#fff;border:1px solid #dde4ed;">
                        <i class="bi bi-layers" style="color:#0f4c81;font-size:1.3rem;"></i>
                        <div>
                            <div class="text-muted" style="font-size:.75rem;">Stok</div>
                            <div class="fw-bold">{{ $product->stock }} unit</div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="d-flex align-items-center gap-2 p-3 rounded-3"
                         style="background:#fff;border:1px solid #dde4ed;">
                        <i class="bi bi-chat-dots" style="color:#0f4c81;font-size:1.3rem;"></i>
                        <div>
                            <div class="text-muted" style="font-size:.75rem;">Komentar</div>
                            <div class="fw-bold">{{ $product->comments->count() }}</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Stock badge --}}
            @if($product->stock > 10)
                <span class="badge badge-stock-ok rounded-pill px-3 py-2">
                    <i class="bi bi-check-circle-fill me-1"></i>Produk Tersedia
                </span>
            @elseif($product->stock > 0)
                <span class="badge badge-stock-low rounded-pill px-3 py-2">
                    <i class="bi bi-exclamation-circle-fill me-1"></i>Stok Terbatas ({{ $product->stock }} tersisa)
                </span>
            @else
                <span class="badge badge-stock-out rounded-pill px-3 py-2">
                    <i class="bi bi-x-circle-fill me-1"></i>Stok Habis
                </span>
            @endif
        </div>
    </div>

    {{-- ══════════════ COMMENTS SECTION ══════════════ --}}
    <div class="mt-5">
        <h3 class="section-title mb-4">
            <i class="bi bi-chat-square-text me-2" style="color:#f0a500;"></i>
            Komentar ({{ $product->comments->count() }})
        </h3>

        {{-- Add Comment Form --}}
        @auth
        <div class="card border-0 shadow-sm mb-4" style="border-radius:14px;">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3">Tambah Komentar</h6>
                <form method="POST" action="{{ route('comments.store', $product) }}">
                    @csrf
                    <div class="mb-3">
                        <textarea name="content" rows="3"
                                  class="form-control @error('content') is-invalid @enderror"
                                  placeholder="Tulis komentar Anda tentang produk ini…"
                                  required maxlength="1000">{{ old('content') }}</textarea>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary-custom px-4">
                            <i class="bi bi-send me-2"></i>Kirim Komentar
                        </button>
                    </div>
                </form>
            </div>
        </div>
        @else
        <div class="alert border-0 mb-4" style="background:#e8f0fb;border-radius:12px;">
            <i class="bi bi-info-circle me-2" style="color:#0f4c81;"></i>
            <a href="{{ route('login') }}" style="color:#0f4c81;font-weight:600;">Login</a>
            atau
            <a href="{{ route('register') }}" style="color:#0f4c81;font-weight:600;">daftar</a>
            untuk menambahkan komentar.
        </div>
        @endauth

        {{-- Comments List --}}
        @forelse($product->comments as $comment)
        <div class="card border-0 shadow-sm mb-3" style="border-radius:12px;">
            <div class="card-body p-4">
                <div class="d-flex align-items-start justify-content-between">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold"
                             style="width:40px;height:40px;background:#e8f0fb;color:#0f4c81;font-size:.9rem;flex-shrink:0;">
                            {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                        </div>
                        <div>
                            <div class="fw-bold" style="font-size:.9rem;">
                                {{ $comment->user->name }}
                                @if($comment->user->isAdmin())
                                    <span class="badge-admin">ADMIN</span>
                                @endif
                            </div>
                            <div class="text-muted" style="font-size:.75rem;">
                                {{ $comment->created_at->diffForHumans() }}
                            </div>
                        </div>
                    </div>

                    {{-- Delete (own comment or admin) --}}
                    @auth
                    @if(auth()->id() === $comment->user_id || auth()->user()->isAdmin())
                    <form method="POST" action="{{ route('comments.destroy', $comment) }}"
                          onsubmit="return confirm('Hapus komentar ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger" style="border-radius:8px;">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                    @endif
                    @endauth
                </div>
                <p class="mt-3 mb-0 text-muted" style="line-height:1.6;">{{ $comment->content }}</p>
            </div>
        </div>
        @empty
        <div class="text-center py-5">
            <i class="bi bi-chat" style="font-size:3rem;color:#c5d0db;"></i>
            <p class="text-muted mt-2">Belum ada komentar. Jadilah yang pertama!</p>
        </div>
        @endforelse
    </div>

</div>
@endsection
