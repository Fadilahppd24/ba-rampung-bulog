@extends('layouts.app')

@section('title', 'Gudang')

@section('content')

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
    <x-kpi-card icon="🏠" label="Total Gudang" :value="number_format($kpi['total'])" />
    <x-kpi-card icon="✅" label="Gudang Aktif" :value="number_format($kpi['aktif'])" />
    <x-kpi-card icon="📄" label="Total Dokumen" :value="number_format($kpi['total_dokumen'])" />
    <x-kpi-card icon="⏳" label="Gudang dengan Proses" :value="number_format($kpi['dengan_proses'])" />
</div>

<div class="card p-5">
    <form method="GET" action="{{ route('gudang.index') }}" class="flex flex-col sm:flex-row gap-3 sm:items-center sm:justify-between">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama gudang atau kode gudang…" class="input sm:max-w-sm">
        <div class="flex gap-2">
            <button type="submit" class="btn-secondary">Cari</button>
            @role('admin_gudang', 'admin_sistem')
                <a href="{{ route('gudang.create') }}" class="btn-primary">➕ Tambah Gudang</a>
            @endrole
        </div>
    </form>
</div>

<div class="card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-y border-gray-100 text-left text-gray-500">
                    <th class="px-5 py-3 font-medium">No.</th>
                    <th class="px-5 py-3 font-medium">Kode Gudang</th>
                    <th class="px-5 py-3 font-medium">Nama Gudang</th>
                    <th class="px-5 py-3 font-medium">Alamat</th>
                    <th class="px-5 py-3 font-medium">Kontak</th>
                    <th class="px-5 py-3 font-medium">Status</th>
                    <th class="px-5 py-3 font-medium text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse ($gudangs as $i => $g)
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-3 text-gray-500">{{ $gudangs->firstItem() + $i }}</td>
                        <td class="px-5 py-3 font-medium text-gray-900">{{ $g->kode_gudang }}</td>
                        <td class="px-5 py-3 text-gray-700">{{ $g->nama_gudang }}</td>
                        <td class="px-5 py-3 text-gray-600">{{ $g->alamat ?? '-' }}</td>
                        <td class="px-5 py-3 text-gray-600">{{ $g->nomor_telepon ?? '-' }}</td>
                        <td class="px-5 py-3">
                            <x-status-badge :color="$g->status === 'aktif' ? 'green' : 'gray'" :label="ucfirst($g->status)" />
                        </td>
                        <td class="px-5 py-3">
                            <div class="flex justify-end gap-3 text-xs">
                                <a href="{{ route('gudang.show', $g) }}" class="text-bulog-700 hover:underline">Detail</a>
                                @role('admin_gudang', 'admin_sistem')
                                    <a href="{{ route('gudang.edit', $g) }}" class="text-bulog-700 hover:underline">Edit</a>
                                    <form method="POST" action="{{ route('gudang.toggle-status', $g) }}"
                                          onsubmit="return confirm('{{ $g->status === 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }} gudang {{ $g->nama_gudang }}?');">
                                        @csrf @method('PATCH')
                                        <button class="text-gray-500 hover:underline">{{ $g->status === 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }}</button>
                                    </form>
                                @endrole
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-5 py-16 text-center text-gray-500">
                            <p class="text-3xl mb-2">🏠</p>
                            Belum ada data Gudang.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($gudangs->hasPages())
        <div class="p-5">{{ $gudangs->links() }}</div>
    @endif
</div>

@endsection
