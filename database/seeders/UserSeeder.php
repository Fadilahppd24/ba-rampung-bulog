<?php

namespace Database\Seeders;

use App\Models\Gudang;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $gudangJati = Gudang::where('kode_gudang', 'GDG-001')->first();

        User::create([
            'name' => 'Admin Gudang Jati',
            'email' => 'admingudang@bulog.co.id',
            'password' => Hash::make('password'),
            'role' => User::ROLE_ADMIN_GUDANG,
            'gudang_id' => $gudangJati?->id,
            'is_active' => true,
        ]);

        User::create([
            'name' => 'H. Ahmad Fauzi',
            'email' => 'pimpinan@bulog.co.id',
            'password' => Hash::make('password'),
            'role' => User::ROLE_PIMPINAN_CABANG,
            'gudang_id' => null,
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Dedi Setiawan',
            'email' => 'adminsistem@bulog.co.id',
            'password' => Hash::make('password'),
            'role' => User::ROLE_ADMIN_SISTEM,
            'gudang_id' => null,
            'is_active' => true,
        ]);
    }
}
