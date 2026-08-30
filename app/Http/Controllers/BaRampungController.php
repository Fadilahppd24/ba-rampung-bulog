<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBaRampungRequest;
use App\Http\Requests\UpdateBaRampungRequest;
use App\Http\Requests\VerifyBaRampungRequest;
use App\Models\BaRampung;
use App\Models\Gudang;
use App\Models\MitraPengolahan;
use App\Models\PimpinanCabang;
use App\Services\ActivityLogger;
use App\Services\RendemenCalculator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use PhpOffice\PhpWord\TemplateProcessor;

class BaRampungController extends Controller
{
    // =========================================================
    // INDEX
    // =========================================================

    public function index(Request $request): View
    {
        Gate::authorize('viewAny', BaRampung::class);

        $user = $request->user();

        $query = BaRampung::with([
            'gudang',
            'mitraPengolahan',
        ]);

        // Admin Gudang hanya melihat BA gudangnya sendiri
        if ($user->isAdminGudang() && $user->gudang_id) {
            $query->where(
                'gudang_id',
                $user->gudang_id
            );
        }

        // Search
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {

                $q->where(
                    'nomor_ba',
                    'like',
                    "%{$search}%"
                )

                ->orWhereHas('gudang', function ($g) use ($search) {
                    $g->where(
                        'nama_gudang',
                        'like',
                        "%{$search}%"
                    );
                })

                ->orWhereHas('mitraPengolahan', function ($m) use ($search) {
                    $m->where(
                        'nama_mitra',
                        'like',
                        "%{$search}%"
                    );
                });
            });
        }

        // Filter status
        if ($status = $request->input('status')) {
            $query->where(
                'status',
                $status
            );
        }

        // Filter gudang
        if ($gudangId = $request->input('gudang_id')) {
            $query->where(
                'gudang_id',
                $gudangId
            );
        }

        // Filter mitra
        if ($mitraId = $request->input('mitra_pengolahan_id')) {
            $query->where(
                'mitra_pengolahan_id',
                $mitraId
            );
        }

        // Filter bulan
        if ($bulan = $request->input('bulan')) {
            $query->whereMonth(
                'tanggal_ba',
                $bulan
            );
        }

        // Filter tahun
        if ($tahun = $request->input('tahun')) {
            $query->whereYear(
                'tanggal_ba',
                $tahun
            );
        }

        $baList = $query
            ->latest('tanggal_ba')
            ->paginate(10)
            ->withQueryString();

        // =====================================================
        // KPI
        // =====================================================

        $kpiBase = BaRampung::query();

        if ($user->isAdminGudang() && $user->gudang_id) {
            $kpiBase->where(
                'gudang_id',
                $user->gudang_id
            );
        }

        $kpi = [

            'total' => (clone $kpiBase)->count(),

            'terverifikasi' => (clone $kpiBase)
                ->whereIn('status', [
                    BaRampung::STATUS_TERVERIFIKASI,
                    BaRampung::STATUS_SELESAI,
                ])
                ->count(),

            'belum_serah' => (clone $kpiBase)
                ->where(
                    'status',
                    BaRampung::STATUS_MENUNGGU_VERIFIKASI
                )
                ->count(),

            'ditolak' => (clone $kpiBase)
                ->where(
                    'status',
                    BaRampung::STATUS_DITOLAK
                )
                ->count(),

            'mitra' => MitraPengolahan::aktif()->count(),
        ];

        $gudangs = Gudang::aktif()
            ->orderBy('nama_gudang')
            ->get();

        $mitras = MitraPengolahan::aktif()
            ->orderBy('nama_mitra')
            ->get();

        return view(
            'ba-rampung.index',
            compact(
                'baList',
                'kpi',
                'gudangs',
                'mitras'
            )
        );
    }


    // =========================================================
    // CREATE
    // =========================================================

    public function create(): View
    {
        Gate::authorize(
            'create',
            BaRampung::class
        );

        $gudangs = Gudang::aktif()
            ->orderBy('nama_gudang')
            ->get();

        $mitras = MitraPengolahan::aktif()
            ->orderBy('nama_mitra')
            ->get();

        $pimpinans = PimpinanCabang::aktif()
            ->orderBy('nama')
            ->get();

        $pegawais = \App\Models\Pegawai::aktif()
            ->orderBy('nama')
            ->get();

        return view(
            'ba-rampung.create',
            compact(
                'gudangs',
                'mitras',
                'pimpinans',
                'pegawais'
            )
        );
    }


    // =========================================================
    // STORE
    // =========================================================

    public function store(
        StoreBaRampungRequest $request
    ): RedirectResponse {

        $data = $request->validated();

        $tanggal = \Carbon\Carbon::parse(
            $data['tanggal_ba']
        );

        $ba = DB::transaction(
            function () use (
                $data,
                $tanggal,
                $request
            ) {

                // Nomor BA dibuat otomatis
                $nomorBa = BaRampung::generateNomorBa(
                    $tanggal
                );

                $ba = BaRampung::create([

                    'nomor_ba' => $nomorBa,

                    'tanggal_ba' => $tanggal,

                    'hari' => $tanggal->translatedFormat('l'),

                    'bulan' => $tanggal->translatedFormat('F'),

                    'tahun' => $tanggal->year,

                    'nomor_mo' => $data['nomor_mo'] ?? null,

                    'nomor_po' => $data['nomor_po'] ?? null,

                    'gudang_id' => $data['gudang_id'],

                    'mitra_pengolahan_id' =>
                        $data['mitra_pengolahan_id'],

                    // Pihak Kesatu
                    'nama_penandatangan' =>
                        $data['nama_penandatangan'],

                    'jabatan_penandatangan' =>
                        $data['jabatan_penandatangan'],

                    // Pihak Kedua
                    'nama_penandatangan_pihak_kedua' =>
                        $data['nama_penandatangan_pihak_kedua'],

                    'jabatan_penandatangan_pihak_kedua' =>
                        $data['jabatan_penandatangan_pihak_kedua'],

                    // Mengetahui
                    'pimpinan_cabang_id' =>
                        $data['pimpinan_cabang_id'],

                    'status' =>
                        $data['action'] === 'submit'
                            ? BaRampung::STATUS_MENUNGGU_VERIFIKASI
                            : BaRampung::STATUS_DRAFT,

                    'catatan' =>
                        $data['catatan'] ?? null,

                    'created_by' =>
                        $request->user()->id,
                ]);

                $this->simpanProduksi(
                    $ba,
                    $data
                );

                return $ba;
            }
        );

        ActivityLogger::log(
            'Membuat BA Rampung',
            'ba_rampung',
            $ba->id,
            "Nomor BA: {$ba->nomor_ba}"
        );

        return redirect()
            ->route(
                'ba-rampung.show',
                $ba
            )
            ->with(
                'success',
                "BA Rampung {$ba->nomor_ba} berhasil disimpan."
            );
    }


    // =========================================================
    // SHOW
    // =========================================================

    public function show(
        BaRampung $baRampung
    ): View {

        Gate::authorize(
            'view',
            $baRampung
        );

        $baRampung->load([
            'gudang',
            'mitraPengolahan',
            'pimpinanCabang',
            'pembuat',
            'verifikator',
            'produksis',
        ]);

        return view(
            'ba-rampung.show',
            compact('baRampung')
        );
    }


    // =========================================================
    // EDIT
    // =========================================================

    public function edit(
        BaRampung $baRampung
    ): View {

        Gate::authorize(
            'update',
            $baRampung
        );

        $baRampung->load(
            'produksis'
        );

        $gudangs = Gudang::aktif()
            ->orderBy('nama_gudang')
            ->get();

        $mitras = MitraPengolahan::aktif()
            ->orderBy('nama_mitra')
            ->get();

        $pimpinans = PimpinanCabang::aktif()
            ->orderBy('nama')
            ->get();

        $pegawais = \App\Models\Pegawai::aktif()
            ->orderBy('nama')
            ->get();

        return view(
            'ba-rampung.edit',
            compact(
                'baRampung',
                'gudangs',
                'mitras',
                'pimpinans',
                'pegawais'
            )
        );
    }


    // =========================================================
    // UPDATE
    // =========================================================

    public function update(
        UpdateBaRampungRequest $request,
        BaRampung $baRampung
    ): RedirectResponse {

        $data = $request->validated();

        $tanggal = \Carbon\Carbon::parse(
            $data['tanggal_ba']
        );

        DB::transaction(
            function () use (
                $data,
                $tanggal,
                $baRampung
            ) {

                $baRampung->update([

                    'tanggal_ba' => $tanggal,

                    'hari' =>
                        $tanggal->translatedFormat('l'),

                    'bulan' =>
                        $tanggal->translatedFormat('F'),

                    'tahun' =>
                        $tanggal->year,

                    'nomor_mo' =>
                        $data['nomor_mo'],

                    'nomor_po' =>
                        $data['nomor_po'],

                    'gudang_id' =>
                        $data['gudang_id'],

                    'mitra_pengolahan_id' =>
                        $data['mitra_pengolahan_id'],

                    // Pihak Kesatu
                    'nama_penandatangan' =>
                        $data['nama_penandatangan'],

                    'jabatan_penandatangan' =>
                        $data['jabatan_penandatangan'],

                    // Pihak Kedua
                    'nama_penandatangan_pihak_kedua' =>
                        $data['nama_penandatangan_pihak_kedua'],

                    'jabatan_penandatangan_pihak_kedua' =>
                        $data['jabatan_penandatangan_pihak_kedua'],

                    // Mengetahui
                    'pimpinan_cabang_id' =>
                        $data['pimpinan_cabang_id'],

                    'status' =>
                        $data['action'] === 'submit'
                            ? BaRampung::STATUS_MENUNGGU_VERIFIKASI
                            : BaRampung::STATUS_DRAFT,

                    'catatan' =>
                        $data['catatan'] ?? null,
                ]);

                // Hapus produksi lama
                $baRampung
                    ->produksis()
                    ->delete();

                // Simpan produksi baru
                $this->simpanProduksi(
                    $baRampung,
                    $data
                );
            }
        );

        ActivityLogger::log(
            'Mengubah BA Rampung',
            'ba_rampung',
            $baRampung->id,
            "Nomor BA: {$baRampung->nomor_ba}"
        );

        return redirect()
            ->route(
                'ba-rampung.show',
                $baRampung
            )
            ->with(
                'success',
                "BA Rampung {$baRampung->nomor_ba} berhasil diperbarui."
            );
    }


    // =========================================================
    // DELETE
    // =========================================================

    public function destroy(
        BaRampung $baRampung
    ): RedirectResponse {

        Gate::authorize(
            'delete',
            $baRampung
        );

        $nomor = $baRampung->nomor_ba;
        $id = $baRampung->id;

        $baRampung->delete();

        ActivityLogger::log(
            'Menghapus BA Rampung',
            'ba_rampung',
            $id,
            "Nomor BA: {$nomor}"
        );

        return redirect()
            ->route('ba-rampung.index')
            ->with(
                'success',
                "BA Rampung {$nomor} berhasil dihapus."
            );
    }


    // =========================================================
    // VERIFY
    // =========================================================

    public function verify(
        VerifyBaRampungRequest $request,
        BaRampung $baRampung
    ): RedirectResponse {

        $data = $request->validated();

        if ($data['keputusan'] === 'terima') {

            $baRampung->update([

                'status' =>
                    BaRampung::STATUS_TERVERIFIKASI,

                'verified_by' =>
                    $request->user()->id,

                'verified_at' =>
                    now(),

                'alasan_penolakan' =>
                    null,
            ]);

            ActivityLogger::log(
                'Verifikasi BA Rampung',
                'ba_rampung',
                $baRampung->id,
                "BA {$baRampung->nomor_ba} diterima."
            );

            $pesan =
                "BA Rampung {$baRampung->nomor_ba} berhasil diverifikasi.";

        } else {

            $baRampung->update([

                'status' =>
                    BaRampung::STATUS_DITOLAK,

                'verified_by' =>
                    $request->user()->id,

                'verified_at' =>
                    now(),

                'alasan_penolakan' =>
                    $data['alasan_penolakan'],
            ]);

            ActivityLogger::log(
                'Menolak BA Rampung',
                'ba_rampung',
                $baRampung->id,
                "BA {$baRampung->nomor_ba} ditolak: {$data['alasan_penolakan']}"
            );

            $pesan =
                "BA Rampung {$baRampung->nomor_ba} ditolak.";
        }

        return redirect()
            ->route(
                'ba-rampung.show',
                $baRampung
            )
            ->with(
                'success',
                $pesan
            );
    }


    // =========================================================
    // EXPORT EXCEL
    // =========================================================

    public function export(Request $request)
    {
        Gate::authorize(
            'viewAny',
            BaRampung::class
        );

        $user = $request->user();

        $filters = $request->only([
            'search',
            'status',
            'gudang_id',
            'mitra_pengolahan_id',
            'bulan',
            'tahun',
        ]);

        if (
            $user->isAdminGudang()
            && $user->gudang_id
        ) {
            $filters['gudang_id'] =
                $user->gudang_id;
        }

        ActivityLogger::log(
            'Export Excel BA Rampung',
            'ba_rampung',
            null,
            'Export daftar BA Rampung ke Excel.'
        );

        $namaBulan =
            $filters['bulan'] ?? null
                ? \Carbon\Carbon::create()
                    ->month(
                        (int) $filters['bulan']
                    )
                    ->translatedFormat('F')
                : 'Semua';

        $tahun =
            $filters['tahun']
            ?? now()->year;

        $fileName =
            "Rekap_BA_Rampung_{$namaBulan}_{$tahun}.xlsx";

        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\BaRampungExport($filters),
            $fileName
        );
    }


    // =========================================================
    // PDF DARI TEMPLATE WORD
    // =========================================================

    public function pdf(
        BaRampung $baRampung
    ) {

        Gate::authorize(
            'view',
            $baRampung
        );

        $baRampung->load([
            'gudang',
            'mitraPengolahan',
            'pimpinanCabang',
            'produksis',
        ]);

        ActivityLogger::log(
            'Generate PDF BA Rampung',
            'ba_rampung',
            $baRampung->id,
            "Nomor BA: {$baRampung->nomor_ba}"
        );

        // =====================================================
        // PRODUKSI
        // =====================================================

        $beras = $baRampung->produksis
            ->firstWhere(
                'produk_sesudah',
                'Beras (HGL)'
            );

        $menir = $baRampung->produksis
            ->firstWhere(
                'produk_sesudah',
                'Menir'
            );

        $bekatul = $baRampung->produksis
            ->firstWhere(
                'produk_sesudah',
                'Bekatul'
            );

        $gabah = (float) (
            $beras->kuantum_sebelum ?? 0
        );

        $kuantumBeras = (float) (
            $beras->kuantum_sesudah ?? 0
        );

        $kuantumMenir = (float) (
            $menir->kuantum_sesudah ?? 0
        );

        $kuantumBekatul = (float) (
            $bekatul->kuantum_sesudah ?? 0
        );

        // =====================================================
        // NAMA FILE
        // =====================================================

        $namaFile = preg_replace(
            '/[\/\\\\:*?"<>|]+/',
            '-',
            $baRampung->nomor_ba
        );

        $namaFile = preg_replace(
            '/\s*-\s*/',
            '-',
            $namaFile
        );

        $namaFile = trim(
            $namaFile,
            " .-"
        );

        if (!$namaFile) {
            $namaFile =
                'BA-Rampung-' . $baRampung->id;
        }

        // =====================================================
        // FOLDER TEMPLATE
        // =====================================================

        $templatePath = storage_path(
            'app/templates/template-ba-rampung.docx'
        );

        if (!File::exists($templatePath)) {
            abort(
                500,
                'Template Word tidak ditemukan: '
                . $templatePath
            );
        }

        // =====================================================
        // FOLDER TEMP
        // =====================================================

        $tempDir = storage_path(
            'app/temp-ba-rampung'
        );

        if (!File::exists($tempDir)) {
            File::makeDirectory(
                $tempDir,
                0755,
                true
            );
        }

        // =====================================================
        // FILE DOCX HASIL
        // =====================================================

        $docxPath =
            $tempDir
            . DIRECTORY_SEPARATOR
            . $namaFile
            . '.docx';

        // =====================================================
        // LOAD TEMPLATE
        // =====================================================

        $template = new TemplateProcessor(
            $templatePath
        );

        // =====================================================
        // DATA BA
        // =====================================================

        $template->setValue(
            'nomor_ba',
            $baRampung->nomor_ba ?? '-'
        );

        $template->setValue(
            'hari',
            $baRampung->hari ?? '-'
        );

        $template->setValue(
            'tanggal',
            $baRampung->tanggal_ba
                ? $baRampung->tanggal_ba->format('d')
                : '-'
        );

        $template->setValue(
            'bulan',
            $baRampung->bulan ?? '-'
        );

        $template->setValue(
            'tahun',
            $baRampung->tahun ?? '-'
        );

        $template->setValue(
            'nomor_mo',
            $baRampung->nomor_mo ?? '-'
        );

        $template->setValue(
            'nomor_po',
            $baRampung->nomor_po ?? '-'
        );

        // =====================================================
        // GUDANG
        // =====================================================

        $template->setValue(
            'nama_gudang',
            $baRampung->gudang->nama_gudang ?? '-'
        );

        $template->setValue(
            'alamat_gudang',
            $baRampung->gudang->alamat ?? ''
        );

        // =====================================================
        // MITRA
        // =====================================================

        $template->setValue(
            'nama_mitra',
            $baRampung->mitraPengolahan->nama_mitra ?? '-'
        );

        $template->setValue(
            'alamat_mitra',
            $baRampung->mitraPengolahan->alamat ?? ''
        );

        // =====================================================
        // PRODUKSI
        // =====================================================

        $template->setValue(
            'gabah',
            number_format(
                $gabah,
                2,
                '.',
                ','
            )
        );

        $template->setValue(
            'beras',
            number_format(
                $kuantumBeras,
                2,
                '.',
                ','
            )
        );

        $template->setValue(
            'menir',
            number_format(
                $kuantumMenir,
                2,
                '.',
                ','
            )
        );

        $template->setValue(
            'bekatul',
            number_format(
                $kuantumBekatul,
                2,
                '.',
                ','
            )
        );

        // =====================================================
        // RENDEMEN
        // =====================================================

        $template->setValue(
            'rendemen_beras',
            number_format(
                (float) (
                    $beras->rendemen ?? 0
                ),
                2,
                '.',
                ','
            )
        );

        $template->setValue(
            'rendemen_menir',
            number_format(
                (float) (
                    $menir->rendemen ?? 0
                ),
                2,
                '.',
                ','
            )
        );

        $template->setValue(
            'rendemen_bekatul',
            number_format(
                (float) (
                    $bekatul->rendemen ?? 0
                ),
                2,
                '.',
                ','
            )
        );

        // =====================================================
        // PIHAK KESATU
        // =====================================================

        $template->setValue(
            'nama_pihak_kesatu',
            $baRampung->nama_penandatangan ?? '-'
        );

        $template->setValue(
            'jabatan_pihak_kesatu',
            $baRampung->jabatan_penandatangan ?? ''
        );

        // =====================================================
        // PIHAK KEDUA
        // =====================================================

        $template->setValue(
            'nama_pihak_kedua',
            $baRampung->nama_penandatangan_pihak_kedua ?? '-'
        );

        $template->setValue(
            'jabatan_pihak_kedua',
            $baRampung->jabatan_penandatangan_pihak_kedua ?? ''
        );

        // =====================================================
        // PIMPINAN CABANG
        // =====================================================

        $template->setValue(
            'nama_pimpinan',
            $baRampung->pimpinanCabang->nama ?? '-'
        );

        $template->setValue(
            'jabatan_pimpinan',
            $baRampung->pimpinanCabang->jabatan
                ?? 'Pimpinan Cabang BULOG Indramayu'
        );

        // =====================================================
        // CATATAN
        // =====================================================

        $template->setValue(
            'catatan',
            $baRampung->catatan ?? ''
        );

        // =====================================================
        // TANGGAL TTD
        // =====================================================

        $template->setValue(
            'tanggal_ttd',
            $baRampung->tanggal_ba
                ? $baRampung->tanggal_ba->format('d / m / Y')
                : now()->format('d / m / Y')
        );

        // =====================================================
        // SIMPAN DOCX
        // =====================================================

        $template->saveAs(
            $docxPath
        );

        // =====================================================
        // CARI LIBREOFFICE
        // =====================================================

        $libreOfficeCandidates = [

            'C:\Program Files\LibreOffice\program\soffice.exe',

            'C:\Program Files (x86)\LibreOffice\program\soffice.exe',

        ];

        $libreOffice = null;

        foreach ($libreOfficeCandidates as $candidate) {

            if (File::exists($candidate)) {
                $libreOffice = $candidate;
                break;
            }
        }

        if (!$libreOffice) {

            abort(
                500,
                'LibreOffice tidak ditemukan. Install LibreOffice terlebih dahulu.'
            );
        }

        // =====================================================
        // CONVERT DOCX → PDF
        // =====================================================

        $command =
            '"' . $libreOffice . '"'
            . ' --headless'
            . ' --convert-to pdf'
            . ' --outdir '
            . escapeshellarg($tempDir)
            . ' '
            . escapeshellarg($docxPath)
            . ' 2>&1';

        exec(
            $command,
            $output,
            $returnCode
        );

        // =====================================================
        // PATH PDF
        // =====================================================

        $pdfPath =
            $tempDir
            . DIRECTORY_SEPARATOR
            . $namaFile
            . '.pdf';

        // =====================================================
        // CEK PDF
        // =====================================================

        if (
            $returnCode !== 0
            || !File::exists($pdfPath)
        ) {

            abort(
                500,
                "Gagal mengubah template Word menjadi PDF.\n\n"
                . implode(
                    "\n",
                    $output
                )
            );
        }

        // =====================================================
        // TAMPILKAN PDF
        // =====================================================

        return response()->file(
            $pdfPath,
            [
                'Content-Type' =>
                    'application/pdf',

                'Content-Disposition' =>
                    'inline; filename="'
                    . $namaFile
                    . '.pdf"',
            ]
        );
    }


    // =========================================================
    // SIMPAN PRODUKSI
    // =========================================================

    private function simpanProduksi(
        BaRampung $ba,
        array $data
    ): void {

        $gabah =
            (float) $data['kuantum_gabah'];

        $beras =
            (float) $data['kuantum_beras'];

        $menir =
            (float) (
                $data['kuantum_menir']
                ?? 0
            );

        $bekatul =
            (float) (
                $data['kuantum_bekatul']
                ?? 0
            );

        $rows = [

            [
                'produk_sesudah' =>
                    'Beras (HGL)',

                'kuantum' =>
                    $beras,
            ],

            [
                'produk_sesudah' =>
                    'Menir',

                'kuantum' =>
                    $menir,
            ],

            [
                'produk_sesudah' =>
                    'Bekatul',

                'kuantum' =>
                    $bekatul,
            ],
        ];

        foreach ($rows as $row) {

            $ba->produksis()->create([

                'produk_sebelum' =>
                    'Gabah (GKP)',

                'kuantum_sebelum' =>
                    $gabah,

                'produk_sesudah' =>
                    $row['produk_sesudah'],

                'kuantum_sesudah' =>
                    $row['kuantum'],

                'rendemen' =>
                    RendemenCalculator::hitung(
                        $gabah,
                        $row['kuantum']
                    ),
            ]);
        }
    }
}