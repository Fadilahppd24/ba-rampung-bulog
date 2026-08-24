@extends('layouts.app')

@section('title', 'Detail Mitra Pengolahan')

@section('content')

<div class="flex items-center justify-between">
    <div>
        <h2 class="text-lg font-semibold text-gray-900">{{ $mitra->nama_mitra }}</h2>
        <p class="text-sm text-gray-500">{{ $mitra->kode_mitra }}</p>
    </div>
    <div class="flex items-center gap-3">
        <x-status-badge :color="$mitra->status === 'aktif' ? 'green' : 'gray'" :label="ucfirst($mitra->status)" />
        @role('admin_gudang', 'admin_sistem')
            <a href="{{ route('mitra.edit', $mitra) }}" class="btn-secondary">✏️ Edit</a>
        @endrole
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
    <div class="card p-6 lg:col-span-1">
        <h3 class="font-semibold text-gray-900 mb-4">Informasi Mitra</h3>
        <dl class="space-y-3 text-sm">
            <div><dt class="text-gray-500">Jenis Usaha</dt><dd class="font-medium">{{ $mitra->jenis_usaha ?? '-' }}</dd></div>
            <div><dt class="text-gray-500">Penanggung Jawab</dt><dd class="font-medium">{{ $mitra->penanggung_jawab ?? '-' }}</dd></div>
            <div><dt class="text-gray-500">Alamat</dt><dd class="font-medium">{{ $mitra->alamat ?? '-' }}</dd></div>
            <div><dt class="text-gray-500">Kecamatan / Desa</dt><dd class="font-medium">{{ $mitra->kecamatan ?? '-' }} / {{ $mitra->desa ?? '-' }}</dd></div>
            <div><dt class="text-gray-500">Telepon</dt><dd class="font-medium">{{ $mitra->nomor_telepon ?? '-' }}</dd></div>
            <div><dt class="text-gray-500">Email</dt><dd class="font-medium">{{ $mitra->email ?? '-' }}</dd></div>
            <div><dt class="text-gray-500">Total BA Rampung</dt><dd class="font-medium">{{ $mitra->ba_rampungs_count }}</dd></div>
        </dl>
    </div>

    <div class="card p-6 lg:col-span-2">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-semibold text-gray-900">🧾 BA Rampung Terbaru dari Mitra Ini</h3>
            <a href="{{ route('ba-rampung.index', ['mitra_pengolahan_id' => $mitra->id]) }}" class="text-sm text-bulog-700 hover:underline">Lihat Semua →</a>
        </div>
        @if ($baTerbaru->isEmpty())
            <p class="text-sm text-gray-500 py-6 text-center">Belum ada data BA Rampung.</p>
        @else
            <div class="divide-y divide-gray-100">
                @foreach ($baTerbaru as $ba)
                    <a href="{{ route('ba-rampung.show', $ba) }}" class="flex items-center justify-between py-3 hover:bg-gray-50 -mx-2 px-2 rounded-lg">
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ $ba->nomor_ba }}</p>
                            <p class="text-xs text-gray-500">{{ $ba->gudang->nama_gudang }}</p>
                        </div>
                        <x-status-badge :color="$ba->statusBadgeColor()" :label="$ba->statusLabel()" />
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</div>

@endsection
