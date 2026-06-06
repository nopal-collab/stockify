<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /*
    |--------------------------------------------------------------------------
    | STOCK OPNAME TABLE
    | Menyimpan header/sesi setiap proses stock opname
    |--------------------------------------------------------------------------
    */

    public function up(): void
    {
        Schema::create('stock_opnames', function (Blueprint $table) {

            $table->id();

            // Judul / label sesi opname
            $table->string('title');

            // Catatan tambahan
            $table->text('notes')->nullable();

            // Status: draft → in_progress → completed
            $table->enum('status', ['draft', 'in_progress', 'completed'])->default('draft');

            // Siapa yang membuat sesi opname
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');

            // Siapa yang menyelesaikan (nullable sampai completed)
            $table->unsignedBigInteger('completed_by')->nullable();
            $table->foreign('completed_by')->references('id')->on('users')->onDelete('set null');

            $table->timestamp('completed_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_opnames');
    }
};