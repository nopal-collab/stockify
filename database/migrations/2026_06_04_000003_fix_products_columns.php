<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * - Drop kolom 'price' lama (sudah digantikan harga_beli & harga_jual)
     * - Ubah 'description' di products menjadi nullable
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Hapus kolom price lama
            $table->dropColumn('price');

            // Buat description nullable
            $table->text('description')->nullable()->default(null)->change();
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('price', 12, 2)->default(0);
            $table->text('description')->nullable(false)->change();
        });
    }
};