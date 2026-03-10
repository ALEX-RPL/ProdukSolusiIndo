@extends('layouts.admin')

@section('title', 'Edit Produk')
@section('page-title', 'Edit Produk')
@section('page-subtitle', 'Perbarui foto dan informasi produk')

@section('content')

<div class="row justify-content-center">
    <div class="col-xl-9">
        <div class="card shadow-sm">
            <div class="card-header bg-transparent py-3">
                <div class="d-flex align-items-center justify-content-between">
                    <h6 class="fw-bold mb-0">
                        <i class="bi bi-pencil me-2" style="color:#f0a500;"></i>Edit: {{ Str::limit($product->name, 40) }}
                    </h6>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-outline-secondary" style="border-radius:8px;">
                        <i class="bi bi-arrow-left me-1"></i>Kembali
                    </a>
                </div>
            </div>
            <div class="card-body p-4">

                @if($errors->any())
                <div class="alert alert-danger rounded-3 mb-4">
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                    </ul>
                </div>
                @endif

                <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
                    @csrf @method('PUT')

                    <div class="row g-4">

                        {{-- Photo --}}
                        <div class="col-12">
                            <label class="form-label fw-semibold">Foto Produk</label>
                            <div class="row g-3 align-items-center">
                                {{-- Current Photo --}}
                                <div class="col-auto">
                                    @if($product->photo)
                                        <div>
                                            <img src="{{ asset('storage/products/' . $product->photo) }}"
                                                 id="currentPhoto"
                                                 style="height:120px;width:120px;object-fit:cover;border-radius:12px;border:2px solid #dde4ed;">
                                            <div class="text-muted text-center mt-1" style="font-size:.7rem;">Foto Sekarang</div>
                                        </div>
                                    @endif
                                </div>
                                <div class="col">
                                    <div class="border rounded-3 p-3 text-center"
                                         style="border-color:#dde4ed !important;background:#fafbfc;cursor:pointer;"
                                         id="dropZone">
                                        <div id="previewWrap" class="d-none mb-2">
                                            <img id="imgPreview" src="#" alt="Preview"
                                                 style="max-height:100px;border-radius:8px;">
                                        </div>
                                        <i class="bi bi-arrow-repeat" style="font-size:1.5rem;color:#c5d0db;"></i>
                                        <p class="text-muted small mb-0 mt-1">
                                            Klik untuk ganti foto (opsional) — PNG, JPG, WEBP maks 2MB
                                        </p>
                                        <input type="file" name="photo" id="photoInput"
                                               accept="image/*" style="display:none;">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Name --}}
                        <div class="col-md-8">
                            <label class="form-label fw-semibold">Nama Produk <span class="text-danger">*</span></label>
                            <input type="text" name="name" value="{{ old('name', $product->name) }}"
                                   class="form-control @error('name') is-invalid @enderror" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        {{-- Category --}}
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Kategori <span class="text-danger">*</span></label>
                            <input type="text" name="category" value="{{ old('category', $product->category) }}"
                                   class="form-control @error('category') is-invalid @enderror"
                                   list="categoryList" required>
                            <datalist id="categoryList">
                                <option value="Elektronik">
                                <option value="Fashion">
                                <option value="Aksesoris">
                                <option value="Makanan & Minuman">
                                <option value="Kesehatan">
                                <option value="Olahraga">
                            </datalist>
                            @error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        {{-- Description --}}
                        <div class="col-12">
                            <label class="form-label fw-semibold">Deskripsi <span class="text-danger">*</span></label>
                            <textarea name="description" rows="4"
                                      class="form-control @error('description') is-invalid @enderror"
                                      required>{{ old('description', $product->description) }}</textarea>
                            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        {{-- Price --}}
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Harga (Rp) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text" style="border-radius:10px 0 0 10px;">Rp</span>
                                <input type="number" name="price" value="{{ old('price', $product->price) }}"
                                       class="form-control @error('price') is-invalid @enderror"
                                       style="border-radius:0 10px 10px 0;" min="0" required>
                            </div>
                            @error('price')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>

                        {{-- Stock --}}
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Stok <span class="text-danger">*</span></label>
                            <input type="number" name="stock" value="{{ old('stock', $product->stock) }}"
                                   class="form-control @error('stock') is-invalid @enderror" min="0" required>
                            @error('stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        {{-- Actions --}}
                        <div class="col-12 d-flex gap-3 pt-2">
                            <button type="submit" class="btn btn-primary-custom px-5 py-2 fw-bold">
                                <i class="bi bi-check-lg me-2"></i>Simpan Perubahan
                            </button>
                            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary px-4 py-2">
                                Batal
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
const dropZone    = document.getElementById('dropZone');
const photoInput  = document.getElementById('photoInput');
const previewWrap = document.getElementById('previewWrap');
const imgPreview  = document.getElementById('imgPreview');

dropZone.addEventListener('click', () => photoInput.click());

photoInput.addEventListener('change', (e) => {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = (ev) => {
            imgPreview.src = ev.target.result;
            previewWrap.classList.remove('d-none');
            const curr = document.getElementById('currentPhoto');
            if (curr) curr.style.opacity = '.4';
        };
        reader.readAsDataURL(file);
    }
});
</script>
@endsection
