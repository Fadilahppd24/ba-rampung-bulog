<?php

namespace App\Http\Controllers;

use App\Models\AktivitasLog;
use App\Models\Pengaturan;
use App\Services\ActivityLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PengaturanController extends Controller
{
    public function umum(): View
    {
        $pengaturan = Pengaturan::current();

        return view('pengaturan.umum', compact('pengaturan'));
    }

    public function updateUmum(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nama_cabang' => ['required', 'string', 'max:150'],
            'alamat_kantor' => ['nullable', 'string', 'max:500'],
            'telepon' => ['nullable', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:150'],
            'warna_tema' => ['required', 'string', 'max:20'],
            'logo' => ['nullable', 'image', 'max:2048'],
        ], [
            'nama_cabang.required' => 'Nama cabang wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'logo.image' => 'Logo harus berupa file gambar.',
            'logo.max' => 'Ukuran logo maksimal 2MB.',
        ]);

        $pengaturan = Pengaturan::current();

        if ($request->hasFile('logo')) {
            if ($pengaturan->logo_path) {
                Storage::disk('public')->delete($pengaturan->logo_path);
            }
            $data['logo_path'] = $request->file('logo')->store('logo', 'public');
        }

        unset($data['logo']);
        $pengaturan->update($data);

        ActivityLogger::log('Mengubah Pengaturan Umum', 'pengaturan', $pengaturan->id);

        return redirect()->route('pengaturan.umum')->with('success', 'Pengaturan Umum berhasil disimpan.');
    }

    public function sistem(): View
    {
        $pengaturan = Pengaturan::current();

        return view('pengaturan.sistem', compact('pengaturan'));
    }

    public function updateSistem(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'prefix_nomor_ba' => ['required', 'string', 'max:20'],
            'suffix_nomor_ba' => ['required', 'string', 'max:20'],
            'tahun_aktif' => ['required', 'integer', 'min:2000', 'max:2100'],
            'item_per_halaman' => ['required', 'integer', 'min:5', 'max:100'],
        ], [
            'prefix_nomor_ba.required' => 'Prefix nomor BA wajib diisi.',
            'tahun_aktif.required' => 'Tahun aktif wajib diisi.',
            'item_per_halaman.required' => 'Jumlah item per halaman wajib diisi.',
            'item_per_halaman.min' => 'Minimal 5 item per halaman.',
            'item_per_halaman.max' => 'Maksimal 100 item per halaman.',
        ]);

        $pengaturan = Pengaturan::current();
        $pengaturan->update($data);

        ActivityLogger::log('Mengubah Pengaturan Sistem', 'pengaturan', $pengaturan->id);

        return redirect()->route('pengaturan.sistem')->with('success', 'Pengaturan Sistem berhasil disimpan. Catatan: format nomor BA yang sudah berjalan tidak diubah retroaktif.');
    }

    public function logAktivitas(Request $request): View
    {
        $query = AktivitasLog::with('user')->latest('created_at');

        if ($modul = $request->input('modul')) {
            $query->where('modul', $modul);
        }

        if ($userId = $request->input('user_id')) {
            $query->where('user_id', $userId);
        }

        $logs = $query->paginate(20)->withQueryString();
        $modulOptions = AktivitasLog::distinct()->orderBy('modul')->pluck('modul');
        $users = \App\Models\User::orderBy('name')->get();

        return view('pengaturan.log-aktivitas', compact('logs', 'modulOptions', 'users'));
    }
}
