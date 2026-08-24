<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pimpinan_cabangs', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('jabatan')->default('Pimpinan Cabang BULOG Indramayu');
            $table->date('periode_mulai');
            $table->date('periode_selesai')->nullable();
            $table->string('email')->nullable();
            $table->string('nomor_telepon', 30)->nullable();
            $table->text('alamat')->nullable();
            $table->string('foto')->nullable();
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();

            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pimpinan_cabangs');
    }
};
