@extends('layouts.app')

@section('title', 'Detail Pegawai')

@section('content')

<div class="flex items-center justify-between">
    <div>
        <h2 class="text-lg font-semibold text-gray-900">{{ $pegawai->nama }}</h2>
        <p class="text-sm text-gray-500">{{ $pegawai->nip }} · {{ $pegawai->jabatan }}</p>
    </div>
    <div class="flex items-center gap-3">
        <x-status-badge :color="$pegawai->status === 'aktif' ? 'green' : 'gray'" :label="ucfirst($pegawai->status)" />
        @role('admin_gudang', 'admin_sistem')
            <a href="{{ route('pegawai.edit', $pegawai) }}" class="btn-secondary">✏️ Edit</a>
        @endrole
    </div>
</div>

<div class="card p-6 max-w-2xl">
    <h3 class="font-semibold text-gray-900 mb-4">Informasi Pegawai</h3>
    <dl class="space-y-3 text-sm">
        <div class="flex justify-between"><dt class="text-gray-500">NIP</dt><dd class="font-medium">{{ $pegawai->nip }}</dd></div>
        <div class="flex justify-between"><dt class="text-gray-500">Nama</dt><dd class="font-medium">{{ $pegawai->nama }}</dd></div>
        <div class="flex justify-between"><dt class="text-gray-500">Jabatan</dt><dd class="font-medium">{{ $pegawai->jabatan }}</dd></div>
        <div class="flex justify-between"><dt class="text-gray-500">Gudang</dt><dd class="font-medium">{{ $pegawai->gudang->nama_gudang ?? '— Tidak terikat gudang —' }}</dd></div>
        <div class="flex justify-between"><dt class="text-gray-500">Telepon</dt><dd class="font-medium">{{ $pegawai->nomor_telepon ?? '-' }}</dd></div>
        <div class="flex justify-between"><dt class="text-gray-500">Email</dt><dd class="font-medium">{{ $pegawai->email ?? '-' }}</dd></div>
    </dl>
</div>

@endsection
