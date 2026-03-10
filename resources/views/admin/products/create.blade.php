@extends('layouts.admin')

@section('title', 'Tambah Produk')
@section('page-title', 'Tambah Produk Baru')
@section('page-subtitle', 'Upload foto dan isi informasi produk')

@section('content')

<div class="row justify-content-center">
    <div class="col-xl-9">
        <div class="card shadow-sm">
            <div class="card-header bg-transparent py-3">
                <div class="d-flex align-items-center justify-content-between">
                    <h6 class="fw-bold mb-0">
                        <i class="bi bi-plus-circle me-2" style="color:#f0a500;"></i>Form Tambah Produk
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
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="row g-4">

                        {{-- Photo Upload --}}
                        <div class="col-12">
                            <label class="form-label fw-semibold">Foto Produk <span class="text-danger">*</span></label>
                            <div class="border-2 border-dashed rounded-3 p-4 text-center"
                                 style="border:2px dashed #dde4ed;cursor:pointer;background:#fafbfc;transition:all .2s;"
                                 id="dropZone">
                                <div id="previewWrap" class="d-none mb-3">
                                    <img id="imgPreview" src="#" alt="Preview"
                                         style="max-height:200px;border-radius:10px;box-shadow:0 4px 15px rgba(0,0,0,.1);">
                                </div>
                                <div id="uploadPlaceholder">
                                    <i class="bi bi-cloud-arrow-up" style="font-size:3rem;color:#c5d0db;display:block;"></i>
                                    <p class="text-muted mb-1 mt-2">Klik atau drag & drop foto di sini</p>
                                    <p class="text-muted small mb-0">PNG, JPG, WEBP — Maks 2MB</p>
                                </div>
                                <input type="file" name="photo" id="photoInput"
                                       class="@error('photo') is-invalid @enderror"
                                       accept="image/*" style="display:none;" required>
                            </div>
                            @error('photo')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Name --}}
                        <div class="col-md-8">
                            <label class="form-label fw-semibold">Nama Produk <span class="text-danger">*</span></label>
                            <input type="text" name="name" value="{{ old('name') }}"
                                   class="form-control @error('name') is-invalid @enderror"
                                   placeholder="Contoh: Laptop ASUS VivoBook 14" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        {{-- Category --}}
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Kategori <span class="text-danger">*</span></label>
                            <input type="text" name="category" value="{{ old('category') }}"
                                   class="form-control @error('category') is-invalid @enderror"
                                   list="categoryList" placeholder="Contoh: Elektronik" required>
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
                                      placeholder="Tuliskan deskripsi lengkap produk…" required>{{ old('description') }}</textarea>
                            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        {{-- Price --}}
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Harga (Rp) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text" style="border-radius:10px 0 0 10px;">Rp</span>
                                <input type="number" name="price" value="{{ old('price') }}"
                                       class="form-control @error('price') is-invalid @enderror"
                                       style="border-radius:0 10px 10px 0;"
                                       placeholder="0" min="0" required>
                            </div>
                            @error('price')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>

                        {{-- Stock --}}
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Stok <span class="text-danger">*</span></label>
                            <input type="number" name="stock" value="{{ old('stock', 0) }}"
                                   class="form-control @error('stock') is-invalid @enderror"
                                   placeholder="0" min="0" required>
                            @error('stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        {{-- Actions --}}
                        <div class="col-12 d-flex gap-3 pt-2">
                            <button type="submit" class="btn btn-primary-custom px-5 py-2 fw-bold">
                                <i class="bi bi-check-lg me-2"></i>Simpan Produk
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
const placeholder = document.getElementById('uploadPlaceholder');

dropZone.addEventListener('click', () => photoInput.click());

dropZone.addEventListener('dragover', (e) => {
    e.preventDefault();
    dropZone.style.borderColor = '#0f4c81';
    dropZone.style.background  = '#e8f0fb';
});

dropZone.addEventListener('dragleave', () => {
    dropZone.style.borderColor = '#dde4ed';
    dropZone.style.background  = '#fafbfc';
});

dropZone.addEventListener('drop', (e) => {
    e.preventDefault();
    const file = e.dataTransfer.files[0];
    if (file) showPreview(file);
});

photoInput.addEventListener('change', (e) => {
    const file = e.target.files[0];
    if (file) showPreview(file);
});

function showPreview(file) {
    const reader = new FileReader();
    reader.onload = (e) => {
        imgPreview.src = e.target.result;
        previewWrap.classList.remove('d-none');
        placeholder.classList.add('d-none');
        dropZone.style.borderColor = '#0f4c81';
    };
    reader.readAsDataURL(file);

    // Update the file input
    const dt = new DataTransfer();
    dt.items.add(file);
    photoInput.files = dt.files;
}
</script>
@endsection
