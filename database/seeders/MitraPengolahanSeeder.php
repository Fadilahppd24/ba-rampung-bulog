<?php

namespace Database\Seeders;

use App\Models\MitraPengolahan;
use Illuminate\Database\Seeder;

class MitraPengolahanSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['kode_mitra' => 'MIT-001', 'nama_mitra' => 'UD. Sumber Rezeki', 'jenis_usaha' => 'Penggilingan Padi', 'alamat' => 'Jl. Raya Jetibarang No. 88, Indramayu', 'nomor_telepon' => '(0234) 123456', 'penanggung_jawab' => 'Eri Roxmantara'],
            ['kode_mitra' => 'MIT-002', 'nama_mitra' => 'UD. Sinar Pangan', 'jenis_usaha' => 'Penggilingan Padi', 'alamat' => 'Jl. Sukra No. 45, Indramayu', 'nomor_telepon' => '(0234) 234567', 'penanggung_jawab' => 'Dadan Hendayana'],
            ['kode_mitra' => 'MIT-003', 'nama_mitra' => 'CV. Berkah Tani', 'jenis_usaha' => 'Penggilingan Padi', 'alamat' => 'Jl. Karangampel No. 12, Indramayu', 'nomor_telepon' => '(0234) 345678', 'penanggung_jawab' => 'Siti Nurhaliza'],
            ['kode_mitra' => 'MIT-004', 'nama_mitra' => 'Koperasi Tani Jaya', 'jenis_usaha' => 'Penggilingan Padi', 'alamat' => 'Jl. Patrol No. 09, Indramayu', 'nomor_telepon' => '(0234) 456789', 'penanggung_jawab' => 'Budi Santoso'],
            ['kode_mitra' => 'MIT-005', 'nama_mitra' => 'CV. Mitra Pangan', 'jenis_usaha' => 'Penggilingan Padi', 'alamat' => 'Jl. Balongan No. 77, Indramayu', 'nomor_telepon' => '(0234) 567890', 'penanggung_jawab' => 'Rina Agustina'],
        ];

        foreach ($data as $row) {
            MitraPengolahan::create($row + ['status' => 'aktif']);
        }
    }
}
