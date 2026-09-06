<?php

namespace App\Http\Controllers;

use App\Models\AktivitasLog;
use App\Models\BaRampung;
use App\Models\Gudang;
use App\Models\MitraPengolahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $tahun = (int) $request->input('tahun', now()->year);

        /*
        |--------------------------------------------------------------------------
        | Query BA Rampung
        |--------------------------------------------------------------------------
        | Admin Gudang hanya melihat BA dari gudangnya sendiri.
        | Admin Kantor melihat seluruh BA.
        */

        $baQuery = BaRampung::query();

        if ($user->isAdminGudang() && $user->gudang_id) {
            $baQuery->where('gudang_id', $user->gudang_id);
        }


        /*
        |--------------------------------------------------------------------------
        | KPI
        |--------------------------------------------------------------------------
        */

        if ($user->isAdminGudang()) {

            // KPI khusus Admin Gudang
            $kpi = [
                'total_ba' => (clone $baQuery)->count(),

                'menunggu_verifikasi' => (clone $baQuery)
                    ->where(
                        'status',
                        BaRampung::STATUS_MENUNGGU_VERIFIKASI
                    )
                    ->count(),

                'selesai' => (clone $baQuery)
                    ->where('status', 'selesai')
                    ->count(),

                'ditolak' => (clone $baQuery)
                    ->where('status', 'ditolak')
                    ->count(),
            ];

        } elseif ($user->isAdminKantor()) {

            // KPI khusus Admin Kantor
            $kpi = [
                'total_ba' => (clone $baQuery)->count(),

                'gudang_aktif' => Gudang::aktif()->count(),

                'mitra_pengolahan' => MitraPengolahan::aktif()->count(),

                'penyaluran_berjalan' => (clone $baQuery)
                    ->where(
                        'status',
                        BaRampung::STATUS_MENUNGGU_VERIFIKASI
                    )
                    ->count(),
            ];

        } else {

            // Default untuk role lain
            $kpi = [
                'total_ba' => (clone $baQuery)->count(),

                'gudang_aktif' => 0,

                'mitra_pengolahan' => 0,

                'penyaluran_berjalan' => 0,
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | Rekap BA Rampung per Bulan
        |--------------------------------------------------------------------------
        */

        $perBulanRaw = (clone $baQuery)
            ->whereYear('tanggal_ba', $tahun)
            ->select(
                DB::raw('MONTH(tanggal_ba) as bulan'),
                DB::raw('COUNT(*) as jumlah')
            )
            ->groupBy(DB::raw('MONTH(tanggal_ba)'))
            ->pluck('jumlah', 'bulan');

        $namaBulan = [
            'Jan',
            'Feb',
            'Mar',
            'Apr',
            'Mei',
            'Jun',
            'Jul',
            'Agu',
            'Sep',
            'Okt',
            'Nov',
            'Des',
        ];

        $perBulan = [];

        foreach ($namaBulan as $i => $nama) {
            $perBulan[] = [
                'bulan' => $nama,
                'jumlah' => (int) ($perBulanRaw[$i + 1] ?? 0),
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | Distribusi BA per Gudang
        |--------------------------------------------------------------------------
        | Hanya ditampilkan pada Dashboard Admin Kantor.
        */

        $distribusiGudang = collect();

        if ($user->isAdminKantor()) {

            $distribusiGudang = (clone $baQuery)
                ->join(
                    'gudangs',
                    'gudangs.id',
                    '=',
                    'ba_rampungs.gudang_id'
                )
                ->select(
                    'gudangs.nama_gudang',
                    DB::raw('COUNT(*) as jumlah')
                )
                ->groupBy('gudangs.nama_gudang')
                ->orderByDesc('jumlah')
                ->get();
        }


        /*
        |--------------------------------------------------------------------------
        | BA Rampung Terbaru
        |--------------------------------------------------------------------------
        */

        $baTerbaru = (clone $baQuery)
            ->with([
                'gudang',
                'mitraPengolahan',
            ])
            ->latest('tanggal_ba')
            ->limit(5)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Aktivitas Sistem Terbaru
        |--------------------------------------------------------------------------
        | Hanya Admin Kantor yang melihat aktivitas sistem global.
        */

        $aktivitasTerbaru = collect();

        if ($user->isAdminKantor()) {

            $aktivitasTerbaru = AktivitasLog::with('user')
                ->latest('created_at')
                ->limit(6)
                ->get();
        }


        /*
        |--------------------------------------------------------------------------
        | Kirim Data ke Dashboard
        |--------------------------------------------------------------------------
        */

        return view('dashboard.index', compact(
            'kpi',
            'perBulan',
            'distribusiGudang',
            'baTerbaru',
            'aktivitasTerbaru',
            'tahun'
        ));
    }
}