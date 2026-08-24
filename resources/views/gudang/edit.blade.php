@extends('layouts.app')

@section('title', 'Edit Gudang')

@section('content')

<form method="POST" action="{{ route('gudang.update', $gudang) }}" class="card p-6 space-y-5 max-w-3xl">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <div>
            <label class="label">Kode Gudang</label>
            <input type="text" name="kode_gudang" value="{{ old('kode_gudang', $gudang->kode_gudang) }}" required class="input">
        </div>
        <div>
            <label class="label">Nama Gudang</label>
            <input type="text" name="nama_gudang" value="{{ old('nama_gudang', $gudang->nama_gudang) }}" required class="input">
        </div>
        <div class="md:col-span-2">
            <label class="label">Alamat</label>
            <textarea name="alamat" rows="2" class="input">{{ old('alamat', $gudang->alamat) }}</textarea>
        </div>
        <div>
            <label class="label">Kecamatan</label>
            <input type="text" name="kecamatan" value="{{ old('kecamatan', $gudang->kecamatan) }}" class="input">
        </div>
        <div>
            <label class="label">Desa</label>
            <input type="text" name="desa" value="{{ old('desa', $gudang->desa) }}" class="input">
        </div>
        <div>
            <label class="label">Nomor Telepon</label>
            <input type="text" name="nomor_telepon" value="{{ old('nomor_telepon', $gudang->nomor_telepon) }}" class="input">
        </div>
        <div>
            <label class="label">Email</label>
            <input type="email" name="email" value="{{ old('email', $gudang->email) }}" class="input">
        </div>
        <div>
            <label class="label">Kapasitas (Ton)</label>
            <input type="number" step="0.01" name="kapasitas" value="{{ old('kapasitas', $gudang->kapasitas) }}" class="input">
        </div>
        <div>
            <label class="label">Status</label>
            <select name="status" class="input">
                <option value="aktif" @selected(old('status', $gudang->status) === 'aktif')>Aktif</option>
                <option value="nonaktif" @selected(old('status', $gudang->status) === 'nonaktif')>Nonaktif</option>
            </select>
        </div>
    </div>

    <div class="flex justify-between pt-2">
        <a href="{{ route('gudang.show', $gudang) }}" class="btn-secondary">← Kembali</a>
        <button type="submit" class="btn-primary">💾 Simpan Perubahan</button>
    </div>
</form>

@endsection
