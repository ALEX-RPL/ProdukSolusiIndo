@extends('layouts.app')

@section('title', 'Katalog Produk')

@section('content')
{{-- ═══════════════════════════════════ PAGE HEADER ═══════════════════════════════════ --}}
<div class="page-header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <h1 class="mb-2">Katalog Produk</h1>
                <p class="mb-0" style="opacity:0.85;font-size:1.05rem;">
                    Temukan produk terbaik dari PT Indonesia Solusindo
                </p>
            </div>
        </div>
    </div>
</div>

<div class="container py-5">

    {{-- ═══════════════════════════════════ SEARCH & FILTER ═══════════════════════════════════ --}}
    <div class="card border-0 shadow-sm mb-4" style="border-radius:14px;">
        <div class="card-body p-4">
            <form method="GET" action="{{ route('home') }}" class="row g-3 align-items-end">
                <div class="col-lg-5">
                    <label class="form-label fw-semibold small text-muted mb-1">Cari Produk</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="bi bi-search text-muted"></i>
                        </span>
                        <input type="text" name="search" class="form-control border-start-0"
                               placeholder="Nama produk atau deskripsi..."
                               value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-lg-4">
                    <label class="form-label fw-semibold small text-muted mb-1">Kategori</label>
                    <select name="category" class="form-select">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                {{ $category }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-3">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary-custom flex-grow-1">
                            <i class="bi bi-filter me-1"></i>Filter
                        </button>
                        @if(request('search') || request('category'))
                            <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-x-lg"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- ═══════════════════════════════════ PRODUCTS GRID ═══════════════════════════════════ --}}
    @if($products->count() > 0)
        <div class="row g-4">
            @foreach($products as $product)
                <div class="col-lg-4 col-md-6">
                    <a href="{{ route('products.show', $product) }}" class="text-decoration-none">
                        <div class="card card-hover h-100 border-0 shadow-sm" style="border-radius:14px;overflow:hidden;">
                            {{-- Product Image --}}
                            <div class="product-img-wrap">
                                @if($product->photo)
                                    <img src="{{ asset('storage/products/' . $product->photo) }}"
                                         alt="{{ $product->name }}">
                                @else
                                    <div class="d-flex align-items-center justify-content-center h-100">
                                        <i class="bi bi-image" style="font-size:4rem;color:#c5d0db;"></i>
                                    </div>
                                @endif
                            </div>

                            {{-- Product Info --}}
                            <div class="card-body p-4">
                                <span class="badge rounded-pill mb-2"
                                      style="background:#e8f0fb;color:#0f4c81;font-weight:600;font-size:.7rem;">
                                    <i class="bi bi-tag me-1"></i>{{ $product->category }}
                                </span>

                                <h5 class="card-title fw-bold mb-2"
                                    style="color:#1e2d3d;font-size:1.1rem;line-height:1.3;">
                                    {{ $product->name }}
                                </h5>

                                <p class="text-muted mb-3 small" style="line-height:1.5;">
                                    {{ Str::limit($product->description, 80) }}
                                </p>

                                <div class="d-flex align-items-center justify-content-between">
                                    <span class="fw-bold" style="color:#0f4c81;font-size:1.2rem;">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </span>
                                    <span class="badge rounded-pill px-2 py-1"
                                          style="font-size:.7rem;font-weight:600;
                                          @if($product->stock > 10) background:#d1fae5;color:#065f46;
                                          @elseif($product->stock > 0) background:#fef3c7;color:#92400e;
                                          @else background:#fee2e2;color:#991b1b; @endif">
                                        @if($product->stock > 10)
                                            <i class="bi bi-check-circle-fill me-1"></i>Tersedia
                                        @elseif($product->stock > 0)
                                            <i class="bi bi-exclamation-circle-fill me-1"></i>{{ $product->stock }} tersisa
                                        @else
                                            <i class="bi bi-x-circle-fill me-1"></i>Habis
                                        @endif
                                    </span>
                                </div>
                            </div>

                            {{-- Footer --}}
                            <div class="card-footer bg-transparent border-0 pt-0 pb-3 px-4">
