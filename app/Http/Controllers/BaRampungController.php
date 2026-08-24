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
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class BaRampungController extends Controller
{
    public function index(Request $request): View
    {
        Gate::authorize('viewAny', BaRampung::class);
        $user = $request->user();

        $query = BaRampung::with(['gudang', 'mitraPengolahan']);

        if ($user->isAdminGudang() && $user->gudang_id) {
            $query->where('gudang_id', $user->gudang_id);
        }

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('nomor_ba', 'like', "%{$search}%")
                    ->orWhereHas('gudang', fn ($g) => $g->where('nama_gudang', 'like', "%{$search}%"))
                    ->orWhereHas('mitraPengolahan', fn ($m) => $m->where('nama_mitra', 'like', "%{$search}%"));
            });
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        if ($gudangId = $request->input('gudang_id')) {
            $query->where('gudang_id', $gudangId);
        }

        if ($mitraId = $request->input('mitra_pengolahan_id')) {
            $query->where('mitra_pengolahan_id', $mitraId);
        }

        if ($bulan = $request->input('bulan')) {
            $query->whereMonth('tanggal_ba', $bulan);
        }

        if ($tahun = $request->input('tahun')) {
            $query->whereYear('tanggal_ba', $tahun);
        }

        $baList = $query->latest('tanggal_ba')->paginate(10)->withQueryString();

        $kpiBase = BaRampung::query();
        if ($user->isAdminGudang() && $user->gudang_id) {
            $kpiBase->where('gudang_id', $user->gudang_id);
        }

        $kpi = [
            'total' => (clone $kpiBase)->count(),
            'terverifikasi' => (clone $kpiBase)->whereIn('status', [BaRampung::STATUS_TERVERIFIKASI, BaRampung::STATUS_SELESAI])->count(),
            'belum_serah' => (clone $kpiBase)->where('status', BaRampung::STATUS_MENUNGGU_VERIFIKASI)->count(),
            'ditolak' => (clone $kpiBase)->where('status', BaRampung::STATUS_DITOLAK)->count(),
            'mitra' => MitraPengolahan::aktif()->count(),
        ];

        $gudangs = Gudang::aktif()->orderBy('nama_gudang')->get();
        $mitras = MitraPengolahan::aktif()->orderBy('nama_mitra')->get();

        return view('ba-rampung.index', compact('baList', 'kpi', 'gudangs', 'mitras'));
    }

    public function create(): View
    {
        Gate::authorize('create', BaRampung::class);

        $gudangs = Gudang::aktif()->orderBy('nama_gudang')->get();
        $mitras = MitraPengolahan::aktif()->orderBy('nama_mitra')->get();
        $pimpinans = PimpinanCabang::aktif()->orderBy('nama')->get();
        $pegawais = \App\Models\Pegawai::aktif()->orderBy('nama')->get();

        return view('ba-rampung.create', compact('gudangs', 'mitras', 'pimpinans', 'pegawais'));
    }

    public function store(StoreBaRampungRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $tanggal = \Carbon\Carbon::parse($data['tanggal_ba']);

        $ba = DB::transaction(function () use ($data, $tanggal, $request) {
            $ba = BaRampung::create([
                'nomor_ba' => BaRampung::generateNomorBa($tanggal),
                'tanggal_ba' => $tanggal,
                'hari' => $tanggal->translatedFormat('l'),
                'bulan' => $tanggal->translatedFormat('F'),
                'tahun' => $tanggal->year,
                'nomor_mo' => $data['nomor_mo'],
                'nomor_po' => $data['nomor_po'],
                'gudang_id' => $data['gudang_id'],
                'mitra_pengolahan_id' => $data['mitra_pengolahan_id'],
                'nama_penandatangan' => $data['nama_penandatangan'],
                'jabatan_penandatangan' => $data['jabatan_penandatangan'],
                'pimpinan_cabang_id' => $data['pimpinan_cabang_id'],
                'status' => $data['action'] === 'submit' ? BaRampung::STATUS_MENUNGGU_VERIFIKASI : BaRampung::STATUS_DRAFT,
                'status_pbp' => $data['status_pbp'] ?? 'normal',
                'catatan' => $data['catatan'] ?? null,
                'created_by' => $request->user()->id,
            ]);

            $this->simpanProduksi($ba, $data);

            return $ba;
        });

        ActivityLogger::log('Membuat BA Rampung', 'ba_rampung', $ba->id, "Nomor BA: {$ba->nomor_ba}");

        return redirect()->route('ba-rampung.show', $ba)
            ->with('success', "BA Rampung {$ba->nomor_ba} berhasil disimpan.");
    }

    public function show(BaRampung $baRampung): View
    {
        Gate::authorize('view', $baRampung);
        $baRampung->load(['gudang', 'mitraPengolahan', 'pimpinanCabang', 'pembuat', 'verifikator', 'produksis']);

        return view('ba-rampung.show', compact('baRampung'));
    }

    public function edit(BaRampung $baRampung): View
    {
        Gate::authorize('update', $baRampung);
        $baRampung->load('produksis');

        $gudangs = Gudang::aktif()->orderBy('nama_gudang')->get();
        $mitras = MitraPengolahan::aktif()->orderBy('nama_mitra')->get();
        $pimpinans = PimpinanCabang::aktif()->orderBy('nama')->get();
        $pegawais = \App\Models\Pegawai::aktif()->orderBy('nama')->get();

        return view('ba-rampung.edit', compact('baRampung', 'gudangs', 'mitras', 'pimpinans', 'pegawais'));
    }

    public function update(UpdateBaRampungRequest $request, BaRampung $baRampung): RedirectResponse
    {
        $data = $request->validated();
        $tanggal = \Carbon\Carbon::parse($data['tanggal_ba']);

        DB::transaction(function () use ($data, $tanggal, $baRampung) {
            $baRampung->update([
                'tanggal_ba' => $tanggal,
                'hari' => $tanggal->translatedFormat('l'),
                'bulan' => $tanggal->translatedFormat('F'),
                'tahun' => $tanggal->year,
                'nomor_mo' => $data['nomor_mo'],
                'nomor_po' => $data['nomor_po'],
                'gudang_id' => $data['gudang_id'],
                'mitra_pengolahan_id' => $data['mitra_pengolahan_id'],
                'nama_penandatangan' => $data['nama_penandatangan'],
                'jabatan_penandatangan' => $data['jabatan_penandatangan'],
                'pimpinan_cabang_id' => $data['pimpinan_cabang_id'],
                'status' => $data['action'] === 'submit' ? BaRampung::STATUS_MENUNGGU_VERIFIKASI : BaRampung::STATUS_DRAFT,
                'status_pbp' => $data['status_pbp'] ?? 'normal',
                'catatan' => $data['catatan'] ?? null,
            ]);

            $baRampung->produksis()->delete();
            $this->simpanProduksi($baRampung, $data);
        });

        ActivityLogger::log('Mengubah BA Rampung', 'ba_rampung', $baRampung->id, "Nomor BA: {$baRampung->nomor_ba}");

        return redirect()->route('ba-rampung.show', $baRampung)
            ->with('success', "BA Rampung {$baRampung->nomor_ba} berhasil diperbarui.");
    }

    public function destroy(BaRampung $baRampung): RedirectResponse
    {
        Gate::authorize('delete', $baRampung);
        $nomor = $baRampung->nomor_ba;
        $id = $baRampung->id;

        $baRampung->delete();

        ActivityLogger::log('Menghapus BA Rampung', 'ba_rampung', $id, "Nomor BA: {$nomor}");

        return redirect()->route('ba-rampung.index')->with('success', "BA Rampung {$nomor} berhasil dihapus.");
    }

    public function verify(VerifyBaRampungRequest $request, BaRampung $baRampung): RedirectResponse
    {
        $data = $request->validated();

        if ($data['keputusan'] === 'terima') {
            $baRampung->update([
                'status' => BaRampung::STATUS_TERVERIFIKASI,
                'verified_by' => $request->user()->id,
                'verified_at' => now(),
                'alasan_penolakan' => null,
            ]);
            ActivityLogger::log('Verifikasi BA Rampung', 'ba_rampung', $baRampung->id, "BA {$baRampung->nomor_ba} diterima.");
            $pesan = "BA Rampung {$baRampung->nomor_ba} berhasil diverifikasi.";
        } else {
            $baRampung->update([
                'status' => BaRampung::STATUS_DITOLAK,
                'verified_by' => $request->user()->id,
                'verified_at' => now(),
                'alasan_penolakan' => $data['alasan_penolakan'],
            ]);
            ActivityLogger::log('Menolak BA Rampung', 'ba_rampung', $baRampung->id, "BA {$baRampung->nomor_ba} ditolak: {$data['alasan_penolakan']}");
            $pesan = "BA Rampung {$baRampung->nomor_ba} ditolak.";
        }

        return redirect()->route('ba-rampung.show', $baRampung)->with('success', $pesan);
    }

    public function export(Request $request)
    {
        Gate::authorize('viewAny', BaRampung::class);
        $user = $request->user();

        $filters = $request->only(['search', 'status', 'gudang_id', 'mitra_pengolahan_id', 'bulan', 'tahun']);

        if ($user->isAdminGudang() && $user->gudang_id) {
            $filters['gudang_id'] = $user->gudang_id;
        }

        ActivityLogger::log('Export Excel BA Rampung', 'ba_rampung', null, 'Export daftar BA Rampung ke Excel.');

        $namaBulan = $filters['bulan'] ?? null
            ? \Carbon\Carbon::create()->month((int) $filters['bulan'])->translatedFormat('F')
            : 'Semua';
        $tahun = $filters['tahun'] ?? now()->year;
        $fileName = "Rekap_BA_Rampung_{$namaBulan}_{$tahun}.xlsx";

        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\BaRampungExport($filters), $fileName);
    }

    public function pdf(BaRampung $baRampung)
    {
        Gate::authorize('view', $baRampung);
        $baRampung->load(['gudang', 'mitraPengolahan', 'pimpinanCabang', 'produksis']);

        ActivityLogger::log('Generate PDF BA Rampung', 'ba_rampung', $baRampung->id, "Nomor BA: {$baRampung->nomor_ba}");

        $pdf = Pdf::loadView('pdf.ba-rampung', compact('baRampung'))->setPaper('a4', 'portrait');

        return $pdf->stream("{$baRampung->nomor_ba}.pdf");
    }

    /**
     * Persist the production rows and recompute rendemen server-side.
     * The client-submitted rendemen (if any) is never trusted or stored.
     */
    private function simpanProduksi(BaRampung $ba, array $data): void
    {
        $gabah = (float) $data['kuantum_gabah'];
        $beras = (float) $data['kuantum_beras'];
        $menir = (float) ($data['kuantum_menir'] ?? 0);
        $bekatul = (float) ($data['kuantum_bekatul'] ?? 0);

        $rows = [
            ['produk_sesudah' => 'Beras (HGL)', 'kuantum' => $beras],
            ['produk_sesudah' => 'Menir', 'kuantum' => $menir],
            ['produk_sesudah' => 'Bekatul', 'kuantum' => $bekatul],
        ];

        foreach ($rows as $row) {
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
