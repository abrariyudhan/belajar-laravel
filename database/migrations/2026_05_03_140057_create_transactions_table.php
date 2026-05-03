<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('transactions', function (Blueprint $table) {
        $table->id();
        
        // 1. Relasi ke User (Penting untuk CMS agar data tidak tertukar)
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        
        // 2. Nominal Uang (Precision 15, Scale 2 untuk akurasi)
        $table->decimal('amount', 15, 2);
        
        // 3. Tipe Transaksi (Pemasukan atau Pengeluaran)
        $table->enum('type', ['income', 'expense']);
        
        // 4. Kategori & Deskripsi
        $table->string('category'); 
        $table->string('description')->nullable(); // nullable agar catatan tidak wajib diisi
        
        // 5. Waktu Transaksi
        $table->date('date');
        $table->timestamps(); // Menghasilkan created_at & updated_at
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
