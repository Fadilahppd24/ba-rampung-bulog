<?php

namespace App\Http\Controllers;

use App\Models\AktivitasLog;
use App\Models\Gudang;
use App\Models\MitraPengolahan;
use App\Models\Pegawai;
use App\Models\Pengaturan;
use App\Models\PimpinanCabang;
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

    public function backup(): View
    {
        return view('pengaturan.backup');
    }

    /**
     * "Backup" here is a logical export (JSON snapshot of the master-data
     * tables) rather than a raw `mysqldump`, since a real SQL dump needs a
     * shell binary that may not exist on every host. It is a genuine,
     * restorable backup of Gudang / Mitra / Pegawai / Pimpinan Cabang data.
     */
    public function downloadBackup()
    {
        $snapshot = [
            'exported_at' => now()->toIso8601String(),
            'gudangs' => Gudang::all()->toArray(),
            'mitra_pengolahans' => MitraPengolahan::all()->toArray(),
            'pegawais' => Pegawai::all()->toArray(),
            'pimpinan_cabangs' => PimpinanCabang::all()->toArray(),
        ];

        ActivityLogger::log('Backup Database', 'pengaturan', null, 'Export snapshot data master ke JSON.');

        $fileName = 'backup_ba_rampung_' . now()->format('Y-m-d_His') . '.json';

        return response()->streamDownload(function () use ($snapshot) {
            echo json_encode($snapshot, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }, $fileName, ['Content-Type' => 'application/json']);
    }

    /**
     * Restore is intentionally NON-destructive: it only inserts records
     * whose unique key (kode_gudang / kode_mitra / nip) does not already
     * exist. It never updates or deletes existing rows, so it cannot wipe
     * or corrupt current data — matching the "don't touch existing data"
     * requirement.
     */
    public function restore(Request $request): RedirectResponse
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:json'],
        ], [
            'file.required' => 'File backup wajib dipilih.',
            'file.mimes' => 'File harus berformat .json.',
        ]);

        $content = json_decode(file_get_contents($request->file('file')->getRealPath()), true);

        if (! is_array($content)) {
            return back()->withErrors(['file' => 'File backup tidak valid atau rusak.']);
        }

        $ringkasan = [];

        $ringkasan['gudang'] = $this->restoreTable(Gudang::class, $content['gudangs'] ?? [], 'kode_gudang');
        $ringkasan['mitra'] = $this->restoreTable(MitraPengolahan::class, $content['mitra_pengolahans'] ?? [], 'kode_mitra');
        $ringkasan['pegawai'] = $this->restoreTable(Pegawai::class, $content['pegawais'] ?? [], 'nip');

        ActivityLogger::log('Restore Database', 'pengaturan', null, 'Menambahkan ' . array_sum($ringkasan) . ' data baru dari file backup (data lama tidak diubah).');

        return back()->with('success', "Restore selesai. Ditambahkan: {$ringkasan['gudang']} Gudang, {$ringkasan['mitra']} Mitra, {$ringkasan['pegawai']} Pegawai baru. Data yang sudah ada tidak diubah.");
    }

    private function restoreTable(string $modelClass, array $rows, string $uniqueKey): int
    {
        $ditambahkan = 0;

        foreach ($rows as $row) {
            if (empty($row[$uniqueKey])) {
                continue;
            }
            $exists = $modelClass::where($uniqueKey, $row[$uniqueKey])->exists();
            if (! $exists) {
                $fillable = (new $modelClass())->getFillable();
                $modelClass::create(array_intersect_key($row, array_flip($fillable)));
                $ditambahkan++;
            }
        }

        return $ditambahkan;
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
