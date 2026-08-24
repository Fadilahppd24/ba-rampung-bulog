@extends('layouts.app')

@section('title', 'Mitra Pengolahan')

@section('content')

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
    <x-kpi-card icon="🤝" label="Total Mitra" :value="number_format($kpi['total'])" />
    <x-kpi-card icon="✅" label="Mitra Aktif" :value="number_format($kpi['aktif'])" />
    <x-kpi-card icon="📄" label="Total BA" :value="number_format($kpi['total_ba'])" />
    <x-kpi-card icon="⏳" label="Mitra dengan Proses" :value="number_format($kpi['dengan_proses'])" />
</div>

<div class="card p-5">
    <form method="GET" action="{{ route('mitra.index') }}" class="flex flex-col sm:flex-row gap-3 sm:items-center sm:justify-between">
        <div class="flex flex-col sm:flex-row gap-3 flex-1">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama mitra atau kode mitra…" class="input sm:max-w-sm">
            <select name="jenis_usaha" class="input sm:max-w-xs" onchange="this.form.submit()">
                <option value="">Pilih Jenis Usaha</option>
                @foreach ($jenisUsahaOptions as $j)
                    <option value="{{ $j }}" @selected(request('jenis_usaha') === $j)>{{ $j }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex gap-2">
            <button type="submit" class="btn-secondary">Cari</button>
            @role('admin_gudang', 'admin_sistem')
                <a href="{{ route('mitra.create') }}" class="btn-primary">➕ Tambah Mitra</a>
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
                    <th class="px-5 py-3 font-medium">Kode Mitra</th>
                    <th class="px-5 py-3 font-medium">Nama Mitra</th>
                    <th class="px-5 py-3 font-medium">Jenis Usaha</th>
                    <th class="px-5 py-3 font-medium">Alamat</th>
                    <th class="px-5 py-3 font-medium">Kontak</th>
                    <th class="px-5 py-3 font-medium">Status</th>
                    <th class="px-5 py-3 font-medium text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse ($mitras as $i => $m)
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-3 text-gray-500">{{ $mitras->firstItem() + $i }}</td>
                        <td class="px-5 py-3 font-medium text-gray-900">{{ $m->kode_mitra }}</td>
                        <td class="px-5 py-3 text-gray-700">{{ $m->nama_mitra }}</td>
                        <td class="px-5 py-3 text-gray-600">{{ $m->jenis_usaha ?? '-' }}</td>
                        <td class="px-5 py-3 text-gray-600">{{ $m->alamat ?? '-' }}</td>
                        <td class="px-5 py-3 text-gray-600">{{ $m->nomor_telepon ?? '-' }}</td>
                        <td class="px-5 py-3">
                            <x-status-badge :color="$m->status === 'aktif' ? 'green' : 'gray'" :label="ucfirst($m->status)" />
                        </td>
                        <td class="px-5 py-3">
                            <div class="flex justify-end gap-3 text-xs">
                                <a href="{{ route('mitra.show', $m) }}" class="text-bulog-700 hover:underline">Detail</a>
                                @role('admin_gudang', 'admin_sistem')
                                    <a href="{{ route('mitra.edit', $m) }}" class="text-bulog-700 hover:underline">Edit</a>
                                    <form method="POST" action="{{ route('mitra.toggle-status', $m) }}"
                                          onsubmit="return confirm('{{ $m->status === 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }} mitra {{ $m->nama_mitra }}?');">
                                        @csrf @method('PATCH')
                                        <button class="text-gray-500 hover:underline">{{ $m->status === 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }}</button>
                                    </form>
                                @endrole
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-5 py-16 text-center text-gray-500">
                            <p class="text-3xl mb-2">🤝</p>
                            Belum ada data Mitra Pengolahan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($mitras->hasPages())
        <div class="p-5">{{ $mitras->links() }}</div>
    @endif
</div>

@endsection
