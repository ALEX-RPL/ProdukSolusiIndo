@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Ringkasan data aplikasi KatalogKu')

@section('content')

{{-- Stats Cards --}}
<div class="row g-4 mb-5">
    <div class="col-md-6 col-xl-3">
        <div class="stat-card" style="background:linear-gradient(135deg,#0f4c81,#1a6db5);color:#fff;">
            <div class="stat-icon"><i class="bi bi-grid-3x3-gap"></i></div>
            <div style="font-size:.8rem;opacity:.75;text-transform:uppercase;letter-spacing:.5px;">Total Produk</div>
            <div style="font-size:2.5rem;font-weight:800;line-height:1.2;">{{ $totalProducts }}</div>
            <div style="font-size:.8rem;opacity:.6;">produk terdaftar</div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="stat-card" style="background:linear-gradient(135deg,#f0a500,#ffc233);color:#1e2d3d;">
            <div class="stat-icon"><i class="bi bi-chat-dots"></i></div>
            <div style="font-size:.8rem;opacity:.75;text-transform:uppercase;letter-spacing:.5px;">Total Komentar</div>
            <div style="font-size:2.5rem;font-weight:800;line-height:1.2;">{{ $totalComments }}</div>
            <div style="font-size:.8rem;opacity:.6;">komentar masuk</div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="stat-card border" style="background:#fff;">
            <div class="stat-icon" style="color:#0f4c81;"><i class="bi bi-camera"></i></div>
            <div style="font-size:.8rem;color:#6b7f93;text-transform:uppercase;letter-spacing:.5px;">Foto Produk</div>
            <div style="font-size:2.5rem;font-weight:800;line-height:1.2;color:#0d1b2a;">{{ $totalProducts }}</div>
            <div style="font-size:.8rem;color:#6b7f93;">foto tersimpan</div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="stat-card border" style="background:#fff;">
            <div class="stat-icon" style="color:#10b981;"><i class="bi bi-check-circle"></i></div>
            <div style="font-size:.8rem;color:#6b7f93;text-transform:uppercase;letter-spacing:.5px;">Status</div>
            <div style="font-size:2.5rem;font-weight:800;line-height:1.2;color:#0d1b2a;">Online</div>
            <div style="font-size:.8rem;color:#10b981;"><i class="bi bi-circle-fill me-1" style="font-size:.5rem;"></i>Aplikasi berjalan</div>
        </div>
    </div>
</div>

<div class="row g-4">

    {{-- Recent Products --}}
    <div class="col-lg-7">
        <div class="card shadow-sm">
            <div class="card-header bg-transparent d-flex align-items-center justify-content-between py-3">
                <h6 class="fw-bold mb-0">
                    <i class="bi bi-grid-3x3-gap me-2" style="color:#f0a500;"></i>Produk Terbaru
                </h6>
                <a href="{{ route('admin.products.index') }}"
                   class="btn btn-sm btn-outline-primary" style="border-radius:8px;">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th class="ps-4">Produk</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th class="pe-4"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($latestProducts as $product)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center gap-3">
                                        @if($product->photo)
                                            <img src="{{ asset('storage/products/' . $product->photo) }}"
                                                 style="width:40px;height:40px;object-fit:cover;border-radius:8px;">
                                        @else
                                            <div style="width:40px;height:40px;background:#eef1f5;border-radius:8px;display:flex;align-items:center;justify-content:center;">
                                                <i class="bi bi-image text-muted"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="fw-semibold">{{ Str::limit($product->name, 30) }}</div>
                                            <div class="text-muted" style="font-size:.75rem;">{{ $product->category }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td style="color:#0f4c81;font-weight:600;">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </td>
                                <td>
                                    @if($product->stock > 0)
                                        <span class="badge" style="background:#d1fae5;color:#065f46;border-radius:20px;">
                                            {{ $product->stock }}
                                        </span>
                                    @else
                                        <span class="badge" style="background:#fee2e2;color:#991b1b;border-radius:20px;">Habis</span>
                                    @endif
                                </td>
                                <td class="pe-4">
                                    <a href="{{ route('admin.products.edit', $product) }}"
                                       class="btn btn-sm btn-outline-secondary" style="border-radius:7px;">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Recent Comments --}}
    <div class="col-lg-5">
        <div class="card shadow-sm">
            <div class="card-header bg-transparent py-3">
                <h6 class="fw-bold mb-0">
                    <i class="bi bi-chat-dots me-2" style="color:#f0a500;"></i>Komentar Terbaru
                </h6>
            </div>
            <div class="card-body p-0">
                @foreach($latestComments as $comment)
                <div class="p-3 border-bottom">
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold"
                             style="width:30px;height:30px;background:#e8f0fb;color:#0f4c81;font-size:.75rem;flex-shrink:0;">
                            {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                        </div>
                        <div>
                            <span class="fw-semibold" style="font-size:.8rem;">{{ $comment->user->name }}</span>
                            <span class="text-muted ms-1" style="font-size:.7rem;">
                                di {{ Str::limit($comment->product->name, 20) }}
                            </span>
                        </div>
                    </div>
                    <p class="text-muted mb-0" style="font-size:.8rem;line-height:1.5;">
                        {{ Str::limit($comment->content, 80) }}
                    </p>
                    <small class="text-muted" style="font-size:.7rem;">{{ $comment->created_at->diffForHumans() }}</small>
                </div>
                @endforeach
            </div>
        </div>
    </div>

</div>

{{-- Quick Actions --}}
<div class="row g-3 mt-2">
    <div class="col-12">
        <div class="card border-0" style="background:linear-gradient(135deg,#0d1b2a,#0f4c81);border-radius:16px;">
            <div class="card-body p-4 d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div>
                    <h5 class="text-white fw-bold mb-1">Tambah Produk Baru</h5>
                    <p class="mb-0" style="color:rgba(255,255,255,.6);font-size:.875rem;">
                        Unggah foto dan lengkapi informasi produk
                    </p>
                </div>
                <a href="{{ route('admin.products.create') }}"
                   class="btn btn-accent px-4 py-2 fw-bold" style="border-radius:10px;">
                    <i class="bi bi-plus-lg me-2"></i>Tambah Produk
                </a>
            </div>
        </div>
    </div>
</div>

@endsection

<style>
.btn-accent { background:#f0a500;border-color:#f0a500;color:#0d1b2a; }
.btn-accent:hover { background:#ffc233;border-color:#ffc233;color:#0d1b2a; }
</style>
