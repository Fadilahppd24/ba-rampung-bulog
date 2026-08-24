<?php

namespace Database\Seeders;

use App\Models\Gudang;
use App\Models\Pegawai;
use Illuminate\Database\Seeder;

class PegawaiSeeder extends Seeder
{
    public function run(): void
    {
        $gudangJati = Gudang::where('kode_gudang', 'GDG-001')->first();
        $gudangKarangampel = Gudang::where('kode_gudang', 'GDG-002')->first();
        $gudangSukra = Gudang::where('kode_gudang', 'GDG-003')->first();

        $data = [
            ['nip' => '199801012010031001', 'nama' => 'Eri Roxmantara', 'jabatan' => 'Pengelola Gudang', 'gudang_id' => $gudangJati?->id, 'nomor_telepon' => '0812 3456 7890'],
            ['nip' => '199003022016032002', 'nama' => 'Dadan Hendayana', 'jabatan' => 'Staff Administrasi', 'gudang_id' => $gudangJati?->id, 'nomor_telepon' => '0812 3456 7891'],
            ['nip' => '199205102017033003', 'nama' => 'Siti Nurhaliza', 'jabatan' => 'Verifikator', 'gudang_id' => $gudangJati?->id, 'nomor_telepon' => '0812 3456 7892'],
            ['nip' => '199107152020034004', 'nama' => 'Budi Santoso', 'jabatan' => 'Operator', 'gudang_id' => $gudangKarangampel?->id, 'nomor_telepon' => '0812 3456 7893'],
            ['nip' => '199312202019035005', 'nama' => 'Rina Agustina', 'jabatan' => 'Verifikator', 'gudang_id' => $gudangSukra?->id, 'nomor_telepon' => '0812 3456 7894'],
            ['nip' => '198809112015036006', 'nama' => 'H. Ahmad Fauzi', 'jabatan' => 'Pimpinan Cabang', 'gudang_id' => null, 'nomor_telepon' => '0812 3456 7895'],
            ['nip' => '199409302021037007', 'nama' => 'Nurul Fadhila', 'jabatan' => 'Staff Administrasi', 'gudang_id' => $gudangKarangampel?->id, 'nomor_telepon' => '0812 3456 7896'],
            ['nip' => '199601182018038008', 'nama' => 'Agus Widodo', 'jabatan' => 'Operator', 'gudang_id' => $gudangSukra?->id, 'nomor_telepon' => '0812 3456 7897'],
            ['nip' => '199502252019039009', 'nama' => 'Dedi Setiawan', 'jabatan' => 'Admin Sistem', 'gudang_id' => null, 'nomor_telepon' => '0812 3456 7898'],
            ['nip' => '199711052022040010', 'nama' => 'Rina Marlina', 'jabatan' => 'Admin Sistem', 'gudang_id' => null, 'nomor_telepon' => '0812 3456 7899'],
        ];

        foreach ($data as $row) {
            Pegawai::create($row + [
                'email' => strtolower(str_replace(' ', '.', $row['nama'])) . '@bulog.co.id',
                'status' => 'aktif',
            ]);
        }
    }
}
