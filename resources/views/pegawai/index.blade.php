@extends('layouts.app')

@section('title', 'Pegawai')

@section('content')

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
    <x-kpi-card icon="👤" label="Total Pegawai" :value="number_format($kpi['total'])" />
    <x-kpi-card icon="✅" label="Pegawai Aktif" :value="number_format($kpi['aktif'])" />
    <x-kpi-card icon="🚫" label="Pegawai Nonaktif" :value="number_format($kpi['nonaktif'])" />
    <x-kpi-card icon="🛡️" label="Admin Sistem" :value="number_format($kpi['admin_sistem'])" />
</div>

<div class="card p-5">
    <form method="GET" action="{{ route('pegawai.index') }}" class="flex flex-col sm:flex-row gap-3 sm:items-center sm:justify-between">
        <div class="flex flex-col sm:flex-row gap-3 flex-1">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama pegawai atau NIP…" class="input sm:max-w-sm">
            <select name="jabatan" class="input sm:max-w-xs" onchange="this.form.submit()">
                <option value="">Pilih Jabatan</option>
                @foreach ($jabatanOptions as $j)
                    <option value="{{ $j }}" @selected(request('jabatan') === $j)>{{ $j }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex gap-2">
            <button type="submit" class="btn-secondary">Cari</button>
            @role('admin_gudang', 'admin_sistem')
                <a href="{{ route('pegawai.create') }}" class="btn-primary">➕ Tambah Pegawai</a>
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
                    <th class="px-5 py-3 font-medium">NIP</th>
                    <th class="px-5 py-3 font-medium">Nama</th>
                    <th class="px-5 py-3 font-medium">Jabatan</th>
                    <th class="px-5 py-3 font-medium">Gudang</th>
                    <th class="px-5 py-3 font-medium">Kontak</th>
                    <th class="px-5 py-3 font-medium">Status</th>
                    <th class="px-5 py-3 font-medium text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse ($pegawais as $i => $p)
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-3 text-gray-500">{{ $pegawais->firstItem() + $i }}</td>
                        <td class="px-5 py-3 font-medium text-gray-900">{{ $p->nip }}</td>
                        <td class="px-5 py-3 text-gray-700">{{ $p->nama }}</td>
                        <td class="px-5 py-3 text-gray-600">{{ $p->jabatan }}</td>
                        <td class="px-5 py-3 text-gray-600">{{ $p->gudang->nama_gudang ?? '-' }}</td>
                        <td class="px-5 py-3 text-gray-600">{{ $p->nomor_telepon ?? '-' }}</td>
                        <td class="px-5 py-3">
                            <x-status-badge :color="$p->status === 'aktif' ? 'green' : 'gray'" :label="ucfirst($p->status)" />
                        </td>
                        <td class="px-5 py-3">
                            <div class="flex justify-end gap-3 text-xs">
                                <a href="{{ route('pegawai.show', $p) }}" class="text-bulog-700 hover:underline">Detail</a>
                                @role('admin_gudang', 'admin_sistem')
                                    <a href="{{ route('pegawai.edit', $p) }}" class="text-bulog-700 hover:underline">Edit</a>
                                    <form method="POST" action="{{ route('pegawai.toggle-status', $p) }}"
                                          onsubmit="return confirm('{{ $p->status === 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }} pegawai {{ $p->nama }}?');">
                                        @csrf @method('PATCH')
                                        <button class="text-gray-500 hover:underline">{{ $p->status === 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }}</button>
                                    </form>
                                @endrole
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-5 py-16 text-center text-gray-500">
                            <p class="text-3xl mb-2">👤</p>
                            Belum ada data Pegawai.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($pegawais->hasPages())
        <div class="p-5">{{ $pegawais->links() }}</div>
    @endif
</div>

@endsection
