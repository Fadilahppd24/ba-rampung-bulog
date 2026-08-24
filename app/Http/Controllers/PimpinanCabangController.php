<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePimpinanCabangRequest;
use App\Http\Requests\UpdatePimpinanCabangRequest;
use App\Models\PimpinanCabang;
use App\Services\ActivityLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PimpinanCabangController extends Controller
{
    public function index(): View
    {
        $pimpinanAktif = PimpinanCabang::aktif()->latest('periode_mulai')->first();
        $riwayat = PimpinanCabang::orderByDesc('periode_mulai')->paginate(10);

        return view('pimpinan.index', compact('pimpinanAktif', 'riwayat'));
    }

    public function create(): View
    {
        return view('pimpinan.create');
    }

    public function store(StorePimpinanCabangRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $pimpinan = DB::transaction(function () use ($data) {
            if (($data['status'] ?? null) === 'aktif') {
                $this->nonaktifkanYangLain($data['periode_mulai']);
            }

            return PimpinanCabang::create($data);
        });

        ActivityLogger::log('Menambah Riwayat Pimpinan Cabang', 'pimpinan_cabang', $pimpinan->id, "Nama: {$pimpinan->nama}");

        return redirect()->route('pimpinan.index')->with('success', "Riwayat Pimpinan Cabang {$pimpinan->nama} berhasil ditambahkan.");
    }

    public function show(PimpinanCabang $pimpinan): View
    {
        return view('pimpinan.show', compact('pimpinan'));
    }

    public function edit(PimpinanCabang $pimpinan): View
    {
        return view('pimpinan.edit', compact('pimpinan'));
    }

    public function update(UpdatePimpinanCabangRequest $request, PimpinanCabang $pimpinan): RedirectResponse
    {
        $data = $request->validated();

        DB::transaction(function () use ($data, $pimpinan) {
            if (($data['status'] ?? null) === 'aktif') {
                $this->nonaktifkanYangLain($data['periode_mulai'], $pimpinan->id);
            }

            $pimpinan->update($data);
        });

        ActivityLogger::log('Mengubah Riwayat Pimpinan Cabang', 'pimpinan_cabang', $pimpinan->id, "Nama: {$pimpinan->nama}");

        return redirect()->route('pimpinan.show', $pimpinan)->with('success', "Data Pimpinan Cabang {$pimpinan->nama} berhasil diperbarui.");
    }

    /**
     * Business rule: only one Pimpinan Cabang can be "aktif" at a time,
     * since this record is referenced as the "Mengetahui" signatory on
     * every BA Rampung. Whenever a record is (re)activated, every other
     * record is closed out.
     */
    private function nonaktifkanYangLain(string $periodeMulaiBaru, ?int $kecualiId = null): void
    {
        PimpinanCabang::where('status', 'aktif')
            ->when($kecualiId, fn ($q) => $q->where('id', '!=', $kecualiId))
            ->update([
                'status' => 'nonaktif',
                'periode_selesai' => $periodeMulaiBaru,
            ]);
    }
}
