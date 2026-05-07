<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            // Pengeluaran (Expense) - Biasanya warna hangat (Merah/Oranye)
            ['name' => 'Makanan & Minuman', 'type' => 'expense', 'color' => '#ef4444'],
            ['name' => 'Transportasi', 'type' => 'expense', 'color' => '#f59e0b'],
            ['name' => 'Belanja', 'type' => 'expense', 'color' => '#3b82f6'],
            ['name' => 'Kesehatan', 'type' => 'expense', 'color' => '#ec4899'],
            ['name' => 'Hiburan', 'type' => 'expense', 'color' => '#8b5cf6'],
            
            // Pemasukan (Income) - Biasanya warna dingin (Hijau)
            ['name' => 'Gaji', 'type' => 'income', 'color' => '#10b981'],
            ['name' => 'Investasi', 'type' => 'income', 'color' => '#065f46'],
            ['name' => 'Freelance', 'type' => 'income', 'color' => '#22c55e'],
            
            // Kategori Lainnya
            ['name' => 'Lain-lain', 'type' => 'expense', 'color' => '#6b7280'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        $this->command->info('CategorySeeder berhasil dijalankan!');
    }
}