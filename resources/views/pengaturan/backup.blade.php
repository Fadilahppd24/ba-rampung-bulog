@extends('layouts.app')

@section('title', 'Backup & Restore')

@section('content')

@include('pengaturan._tabs')

<div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
    <div class="card p-6">
        <h3 class="font-semibold text-gray-900 mb-2">💾 Backup Data</h3>
        <p class="text-sm text-gray-500 mb-4">
            Mengunduh salinan data master (Gudang, Mitra Pengolahan, Pegawai, Pimpinan Cabang) dalam format JSON.
            Ini adalah backup logis data master, bukan dump SQL mentah — cukup untuk memulihkan data master jika hilang.
        </p>
        <a href="{{ route('pengaturan.backup.download') }}" class="btn-primary">⬇️ Download Backup (.json)</a>
    </div>

    <div class="card p-6">
        <h3 class="font-semibold text-gray-900 mb-2">📤 Restore Data</h3>
        <p class="text-sm text-gray-500 mb-4">
            Mengunggah file backup (.json). Proses ini <strong>hanya menambahkan</strong> data yang belum ada
            (berdasarkan Kode Gudang / Kode Mitra / NIP) — data yang sudah ada di database <strong>tidak akan diubah atau ditimpa</strong>.
        </p>
        <form method="POST" action="{{ route('pengaturan.restore') }}" enctype="multipart/form-data" class="space-y-3">
            @csrf
            <input type="file" name="file" accept="application/json" required class="input">
            <button type="submit" class="btn-secondary" onclick="return confirm('Lanjutkan restore dari file ini? Data yang sudah ada tidak akan diubah, hanya data baru yang ditambahkan.');">
                📤 Restore dari File
            </button>
        </form>
    </div>
</div>

@endsection
