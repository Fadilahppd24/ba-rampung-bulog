@extends('layouts.app')

@section('title', 'Tambah Gudang')

@section('content')

<form method="POST" action="{{ route('gudang.store') }}" class="card p-6 space-y-5 max-w-3xl">
    @csrf

    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <div>
            <label class="label">Kode Gudang</label>
            <input type="text" name="kode_gudang" value="{{ old('kode_gudang') }}" required class="input" placeholder="GDG-007">
        </div>
        <div>
            <label class="label">Nama Gudang</label>
            <input type="text" name="nama_gudang" value="{{ old('nama_gudang') }}" required class="input" placeholder="Gudang Cikedung">
        </div>
        <div class="md:col-span-2">
            <label class="label">Alamat</label>
            <textarea name="alamat" rows="2" class="input">{{ old('alamat') }}</textarea>
        </div>
        <div>
            <label class="label">Kecamatan</label>
            <input type="text" name="kecamatan" value="{{ old('kecamatan') }}" class="input">
        </div>
        <div>
            <label class="label">Desa</label>
            <input type="text" name="desa" value="{{ old('desa') }}" class="input">
        </div>
        <div>
            <label class="label">Nomor Telepon</label>
            <input type="text" name="nomor_telepon" value="{{ old('nomor_telepon') }}" class="input">
        </div>
        <div>
            <label class="label">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" class="input">
        </div>
        <div>
            <label class="label">Kapasitas (Ton)</label>
            <input type="number" step="0.01" name="kapasitas" value="{{ old('kapasitas') }}" class="input">
        </div>
        <div>
            <label class="label">Status</label>
            <select name="status" class="input">
                <option value="aktif" @selected(old('status', 'aktif') === 'aktif')>Aktif</option>
                <option value="nonaktif" @selected(old('status') === 'nonaktif')>Nonaktif</option>
            </select>
        </div>
    </div>

    <div class="flex justify-between pt-2">
        <a href="{{ route('gudang.index') }}" class="btn-secondary">← Kembali</a>
        <button type="submit" class="btn-primary">💾 Simpan Gudang</button>
    </div>
</form>

@endsection
