<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use App\Models\Comment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * Membuat akun admin default dan contoh produk
     */
    public function run(): void
    {
        // Buat akun Admin
        $admin = User::create([
            'name'     => 'Administrator',
            'email'    => 'admin@solusindo.com',
            'password' => Hash::make('admin123'),
            'role'     => 'admin',
        ]);

        // Buat akun User contoh
        $user = User::create([
            'name'     => 'Budi Santoso',
            'email'    => 'user@example.com',
            'password' => Hash::make('user123'),
            'role'     => 'user',
        ]);

        // Buat contoh produk
        $products = [
            [
                'name'        => 'Laptop ASUS VivoBook 14',
                'description' => 'Laptop ringan dengan prosesor Intel Core i5 generasi ke-11, RAM 8GB, SSD 512GB. Cocok untuk pelajar dan profesional muda.',
                'price'       => 8500000,
                'category'    => 'Elektronik',
                'stock'       => 15,
                'photo'       => null,
            ],
            [
                'name'        => 'Smartphone Samsung Galaxy A54',
                'description' => 'Smartphone flagship dengan kamera 50MP, layar Super AMOLED 6.4 inci, baterai 5000mAh. Performa tinggi dengan harga terjangkau.',
                'price'       => 4999000,
                'category'    => 'Elektronik',
                'stock'       => 30,
                'photo'       => null,
            ],
            [
                'name'        => 'Sepatu Nike Air Max 270',
                'description' => 'Sepatu casual dengan teknologi Air Max yang memberikan kenyamanan maksimal. Tersedia dalam berbagai ukuran dan warna.',
                'price'       => 1850000,
                'category'    => 'Fashion',
                'stock'       => 50,
                'photo'       => null,
            ],
            [
                'name'        => 'Kamera Canon EOS M50',
                'description' => 'Kamera mirrorless dengan sensor APS-C 24.1MP, video 4K, layar sentuh yang dapat diputar. Ideal untuk fotografer pemula.',
                'price'       => 7200000,
                'category'    => 'Elektronik',
                'stock'       => 8,
                'photo'       => null,
            ],
            [
                'name'        => 'Tas Ransel Eiger Cordura',
                'description' => 'Tas ransel outdoor dengan material Cordura yang kuat dan tahan air. Kapasitas 35L, dilengkapi kompartemen laptop 15 inci.',
                'price'       => 650000,
                'category'    => 'Aksesoris',
                'stock'       => 25,
                'photo'       => null,
            ],
            [
                'name'        => 'Headphone Sony WH-1000XM4',
                'description' => 'Headphone over-ear dengan noise canceling terbaik di kelasnya. Baterai 30 jam, koneksi multipoint Bluetooth.',
                'price'       => 3500000,
                'category'    => 'Elektronik',
                'stock'       => 12,
                'photo'       => null,
            ],
        ];

        foreach ($products as $productData) {
            $product = Product::create($productData);

            // Tambah komentar contoh
            Comment::create([
                'product_id' => $product->id,
                'user_id'    => $user->id,
                'content'    => 'Produk bagus! Kualitasnya sesuai dengan deskripsi. Sangat puas dengan pembelian ini.',
            ]);
        }

        $this->command->info('✅ Seeder berhasil! Akun tersedia:');
        $this->command->info('   Admin - Email: admin@solusindo.com | Password: admin123');
        $this->command->info('   User  - Email: user@example.com   | Password: user123');
    }
}
