<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ba_rampungs', function (Blueprint $table) {
            $table->string('nama_penandatangan_pihak_kedua')
                ->nullable()
                ->after('jabatan_penandatangan');

            $table->string('jabatan_penandatangan_pihak_kedua')
                ->nullable()
                ->after('nama_penandatangan_pihak_kedua');

            $table->dropColumn('status_pbp');
        });
    }

    public function down(): void
    {
        Schema::table('ba_rampungs', function (Blueprint $table) {
            $table->dropColumn([
                'nama_penandatangan_pihak_kedua',
                'jabatan_penandatangan_pihak_kedua',
            ]);

            $table->enum('status_pbp', [
                'normal',
                'perwakilan_satu_kk',
                'pengganti',
                'perwakilan_beda_kk'
            ])->default('normal')->after('status');
        });
    }
};