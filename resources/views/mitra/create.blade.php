@extends('layouts.app')

@section('title', 'Tambah Mitra Pengolahan')

@section('content')

<form method="POST" action="{{ route('mitra.store') }}" class="card p-6 space-y-5 max-w-3xl">
    @csrf

    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <div>
            <label class="label">Kode Mitra</label>
            <input type="text" name="kode_mitra" value="{{ old('kode_mitra') }}" required class="input" placeholder="MIT-006">
        </div>
        <div>
            <label class="label">Nama Mitra</label>
            <input type="text" name="nama_mitra" value="{{ old('nama_mitra') }}" required class="input" placeholder="UD. Contoh Makmur">
        </div>
        <div>
            <label class="label">Jenis Usaha</label>
            <input type="text" name="jenis_usaha" value="{{ old('jenis_usaha', 'Penggilingan Padi') }}" class="input">
        </div>
        <div>
            <label class="label">Penanggung Jawab</label>
            <input type="text" name="penanggung_jawab" value="{{ old('penanggung_jawab') }}" class="input">
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
            <label class="label">Status</label>
            <select name="status" class="input">
                <option value="aktif" @selected(old('status', 'aktif') === 'aktif')>Aktif</option>
                <option value="nonaktif" @selected(old('status') === 'nonaktif')>Nonaktif</option>
            </select>
        </div>
    </div>

    <div class="flex justify-between pt-2">
        <a href="{{ route('mitra.index') }}" class="btn-secondary">← Kembali</a>
        <button type="submit" class="btn-primary">💾 Simpan Mitra</button>
    </div>
</form>

@endsection
