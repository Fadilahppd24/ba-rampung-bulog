<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMitraPengolahanRequest;
use App\Http\Requests\UpdateMitraPengolahanRequest;
use App\Models\BaRampung;
use App\Models\MitraPengolahan;
use App\Services\ActivityLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MitraPengolahanController extends Controller
{
    public function index(Request $request): View
    {
        $query = MitraPengolahan::withCount('baRampungs');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_mitra', 'like', "%{$search}%")
                    ->orWhere('kode_mitra', 'like', "%{$search}%");
            });
        }

        if ($jenisUsaha = $request->input('jenis_usaha')) {
            $query->where('jenis_usaha', $jenisUsaha);
        }

        $mitras = $query->orderBy('nama_mitra')->paginate(10)->withQueryString();

        $jenisUsahaOptions = MitraPengolahan::whereNotNull('jenis_usaha')
            ->distinct()
            ->orderBy('jenis_usaha')
            ->pluck('jenis_usaha');

        $kpi = [
            'total' => MitraPengolahan::count(),
            'aktif' => MitraPengolahan::aktif()->count(),
            'total_ba' => BaRampung::count(),
            'dengan_proses' => MitraPengolahan::whereHas('baRampungs', function ($q) {
                $q->where('status', BaRampung::STATUS_MENUNGGU_VERIFIKASI);
            })->count(),
        ];

        return view('mitra.index', compact('mitras', 'kpi', 'jenisUsahaOptions'));
    }

    public function create(): View
    {
        return view('mitra.create');
    }

    public function store(StoreMitraPengolahanRequest $request): RedirectResponse
    {
        $mitra = MitraPengolahan::create($request->validated());

        ActivityLogger::log('Membuat Mitra Pengolahan', 'mitra_pengolahan', $mitra->id, "Kode: {$mitra->kode_mitra}");

        return redirect()->route('mitra.index')->with('success', "Mitra {$mitra->nama_mitra} berhasil ditambahkan.");
    }

    public function show(MitraPengolahan $mitra): View
    {
        $mitra->loadCount('baRampungs');

        $baTerbaru = BaRampung::where('mitra_pengolahan_id', $mitra->id)
            ->with('gudang')
            ->latest('tanggal_ba')
            ->limit(5)
            ->get();

        return view('mitra.show', compact('mitra', 'baTerbaru'));
    }

    public function edit(MitraPengolahan $mitra): View
    {
        return view('mitra.edit', compact('mitra'));
    }

    public function update(UpdateMitraPengolahanRequest $request, MitraPengolahan $mitra): RedirectResponse
    {
        $mitra->update($request->validated());

        ActivityLogger::log('Mengubah Mitra Pengolahan', 'mitra_pengolahan', $mitra->id, "Kode: {$mitra->kode_mitra}");

        return redirect()->route('mitra.index')->with('success', "Mitra {$mitra->nama_mitra} berhasil diperbarui.");
    }

    public function toggleStatus(MitraPengolahan $mitra): RedirectResponse
    {
        $mitra->update([
            'status' => $mitra->status === 'aktif' ? 'nonaktif' : 'aktif',
        ]);

        ActivityLogger::log(
            $mitra->status === 'aktif' ? 'Mengaktifkan Mitra Pengolahan' : 'Menonaktifkan Mitra Pengolahan',
            'mitra_pengolahan',
            $mitra->id,
            "Kode: {$mitra->kode_mitra}"
        );

        return back()->with('success', "Status Mitra {$mitra->nama_mitra} berhasil diubah menjadi " . ucfirst($mitra->status) . '.');
    }
}
