<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /*
    |--------------------------------------------------------------------------
    | Tambah foreign key constraint untuk user_id di tabel stock_transactions.
    | Sebelumnya user_id hanya unsignedBigInteger biasa tanpa relasi ke users,
    | sehingga integritas data tidak terjaga di level database.
    |--------------------------------------------------------------------------
    */

    public function up(): void
    {
        Schema::table('stock_transactions', function (Blueprint $table) {

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('restrict'); // mencegah hapus user yang punya transaksi

        });
    }

    public function down(): void
    {
        Schema::table('stock_transactions', function (Blueprint $table) {

            $table->dropForeign(['user_id']);

        });
    }
};