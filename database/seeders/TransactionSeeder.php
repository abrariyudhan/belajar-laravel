<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaction;
use App\Models\Category; // Tambahkan ini
use App\Models\User;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();

        if ($user) {
            // Ambil ID kategori dari database berdasarkan nama yang kita buat di CategorySeeder
            $catGaji = Category::where('name', 'Gaji')->first();
            $catMakanan = Category::where('name', 'Makanan & Minuman')->first();
            $catTransport = Category::where('name', 'Transportasi')->first();
            $catFreelance = Category::where('name', 'Freelance')->first(); // Gunakan 'Freelance' jika 'Bonus' tidak ada

            $data = [
                [
                    'user_id' => $user->id,
                    'amount' => 5000000,
                    'type' => 'income',
                    'category_id' => $catGaji->id, // UBAH DI SINI
                    'description' => 'Gaji Bulan Mei',
                    'date' => '2026-05-01',
                ],
                [
                    'user_id' => $user->id,
                    'amount' => 50000,
                    'type' => 'expense',
                    'category_id' => $catMakanan->id, // UBAH DI SINI
                    'description' => 'Makan Siang Nasi Padang',
                    'date' => '2026-05-02',
                ],
                [
                    'user_id' => $user->id,
                    'amount' => 150000,
                    'type' => 'expense',
                    'category_id' => $catTransport->id, // UBAH DI SINI
                    'description' => 'Bensin Mobil',
                    'date' => '2026-05-03',
                ],
                [
                    'user_id' => $user->id,
                    'amount' => 1000000,
                    'type' => 'income',
                    'category_id' => $catFreelance->id, // UBAH DI SINI
                    'description' => 'Bonus Proyek CMS',
                    'date' => '2026-05-04',
                ],
            ];

            foreach ($data as $item) {
                Transaction::create($item);
            }
        }
    }
}