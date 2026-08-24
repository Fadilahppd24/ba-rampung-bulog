@extends('layouts.app')

@section('title', 'Tambah Riwayat Pimpinan Cabang')

@section('content')

<div class="card p-4 bg-info-bg text-info-text text-sm max-w-2xl">
    Jika Status diatur ke <strong>Aktif</strong>, seluruh riwayat Pimpinan Cabang lain akan otomatis
    ditutup periodenya (dijadikan Nonaktif) — hanya boleh ada satu Pimpinan Cabang aktif pada satu waktu,
    karena data ini dipakai sebagai penandatangan "Mengetahui" pada setiap BA Rampung.
</div>

<form method="POST" action="{{ route('pimpinan.store') }}" class="card p-6 space-y-5 max-w-2xl">
    @csrf

    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <div class="md:col-span-2">
            <label class="label">Nama</label>
            <input type="text" name="nama" value="{{ old('nama') }}" required class="input">
        </div>
        <div class="md:col-span-2">
            <label class="label">Jabatan</label>
            <input type="text" name="jabatan" value="{{ old('jabatan', 'Pimpinan Cabang BULOG Indramayu') }}" required class="input">
        </div>
        <div>
            <label class="label">Periode Mulai</label>
            <input type="date" name="periode_mulai" value="{{ old('periode_mulai', now()->toDateString()) }}" required class="input">
        </div>
        <div>
            <label class="label">Periode Selesai (opsional)</label>
            <input type="date" name="periode_selesai" value="{{ old('periode_selesai') }}" class="input">
        </div>
        <div>
            <label class="label">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" class="input">
        </div>
        <div>
            <label class="label">Nomor Telepon</label>
            <input type="text" name="nomor_telepon" value="{{ old('nomor_telepon') }}" class="input">
        </div>
        <div class="md:col-span-2">
            <label class="label">Alamat Kantor</label>
            <textarea name="alamat" rows="2" class="input">{{ old('alamat') }}</textarea>
        </div>
        <div>
            <label class="label">Status</label>
            <select name="status" class="input">
                <option value="nonaktif" @selected(old('status', 'nonaktif') === 'nonaktif')>Nonaktif (riwayat)</option>
                <option value="aktif" @selected(old('status') === 'aktif')>Aktif (menjabat sekarang)</option>
            </select>
        </div>
    </div>

    <div class="flex justify-between pt-2">
        <a href="{{ route('pimpinan.index') }}" class="btn-secondary">← Kembali</a>
        <button type="submit" class="btn-primary">💾 Simpan</button>
    </div>
</form>

@endsection
