<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGudangRequest;
use App\Http\Requests\UpdateGudangRequest;
use App\Models\BaRampung;
use App\Models\Gudang;
use App\Services\ActivityLogger;
use Illuminate\Contracts\Cache\LockTimeoutException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class GudangController extends Controller
{
    public function index(Request $request): View
    {
        $query = Gudang::withCount('baRampungs')
            ->with('gudangInduk');

        // =====================================================
        // FILTER GUDANG UTAMA
        // Menampilkan gudang utama + filial
        // =====================================================

        $gudangUtamaId = $request->input('gudang_utama_id');

        if ($gudangUtamaId) {
            $query->where(function ($q) use ($gudangUtamaId) {
                $q->where('id', $gudangUtamaId)
                    ->orWhere(
                        'gudang_induk_id',
                        $gudangUtamaId
                    );
            });
        }

        // =====================================================
        // SEARCH
        // =====================================================

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where(
                    'nama_gudang',
                    'like',
                    "%{$search}%"
                )
                    ->orWhere(
                        'kode_gudang',
                        'like',
                        "%{$search}%"
                    );
            });
        }

        // =====================================================
        // URUTAN GUDANG
        // =====================================================

        $gudangs = $query
            ->orderByRaw(
                'COALESCE(gudang_induk_id, id)'
            )
            ->orderByRaw(
                'CASE WHEN gudang_induk_id IS NULL THEN 0 ELSE 1 END'
            )
            ->orderBy('nama_gudang')
            ->get();

        // =====================================================
        // KPI
        // =====================================================

        $kpi = [
            'total' => Gudang::count(),

            'aktif' => Gudang::aktif()->count(),

            'total_dokumen' => BaRampung::count(),

            'dengan_proses' => Gudang::whereHas(
                'baRampungs',
                function ($q) {
                    $q->where(
                        'status',
                        BaRampung::STATUS_MENUNGGU_VERIFIKASI
                    );
                }
            )->count(),
        ];

        // =====================================================
        // DATA GUDANG UTAMA
        // =====================================================

        $gudangsUtama = Gudang::whereNull(
            'gudang_induk_id'
        )
            ->orderBy('nama_gudang')
            ->get();

        return view(
            'gudang.index',
            compact(
                'gudangs',
                'gudangsUtama',
                'kpi'
            )
        );
    }

    // =========================================================
    // GENERATE KODE GUDANG OTOMATIS
    //
    // - Utama : GDG-001, GDG-002, ...
    // - Filial: FIL-001, FIL-002, ... (GLOBAL, tidak bergantung induk)
    //
    // Mencari NOMOR TERKECIL yang belum dipakai (bukan MAX + 1),
    // sehingga nomor dari gudang yang sudah dihapus dipakai kembali.
    // =========================================================

    private function generateNextGudangCode(
        string $jenisGudang = 'utama'
    ): string {
        $prefix = $jenisGudang === 'filial' ? 'FIL' : 'GDG';

        $kodeTerpakai = Gudang::where(
            'kode_gudang',
            'like',
            $prefix . '-%'
        )->pluck('kode_gudang');

        // Kumpulkan nomor yang sudah dipakai.
        // Hanya kode berformat persis PREFIX-angka yang dihitung.
        $nomorTerpakai = [];

        foreach ($kodeTerpakai as $kode) {
            if (preg_match(
                '/^' . $prefix . '-(\d+)$/',
                $kode,
                $match
            )) {
                $nomorTerpakai[(int) $match[1]] = true;
            }
        }

        // Cari nomor terkecil yang kosong, mulai dari 1.
        $nomor = 1;

        while (isset($nomorTerpakai[$nomor])) {
            $nomor++;
        }

        return sprintf('%s-%03d', $prefix, $nomor);
    }

    // =========================================================
    // PARSE ALAMAT GUDANG
    //
    // Otomatis mengambil:
    // - Desa
    // - Kecamatan
    //
    // dari alamat yang ditulis user.
    //
    // Contoh:
    // "Desa Tempel Kulon Rt 1 Rw 1 Blok Sana Kecamatan Lelea"
    //
    // menjadi:
    // alamat    = "Rt 1 Rw 1 Blok Sana"
    // desa      = "Tempel Kulon"
    // kecamatan = "Lelea"
    // =========================================================

    private function parseAlamatGudang(array $data): array
    {
        $alamat = trim((string) ($data['alamat'] ?? ''));

        if ($alamat === '') {
            return $data;
        }

        $desa = !empty($data['desa'])
            ? trim($data['desa'])
            : null;

        $kecamatan = !empty($data['kecamatan'])
            ? trim($data['kecamatan'])
            : null;

        // =====================================================
        // DETEKSI DESA
        // =====================================================

        if (empty($desa)) {
            if (preg_match(
                '/\bDesa\s+(.+?)(?=\s+(?:Rt|RT|Rw|RW|Blok|Kec\.?|Kecamatan|Kab\.?|Kabupaten)\b|$)/iu',
                $alamat,
                $match
            )) {
                $desa = trim($match[1]);
            }
        }

        // =====================================================
        // DETEKSI KECAMATAN
        // =====================================================

        if (empty($kecamatan)) {
            if (preg_match(
                '/\b(?:Kec\.?|Kecamatan)\s+(.+?)(?=\s+(?:Kab\.?|Kabupaten|Kota)\b|$)/iu',
                $alamat,
                $match
            )) {
                $kecamatan = trim($match[1]);
            }
        }

        // =====================================================
        // BERSIHKAN ALAMAT
        // =====================================================

        $alamatBersih = $alamat;

        // Hapus bagian "Desa ..."
        if ($desa) {
            $alamatBersih = preg_replace(
                '/\bDesa\s+' . preg_quote($desa, '/') . '\b/iu',
                '',
                $alamatBersih,
                1
            );
        }

        // Hapus bagian "Kec ..." / "Kecamatan ..."
        if ($kecamatan) {
            $alamatBersih = preg_replace(
                '/\b(?:Kec\.?|Kecamatan)\s+' .
                preg_quote($kecamatan, '/') .
                '\b/iu',
                '',
                $alamatBersih,
                1
            );
        }

        // Hapus Kabupaten/Kabupaten di bagian akhir
        $alamatBersih = preg_replace(
            '/\b(?:Kab\.?|Kabupaten)\s+[A-Za-zÀ-ÿ .]+$/iu',
            '',
            $alamatBersih
        );

        // Rapikan spasi
        $alamatBersih = preg_replace(
            '/\s+/u',
            ' ',
            $alamatBersih
        );

        // Bersihkan tanda baca yang tersisa di ujung
        $alamatBersih = trim(
            $alamatBersih,
            " \t\n\r\0\x0B,.-"
        );

        // Simpan hasil
        if ($desa) {
            $data['desa'] = $desa;
        }

        if ($kecamatan) {
            $data['kecamatan'] = $kecamatan;
        }

        $data['alamat'] = $alamatBersih ?: $alamat;

        return $data;
    }

    // =========================================================
    // TAMBAH GUDANG
    // =========================================================

    public function create(): View
    {
        $gudangsUtama = Gudang::whereNull(
            'gudang_induk_id'
        )
            ->orderBy('nama_gudang')
            ->get();

        // Preview kode untuk kedua jenis.
        // JavaScript di form hanya memilih salah satunya.
        // Kode FINAL tetap dibuat ulang di store().
        $kodePreview = [
            'utama' => $this->generateNextGudangCode('utama'),
            'filial' => $this->generateNextGudangCode('filial'),
        ];

        $jenisGudang = old(
            'jenis_gudang',
            'utama'
        );

        if (!array_key_exists(
            $jenisGudang,
            $kodePreview
        )) {
            $jenisGudang = 'utama';
        }

        $kodeGudang = $kodePreview[$jenisGudang];

        return view(
            'gudang.create',
            compact(
                'gudangsUtama',
                'kodeGudang',
                'kodePreview'
            )
        );
    }

    // =========================================================
    // SIMPAN GUDANG
    // =========================================================

    public function store(
        StoreGudangRequest $request
    ): RedirectResponse {

        $data = $request->validated();

        // =====================================================
        // OTOMATIS PISAHKAN DESA & KECAMATAN DARI ALAMAT
        // =====================================================

        $data = $this->parseAlamatGudang($data);

        $jenisGudang = $data['jenis_gudang'];

        // jenis_gudang hanya dipakai untuk menentukan kode & relasi.
        // Struktur gudang tetap ditentukan oleh gudang_induk_id.
        unset($data['jenis_gudang']);

        // Gudang Utama tidak boleh punya induk.
        if ($jenisGudang === 'utama') {
            $data['gudang_induk_id'] = null;
        }

        try {
            // Lock agar dua user yang submit bersamaan tidak
            // mendapat kode yang sama. Kode dibuat ulang di sini,
            // BUKAN memakai kode dari form.
            $gudang = Cache::lock(
                'gudang-kode-generator',
                10
            )
                ->block(
                    5,
                    function () use (
                        $data,
                        $jenisGudang
                    ) {
                        return DB::transaction(
                            function () use (
                                $data,
                                $jenisGudang
                            ) {
                                $data['kode_gudang'] =
                                    $this->generateNextGudangCode(
                                        $jenisGudang
                                    );

                                return Gudang::create($data);
                            }
                        );
                    }
                );
        } catch (LockTimeoutException $e) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'Sistem sedang membuat kode gudang lain. Silakan coba simpan kembali.'
                );
        }

        ActivityLogger::log(
            'Membuat Gudang',
            'gudang',
            $gudang->id,
            "Kode: {$gudang->kode_gudang}"
        );

        return redirect()
            ->route('gudang.index')
            ->with(
                'success',
                "Gudang {$gudang->nama_gudang} berhasil ditambahkan dengan kode {$gudang->kode_gudang}."
            );
    }

    // =========================================================
    // DETAIL GUDANG
    // =========================================================

    public function show(
        Gudang $gudang
    ): View {

        $gudang->loadCount(
            'baRampungs'
        );

        $baTerbaru = BaRampung::where(
            'gudang_id',
            $gudang->id
        )
            ->with('mitraPengolahan')
            ->latest('tanggal_ba')
            ->limit(5)
            ->get();

        return view(
            'gudang.show',
            compact(
                'gudang',
                'baTerbaru'
            )
        );
    }

    // =========================================================
    // EDIT GUDANG
    // =========================================================

    public function edit(
        Gudang $gudang
    ): View {

        return view(
            'gudang.edit',
            compact('gudang')
        );
    }

    // =========================================================
    // UPDATE GUDANG
    // =========================================================

    public function update(
        UpdateGudangRequest $request,
        Gudang $gudang
    ): RedirectResponse {

        $data = $request->validated();

        // Saat edit, Desa dan Kecamatan juga akan otomatis
        // dipisahkan dari Alamat jika field-nya dikosongkan.
        $data = $this->parseAlamatGudang($data);

        $gudang->update($data);

        ActivityLogger::log(
            'Mengubah Gudang',
            'gudang',
            $gudang->id,
            "Kode: {$gudang->kode_gudang}"
        );

        return redirect()
            ->route('gudang.index')
            ->with(
                'success',
                "Gudang {$gudang->nama_gudang} berhasil diperbarui."
            );
    }

    // =========================================================
    // TOGGLE STATUS
    // =========================================================

    public function toggleStatus(
        Gudang $gudang
    ): RedirectResponse {

        $gudang->update([
            'status' =>
                $gudang->status === 'aktif'
                    ? 'nonaktif'
                    : 'aktif',
        ]);

        ActivityLogger::log(
            $gudang->status === 'aktif'
                ? 'Mengaktifkan Gudang'
                : 'Menonaktifkan Gudang',
            'gudang',
            $gudang->id,
            "Kode: {$gudang->kode_gudang}"
        );

        return back()->with(
            'success',
            "Status Gudang {$gudang->nama_gudang} berhasil diubah menjadi "
            . ucfirst($gudang->status)
            . '.'
        );
    }

    // =========================================================
    // HAPUS GUDANG
    // =========================================================

    public function destroy(
        Gudang $gudang
    ): RedirectResponse {

        // Jangan hapus gudang yang masih memiliki BA Rampung
        if ($gudang->baRampungs()->exists()) {
            return back()->with(
                'error',
                "Gudang {$gudang->nama_gudang} tidak dapat dihapus karena masih memiliki data BA Rampung."
            );
        }

        // Jangan hapus gudang induk yang masih memiliki filial
        if (
            Gudang::where(
                'gudang_induk_id',
                $gudang->id
            )->exists()
        ) {
            return back()->with(
                'error',
                "Gudang {$gudang->nama_gudang} tidak dapat dihapus karena masih memiliki gudang filial."
            );
        }

        $namaGudang = $gudang->nama_gudang;
        $kodeGudang = $gudang->kode_gudang;
        $idGudang = $gudang->id;

        $gudang->delete();

        ActivityLogger::log(
            'Menghapus Gudang',
            'gudang',
            $idGudang,
            "Kode: {$kodeGudang}"
        );

        return redirect()
            ->route('gudang.index')
            ->with(
                'success',
                "Gudang {$namaGudang} berhasil dihapus."
            );
    }
}