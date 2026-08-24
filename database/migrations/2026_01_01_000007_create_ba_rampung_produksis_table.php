<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ba_rampung_produksis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ba_rampung_id')->constrained('ba_rampungs')->cascadeOnDelete();

            // Sebelum pengolahan
            $table->string('produk_sebelum')->default('Gabah (GKP)');
            $table->decimal('kuantum_sebelum', 14, 2)->comment('Kg');

            // Setelah pengolahan (beras / menir / bekatul disimpan sebagai baris terpisah)
            $table->string('produk_sesudah');
            $table->decimal('kuantum_sesudah', 14, 2)->comment('Kg');
            $table->decimal('rendemen', 6, 2)->comment('Persen, dihitung backend');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ba_rampung_produksis');
    }
};
