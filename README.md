# KatalogKu — Aplikasi Katalog Produk
**PT Indonesia Solusindo** | Latihan Soal UKK

---

## 📋 Deskripsi

Aplikasi web katalog produk berbasis **Laravel 11** dan **MySQL** dengan fitur manajemen produk (foto, edit, hapus), komentar pengguna, dan sistem autentikasi dua peran (User & Admin).

---

## ✅ Fitur

| Fitur                | User | Admin |
|----------------------|:----:|:-----:|
| Login                |  ✅  |  ✅   |
| Logout               |  ✅  |  ✅   |
| Register             |  ✅  |  —    |
| Data Foto Produk     |  ✅  |  ✅   |
| Hapus Foto Produk    |  —   |  ✅   |
| Edit Foto Produk     |  —   |  ✅   |
| Tambah Foto Produk   |  —   |  ✅   |
| Menambahkan Komentar |  ✅  |  ✅   |

---

## 🗃️ Struktur Database

### Tabel `users`
| Kolom             | Tipe         | Keterangan              |
|-------------------|--------------|-------------------------|
| id                | BIGINT (PK)  | Auto increment          |
| name              | VARCHAR(255) | Nama pengguna           |
| email             | VARCHAR(255) | Email unik              |
| password          | VARCHAR(255) | Password terenkripsi    |
| role              | ENUM         | `user` / `admin`        |
| remember_token    | VARCHAR(100) | Token sesi              |
| created_at        | TIMESTAMP    |                         |
| updated_at        | TIMESTAMP    |                         |

### Tabel `products`
| Kolom       | Tipe          | Keterangan              |
|-------------|---------------|-------------------------|
| id          | BIGINT (PK)   | Auto increment          |
| name        | VARCHAR(255)  | Nama produk             |
| description | TEXT          | Deskripsi produk        |
| price       | DECIMAL(15,2) | Harga produk            |
| category    | VARCHAR(100)  | Kategori produk         |
| stock       | INT           | Jumlah stok             |
| photo       | VARCHAR(255)  | Nama file foto          |
| created_at  | TIMESTAMP     |                         |
| updated_at  | TIMESTAMP     |                         |

### Tabel `comments`
| Kolom      | Tipe        | Keterangan              |
|------------|-------------|-------------------------|
| id         | BIGINT (PK) | Auto increment          |
| product_id | BIGINT (FK) | Referensi ke products   |
| user_id    | BIGINT (FK) | Referensi ke users      |
| content    | TEXT        | Isi komentar            |
| created_at | TIMESTAMP   |                         |
| updated_at | TIMESTAMP   |                         |

---

## 🚀 Cara Instalasi

### Prasyarat
- PHP 8.2+
- Composer
- MySQL 8.0+
- Node.js (opsional, untuk asset kompilasi)

### Langkah-langkah

**1. Clone / download project**
```bash
git clone <url-repo> katalog-produk
cd katalog-produk
```

**2. Install dependencies PHP**
```bash
composer install
```

**3. Konfigurasi environment**
```bash
cp .env.example .env
php artisan key:generate
```

**4. Setting database di file `.env`**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=katalog_produk
DB_USERNAME=root
DB_PASSWORD=your_password
```

**5. Buat database MySQL**
```sql
CREATE DATABASE katalog_produk CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

**6. Jalankan migrasi & seeder**
```bash
php artisan migrate --seed
```

**7. Buat symbolic link untuk storage foto**
```bash
php artisan storage:link
```

**8. Jalankan aplikasi**
```bash
php artisan serve
```

Akses di: **http://localhost:8000**

---

## 🔑 Akun Default (Setelah Seeder)

| Role  | Email                    | Password  |
|-------|--------------------------|-----------|
| Admin | admin@solusindo.com      | admin123  |
| User  | user@example.com         | user123   |

---

## 📁 Struktur Proyek Utama

```
katalog-produk/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php       # Login, Register, Logout
│   │   │   ├── ProductController.php    # CRUD Produk + Foto
│   │   │   └── CommentController.php    # Tambah & Hapus Komentar
│   │   └── Middleware/
│   │       └── AdminMiddleware.php      # Proteksi route admin
│   └── Models/
│       ├── User.php                     # Model pengguna
│       ├── Product.php                  # Model produk
│       └── Comment.php                  # Model komentar
├── database/
│   ├── migrations/
│   │   ├── ..._create_users_table.php
│   │   ├── ..._create_products_table.php
│   │   └── ..._create_comments_table.php
│   └── seeders/
│       └── DatabaseSeeder.php           # Data awal (admin + contoh produk)
├── resources/views/
│   ├── layouts/
│   │   ├── app.blade.php                # Layout utama (public)
│   │   └── admin.blade.php              # Layout admin (sidebar)
│   ├── auth/
│   │   ├── login.blade.php              # Halaman login
│   │   └── register.blade.php           # Halaman registrasi
│   ├── products/
│   │   ├── index.blade.php              # Katalog produk (user)
│   │   └── show.blade.php               # Detail produk + komentar
│   └── admin/
│       ├── dashboard.blade.php          # Dashboard admin
│       └── products/
│           ├── index.blade.php          # Daftar produk (admin)
│           ├── create.blade.php         # Form tambah produk
│           └── edit.blade.php           # Form edit produk
└── routes/
    └── web.php                          # Semua route aplikasi
```

---

## 🛡️ Keamanan

- Password di-hash dengan **bcrypt** (Laravel default)
- CSRF protection pada semua form POST/PUT/DELETE
- Middleware `auth` untuk route yang membutuhkan autentikasi
- Middleware `admin` khusus untuk route admin
- Validasi input di semua form
- File upload dibatasi tipe (image) dan ukuran (2MB)

---

## 👥 Tim Developer
Ryan & Salfin — PT Indonesia Solusindo
