<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePegawaiRequest;
use App\Http\Requests\UpdatePegawaiRequest;
use App\Models\Gudang;
use App\Models\Pegawai;
use App\Services\ActivityLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PegawaiController extends Controller
{
    public function index(Request $request): View
    {
        $query = Pegawai::with('gudang');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('nip', 'like', "%{$search}%");
            });
        }

        if ($jabatan = $request->input('jabatan')) {
            $query->where('jabatan', $jabatan);
        }

        $pegawais = $query->orderBy('nama')->paginate(10)->withQueryString();

        $jabatanOptions = Pegawai::distinct()->orderBy('jabatan')->pluck('jabatan');

        $kpi = [
            'total' => Pegawai::count(),
            'aktif' => Pegawai::aktif()->count(),
            'nonaktif' => Pegawai::where('status', 'nonaktif')->count(),
            'admin_sistem' => Pegawai::where('jabatan', 'Admin Sistem')->count(),
        ];

        $gudangs = Gudang::aktif()->orderBy('nama_gudang')->get();

        return view('pegawai.index', compact('pegawais', 'kpi', 'jabatanOptions', 'gudangs'));
    }

    public function create(): View
    {
        $gudangs = Gudang::aktif()->orderBy('nama_gudang')->get();

        return view('pegawai.create', compact('gudangs'));
    }

    public function store(StorePegawaiRequest $request): RedirectResponse
    {
        $pegawai = Pegawai::create($request->validated());

        ActivityLogger::log('Membuat Pegawai', 'pegawai', $pegawai->id, "NIP: {$pegawai->nip}");

        return redirect()->route('pegawai.index')->with('success', "Pegawai {$pegawai->nama} berhasil ditambahkan.");
    }

    public function show(Pegawai $pegawai): View
    {
        $pegawai->load('gudang');

        return view('pegawai.show', compact('pegawai'));
    }

    public function edit(Pegawai $pegawai): View
    {
        $gudangs = Gudang::aktif()->orderBy('nama_gudang')->get();

        return view('pegawai.edit', compact('pegawai', 'gudangs'));
    }

    public function update(UpdatePegawaiRequest $request, Pegawai $pegawai): RedirectResponse
    {
        $pegawai->update($request->validated());

        ActivityLogger::log('Mengubah Pegawai', 'pegawai', $pegawai->id, "NIP: {$pegawai->nip}");

        return redirect()->route('pegawai.index')->with('success', "Pegawai {$pegawai->nama} berhasil diperbarui.");
    }

    public function toggleStatus(Pegawai $pegawai): RedirectResponse
    {
        $pegawai->update([
            'status' => $pegawai->status === 'aktif' ? 'nonaktif' : 'aktif',
        ]);

        ActivityLogger::log(
            $pegawai->status === 'aktif' ? 'Mengaktifkan Pegawai' : 'Menonaktifkan Pegawai',
            'pegawai',
            $pegawai->id,
            "NIP: {$pegawai->nip}"
        );

        return back()->with('success', "Status Pegawai {$pegawai->nama} berhasil diubah menjadi " . ucfirst($pegawai->status) . '.');
    }
}
