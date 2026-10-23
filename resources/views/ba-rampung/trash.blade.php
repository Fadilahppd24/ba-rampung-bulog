@extends('layouts.app')
@section('title', 'Riwayat Sampah BA Rampung')
@section('content')
<style>
/* Header Riwayat Sampah mengikuti header Manajemen User */
.um-header{position:relative;overflow:hidden;min-height:205px;border:1px solid rgba(255,255,255,.18);border-top:2px solid #F28C28;border-radius:24px;padding:30px 44px;background:linear-gradient(135deg,rgba(8,42,78,.86) 0%,rgba(18,67,116,.72) 48%,rgba(30,88,145,.52) 100%);box-shadow:0 18px 45px rgba(5,25,48,.18),inset 0 1px 0 rgba(255,255,255,.10);backdrop-filter:blur(10px);-webkit-backdrop-filter:blur(10px)}
.um-header::before{content:"";position:absolute;inset:0;pointer-events:none;background:radial-gradient(circle at 88% 22%,rgba(242,140,40,.20) 0,rgba(242,140,40,.08) 16%,transparent 38%),linear-gradient(90deg,rgba(7,34,62,.12),transparent 55%)}
.um-header::after{content:"";position:absolute;width:320px;height:320px;right:-150px;bottom:-220px;border-radius:999px;pointer-events:none;background:radial-gradient(circle,rgba(82,157,230,.18),transparent 68%)}
.um-header-content{position:relative;z-index:2;height:100%;display:flex;flex-direction:column;justify-content:center}
.um-back{display:inline-flex;align-items:center;gap:7px;width:fit-content;margin-bottom:18px;color:rgba(235,243,252,.78);font-size:12px;font-weight:700;letter-spacing:.01em;transition:.2s ease}
.um-back:hover{color:#fff;transform:translateX(-2px)}
.um-title-row{display:flex;align-items:flex-end;justify-content:space-between;gap:30px}
.um-title-wrap{display:block}
.um-kicker{margin-bottom:5px;color:rgba(235,243,252,.82);font-size:10px;font-weight:800;letter-spacing:.28em;text-transform:uppercase}
.um-title{margin:0;color:#fff;font-family:Georgia,"Times New Roman",serif;font-size:clamp(42px,4vw,58px);line-height:.98;font-weight:400;letter-spacing:-.035em}
.um-title-accent{color:#F28C28}
.um-subtitle{margin-top:13px;color:rgba(239,246,255,.84);font-size:14px;line-height:1.5}
.um-header-actions{display:flex;flex-direction:column;align-items:flex-end;justify-content:flex-end;gap:12px;flex-shrink:0}
.um-status-card{min-width:160px;padding:10px 16px;border:1px solid rgba(255,255,255,.12);border-radius:16px;background:rgba(7,31,57,.30);box-shadow:inset 0 1px 0 rgba(255,255,255,.06);backdrop-filter:blur(8px)}
.um-status-label{display:block;margin-bottom:4px;color:rgba(224,235,247,.62);font-size:9px;font-weight:800;letter-spacing:.18em;text-transform:uppercase}
.um-status-value{display:flex;align-items:center;gap:7px;color:#fff;font-size:12px;font-weight:700}
.um-status-value::before{content:"";width:9px;height:9px;border-radius:50%;background:#34D399;box-shadow:0 0 0 4px rgba(52,211,153,.12),0 0 12px rgba(52,211,153,.35)}
.um-add-btn{display:inline-flex;align-items:center;justify-content:center;gap:8px;min-height:44px;padding:0 18px;border-radius:13px;color:#fff;background:linear-gradient(135deg,#F28C28,#E9780C);box-shadow:0 8px 20px rgba(242,140,40,.28),inset 0 1px 0 rgba(255,255,255,.12);font-size:13px;font-weight:800;transition:.2s ease}
.um-add-btn:hover{transform:translateY(-1px);box-shadow:0 12px 24px rgba(242,140,40,.30)}
html.dark-theme .um-header{border-color:rgba(255,255,255,.12);background:linear-gradient(135deg,rgba(5,25,46,.92) 0%,rgba(8,38,67,.84) 48%,rgba(13,55,96,.70) 100%)}
html.dark-theme .um-back:hover{color:#FFB454}
@media(max-width:900px){.um-title-row{align-items:flex-start;flex-direction:column}.um-header-actions{width:100%;align-items:flex-start;flex-direction:row;flex-wrap:wrap}}
@media(max-width:640px){.um-header{min-height:0;padding:22px 20px;border-radius:18px}.um-title{font-size:40px}.um-header-actions{flex-direction:column;align-items:stretch}.um-status-card{min-width:0;width:100%}.um-add-btn{width:100%}}
</style>
<div class="ba-rampung-page space-y-6">
    <section class="um-header">
        <div class="um-header-content">
            <a href="{{ route('dashboard') }}" class="um-back">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 12H5"/><path d="M12 19l-7-7 7-7"/>
                </svg>
                Kembali ke Dashboard
            </a>
            <div class="um-title-row">
                <div class="um-title-wrap">
                    <div class="um-kicker">PENGATURAN</div>
                    <h1 class="um-title">Riwayat <span class="um-title-accent">Sampah</span></h1>
                    <p class="um-subtitle">Kelola BA Rampung yang dihapus, pulihkan data, atau hapus secara permanen.</p>
                </div>
                <div class="um-header-actions">
                    <div class="um-status-card">
                        <span class="um-status-label">STATUS DATA</span>
                        <span class="um-status-value">{{ $items->total() }} data di sampah</span>
                    </div>
                    <a href="{{ route('ba-rampung.index') }}" class="um-add-btn">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M19 12H5"/><path d="M12 19l-7-7 7-7"/>
                        </svg>
                        Daftar BA Rampung
                    </a>
                </div>
            </div>
        </div>
    </section>
    {{-- Tab Pengaturan: Manajemen User, Log Aktivitas, Riwayat Sampah --}}
    @include('pengaturan._tabs')
    <section class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-xl">
        <div class="border-b border-slate-200 p-5 sm:p-6">
            <form method="GET" action="{{ route('ba-rampung.trash.index') }}" class="flex flex-wrap gap-3">
                <input name="search" value="{{ request('search') }}" placeholder="Cari nomor BA, gudang, atau mitra" class="min-w-[230px] flex-1 rounded-xl border border-slate-300 px-4 py-2 text-slate-900">
                <button type="submit" class="rounded-xl bg-[#123F7A] px-5 py-2 font-semibold text-white">Cari</button>
                <a href="{{ route('ba-rampung.trash.index') }}" class="rounded-xl border border-slate-300 px-5 py-2 font-semibold text-slate-600">Reset</a>
            </form>
            <p class="mt-3 text-sm text-slate-500">{{ $items->total() }} BA dalam hasil pencarian. Pilih semua hanya memilih baris pada halaman ini (maksimal 20).</p>
        </div>
        <form id="bulk-trash" method="POST" action="{{ route('ba-rampung.trash.bulk') }}" class="border-b border-slate-200 p-4 sm:p-5" data-ba-confirm="bulk">
            @csrf
            <div class="flex flex-wrap items-center gap-3">
                <label class="flex items-center gap-2 text-sm font-semibold text-slate-700"><input type="checkbox" id="select-all-trash"> Pilih semua di halaman ini</label>
                <select name="action" required class="rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-900">
                    <option value="restore">Restore terpilih</option>
                    <option value="delete">Hapus permanen terpilih</option>
                </select>
                <button type="submit" class="rounded-lg bg-[#123F7A] px-4 py-2 text-sm font-bold text-white">Proses pilihan</button>
            </div>
        </form>
        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm">
                <thead class="bg-slate-100 text-slate-700"><tr>
                    <th class="p-4">Pilih</th><th class="p-4">Nomor BA</th><th class="p-4">Tanggal BA</th><th class="p-4">Gudang</th><th class="p-4">Mitra</th><th class="p-4">Dihapus pada</th><th class="p-4">Aksi</th>
                </tr></thead>
                <tbody>
                @forelse($items as $ba)
                    <tr class="border-t border-slate-200">
                        <td class="p-4"><input type="checkbox" form="bulk-trash" name="ids[]" value="{{ $ba->id }}" class="trash-check" aria-label="Pilih BA {{ $ba->nomor_ba }}"></td>
                        <td class="p-4 font-bold text-[#123F7A]">{{ $ba->nomor_ba }}</td>
                        <td class="p-4">{{ optional($ba->tanggal_ba)->format('d/m/Y') ?? '-' }}</td>
                        <td class="p-4">{{ $ba->gudang?->nama_gudang ?? '-' }}</td>
                        <td class="p-4">{{ $ba->mitraPengolahan?->nama_mitra ?? '-' }}</td>
                        <td class="p-4">{{ optional($ba->deleted_at)->format('d/m/Y H:i') }}</td>
                        <td class="p-4"><div class="flex flex-wrap gap-2">
                            <form method="POST" action="{{ route('ba-rampung.trash.restore', $ba->id) }}" data-ba-confirm="restore" data-ba-label="{{ $ba->nomor_ba }}">@csrf @method('PATCH')<button class="rounded-lg border border-green-300 px-3 py-2 font-semibold text-green-700">Restore</button></form>
                            <form method="POST" action="{{ route('ba-rampung.trash.force-delete', $ba->id) }}" data-ba-confirm="permanent" data-ba-label="{{ $ba->nomor_ba }}">@csrf @method('DELETE')<button class="rounded-lg border border-red-300 px-3 py-2 font-semibold text-red-700">Hapus permanen</button></form>
                        </div></td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="p-12 text-center text-slate-500">Belum ada BA Rampung di sampah.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-5">{{ $items->links() }}</div>
    </section>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const master = document.getElementById('select-all-trash');
    const checks = [...document.querySelectorAll('.trash-check')];
    if (master) master.addEventListener('change', () => checks.forEach(c => c.checked = master.checked));
    checks.forEach(c => c.addEventListener('change', () => {
        master.checked = checks.length > 0 && checks.every(x => x.checked);
    }));
});
</script>
@include('components.ba-action-modal')

@endsection
