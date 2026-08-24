<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ba_rampungs', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_ba')->unique();
            $table->date('tanggal_ba');
            $table->string('hari', 20);
            $table->string('bulan', 20);
            $table->unsignedSmallInteger('tahun');
            $table->string('nomor_mo');
            $table->string('nomor_po');

            $table->foreignId('gudang_id')->constrained('gudangs')->restrictOnDelete();
            $table->foreignId('mitra_pengolahan_id')->constrained('mitra_pengolahans')->restrictOnDelete();

            $table->string('nama_penandatangan')->nullable();
            $table->string('jabatan_penandatangan')->nullable();
            $table->foreignId('pimpinan_cabang_id')->nullable()->constrained('pimpinan_cabangs')->nullOnDelete();

            $table->enum('status', ['draft', 'menunggu_verifikasi', 'terverifikasi', 'ditolak', 'selesai'])
                ->default('draft');
            $table->enum('status_pbp', ['normal', 'perwakilan_satu_kk', 'pengganti', 'perwakilan_beda_kk'])
                ->default('normal');
            $table->text('catatan')->nullable();
            $table->text('alasan_penolakan')->nullable();

            $table->foreignId('created_by')->constrained('users')->restrictOnDelete();
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('verified_at')->nullable();

            $table->timestamps();

            $table->index(['status', 'tahun', 'bulan']);
            $table->index('tanggal_ba');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ba_rampungs');
    }
};
