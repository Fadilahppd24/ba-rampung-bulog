<?php

namespace App\Http\Controllers;

use App\Exports\LaporanExport;
use App\Models\BaRampung;
use App\Models\Gudang;
use App\Models\MitraPengolahan;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class LaporanController extends Controller
{
    private const JENIS_LABEL = [
        'ba_rampung' => 'Laporan BA Rampung',
        'per_gudang' => 'Laporan per Gudang',
        'per_mitra' => 'Laporan per Mitra',
        'status_pbp' => 'Laporan Status PBP',
        'catatan' => 'Laporan Catatan',
    ];

    public function index(Request $request): View
    {
        $jenis = $request->input('jenis', 'ba_rampung');
        if (! array_key_exists($jenis, self::JENIS_LABEL)) {
            $jenis = 'ba_rampung';
        }

        $filters = $request->only(['gudang_id', 'mitra_pengolahan_id', 'bulan', 'tahun']);

        $sudahFilter = $request->filled('tampilkan');
        [$headings, $rows] = $sudahFilter ? $this->buildData($jenis, $filters) : [[], collect()];

        $gudangs = Gudang::orderBy('nama_gudang')->get();
        $mitras = MitraPengolahan::orderBy('nama_mitra')->get();

        return view('laporan.index', [
            'jenisList' => self::JENIS_LABEL,
            'jenis' => $jenis,
            'headings' => $headings,
            'rows' => $rows,
            'gudangs' => $gudangs,
            'mitras' => $mitras,
            'sudahFilter' => $sudahFilter,
        ]);
    }

    public function exportExcel(Request $request)
    {
        $jenis = $request->input('jenis', 'ba_rampung');
        if (! array_key_exists($jenis, self::JENIS_LABEL)) {
            $jenis = 'ba_rampung';
        }

        $filters = $request->only(['gudang_id', 'mitra_pengolahan_id', 'bulan', 'tahun']);
        [$headings, $rows] = $this->buildData($jenis, $filters);

        ActivityLogger::log('Export Excel Laporan', 'laporan', null, self::JENIS_LABEL[$jenis]);

        $namaBulan = ! empty($filters['bulan']) ? \Carbon\Carbon::create()->month((int) $filters['bulan'])->translatedFormat('F') : 'Semua';
        $tahun = $filters['tahun'] ?? now()->year;
        $fileName = str_replace(' ', '_', self::JENIS_LABEL[$jenis]) . "_{$namaBulan}_{$tahun}.xlsx";

        return \Maatwebsite\Excel\Facades\Excel::download(new LaporanExport($jenis, $rows, $headings), $fileName);
    }

    public function exportPdf(Request $request)
    {
        $jenis = $request->input('jenis', 'ba_rampung');
        if (! array_key_exists($jenis, self::JENIS_LABEL)) {
            $jenis = 'ba_rampung';
        }

        $filters = $request->only(['gudang_id', 'mitra_pengolahan_id', 'bulan', 'tahun']);
        [$headings, $rows] = $this->buildData($jenis, $filters);

        ActivityLogger::log('Export PDF Laporan', 'laporan', null, self::JENIS_LABEL[$jenis]);

        $judul = self::JENIS_LABEL[$jenis];
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.laporan', compact('judul', 'headings', 'rows'))
            ->setPaper('a4', 'landscape');

        return $pdf->stream(str_replace(' ', '_', $judul) . '.pdf');
    }

    /**
     * Builds [headings, rows] for the given report type. All aggregation
     * (SUM/COUNT/GROUP BY) happens in the database — rows never exceed
     * what's actually needed for display/export.
     */
    private function buildData(string $jenis, array $filters): array
    {
        return match ($jenis) {
            'per_gudang' => $this->laporanPerGudang($filters),
            'per_mitra' => $this->laporanPerMitra($filters),
            'status_pbp' => $this->laporanStatusPbp($filters),
            'catatan' => $this->laporanCatatan($filters),
            default => $this->laporanBaRampung($filters),
        };
    }

    private function applyFilters($query, array $filters)
    {
        if (! empty($filters['gudang_id'])) {
            $query->where('gudang_id', $filters['gudang_id']);
        }
        if (! empty($filters['mitra_pengolahan_id'])) {
            $query->where('mitra_pengolahan_id', $filters['mitra_pengolahan_id']);
        }
        if (! empty($filters['bulan'])) {
            $query->whereMonth('tanggal_ba', $filters['bulan']);
        }
        if (! empty($filters['tahun'])) {
            $query->whereYear('tanggal_ba', $filters['tahun']);
        }

        return $query;
    }

    private function laporanBaRampung(array $filters): array
    {
        $rows = $this->applyFilters(BaRampung::with(['gudang', 'mitraPengolahan']), $filters)
            ->orderByDesc('tanggal_ba')
            ->get()
            ->map(fn ($ba, $i) => [
                $i + 1,
                $ba->nomor_ba,
                $ba->tanggal_ba->format('d/m/Y'),
                $ba->gudang->nama_gudang,
                $ba->mitraPengolahan->nama_mitra,
                $ba->statusLabel(),
                $ba->statusPbpLabel(),
            ]);

        return [['No.', 'Nomor BA', 'Tanggal', 'Gudang', 'Mitra Pengolahan', 'Status', 'Status PBP'], $rows];
    }

    private function laporanPerGudang(array $filters): array
    {
        $query = $this->applyFilters(BaRampung::query(), $filters)
            ->join('gudangs', 'gudangs.id', '=', 'ba_rampungs.gudang_id')
            ->select(
                'gudangs.nama_gudang',
                DB::raw('COUNT(*) as total_ba'),
                DB::raw("SUM(CASE WHEN ba_rampungs.status IN ('terverifikasi','selesai') THEN 1 ELSE 0 END) as terverifikasi"),
                DB::raw("SUM(CASE WHEN ba_rampungs.status = 'ditolak' THEN 1 ELSE 0 END) as ditolak")
            )
            ->groupBy('gudangs.nama_gudang')
            ->orderBy('gudangs.nama_gudang')
            ->get();

        $rows = $query->map(fn ($r, $i) => [$i + 1, $r->nama_gudang, $r->total_ba, $r->terverifikasi, $r->ditolak]);

        return [['No.', 'Gudang', 'Total BA', 'Terverifikasi', 'Ditolak'], $rows];
    }

    private function laporanPerMitra(array $filters): array
    {
        $query = $this->applyFilters(BaRampung::query(), $filters)
            ->join('mitra_pengolahans', 'mitra_pengolahans.id', '=', 'ba_rampungs.mitra_pengolahan_id')
            ->select(
                'mitra_pengolahans.nama_mitra',
                DB::raw('COUNT(*) as total_ba'),
                DB::raw("SUM(CASE WHEN ba_rampungs.status IN ('terverifikasi','selesai') THEN 1 ELSE 0 END) as terverifikasi"),
                DB::raw("SUM(CASE WHEN ba_rampungs.status = 'ditolak' THEN 1 ELSE 0 END) as ditolak")
            )
            ->groupBy('mitra_pengolahans.nama_mitra')
            ->orderBy('mitra_pengolahans.nama_mitra')
            ->get();

        $rows = $query->map(fn ($r, $i) => [$i + 1, $r->nama_mitra, $r->total_ba, $r->terverifikasi, $r->ditolak]);

        return [['No.', 'Mitra Pengolahan', 'Total BA', 'Terverifikasi', 'Ditolak'], $rows];
    }

    private function laporanStatusPbp(array $filters): array
    {
        $query = $this->applyFilters(BaRampung::query(), $filters)
            ->select('status_pbp', DB::raw('COUNT(*) as jumlah'))
            ->groupBy('status_pbp')
            ->get();

        $rows = $query->map(fn ($r, $i) => [$i + 1, BaRampung::STATUS_PBP[$r->status_pbp] ?? $r->status_pbp, $r->jumlah]);

        return [['No.', 'Status PBP', 'Jumlah'], $rows];
    }

    private function laporanCatatan(array $filters): array
    {
        $rows = $this->applyFilters(BaRampung::with(['gudang', 'mitraPengolahan']), $filters)
            ->whereNotNull('catatan')
            ->orderByDesc('tanggal_ba')
            ->get()
            ->map(fn ($ba, $i) => [
                $i + 1,
                $ba->nomor_ba,
                $ba->tanggal_ba->format('d/m/Y'),
                $ba->gudang->nama_gudang,
                $ba->catatan,
            ]);

        return [['No.', 'Nomor BA', 'Tanggal', 'Gudang', 'Catatan'], $rows];
    }
}
