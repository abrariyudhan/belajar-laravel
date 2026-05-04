<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaction;
use App\Models\User;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan ada setidaknya satu user untuk menghubungkan transaksi
        $user = User::first();

        if ($user) {
            $data = [
                [
                    'user_id' => $user->id,
                    'amount' => 5000000,
                    'type' => 'income',
                    'category' => 'Gaji',
                    'description' => 'Gaji Bulan Mei',
                    'date' => '2026-05-01',
                ],
                [
                    'user_id' => $user->id,
                    'amount' => 50000,
                    'type' => 'expense',
                    'category' => 'Makanan',
                    'description' => 'Makan Siang Nasi Padang',
                    'date' => '2026-05-02',
                ],
                [
                    'user_id' => $user->id,
                    'amount' => 150000,
                    'type' => 'expense',
                    'category' => 'Transportasi',
                    'description' => 'Bensin Mobil',
                    'date' => '2026-05-03',
                ],
                [
                    'user_id' => $user->id,
                    'amount' => 1000000,
                    'type' => 'income',
                    'category' => 'Bonus',
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