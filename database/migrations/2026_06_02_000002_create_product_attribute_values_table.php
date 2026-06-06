<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_attribute_values', function (Blueprint $table) {

            $table->id();

            $table->foreignId('product_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->foreignId('product_attribute_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->string('value');
            // Nilai atribut untuk produk ini, misal: "Merah", "XL", "1.5 kg"

            $table->timestamps();

            // Satu produk hanya boleh punya satu nilai per atribut
            $table->unique(['product_id', 'product_attribute_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_attribute_values');
    }
};