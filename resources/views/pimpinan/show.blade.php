@extends('layouts.app')

@section('title', 'Detail Pimpinan Cabang')

@section('content')

<div class="flex items-center justify-between">
    <div>
        <h2 class="text-lg font-semibold text-gray-900">{{ $pimpinan->nama }}</h2>
        <p class="text-sm text-gray-500">{{ $pimpinan->jabatan }}</p>
    </div>
    <div class="flex items-center gap-3">
        <x-status-badge :color="$pimpinan->status === 'aktif' ? 'green' : 'gray'" :label="ucfirst($pimpinan->status)" />
        @role('admin_sistem')
            <a href="{{ route('pimpinan.edit', $pimpinan) }}" class="btn-secondary">✏️ Edit</a>
        @endrole
    </div>
</div>

<div class="card p-6 max-w-2xl">
    <h3 class="font-semibold text-gray-900 mb-4">Informasi</h3>
    <dl class="space-y-3 text-sm">
        <div class="flex justify-between"><dt class="text-gray-500">Periode</dt><dd class="font-medium">{{ $pimpinan->periode_mulai->format('d/m/Y') }} – {{ $pimpinan->periode_selesai?->format('d/m/Y') ?? 'Sekarang' }}</dd></div>
        <div class="flex justify-between"><dt class="text-gray-500">Email</dt><dd class="font-medium">{{ $pimpinan->email ?? '-' }}</dd></div>
        <div class="flex justify-between"><dt class="text-gray-500">Telepon</dt><dd class="font-medium">{{ $pimpinan->nomor_telepon ?? '-' }}</dd></div>
        <div class="flex justify-between"><dt class="text-gray-500">Alamat Kantor</dt><dd class="font-medium">{{ $pimpinan->alamat ?? '-' }}</dd></div>
    </dl>
</div>

<a href="{{ route('pimpinan.index') }}" class="btn-secondary inline-flex">← Kembali ke Riwayat</a>

@endsection
