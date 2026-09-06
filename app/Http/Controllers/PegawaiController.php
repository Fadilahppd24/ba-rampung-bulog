<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePegawaiRequest;
use App\Http\Requests\UpdatePegawaiRequest;
use App\Models\Gudang;
use App\Models\Pegawai;
use App\Models\User;
use App\Services\ActivityLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PegawaiController extends Controller
{
    public function index(Request $request): View
    {
        $query = Pegawai::with(['gudang', 'user']);

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('nip', 'like', "%{$search}%");
            });
        }

        if ($jabatan = $request->input('jabatan')) {
            $query->where('jabatan', $jabatan);
        }

        $pegawais = $query
            ->orderBy('nama')
            ->paginate(10)
            ->withQueryString();

        $jabatanOptions = Pegawai::distinct()
            ->orderBy('jabatan')
            ->pluck('jabatan');

        $kpi = [
            'total' => Pegawai::count(),
            'aktif' => Pegawai::aktif()->count(),
            'nonaktif' => Pegawai::where('status', 'nonaktif')->count(),
            'admin_sistem' => Pegawai::where('jabatan', 'Admin Sistem')->count(),
        ];

        $gudangs = Gudang::aktif()
            ->orderBy('nama_gudang')
            ->get();

        return view('pegawai.index', compact(
            'pegawais',
            'kpi',
            'jabatanOptions',
            'gudangs'
        ));
    }

    public function create(): View
    {
        $gudangs = Gudang::aktif()
            ->orderBy('nama_gudang')
            ->get();

        return view('pegawai.create', compact('gudangs'));
    }

    /**
     * Membuat Pegawai sekaligus akun User.
     */
    public function store(StorePegawaiRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $pegawai = DB::transaction(function () use ($data) {

            $user = User::create([
                'name' => $data['nama'],
                'email' => $data['email'],
                'password' => $data['password'],
                'role' => $data['role'],
                'gudang_id' => $data['gudang_id'] ?? null,
                'is_active' => $data['status'] === 'aktif',
            ]);

            return Pegawai::create([
                'nip' => $data['nip'],
                'nama' => $data['nama'],
                'jabatan' => $data['jabatan'],
                'gudang_id' => $data['gudang_id'] ?? null,
                'nomor_telepon' => $data['nomor_telepon'] ?? null,
                'email' => $data['email'],
                'status' => $data['status'],
                'user_id' => $user->id,
            ]);
        });

        ActivityLogger::log(
            'Membuat Pegawai dan Akun',
            'pegawai',
            $pegawai->id,
            "NIP: {$pegawai->nip}"
        );

        return redirect()
            ->route('pegawai.index')
            ->with(
                'success',
                "Pegawai {$pegawai->nama} dan akun login berhasil dibuat."
            );
    }

    public function show(Pegawai $pegawai): View
    {
        $pegawai->load(['gudang', 'user']);

        return view('pegawai.show', compact('pegawai'));
    }

    public function edit(Pegawai $pegawai): View
    {
        $pegawai->load('user');

        $gudangs = Gudang::aktif()
            ->orderBy('nama_gudang')
            ->get();

        return view('pegawai.edit', compact(
            'pegawai',
            'gudangs'
        ));
    }

    /**
     * Mengubah data Pegawai sekaligus data akun User.
     */
    public function update(
        UpdatePegawaiRequest $request,
        Pegawai $pegawai
    ): RedirectResponse {
        $data = $request->validated();

        DB::transaction(function () use ($data, $pegawai) {

            // Update data Pegawai
            $pegawai->update([
                'nip' => $data['nip'],
                'nama' => $data['nama'],
                'jabatan' => $data['jabatan'],
                'gudang_id' => $data['gudang_id'] ?? null,
                'nomor_telepon' => $data['nomor_telepon'] ?? null,
                'email' => $data['email'],
                'status' => $data['status'],
            ]);

            // Kalau Pegawai memiliki akun User
            if ($pegawai->user) {

                $userData = [
                    'name' => $data['nama'],
                    'email' => $data['email'],
                    'role' => $data['role'],
                    'gudang_id' => $data['gudang_id'] ?? null,
                    'is_active' => $data['status'] === 'aktif',
                ];

                // Password hanya diubah jika diisi
                if (!empty($data['password'])) {
                    $userData['password'] = $data['password'];
                }

                $pegawai->user->update($userData);
            }
        });

        ActivityLogger::log(
            'Mengubah Pegawai dan Akun',
            'pegawai',
            $pegawai->id,
            "NIP: {$pegawai->nip}"
        );

        return redirect()
            ->route('pegawai.index')
            ->with(
                'success',
                "Pegawai {$pegawai->nama} berhasil diperbarui."
            );
    }

    /**
     * Mengaktifkan / menonaktifkan Pegawai sekaligus akun User.
     */
    public function toggleStatus(Pegawai $pegawai): RedirectResponse
    {
        $statusBaru = $pegawai->status === 'aktif'
            ? 'nonaktif'
            : 'aktif';

        DB::transaction(function () use ($pegawai, $statusBaru) {

            $pegawai->update([
                'status' => $statusBaru,
            ]);

            if ($pegawai->user) {
                $pegawai->user->update([
                    'is_active' => $statusBaru === 'aktif',
                ]);
            }
        });

        ActivityLogger::log(
            $statusBaru === 'aktif'
                ? 'Mengaktifkan Pegawai'
                : 'Menonaktifkan Pegawai',
            'pegawai',
            $pegawai->id,
            "NIP: {$pegawai->nip}"
        );

        return back()->with(
            'success',
            "Status Pegawai {$pegawai->nama} berhasil diubah menjadi "
            . ucfirst($statusBaru) . '.'
        );
    }
}