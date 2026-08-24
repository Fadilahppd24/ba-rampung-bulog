<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mitra_pengolahans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_mitra', 20)->unique();
            $table->string('nama_mitra');
            $table->string('jenis_usaha')->nullable();
            $table->text('alamat')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('desa')->nullable();
            $table->string('nomor_telepon', 30)->nullable();
            $table->string('email')->nullable();
            $table->string('penanggung_jawab')->nullable();
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();

            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mitra_pengolahans');
    }
};
