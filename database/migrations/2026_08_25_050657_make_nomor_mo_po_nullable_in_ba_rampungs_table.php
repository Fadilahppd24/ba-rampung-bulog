<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ba_rampungs', function (Blueprint $table) {
            $table->string('nomor_mo')->nullable()->change();
            $table->string('nomor_po')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('ba_rampungs', function (Blueprint $table) {
            $table->string('nomor_mo')->nullable(false)->change();
            $table->string('nomor_po')->nullable(false)->change();
        });
    }
};