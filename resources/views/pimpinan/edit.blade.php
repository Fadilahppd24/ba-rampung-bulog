@extends('layouts.app')

@section('title', 'Edit Riwayat Pimpinan Cabang')

@section('content')

<div class="card p-4 bg-info-bg text-info-text text-sm max-w-2xl">
    Jika Status diatur ke <strong>Aktif</strong>, seluruh riwayat Pimpinan Cabang lain akan otomatis
    ditutup periodenya (dijadikan Nonaktif).
</div>

<form method="POST" action="{{ route('pimpinan.update', $pimpinan) }}" class="card p-6 space-y-5 max-w-2xl">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <div class="md:col-span-2">
            <label class="label">Nama</label>
            <input type="text" name="nama" value="{{ old('nama', $pimpinan->nama) }}" required class="input">
        </div>
        <div class="md:col-span-2">
            <label class="label">Jabatan</label>
            <input type="text" name="jabatan" value="{{ old('jabatan', $pimpinan->jabatan) }}" required class="input">
        </div>
        <div>
            <label class="label">Periode Mulai</label>
            <input type="date" name="periode_mulai" value="{{ old('periode_mulai', $pimpinan->periode_mulai->toDateString()) }}" required class="input">
        </div>
        <div>
            <label class="label">Periode Selesai (opsional)</label>
            <input type="date" name="periode_selesai" value="{{ old('periode_selesai', $pimpinan->periode_selesai?->toDateString()) }}" class="input">
        </div>
        <div>
            <label class="label">Email</label>
            <input type="email" name="email" value="{{ old('email', $pimpinan->email) }}" class="input">
        </div>
        <div>
            <label class="label">Nomor Telepon</label>
            <input type="text" name="nomor_telepon" value="{{ old('nomor_telepon', $pimpinan->nomor_telepon) }}" class="input">
        </div>
        <div class="md:col-span-2">
            <label class="label">Alamat Kantor</label>
            <textarea name="alamat" rows="2" class="input">{{ old('alamat', $pimpinan->alamat) }}</textarea>
        </div>
        <div>
            <label class="label">Status</label>
            <select name="status" class="input">
                <option value="nonaktif" @selected(old('status', $pimpinan->status) === 'nonaktif')>Nonaktif (riwayat)</option>
                <option value="aktif" @selected(old('status', $pimpinan->status) === 'aktif')>Aktif (menjabat sekarang)</option>
            </select>
        </div>
    </div>

    <div class="flex justify-between pt-2">
        <a href="{{ route('pimpinan.show', $pimpinan) }}" class="btn-secondary">← Kembali</a>
        <button type="submit" class="btn-primary">💾 Simpan Perubahan</button>
    </div>
</form>

@endsection
