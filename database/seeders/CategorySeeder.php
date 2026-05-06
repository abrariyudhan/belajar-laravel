<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan ada user untuk memiliki kategori ini
        $user = User::first();

        if (!$user) {
            $this->command->warn('User tidak ditemukan! Pastikan sudah ada user sebelum seeding category.');
            return;
        }

        $categories = [
            // Pengeluaran (Expense) - Biasanya warna hangat (Merah/Oranye)
            ['user_id' => $user->id, 'name' => 'Makanan & Minuman', 'type' => 'expense', 'color' => '#ef4444'],
            ['user_id' => $user->id, 'name' => 'Transportasi', 'type' => 'expense', 'color' => '#f59e0b'],
            ['user_id' => $user->id, 'name' => 'Belanja', 'type' => 'expense', 'color' => '#3b82f6'],
            ['user_id' => $user->id, 'name' => 'Kesehatan', 'type' => 'expense', 'color' => '#ec4899'],
            ['user_id' => $user->id, 'name' => 'Hiburan', 'type' => 'expense', 'color' => '#8b5cf6'],
            
            // Pemasukan (Income) - Biasanya warna dingin (Hijau)
            ['user_id' => $user->id, 'name' => 'Gaji', 'type' => 'income', 'color' => '#10b981'],
            ['user_id' => $user->id, 'name' => 'Investasi', 'type' => 'income', 'color' => '#065f46'],
            ['user_id' => $user->id, 'name' => 'Freelance', 'type' => 'income', 'color' => '#22c55e'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        $this->command->info('CategorySeeder berhasil dijalankan!');
    }
}