@extends('layouts.admin')

@section('title', 'Data Produk')
@section('page-title', 'Data Produk')
@section('page-subtitle', 'Kelola semua foto dan informasi produk')

@section('content')

{{-- Header Actions --}}
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <span class="text-muted small">
            Total: <strong>{{ $products->total() }}</strong> produk
        </span>
    </div>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary-custom px-4">
        <i class="bi bi-plus-lg me-2"></i>Tambah Produk
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th class="ps-4" style="width:60px;">No</th>
                        <th>Produk</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Komentar</th>
                        <th class="text-center pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr>
                        <td class="ps-4 text-muted">{{ $loop->iteration + ($products->currentPage() - 1) * $products->perPage() }}</td>

                        <td>
                            <div class="d-flex align-items-center gap-3">
                                @if($product->photo)
                                    <img src="{{ asset('storage/products/' . $product->photo) }}"
                                         style="width:50px;height:50px;object-fit:cover;border-radius:10px;border:1px solid #dde4ed;">
                                @else
                                    <div style="width:50px;height:50px;background:#eef1f5;border-radius:10px;display:flex;align-items:center;justify-content:center;">
                                        <i class="bi bi-image text-muted"></i>
                                    </div>
                                @endif
                                <div>
                                    <div class="fw-semibold" style="font-size:.9rem;">{{ $product->name }}</div>
                                    <div class="text-muted" style="font-size:.75rem;">
                                        {{ Str::limit($product->description, 45) }}
                                    </div>
                                </div>
                            </div>
                        </td>

                        <td>
                            <span class="badge rounded-pill"
                                  style="background:#e8f0fb;color:#0f4c81;font-size:.75rem;">
                                {{ $product->category }}
                            </span>
                        </td>

                        <td style="font-weight:600;color:#0f4c81;">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </td>

                        <td>
                            @if($product->stock > 10)
                                <span class="badge" style="background:#d1fae5;color:#065f46;border-radius:20px;">
                                    {{ $product->stock }}
                                </span>
                            @elseif($product->stock > 0)
                                <span class="badge" style="background:#fef3c7;color:#92400e;border-radius:20px;">
                                    {{ $product->stock }}
                                </span>
                            @else
                                <span class="badge" style="background:#fee2e2;color:#991b1b;border-radius:20px;">Habis</span>
                            @endif
                        </td>

                        <td>
                            <span class="text-muted small">
                                <i class="bi bi-chat me-1"></i>{{ $product->comments_count }}
                            </span>
                        </td>

                        <td class="text-center pe-4">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('products.show', $product) }}" target="_blank"
                                   class="btn btn-sm btn-outline-secondary" style="border-radius:8px;"
                                   title="Lihat">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.products.edit', $product) }}"
                                   class="btn btn-sm btn-outline-primary" style="border-radius:8px;"
                                   title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.products.destroy', $product) }}"
                                      onsubmit="return confirm('Hapus produk \'{{ $product->name }}\'? Foto akan ikut terhapus.')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                            style="border-radius:8px;" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="bi bi-inbox" style="font-size:2.5rem;display:block;margin-bottom:.5rem;"></i>
                            Belum ada produk. <a href="{{ route('admin.products.create') }}">Tambah produk pertama</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($products->hasPages())
    <div class="card-footer bg-transparent d-flex justify-content-end">
        {{ $products->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>
@endsection
