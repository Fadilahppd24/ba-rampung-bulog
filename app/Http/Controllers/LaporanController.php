<?php

namespace App\Http\Controllers;

use App\Exports\LaporanExport;
use App\Models\BaRampung;
use App\Models\Gudang;
use App\Models\MitraPengolahan;
use App\Services\ActivityLogger;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class LaporanController extends Controller
{
    private const JENIS_LABEL = [
        'ba_rampung' => 'Laporan BA Rampung',
        'per_gudang' => 'Laporan per Gudang',
        'per_mitra' => 'Laporan per Mitra',
        'catatan' => 'Laporan Catatan',
    ];

    public function index(Request $request): View
    {
        $user = Auth::user();

        $jenis = $request->input('jenis', 'ba_rampung');

        if (!array_key_exists($jenis, self::JENIS_LABEL)) {
            $jenis = 'ba_rampung';
        }

        /*
        |--------------------------------------------------------------------------
        | Filter
        |--------------------------------------------------------------------------
        */

        $filters = $request->only([
            'gudang_id',
            'mitra_pengolahan_id',
            'bulan',
            'tahun',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Admin Gudang hanya boleh melihat gudangnya sendiri
        |--------------------------------------------------------------------------
        */

        if ($user?->isAdminGudang()) {
            $filters['gudang_id'] = $user->gudang_id;
        }

        $sudahFilter = $request->filled('tampilkan');

        [$headings, $rows] = $sudahFilter
            ? $this->buildData($jenis, $filters)
            : [[], collect()];

        /*
        |--------------------------------------------------------------------------
        | Data dropdown
        |--------------------------------------------------------------------------
        */

        if ($user?->isAdminGudang()) {
            $gudangs = Gudang::whereKey($user->gudang_id)
                ->orderBy('nama_gudang')
                ->get();
        } else {
            $gudangs = Gudang::orderBy('nama_gudang')->get();
        }

        $mitras = MitraPengolahan::orderBy('nama_mitra')->get();

        return view('laporan.index', [
            'jenisList' => self::JENIS_LABEL,
            'jenis' => $jenis,
            'headings' => $headings,
            'rows' => $rows,
            'gudangs' => $gudangs,
            'mitras' => $mitras,
            'sudahFilter' => $sudahFilter,
            'isAdminGudang' => $user?->isAdminGudang() ?? false,
            'gudangUser' => $user?->gudang,
        ]);
    }

    public function exportExcel(Request $request)
    {
        $user = Auth::user();

        $jenis = $request->input('jenis', 'ba_rampung');

        if (!array_key_exists($jenis, self::JENIS_LABEL)) {
            $jenis = 'ba_rampung';
        }

        $filters = $request->only([
            'gudang_id',
            'mitra_pengolahan_id',
            'bulan',
            'tahun',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Admin Gudang tetap dikunci ke gudangnya sendiri
        |--------------------------------------------------------------------------
        */

        if ($user?->isAdminGudang()) {
            $filters['gudang_id'] = $user->gudang_id;
        }

        [$headings, $rows] = $this->buildData($jenis, $filters);

        ActivityLogger::log(
            'Export Excel Laporan',
            'laporan',
            null,
            self::JENIS_LABEL[$jenis]
        );

        $namaBulan = !empty($filters['bulan'])
            ? \Carbon\Carbon::create()
                ->month((int) $filters['bulan'])
                ->translatedFormat('F')
            : 'Semua';

        $tahun = $filters['tahun'] ?? now()->year;

        $fileName = str_replace(
            ' ',
            '_',
            self::JENIS_LABEL[$jenis]
        ) . "_{$namaBulan}_{$tahun}.xlsx";

        return \Maatwebsite\Excel\Facades\Excel::download(
            new LaporanExport($jenis, $rows, $headings),
            $fileName
        );
    }

    public function exportPdf(Request $request)
    {
        $user = Auth::user();

        $jenis = $request->input('jenis', 'ba_rampung');

        if (!array_key_exists($jenis, self::JENIS_LABEL)) {
            $jenis = 'ba_rampung';
        }

        $filters = $request->only([
            'gudang_id',
            'mitra_pengolahan_id',
            'bulan',
            'tahun',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Admin Gudang tetap dikunci ke gudangnya sendiri
        |--------------------------------------------------------------------------
        */

        if ($user?->isAdminGudang()) {
            $filters['gudang_id'] = $user->gudang_id;
        }

        [$headings, $rows] = $this->buildData($jenis, $filters);

        ActivityLogger::log(
            'Export PDF Laporan',
            'laporan',
            null,
            self::JENIS_LABEL[$jenis]
        );

        $judul = self::JENIS_LABEL[$jenis];

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView(
            'pdf.laporan',
            compact('judul', 'headings', 'rows')
        )->setPaper('a4', 'landscape');

        return $pdf->stream(
            str_replace(' ', '_', $judul) . '.pdf'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Build Data
    |--------------------------------------------------------------------------
    */

    private function buildData(string $jenis, array $filters): array
    {
        return match ($jenis) {
            'per_gudang' => $this->laporanPerGudang($filters),
            'per_mitra' => $this->laporanPerMitra($filters),
            'catatan' => $this->laporanCatatan($filters),
            default => $this->laporanBaRampung($filters),
        };
    }

    /*
    |--------------------------------------------------------------------------
    | Filter utama
    |--------------------------------------------------------------------------
    */

    private function applyFilters(Builder $query, array $filters): Builder
    {
        if (!empty($filters['gudang_id'])) {
            $query->where(
                'ba_rampungs.gudang_id',
                $filters['gudang_id']
            );
        }

        if (!empty($filters['mitra_pengolahan_id'])) {
            $query->where(
                'ba_rampungs.mitra_pengolahan_id',
                $filters['mitra_pengolahan_id']
            );
        }

        if (!empty($filters['bulan'])) {
            $query->whereMonth(
                'ba_rampungs.tanggal_ba',
                $filters['bulan']
            );
        }

        if (!empty($filters['tahun'])) {
            $query->whereYear(
                'ba_rampungs.tanggal_ba',
                $filters['tahun']
            );
        }

        return $query;
    }

    /*
    |--------------------------------------------------------------------------
    | Laporan BA Rampung
    |--------------------------------------------------------------------------
    */

    private function laporanBaRampung(array $filters): array
    {
        $bas = $this->applyFilters(
            BaRampung::with([
                'gudang',
                'mitraPengolahan',
                'produksis',
            ]),
            $filters
        )
            ->orderByDesc('ba_rampungs.tanggal_ba')
            ->get();

        $rows = $bas->values()->map(function ($ba, $index) {

            $gabah = $ba->produksis
                ->firstWhere('produk_sebelum', 'Gabah (GKP)');

            $beras = $ba->produksis
                ->firstWhere('produk_sesudah', 'Beras (HGL)');

            $kuantumGabah = $gabah?->kuantum_sebelum ?? 0;
            $kuantumBeras = $beras?->kuantum_sesudah ?? 0;
            $rendemenBeras = $beras?->rendemen ?? 0;

            return [
                $index + 1,
                $ba->nomor_ba,
                $ba->tanggal_ba?->format('d/m/Y'),
                $ba->gudang?->nama_gudang ?? '-',
                $ba->mitraPengolahan?->nama_mitra ?? '-',
                $ba->nomor_po ?? '-',
                $ba->nomor_mo ?? '-',
                number_format(
                    (float) $kuantumGabah,
                    0,
                    ',',
                    '.'
                ),
                number_format(
                    (float) $kuantumBeras,
                    0,
                    ',',
                    '.'
                ),
                number_format(
                    (float) $rendemenBeras,
                    2,
                    ',',
                    '.'
                ),
                $ba->statusLabel(),
            ];
        });

        return [
            [
                'No.',
                'Nomor BA',
                'Tanggal BA',
                'Gudang',
                'Mitra Pengolahan',
                'Nomor PO GKP',
                'Nomor MO',
                'Gabah (Kg)',
                'Beras (Kg)',
                'Rendemen (%)',
                'Status',
            ],
            $rows,
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Laporan per Gudang
    |--------------------------------------------------------------------------
    */

    private function laporanPerGudang(array $filters): array
    {
        $query = $this->applyFilters(
            BaRampung::query(),
            $filters
        )
            ->join(
                'gudangs',
                'gudangs.id',
                '=',
                'ba_rampungs.gudang_id'
            )
            ->select(
                'gudangs.nama_gudang',
                DB::raw('COUNT(*) as total_ba')
            )
            ->groupBy('gudangs.nama_gudang')
            ->orderBy('gudangs.nama_gudang')
            ->get();

        $rows = $query->values()->map(
            fn ($r, $i) => [
                $i + 1,
                $r->nama_gudang,
                $r->total_ba,
            ]
        );

        return [
            [
                'No.',
                'Gudang',
                'Total BA',
            ],
            $rows,
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Laporan per Mitra
    |--------------------------------------------------------------------------
    */

    private function laporanPerMitra(array $filters): array
    {
        $query = $this->applyFilters(
            BaRampung::query(),
            $filters
        )
            ->join(
                'mitra_pengolahans',
                'mitra_pengolahans.id',
                '=',
                'ba_rampungs.mitra_pengolahan_id'
            )
            ->select(
                'mitra_pengolahans.nama_mitra',
                DB::raw('COUNT(*) as total_ba')
            )
            ->groupBy('mitra_pengolahans.nama_mitra')
            ->orderBy('mitra_pengolahans.nama_mitra')
            ->get();

        $rows = $query->values()->map(
            fn ($r, $i) => [
                $i + 1,
                $r->nama_mitra,
                $r->total_ba,
            ]
        );

        return [
            [
                'No.',
                'Mitra Pengolahan',
                'Total BA',
            ],
            $rows,
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Laporan Catatan
    |--------------------------------------------------------------------------
    */

    private function laporanCatatan(array $filters): array
    {
        $rows = $this->applyFilters(
            BaRampung::with([
                'gudang',
                'mitraPengolahan',
            ]),
            $filters
        )
            ->whereNotNull('catatan')
            ->where('catatan', '!=', '')
            ->orderByDesc('ba_rampungs.tanggal_ba')
            ->get()
            ->values()
            ->map(function ($ba, $index) {
                return [
                    $index + 1,
                    $ba->nomor_ba,
                    $ba->tanggal_ba?->format('d/m/Y'),
                    $ba->gudang?->nama_gudang ?? '-',
                    $ba->mitraPengolahan?->nama_mitra ?? '-',
                    $ba->catatan,
                ];
            });

        return [
            [
                'No.',
                'Nomor BA',
                'Tanggal BA',
                'Gudang',
                'Mitra Pengolahan',
                'Catatan',
            ],
            $rows,
        ];
    }
}