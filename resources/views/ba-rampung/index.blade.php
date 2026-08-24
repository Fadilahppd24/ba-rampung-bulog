@extends('layouts.app')

@section('title', 'Daftar BA Rampung')

@section('content')

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
    <x-kpi-card icon="📄" label="Total BA Rampung" :value="number_format($kpi['total'])" />
    <x-kpi-card icon="✅" label="Terverifikasi" :value="number_format($kpi['terverifikasi'])" />
    <x-kpi-card icon="⏳" label="Belum Diserah" :value="number_format($kpi['belum_serah'])" />
    <x-kpi-card icon="⚠️" label="Ditolak / Catatan" :value="number_format($kpi['ditolak'])" />
    <x-kpi-card icon="🤝" label="Mitra Pengolahan" :value="number_format($kpi['mitra'])" />
</div>

<div class="card p-5">
    <form method="GET" action="{{ route('ba-rampung.index') }}" class="space-y-3">
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-3">
            <div class="lg:col-span-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Nomor BA, Gudang, atau Mitra…" class="input">
            </div>
            <select name="status" class="input">
                <option value="">Semua Status</option>
                @foreach (\App\Models\BaRampung::STATUSES as $val => $label)
                    <option value="{{ $val }}" @selected(request('status') === $val)>{{ $label }}</option>
                @endforeach
            </select>
            <select name="gudang_id" class="input">
                <option value="">Semua Gudang</option>
                @foreach ($gudangs as $g)
                    <option value="{{ $g->id }}" @selected((string) request('gudang_id') === (string) $g->id)>{{ $g->nama_gudang }}</option>
                @endforeach
            </select>
            <select name="mitra_pengolahan_id" class="input">
                <option value="">Semua Mitra</option>
                @foreach ($mitras as $m)
                    <option value="{{ $m->id }}" @selected((string) request('mitra_pengolahan_id') === (string) $m->id)>{{ $m->nama_mitra }}</option>
                @endforeach
            </select>
            <select name="bulan" class="input">
                <option value="">Semua Bulan</option>
                @foreach (range(1, 12) as $m)
                    <option value="{{ $m }}" @selected((string) request('bulan') === (string) $m)>{{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}</option>
                @endforeach
            </select>
        </div>

        <div class="flex items-center justify-between">
            <select name="tahun" class="input w-32">
                @foreach (range(now()->year, now()->year - 3) as $y)
                    <option value="{{ $y }}" @selected((string) request('tahun', now()->year) === (string) $y)>{{ $y }}</option>
                @endforeach
            </select>

            <div class="flex gap-2">
                <a href="{{ route('ba-rampung.index') }}" class="btn-secondary">↺ Reset</a>
                <a href="{{ route('ba-rampung.export', request()->query()) }}" class="btn-primary">⬇️ Export Excel</a>
                <button type="submit" class="btn-primary">Terapkan Filter</button>
            </div>
        </div>
    </form>
</div>

<div class="card overflow-hidden">
    <div class="flex items-center justify-between p-5 pb-0">
        <h3 class="font-semibold text-gray-900">Daftar BA Rampung</h3>
        <p class="text-sm text-gray-500">Menampilkan {{ $baList->firstItem() ?? 0 }}–{{ $baList->lastItem() ?? 0 }} dari {{ $baList->total() }} data</p>
    </div>

    <div class="overflow-x-auto mt-4">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-y border-gray-100 text-left text-gray-500">
                    <th class="px-5 py-3 font-medium">No.</th>
                    <th class="px-5 py-3 font-medium">Nomor BA</th>
                    <th class="px-5 py-3 font-medium">Tanggal BA</th>
                    <th class="px-5 py-3 font-medium">Gudang</th>
                    <th class="px-5 py-3 font-medium">Mitra Pengolahan</th>
                    <th class="px-5 py-3 font-medium">Status Verifikasi</th>
                    <th class="px-5 py-3 font-medium">Status PBP</th>
                    <th class="px-5 py-3 font-medium text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse ($baList as $i => $ba)
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-3 text-gray-500">{{ $baList->firstItem() + $i }}</td>
                        <td class="px-5 py-3 font-medium text-gray-900">{{ $ba->nomor_ba }}</td>
                        <td class="px-5 py-3 text-gray-600">{{ $ba->tanggal_ba->format('d/m/Y') }}</td>
                        <td class="px-5 py-3 text-gray-600">{{ $ba->gudang->nama_gudang }}</td>
                        <td class="px-5 py-3 text-gray-600">{{ $ba->mitraPengolahan->nama_mitra }}</td>
                        <td class="px-5 py-3"><x-status-badge :color="$ba->statusBadgeColor()" :label="$ba->statusLabel()" /></td>
                        <td class="px-5 py-3 text-gray-600">{{ $ba->statusPbpLabel() }}</td>
                        <td class="px-5 py-3">
                            <div class="flex justify-end gap-3 text-xs">
                                <a href="{{ route('ba-rampung.show', $ba) }}" class="text-bulog-700 hover:underline">Lihat</a>
                                @can('update', $ba)
                                    <a href="{{ route('ba-rampung.edit', $ba) }}" class="text-bulog-700 hover:underline">Edit</a>
                                @endcan
                                <a href="{{ route('ba-rampung.pdf', $ba) }}" target="_blank" class="text-bulog-700 hover:underline">PDF</a>
                                @can('delete', $ba)
                                    <form method="POST" action="{{ route('ba-rampung.destroy', $ba) }}" onsubmit="return confirm('Hapus BA Rampung {{ $ba->nomor_ba }}? Tindakan ini tidak dapat dibatalkan.');">
                                        @csrf @method('DELETE')
                                        <button class="text-danger-text hover:underline">Hapus</button>
                                    </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-5 py-16 text-center text-gray-500">
                            <p class="text-3xl mb-2">🗂️</p>
                            Belum ada data BA Rampung.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($baList->hasPages())
        <div class="p-5">{{ $baList->links() }}</div>
    @endif
</div>

@endsection
