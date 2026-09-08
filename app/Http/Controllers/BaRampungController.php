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

        // =====================================================
        // ADMIN GUDANG
        // Hanya boleh melihat BA dari gudangnya sendiri
        // =====================================================

        if ($user->isAdminGudang()) {
            if (! $user->gudang_id) {
                $query->whereRaw('1 = 0');
            } else {
                $query->where(
                    'gudang_id',
                    $user->gudang_id
                );
            }
        }

        // =====================================================
        // SEARCH
        // =====================================================

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

        // =====================================================
        // FILTER STATUS
        // =====================================================

        if ($status = $request->input('status')) {
            $query->where(
                'status',
                $status
            );
        }

        // =====================================================
        // FILTER GUDANG
        // =====================================================

        if (
            ! $user->isAdminGudang()
            && ($gudangId = $request->input('gudang_id'))
        ) {
            $query->where(
                'gudang_id',
                $gudangId
            );
        }

        // =====================================================
        // FILTER MITRA
        // =====================================================

        if ($mitraId = $request->input('mitra_pengolahan_id')) {
            $query->where(
                'mitra_pengolahan_id',
                $mitraId
            );
        }

        // =====================================================
        // FILTER BULAN
        // =====================================================

        if ($bulan = $request->input('bulan')) {
            $query->whereMonth(
                'tanggal_ba',
                $bulan
            );
        }

        // =====================================================
        // FILTER TAHUN
        // =====================================================

        if ($tahun = $request->input('tahun')) {
            $query->whereYear(
                'tanggal_ba',
                $tahun
            );
        }

        // =====================================================
        // DATA BA
        // =====================================================

        $baList = $query
            ->latest('tanggal_ba')
            ->paginate(10)
            ->withQueryString();

        // =====================================================
        // KPI
        // =====================================================

        $kpiBase = BaRampung::query();

        if ($user->isAdminGudang()) {
            if (! $user->gudang_id) {
                $kpiBase->whereRaw('1 = 0');
            } else {
                $kpiBase->where(
                    'gudang_id',
                    $user->gudang_id
                );
            }
        }

        $kpi = [

            'total' => (clone $kpiBase)
                ->count(),

            'terverifikasi' => (clone $kpiBase)
                ->whereIn(
                    'status',
                    [
                        BaRampung::STATUS_TERVERIFIKASI,
                        BaRampung::STATUS_SELESAI,
                    ]
                )
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

        // =====================================================
        // DATA GUDANG
        // =====================================================

        if ($user->isAdminGudang()) {

            $gudangs = Gudang::aktif()
                ->where(
                    'id',
                    $user->gudang_id
                )
                ->orderBy('nama_gudang')
                ->get();

        } else {

            $gudangs = Gudang::aktif()
                ->orderBy('nama_gudang')
                ->get();
        }

        // =====================================================
        // DATA MITRA
        // =====================================================

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

        $user = request()->user();

        // Admin Gudang hanya melihat gudangnya sendiri
        if ($user->isAdminGudang()) {

            if (! $user->gudang_id) {
                abort(
                    403,
                    'Akun Admin Gudang belum memiliki gudang.'
                );
            }

            $gudangs = Gudang::aktif()
                ->where(
                    'id',
                    $user->gudang_id
                )
                ->orderBy('nama_gudang')
                ->get();

        } else {

            $gudangs = Gudang::aktif()
                ->orderBy('nama_gudang')
                ->get();
        }

        $mitras = MitraPengolahan::aktif()
            ->orderBy('nama_mitra')
            ->get();

        $pimpinans = PimpinanCabang::aktif()
            ->orderBy('nama')
            ->get();

        $pegawais = \App\Models\Pegawai::aktif()
            ->orderBy('nama')
            ->get();

        $pengaturan = \App\Models\Pengaturan::first();
        
        // Riwayat penandatangan Pihak Kesatu
        $penandatanganKesatu = BaRampung::query()
            ->whereNotNull('nama_penandatangan')
            ->whereNotNull('jabatan_penandatangan')
            ->select('nama_penandatangan', 'jabatan_penandatangan')
            ->distinct()
            ->orderBy('nama_penandatangan')
            ->get();

        // Riwayat penandatangan Pihak Kedua
        $penandatanganKedua = BaRampung::query()
            ->whereNotNull('nama_penandatangan_pihak_kedua')
            ->whereNotNull('jabatan_penandatangan_pihak_kedua')
            ->select(
                'nama_penandatangan_pihak_kedua',
                'jabatan_penandatangan_pihak_kedua'
            )
            ->distinct()
            ->orderBy('nama_penandatangan_pihak_kedua')
            ->get();

        return view(
            'ba-rampung.create',
            compact(
                'gudangs',
                'mitras',
                'pimpinans',
                'pegawais',
                'pengaturan',
                'penandatanganKesatu',
                'penandatanganKedua'
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

        $user = $request->user();

        // =====================================================
        // ADMIN GUDANG
        // Gudang BA otomatis mengikuti gudang akun login
        // =====================================================

        if ($user->isAdminGudang()) {

            if (! $user->gudang_id) {
                abort(
                    403,
                    'Akun Admin Gudang belum memiliki gudang.'
                );
            }

            $data['gudang_id'] = $user->gudang_id;
        }

        $tanggal = \Carbon\Carbon::parse(
            $data['tanggal_ba']
        );

        $pengaturan = \App\Models\Pengaturan::first();
$suffix = $pengaturan?->suffix_nomor_ba ?: 'GKP';

        $ba = DB::transaction(
            function () use (
    $data,
    $tanggal,
    $request,
    $suffix
) {

                // =================================================
                // NOMOR BA OTOMATIS
                // =================================================

                $nomorBa = BaRampung::generateNomorBa(
                    $tanggal
                );

                // =================================================
                // SIMPAN BA
                // =================================================

                $ba = BaRampung::create([

                    'nomor_ba' =>
                        $nomorBa,

                    'tanggal_ba' =>
                        $tanggal,

                    'hari' =>
                        $tanggal->translatedFormat('l'),

                    'bulan' =>
                        $tanggal->translatedFormat('F'),

                    'tahun' =>
                        $tanggal->year,

                    'nomor_mo' =>
                        $data['nomor_mo'] ?? null,

                    'nomor_po' =>
                        $data['nomor_po'] ?? null,

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

                    // Status
                    'status' =>
                        $data['action'] === 'submit'
                            ? BaRampung::STATUS_MENUNGGU_VERIFIKASI
                            : BaRampung::STATUS_DRAFT,

                    'catatan' =>
                        $data['catatan'] ?? null,

                    'created_by' =>
                        $request->user()->id,
                ]);

                // =================================================
                // SIMPAN PRODUKSI
                // =================================================

                $this->simpanProduksi(
                    $ba,
                    $data
                );

                return $ba;
            }
        );

        // =====================================================
        // LOG AKTIVITAS
        // =====================================================

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

        $user = request()->user();

        // =====================================================
        // ADMIN GUDANG
        // Hanya gudang sendiri
        // =====================================================

        if ($user->isAdminGudang()) {

            if (! $user->gudang_id) {
                abort(
                    403,
                    'Akun Admin Gudang belum memiliki gudang.'
                );
            }

            if (
                $baRampung->gudang_id
                !== $user->gudang_id
            ) {
                abort(
                    403,
                    'Anda tidak memiliki akses ke BA Rampung ini.'
                );
            }

            $gudangs = Gudang::aktif()
                ->where(
                    'id',
                    $user->gudang_id
                )
                ->orderBy('nama_gudang')
                ->get();

        } else {

            $gudangs = Gudang::aktif()
                ->orderBy('nama_gudang')
                ->get();
        }

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

        $user = $request->user();

        // =====================================================
        // ADMIN GUDANG
        // =====================================================

        if ($user->isAdminGudang()) {

            if (! $user->gudang_id) {
                abort(
                    403,
                    'Akun Admin Gudang belum memiliki gudang.'
                );
            }

            // Pastikan BA memang milik gudangnya
            if (
                $baRampung->gudang_id
                !== $user->gudang_id
            ) {
                abort(
                    403,
                    'Anda tidak memiliki akses ke BA Rampung ini.'
                );
            }

            // Gudang tidak boleh dipindahkan
            $data['gudang_id'] =
                $user->gudang_id;
        }

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

                    'tanggal_ba' =>
                        $tanggal,

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

                    // Status
                    'status' =>
                        $data['action'] === 'submit'
                            ? BaRampung::STATUS_MENUNGGU_VERIFIKASI
                            : BaRampung::STATUS_DRAFT,

                    'catatan' =>
                        $data['catatan'] ?? null,
                ]);

                // =================================================
                // HAPUS PRODUKSI LAMA
                // =================================================

                $baRampung
                    ->produksis()
                    ->delete();

                // =================================================
                // SIMPAN PRODUKSI BARU
                // =================================================

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

        $nomor =
            $baRampung->nomor_ba;

        $id =
            $baRampung->id;

        $baRampung->delete();

        ActivityLogger::log(
            'Menghapus BA Rampung',
            'ba_rampung',
            $id,
            "Nomor BA: {$nomor}"
        );

        return redirect()
            ->route(
                'ba-rampung.index'
            )
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

        Gate::authorize(
            'verify',
            $baRampung
        );

        $data =
            $request->validated();

        if (
            $data['keputusan']
            === 'terima'
        ) {

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

    public function export(
        Request $request
    ) {

        Gate::authorize(
            'viewAny',
            BaRampung::class
        );

        $user =
            $request->user();

        $filters =
            $request->only([
                'search',
                'status',
                'gudang_id',
                'mitra_pengolahan_id',
                'bulan',
                'tahun',
            ]);

        // =====================================================
        // ADMIN GUDANG
        // Export hanya gudangnya sendiri
        // =====================================================

        if ($user->isAdminGudang()) {

            if (! $user->gudang_id) {
                abort(
                    403,
                    'Akun Admin Gudang belum memiliki gudang.'
                );
            }

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
            new \App\Exports\BaRampungExport(
                $filters
            ),
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

        $beras =
            $baRampung->produksis
                ->firstWhere(
                    'produk_sesudah',
                    'Beras (HGL)'
                );

        $menir =
            $baRampung->produksis
                ->firstWhere(
                    'produk_sesudah',
                    'Menir'
                );

        $bekatul =
            $baRampung->produksis
                ->firstWhere(
                    'produk_sesudah',
                    'Bekatul'
                );

        $gabah =
            (float) (
                $beras->kuantum_sebelum
                ?? 0
            );

        $kuantumBeras =
            (float) (
                $beras->kuantum_sesudah
                ?? 0
            );

        $kuantumMenir =
            (float) (
                $menir->kuantum_sesudah
                ?? 0
            );

        $kuantumBekatul =
            (float) (
                $bekatul->kuantum_sesudah
                ?? 0
            );

        // =====================================================
        // NAMA FILE
        // =====================================================

        $namaFile =
            preg_replace(
                '/[\/\\\\:*?"<>|]+/',
                '-',
                $baRampung->nomor_ba
            );

        $namaFile =
            preg_replace(
                '/\s*-\s*/',
                '-',
                $namaFile
            );

        $namaFile =
            trim(
                $namaFile,
                " .-"
            );

        if (! $namaFile) {
            $namaFile =
                'BA-Rampung-' .
                $baRampung->id;
        }

        // =====================================================
        // FOLDER TEMPLATE
        // =====================================================

        $templatePath =
            storage_path(
                'app/templates/template-ba-rampung.docx'
            );

        if (! File::exists($templatePath)) {
            abort(
                500,
                'Template Word tidak ditemukan: '
                . $templatePath
            );
        }

        // =====================================================
        // FOLDER TEMP
        // =====================================================

        $tempDir =
            storage_path(
                'app/temp-ba-rampung'
            );

        if (! File::exists($tempDir)) {
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

        $template =
            new TemplateProcessor(
                $templatePath
            );

        // =====================================================
        // DATA BA
        // =====================================================

        $nomorBa =
            $baRampung->nomor_ba
            ?? '';

        $nomorBaBagian =
            '-';

        if (
            preg_match(
                '/BA\s*-\s*(\d+)/',
                $nomorBa,
                $match
            )
        ) {
            $nomorBaBagian =
                $match[1];
        }

        $template->setValue(
            'nomor_ba_bagian',
            $nomorBaBagian
        );

        $template->setValue(
            'nomor_ba_bulan',
            $baRampung->tanggal_ba
                ? $baRampung->tanggal_ba->format('m')
                : '-'
        );

        $template->setValue(
            'nomor_ba_tahun',
            $baRampung->tanggal_ba
                ? $baRampung->tanggal_ba->format('Y')
                : '-'
        );

        $template->setValue(
    'suffix_nomor_ba',
    \App\Models\Pengaturan::first()?->suffix_nomor_ba ?? 'GKP'
);

        $template->setValue(
            'hari',
            $baRampung->tanggal_ba
                ? $baRampung->tanggal_ba
                    ->locale('id')
                    ->translatedFormat('l')
                : '-'
        );

        $template->setValue(
            'tanggal',
            $baRampung->tanggal_ba
                ? $baRampung->tanggal_ba->format('d')
                : '-'
        );

        $template->setValue(
            'bulan',
            $baRampung->tanggal_ba
                ? $baRampung->tanggal_ba
                    ->locale('id')
                    ->translatedFormat('F')
                : '-'
        );

        $template->setValue(
            'tahun',
            $baRampung->tahun
            ?? '-'
        );

        $template->setValue(
            'nomor_mo',
            $baRampung->nomor_mo
            ?? '-'
        );

        $template->setValue(
            'nomor_po',
            $baRampung->nomor_po
            ?? '-'
        );

        // =====================================================
        // GUDANG
        // =====================================================

        $template->setValue(
            'nama_gudang',
            $baRampung->gudang->nama_gudang
            ?? '-'
        );

        $template->setValue(
            'alamat_gudang',
            $baRampung->gudang->alamat
            ?? ''
        );

        // =====================================================
        // MITRA
        // =====================================================

        $template->setValue(
            'nama_mitra',
            $baRampung->mitraPengolahan->nama_mitra
            ?? '-'
        );

        $template->setValue(
            'alamat_mitra',
            $baRampung->mitraPengolahan->alamat
            ?? ''
        );

        // =====================================================
        // PRODUKSI
        // =====================================================

        $template->setValue(
            'kuantum_gabah',
            number_format(
                $gabah,
                0,
                ',',
                '.'
            )
        );

        $template->setValue(
            'kuantum_beras',
            number_format(
                $kuantumBeras,
                0,
                ',',
                '.'
            )
        );

        $template->setValue(
            'kuantum_menir',
            number_format(
                $kuantumMenir,
                0,
                ',',
                '.'
            )
        );

        $template->setValue(
            'kuantum_bekatul',
            number_format(
                $kuantumBekatul,
                0,
                ',',
                '.'
            )
        );

        // =====================================================
        // RENDEMEN
        // =====================================================

        $template->setValue(
            'rendemen_beras',
            number_format(
                (float) (
                    $beras->rendemen
                    ?? 0
                ),
                2,
                ',',
                '.'
            )
        );

        $template->setValue(
            'rendemen_menir',
            number_format(
                (float) (
                    $menir->rendemen
                    ?? 0
                ),
                2,
                ',',
                '.'
            )
        );

        $template->setValue(
            'rendemen_bekatul',
            number_format(
                (float) (
                    $bekatul->rendemen
                    ?? 0
                ),
                2,
                ',',
                '.'
            )
        );

        // =====================================================
        // PIHAK KESATU - GUDANG
        // =====================================================

        $template->setValue(
            'nama_penandatangan',
            $baRampung->nama_penandatangan
            ?? '-'
        );

        $template->setValue(
            'jabatan_penandatangan',
            $baRampung->jabatan_penandatangan
            ?? '-'
        );

        // =====================================================
        // PIHAK KEDUA - MITRA PENGOLAHAN
        // =====================================================

        $template->setValue(
            'nama_penandatangan_pihak_kedua',
            $baRampung->nama_penandatangan_pihak_kedua
            ?? '-'
        );

        $template->setValue(
            'jabatan_penandatangan_pihak_kedua',
            $baRampung->jabatan_penandatangan_pihak_kedua
            ?? '-'
        );

        // =====================================================
        // PIMPINAN CABANG
        // =====================================================

        $template->setValue(
            'nama_pimpinan',
            $baRampung->pimpinanCabang->nama
            ?? '-'
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
            $baRampung->catatan
            ?? ''
        );

        // =====================================================
        // TANGGAL TTD
        // =====================================================

        $template->setValue(
            'tanggal_ttd_hari',
            $baRampung->tanggal_ba
                ? $baRampung->tanggal_ba->format('d')
                : now()->format('d')
        );

        $template->setValue(
            'tanggal_ttd_bulan',
            $baRampung->tanggal_ba
                ? $baRampung->tanggal_ba->format('m')
                : now()->format('m')
        );

        $template->setValue(
            'tanggal_ttd_tahun',
            $baRampung->tanggal_ba
                ? $baRampung->tanggal_ba->format('Y')
                : now()->format('Y')
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

        foreach (
            $libreOfficeCandidates
            as $candidate
        ) {

            if (
                File::exists(
                    $candidate
                )
            ) {
                $libreOffice =
                    $candidate;

                break;
            }
        }

        if (! $libreOffice) {

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
            || ! File::exists(
                $pdfPath
            )
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

        foreach (
            $rows
            as $row
        ) {

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