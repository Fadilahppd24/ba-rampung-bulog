<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pegawais', function (Blueprint $table) {
            $table->id();
            $table->string('nip', 30)->unique();
            $table->string('nama');
            $table->string('jabatan');
            $table->foreignId('gudang_id')->nullable()->constrained('gudangs')->nullOnDelete();
            $table->string('nomor_telepon', 30)->nullable();
            $table->string('email')->nullable();
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();

            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pegawais');
    }
};
