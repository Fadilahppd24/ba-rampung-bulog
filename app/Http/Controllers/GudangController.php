<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGudangRequest;
use App\Http\Requests\UpdateGudangRequest;
use App\Models\BaRampung;
use App\Models\Gudang;
use App\Services\ActivityLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GudangController extends Controller
{
    public function index(Request $request): View
    {
        $query = Gudang::withCount('baRampungs');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_gudang', 'like', "%{$search}%")
                    ->orWhere('kode_gudang', 'like', "%{$search}%");
            });
        }

        $gudangs = $query
            ->orderBy('nama_gudang')
            ->paginate(10)
            ->withQueryString();

        $kpi = [
            'total' => Gudang::count(),

            'aktif' => Gudang::aktif()->count(),

            'total_dokumen' => BaRampung::count(),

            'dengan_proses' => Gudang::whereHas('baRampungs', function ($q) {
                $q->where(
                    'status',
                    BaRampung::STATUS_MENUNGGU_VERIFIKASI
                );
            })->count(),
        ];

        return view(
            'gudang.index',
            compact('gudangs', 'kpi')
        );
    }

    public function create(): View
    {
        return view('gudang.create');
    }

    public function store(StoreGudangRequest $request): RedirectResponse
    {
        $gudang = Gudang::create(
            $request->validated()
        );

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
                "Gudang {$gudang->nama_gudang} berhasil ditambahkan."
            );
    }

    public function show(Gudang $gudang): View
    {
        $gudang->load([
            'pegawais' => fn ($q) => $q->aktif(),
        ]);

        $gudang->loadCount('baRampungs');

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
            compact('gudang', 'baTerbaru')
        );
    }

    public function edit(Gudang $gudang): View
    {
        return view(
            'gudang.edit',
            compact('gudang')
        );
    }

    public function update(
        UpdateGudangRequest $request,
        Gudang $gudang
    ): RedirectResponse {

        $gudang->update(
            $request->validated()
        );

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

    public function toggleStatus(Gudang $gudang): RedirectResponse
    {
        $gudang->update([
            'status' => $gudang->status === 'aktif'
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
}