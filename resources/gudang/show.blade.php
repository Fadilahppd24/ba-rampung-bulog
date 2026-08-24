@extends('layouts.app')

@section('title', 'Detail Gudang')

@section('content')

<div class="flex items-center justify-between">
    <div>
        <h2 class="text-lg font-semibold text-gray-900">{{ $gudang->nama_gudang }}</h2>
        <p class="text-sm text-gray-500">{{ $gudang->kode_gudang }}</p>
    </div>
    <div class="flex items-center gap-3">
        <x-status-badge :color="$gudang->status === 'aktif' ? 'green' : 'gray'" :label="ucfirst($gudang->status)" />
        @role('admin_gudang', 'admin_sistem')
            <a href="{{ route('gudang.edit', $gudang) }}" class="btn-secondary">✏️ Edit</a>
        @endrole
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
    <div class="card p-6 lg:col-span-1">
        <h3 class="font-semibold text-gray-900 mb-4">Informasi Gudang</h3>
        <dl class="space-y-3 text-sm">
            <div><dt class="text-gray-500">Alamat</dt><dd class="font-medium">{{ $gudang->alamat ?? '-' }}</dd></div>
            <div><dt class="text-gray-500">Kecamatan / Desa</dt><dd class="font-medium">{{ $gudang->kecamatan ?? '-' }} / {{ $gudang->desa ?? '-' }}</dd></div>
            <div><dt class="text-gray-500">Telepon</dt><dd class="font-medium">{{ $gudang->nomor_telepon ?? '-' }}</dd></div>
            <div><dt class="text-gray-500">Email</dt><dd class="font-medium">{{ $gudang->email ?? '-' }}</dd></div>
            <div><dt class="text-gray-500">Kapasitas</dt><dd class="font-medium">{{ $gudang->kapasitas ? number_format($gudang->kapasitas, 2) . ' Ton' : '-' }}</dd></div>
            <div><dt class="text-gray-500">Total BA Rampung</dt><dd class="font-medium">{{ $gudang->ba_rampungs_count }}</dd></div>
        </dl>
    </div>

    <div class="card p-6 lg:col-span-2">
        <h3 class="font-semibold text-gray-900 mb-4">👤 Pegawai di Gudang Ini</h3>
        @if ($gudang->pegawais->isEmpty())
            <p class="text-sm text-gray-500">Belum ada pegawai terdaftar di gudang ini.</p>
        @else
            <div class="divide-y divide-gray-100">
                @foreach ($gudang->pegawais as $p)
                    <div class="flex items-center justify-between py-2.5 text-sm">
                        <div>
                            <p class="font-medium text-gray-900">{{ $p->nama }}</p>
                            <p class="text-xs text-gray-500">{{ $p->jabatan }} · {{ $p->nip }}</p>
                        </div>
                        <span class="text-gray-500">{{ $p->nomor_telepon ?? '-' }}</span>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

<div class="card p-6">
    <div class="flex items-center justify-between mb-4">
        <h3 class="font-semibold text-gray-900">🧾 BA Rampung Terbaru dari Gudang Ini</h3>
        <a href="{{ route('ba-rampung.index', ['gudang_id' => $gudang->id]) }}" class="text-sm text-bulog-700 hover:underline">Lihat Semua →</a>
    </div>
    @if ($baTerbaru->isEmpty())
        <p class="text-sm text-gray-500 py-6 text-center">Belum ada data BA Rampung.</p>
    @else
        <div class="divide-y divide-gray-100">
            @foreach ($baTerbaru as $ba)
                <a href="{{ route('ba-rampung.show', $ba) }}" class="flex items-center justify-between py-3 hover:bg-gray-50 -mx-2 px-2 rounded-lg">
                    <div>
                        <p class="text-sm font-medium text-gray-900">{{ $ba->nomor_ba }}</p>
                        <p class="text-xs text-gray-500">{{ $ba->mitraPengolahan->nama_mitra }}</p>
                    </div>
                    <x-status-badge :color="$ba->statusBadgeColor()" :label="$ba->statusLabel()" />
                </a>
            @endforeach
        </div>
    @endif
</div>

@endsection
