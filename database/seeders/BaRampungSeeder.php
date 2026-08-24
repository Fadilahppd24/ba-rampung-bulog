<?php

namespace Database\Seeders;

use App\Models\BaRampung;
use App\Models\Gudang;
use App\Models\MitraPengolahan;
use App\Models\PimpinanCabang;
use App\Models\User;
use App\Services\RendemenCalculator;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class BaRampungSeeder extends Seeder
{
    public function run(): void
    {
        $gudangs = Gudang::all();
        $mitras = MitraPengolahan::all();
        $pimpinan = PimpinanCabang::aktif()->first();
        $adminGudang = User::where('role', User::ROLE_ADMIN_GUDANG)->first();
        $pimpinanUser = User::where('role', User::ROLE_PIMPINAN_CABANG)->first();

        if ($gudangs->isEmpty() || $mitras->isEmpty() || ! $pimpinan || ! $adminGudang) {
            return; // dependencies not seeded yet
        }

        $statuses = [
            BaRampung::STATUS_TERVERIFIKASI,
            BaRampung::STATUS_TERVERIFIKASI,
            BaRampung::STATUS_TERVERIFIKASI,
            BaRampung::STATUS_MENUNGGU_VERIFIKASI,
            BaRampung::STATUS_DITOLAK,
            BaRampung::STATUS_DRAFT,
            BaRampung::STATUS_SELESAI,
        ];

        $penandatangan = ['Eri Roxmantara', 'Dadan Hendayana', 'Siti Nurhaliza', 'Budi Santoso'];

        for ($i = 1; $i <= 25; $i++) {
            $tanggal = Carbon::create(2026, rand(1, 7), rand(1, 28));
            $gudang = $gudangs->random();
            $mitra = $mitras->random();
            $status = $statuses[array_rand($statuses)];

            $gabah = rand(50000, 90000) + (rand(0, 999) / 1000);
            $beras = round($gabah * (rand(38, 42) / 100), 2);
            $menir = round($gabah * (rand(1, 3) / 1000), 2);
            $bekatul = round($gabah * (rand(35, 45) / 1000), 2);

            $ba = BaRampung::create([
                'nomor_ba' => BaRampung::generateNomorBa($tanggal),
                'tanggal_ba' => $tanggal,
                'hari' => $tanggal->translatedFormat('l'),
                'bulan' => $tanggal->translatedFormat('F'),
                'tahun' => $tanggal->year,
                'nomor_mo' => 'MO-' . rand(1000, 9999),
                'nomor_po' => 'PO-' . rand(1000, 9999),
                'gudang_id' => $gudang->id,
                'mitra_pengolahan_id' => $mitra->id,
                'nama_penandatangan' => $penandatangan[array_rand($penandatangan)],
                'jabatan_penandatangan' => 'Pengelola Gudang',
                'pimpinan_cabang_id' => $pimpinan->id,
                'status' => $status,
                'status_pbp' => collect(['normal', 'perwakilan_satu_kk', 'pengganti', 'perwakilan_beda_kk'])->random(),
                'catatan' => $status === BaRampung::STATUS_DITOLAK ? 'Dokumen pendukung tidak lengkap.' : null,
                'alasan_penolakan' => $status === BaRampung::STATUS_DITOLAK ? 'Data kuantum tidak sesuai berita acara timbang.' : null,
                'created_by' => $adminGudang->id,
                'verified_by' => in_array($status, [BaRampung::STATUS_TERVERIFIKASI, BaRampung::STATUS_DITOLAK, BaRampung::STATUS_SELESAI], true) ? $pimpinanUser?->id : null,
                'verified_at' => in_array($status, [BaRampung::STATUS_TERVERIFIKASI, BaRampung::STATUS_DITOLAK, BaRampung::STATUS_SELESAI], true) ? $tanggal->copy()->addDay() : null,
            ]);

            foreach ([
                ['produk_sesudah' => 'Beras (HGL)', 'kuantum' => $beras],
                ['produk_sesudah' => 'Menir', 'kuantum' => $menir],
                ['produk_sesudah' => 'Bekatul', 'kuantum' => $bekatul],
            ] as $row) {
                $ba->produksis()->create([
                    'produk_sebelum' => 'Gabah (GKP)',
                    'kuantum_sebelum' => $gabah,
                    'produk_sesudah' => $row['produk_sesudah'],
                    'kuantum_sesudah' => $row['kuantum'],
                    'rendemen' => RendemenCalculator::hitung($gabah, $row['kuantum']),
                ]);
            }
        }
    }
}
