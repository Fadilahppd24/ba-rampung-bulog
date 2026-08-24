<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * NOTE: This assumes the default Laravel `users` table migration
     * (0001_01_01_000000_create_users_table.php) has already run,
     * creating id/name/email/password/timestamps. See README step 1.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin_gudang', 'pimpinan_cabang', 'admin_sistem'])
                ->default('admin_gudang')
                ->after('password');
            $table->foreignId('gudang_id')->nullable()->after('role')
                ->constrained('gudangs')->nullOnDelete();
            $table->boolean('is_active')->default(true)->after('gudang_id');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('gudang_id');
            $table->dropColumn(['role', 'is_active']);
        });
    }
};
