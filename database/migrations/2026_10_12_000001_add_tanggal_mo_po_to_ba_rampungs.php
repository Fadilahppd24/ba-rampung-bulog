<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ba_rampungs', function (Blueprint $table) {
            $table->date('tanggal_mo')->nullable()->after('nomor_mo');
            $table->date('tanggal_po')->nullable()->after('nomor_po');
        });
    }

    public function down(): void
    {
        Schema::table('ba_rampungs', function (Blueprint $table) {
            $table->dropColumn(['tanggal_mo', 'tanggal_po']);
        });
    }
};
