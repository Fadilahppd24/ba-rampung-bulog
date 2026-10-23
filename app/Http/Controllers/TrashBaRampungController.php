<?php

namespace App\Http\Controllers;

use App\Models\BaRampung;
use App\Models\Notification;
use App\Services\ActivityLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class TrashBaRampungController extends Controller
{
    private function onlyOffice(Request $request): void
    {
        abort_unless($request->user()?->isAdminKantor(), 403);
    }

    public function index(Request $request): View
    {
        $this->onlyOffice($request);
        Gate::authorize('viewAny', BaRampung::class);

        $query = BaRampung::onlyTrashed()->with(['gudang', 'mitraPengolahan'])
            ->orderByDesc('deleted_at')->orderByDesc('id');

        if ($search = trim((string) $request->query('search', ''))) {
            $query->where(function ($q) use ($search) {
                $q->where('nomor_ba', 'like', "%{$search}%")
                  ->orWhereHas('gudang', fn ($g) => $g->where('nama_gudang', 'like', "%{$search}%"))
                  ->orWhereHas('mitraPengolahan', fn ($m) => $m->where('nama_mitra', 'like', "%{$search}%"));
            });
        }

        $items = $query->paginate(20)->withQueryString();
        return view('ba-rampung.trash', compact('items'));
    }

    public function restore(Request $request, int $id): RedirectResponse
    {
        $this->onlyOffice($request);
        $ba = BaRampung::onlyTrashed()->findOrFail($id);
        Gate::authorize('restore', $ba);
        $ba->restore();
        ActivityLogger::log('Memulihkan BA Rampung', 'ba_rampung', $ba->id, "Nomor BA: {$ba->nomor_ba}");
        return back()->with('success', 'BA Rampung berhasil dipulihkan.');
    }

    public function forceDelete(Request $request, int $id): RedirectResponse
    {
        $this->onlyOffice($request);
        $ba = BaRampung::onlyTrashed()->findOrFail($id);
        Gate::authorize('forceDelete', $ba);
        $this->permanentlyDelete($ba);
        return back()->with('success', 'BA Rampung berhasil dihapus permanen.');
    }

    public function bulk(Request $request): RedirectResponse
    {
        $this->onlyOffice($request);
        $data = $request->validate([
            'action' => ['required', 'in:restore,delete'],
            'ids' => ['required', 'array', 'min:1', 'max:200'],
            'ids.*' => ['required', 'integer', 'distinct'],
        ]);
        $ids = $data['ids'];
        $items = BaRampung::onlyTrashed()->whereIn('id', $ids)->get();
        if ($items->count() !== count($ids)) {
            return back()->withErrors(['ids' => 'Sebagian BA tidak ditemukan di sampah. Pilih ulang data.']);
        }
        foreach ($items as $ba) {
            Gate::authorize($data['action'] === 'restore' ? 'restore' : 'forceDelete', $ba);
        }
        if ($data['action'] === 'restore') {
            DB::transaction(function () use ($items) {
                foreach ($items as $ba) {
                    $ba->restore();
                    ActivityLogger::log('Memulihkan BA Rampung', 'ba_rampung', $ba->id, "Nomor BA: {$ba->nomor_ba}");
                }
            });
        } else {
            DB::transaction(function () use ($items) {
                foreach ($items as $ba) {
                    $this->permanentlyDelete($ba);
                }
            });
        }
        return back()->with('success', $items->count() . ' BA Rampung berhasil diproses.');
    }

    private function permanentlyDelete(BaRampung $ba): void
    {
        DB::transaction(function () use ($ba) {
            $id = $ba->id;
            $nomor = $ba->nomor_ba;
            // Hapus relasi yang diketahui terlebih dahulu untuk menjaga integritas FK.
            Notification::where('ba_rampung_id', $id)->delete();
            $ba->produksis()->delete();
            $ba->forceDelete();
            ActivityLogger::log('Menghapus Permanen BA Rampung', 'ba_rampung', $id, "Nomor BA: {$nomor}");
        });
    }
}
