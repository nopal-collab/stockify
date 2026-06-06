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
        Schema::table('products', function (Blueprint $table) {

            // Ganti kolom price lama menjadi harga_beli & harga_jual
            // Kolom price lama tetap ada agar data tidak hilang,
            // lalu kita isi harga_beli dari price lama via seeder/tinker.

            $table->decimal('harga_beli', 15, 2)->default(0)->after('stock');
            $table->decimal('harga_jual', 15, 2)->default(0)->after('harga_beli');
            $table->integer('min_stock')->default(5)->after('harga_jual');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {

            $table->dropColumn(['harga_beli', 'harga_jual', 'min_stock']);

        });
    }
};