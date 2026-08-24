<?php

namespace Database\Seeders;

use App\Models\PimpinanCabang;
use Illuminate\Database\Seeder;

class PimpinanCabangSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nama' => 'H. Ahmad Fauzi', 'periode_mulai' => '2023-01-01', 'periode_selesai' => null, 'status' => 'aktif', 'email' => 'pinca.indramayu@bulog.co.id', 'nomor_telepon' => '(0234) 567890', 'alamat' => 'Jl. Jenderal Sudirman No. 123, Indramayu 45211'],
            ['nama' => 'Ir. Dedi Setiawan', 'periode_mulai' => '2020-01-01', 'periode_selesai' => '2023-01-01', 'status' => 'nonaktif'],
            ['nama' => 'Hj. Rina Marlina', 'periode_mulai' => '2017-01-01', 'periode_selesai' => '2020-01-01', 'status' => 'nonaktif'],
            ['nama' => 'Drs. Bambang Supriyadi', 'periode_mulai' => '2014-01-01', 'periode_selesai' => '2017-01-01', 'status' => 'nonaktif'],
            ['nama' => 'H. Agus Widodo', 'periode_mulai' => '2011-01-01', 'periode_selesai' => '2014-01-01', 'status' => 'nonaktif'],
        ];

        foreach ($data as $row) {
            PimpinanCabang::create($row + ['jabatan' => 'Pimpinan Cabang BULOG Indramayu']);
        }
    }
}
