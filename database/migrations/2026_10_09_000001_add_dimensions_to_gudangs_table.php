<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('gudangs', function (Blueprint $table) {
            $table->decimal('luas_m2', 12, 2)->nullable()->after('kapasitas');
            $table->decimal('panjang_m', 10, 2)->nullable()->after('luas_m2');
            $table->decimal('lebar_m', 10, 2)->nullable()->after('panjang_m');
            $table->decimal('tinggi_m', 10, 2)->nullable()->after('lebar_m');
        });
    }

    public function down(): void
    {
        Schema::table('gudangs', function (Blueprint $table) {
            $table->dropColumn(['luas_m2', 'panjang_m', 'lebar_m', 'tinggi_m']);
        });
    }
};
