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
        Schema::table('categories', function (Blueprint $table) {
            // Drop foreign key terlebih dahulu
            $table->dropForeign(['user_id']);
            // Lalu drop column user_id
            $table->dropColumn('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            // Tambah kembali user_id jika rollback
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
        });
    }
};
