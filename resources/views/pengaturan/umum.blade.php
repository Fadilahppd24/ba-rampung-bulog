@extends('layouts.app')

@section('title', 'Pengaturan Umum')

@section('content')

@include('pengaturan._tabs')

<form method="POST" action="{{ route('pengaturan.umum.update') }}" enctype="multipart/form-data" class="card p-6 space-y-5 max-w-2xl">
    @csrf

    <div>
        <label class="label">Nama Cabang</label>
        <input type="text" name="nama_cabang" value="{{ old('nama_cabang', $pengaturan->nama_cabang) }}" required class="input">
    </div>

    <div>
        <label class="label">Alamat Kantor</label>
        <textarea name="alamat_kantor" rows="2" class="input">{{ old('alamat_kantor', $pengaturan->alamat_kantor) }}</textarea>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <div>
            <label class="label">Telepon</label>
            <input type="text" name="telepon" value="{{ old('telepon', $pengaturan->telepon) }}" class="input">
        </div>
        <div>
            <label class="label">Email</label>
            <input type="email" name="email" value="{{ old('email', $pengaturan->email) }}" class="input">
        </div>
    </div>

    <div>
        <label class="label">Logo</label>
        <div class="flex items-center gap-4">
            @if ($pengaturan->logo_path)
                <img src="{{ \Illuminate\Support\Facades\Storage::url($pengaturan->logo_path) }}" alt="Logo" class="h-12 w-12 rounded-lg object-cover border border-gray-200">
            @else
                <div class="h-12 w-12 rounded-lg bg-bulog-cream flex items-center justify-center text-bulog-900 font-bold">B</div>
            @endif
            <input type="file" name="logo" accept="image/*" class="input">
        </div>
        <p class="text-xs text-gray-400 mt-1">Format JPG/PNG, ukuran maksimal 2MB.</p>
    </div>

    <div>
        <label class="label">Warna Tema</label>
        <div class="flex items-center gap-3">
            <input type="color" name="warna_tema" value="{{ old('warna_tema', $pengaturan->warna_tema) }}" class="h-10 w-16 rounded border border-gray-300">
            <span class="text-sm text-gray-500">{{ old('warna_tema', $pengaturan->warna_tema) }}</span>
        </div>
    </div>

    <div class="flex justify-end pt-2">
        <button type="submit" class="btn-primary">💾 Simpan Perubahan</button>
    </div>
</form>

@endsection
