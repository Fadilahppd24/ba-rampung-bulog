<?php

namespace Database\Seeders;

use App\Models\Gudang;
use Illuminate\Database\Seeder;

class GudangSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['kode_gudang' => 'GDG-001', 'nama_gudang' => 'Gudang Jati', 'kecamatan' => 'Indramayu', 'desa' => 'Jatibarang', 'alamat' => 'Jl. Raya Jatibarang No. 88, Indramayu', 'nomor_telepon' => '(0234) 123456', 'email' => 'gudangjati@bulog.co.id', 'kapasitas' => 12000],
            ['kode_gudang' => 'GDG-002', 'nama_gudang' => 'Gudang Karangampel', 'kecamatan' => 'Karangampel', 'desa' => 'Karangampel', 'alamat' => 'Jl. Karangampel No. 12, Indramayu', 'nomor_telepon' => '(0234) 223344', 'email' => 'gudangkarangampel@bulog.co.id', 'kapasitas' => 9000],
            ['kode_gudang' => 'GDG-003', 'nama_gudang' => 'Gudang Sukra', 'kecamatan' => 'Sukra', 'desa' => 'Sukra', 'alamat' => 'Jl. Sukra No. 45, Indramayu', 'nomor_telepon' => '(0234) 334455', 'email' => 'gudangsukra@bulog.co.id', 'kapasitas' => 8000],
            ['kode_gudang' => 'GDG-004', 'nama_gudang' => 'Gudang Patrol', 'kecamatan' => 'Patrol', 'desa' => 'Patrol', 'alamat' => 'Jl. Patrol No. 09, Indramayu', 'nomor_telepon' => '(0234) 445566', 'email' => 'gudangpatrol@bulog.co.id', 'kapasitas' => 7500],
            ['kode_gudang' => 'GDG-005', 'nama_gudang' => 'Gudang Balongan', 'kecamatan' => 'Balongan', 'desa' => 'Balongan', 'alamat' => 'Jl. Balongan No. 77, Indramayu', 'nomor_telepon' => '(0234) 556677', 'email' => 'gudangbalongan@bulog.co.id', 'kapasitas' => 6500],
            ['kode_gudang' => 'GDG-006', 'nama_gudang' => 'Gudang Kandanghaur', 'kecamatan' => 'Kandanghaur', 'desa' => 'Kandanghaur', 'alamat' => 'Jl. Kandanghaur No. 21, Indramayu', 'nomor_telepon' => '(0234) 667788', 'email' => 'gudangkandanghaur@bulog.co.id', 'kapasitas' => 7000],
        ];

        foreach ($data as $row) {
            Gudang::create($row + ['status' => 'aktif']);
        }
    }
}
