@extends('layouts.app')
@section('title', 'Riwayat Sampah BA Rampung')
@section('content')
<div class="ba-rampung-page space-y-6">
    <section class="rounded-3xl border border-white/20 bg-[#123F7A]/90 p-8 text-white shadow-xl">
        <p class="text-sm font-semibold tracking-widest text-orange-300">SISTEM BA RAMPUNG</p>
        <h1 class="dashboard-display mt-2 text-4xl font-normal">Riwayat <span class="text-orange-300">Sampah.</span></h1>
        <p class="mt-3 text-sm text-white/80">Khusus Admin Kantor. Pulihkan BA yang terhapus atau hapus permanen dengan hati-hati.</p>
        <a class="mt-5 inline-block rounded-xl bg-[#F28C28] px-5 py-3 text-sm font-bold text-white" href="{{ route('ba-rampung.index') }}">← Kembali ke Daftar BA</a>
    </section>
    {{-- Tab Pengaturan: Manajemen User, Log Aktivitas, Riwayat Sampah --}}
    @include('pengaturan._tabs')
    @if(session('success'))<div class="rounded-xl border border-green-200 bg-green-50 p-4 text-green-800">{{ session('success') }}</div>@endif
    @if($errors->any())<div class="rounded-xl border border-red-200 bg-red-50 p-4 text-red-800">{{ $errors->first() }}</div>@endif
    <section class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-xl">
        <div class="border-b border-slate-200 p-5 sm:p-6">
            <form method="GET" action="{{ route('ba-rampung.trash.index') }}" class="flex flex-wrap gap-3">
                <input name="search" value="{{ request('search') }}" placeholder="Cari nomor BA, gudang, atau mitra" class="min-w-[230px] flex-1 rounded-xl border border-slate-300 px-4 py-2 text-slate-900">
                <button type="submit" class="rounded-xl bg-[#123F7A] px-5 py-2 font-semibold text-white">Cari</button>
                <a href="{{ route('ba-rampung.trash.index') }}" class="rounded-xl border border-slate-300 px-5 py-2 font-semibold text-slate-600">Reset</a>
            </form>
            <p class="mt-3 text-sm text-slate-500">{{ $items->total() }} BA dalam hasil pencarian. Pilih semua hanya memilih baris pada halaman ini (maksimal 20).</p>
        </div>
        <form id="bulk-trash" method="POST" action="{{ route('ba-rampung.trash.bulk') }}" class="border-b border-slate-200 p-4 sm:p-5" onsubmit="return confirm(this.querySelector('select[name=action]').value === 'delete' ? 'HAPUS PERMANEN BA terpilih? Ini tidak dapat dibatalkan.' : 'Pulihkan BA terpilih?')">
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
                            <form method="POST" action="{{ route('ba-rampung.trash.restore', $ba->id) }}" onsubmit="return confirm('Pulihkan BA ini?')">@csrf @method('PATCH')<button class="rounded-lg border border-green-300 px-3 py-2 font-semibold text-green-700">Restore</button></form>
                            <form method="POST" action="{{ route('ba-rampung.trash.force-delete', $ba->id) }}" onsubmit="return confirm('Hapus permanen BA ini? Tindakan tidak bisa dibatalkan.')">@csrf @method('DELETE')<button class="rounded-lg border border-red-300 px-3 py-2 font-semibold text-red-700">Hapus permanen</button></form>
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
@endsection
