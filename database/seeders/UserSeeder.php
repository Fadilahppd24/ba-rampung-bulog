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
        /*
        |--------------------------------------------------------------------------
        | ADMIN GUDANG
        |--------------------------------------------------------------------------
        */

        $akunGudang = [
            [
                'name' => 'Admin Gudang Pekandangan',
                'email' => 'adminpekandangan@bulog.co.id',
                'password' => 'BulogPekandangan@2026',
                'kode_gudang' => 'GDG-001',
            ],
            [
                'name' => 'Admin Gudang Kedungwungu',
                'email' => 'adminkedungwungu@bulog.co.id',
                'password' => 'BulogKedungwungu@2026',
                'kode_gudang' => 'GDG-002',
            ],
            [
                'name' => 'Admin Gudang Leuwigede',
                'email' => 'adminleuwigede@bulog.co.id',
                'password' => 'BulogLeuwigede@2026',
                'kode_gudang' => 'GDG-003',
            ],
            [
                'name' => 'Admin Gudang Losarang',
                'email' => 'adminlosarang@bulog.co.id',
                'password' => 'BulogLosarang@2026',
                'kode_gudang' => 'GDG-004',
            ],
            [
                'name' => 'Admin Gudang Tegalgirang',
                'email' => 'admintegalgirang@bulog.co.id',
                'password' => 'BulogTegalgirang@2026',
                'kode_gudang' => 'GDG-005',
            ],
            [
                'name' => 'Admin Gudang Singakerta I',
                'email' => 'adminsingakertaI@bulog.co.id',
                'password' => 'BulogSingakertaI@2026',
                'kode_gudang' => 'GDG-006',
            ],
            [
                'name' => 'Admin Gudang Singakerta II',
                'email' => 'adminsingakertaII@bulog.co.id',
                'password' => 'BulogSingakertaII@2026',
                'kode_gudang' => 'GDG-007',
            ],
            [
                'name' => 'Admin Gudang Candangpinggan',
                'email' => 'admincandangpinggan@bulog.co.id',
                'password' => 'BulogCandangpinggan@2026',
                'kode_gudang' => 'GDG-008',
            ],
        ];

        foreach ($akunGudang as $akun) {
            $gudang = Gudang::where(
                'kode_gudang',
                $akun['kode_gudang']
            )->firstOrFail();

            User::updateOrCreate(
                [
                    'email' => $akun['email'],
                ],
                [
                    'name' => $akun['name'],
                    'password' => Hash::make($akun['password']),
                    'role' => User::ROLE_ADMIN_GUDANG,
                    'gudang_id' => $gudang->id,
                    'is_active' => true,
                ]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | PIMPINAN CABANG
        |--------------------------------------------------------------------------
        */

        User::updateOrCreate(
            [
                'email' => 'pimpinan@bulog.co.id',
            ],
            [
                'name' => 'H. Ahmad Fauzi',
                'password' => Hash::make('password'),
                'role' => User::ROLE_PIMPINAN_CABANG,
                'gudang_id' => null,
                'is_active' => true,
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | ADMIN SISTEM
        |--------------------------------------------------------------------------
        */

        User::updateOrCreate(
            [
                'email' => 'adminsistem@bulog.co.id',
            ],
            [
                'name' => 'Dedi Setiawan',
                'password' => Hash::make('password'),
                'role' => 'admin_sistem',
                'gudang_id' => null,
                'is_active' => true,
            ]
        );
    }
}