<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gudangs', function (Blueprint $table) {
            $table->id();
            $table->string('kode_gudang', 20)->unique();
            $table->string('nama_gudang');
            $table->text('alamat')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('desa')->nullable();
            $table->string('nomor_telepon', 30)->nullable();
            $table->string('email')->nullable();
            $table->decimal('kapasitas', 12, 2)->nullable()->comment('Kapasitas dalam Ton');
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();

            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gudangs');
    }
};
