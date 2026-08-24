@extends('layouts.app')

@section('title', 'Edit Pegawai')

@section('content')

<form method="POST" action="{{ route('pegawai.update', $pegawai) }}" class="card p-6 space-y-5 max-w-3xl">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <div>
            <label class="label">NIP</label>
            <input type="text" name="nip" value="{{ old('nip', $pegawai->nip) }}" required class="input">
        </div>
        <div>
            <label class="label">Nama Pegawai</label>
            <input type="text" name="nama" value="{{ old('nama', $pegawai->nama) }}" required class="input">
        </div>
        <div>
            <label class="label">Jabatan</label>
            <input type="text" name="jabatan" value="{{ old('jabatan', $pegawai->jabatan) }}" required class="input">
        </div>
        <div>
            <label class="label">Gudang</label>
            <select name="gudang_id" class="input">
                <option value="">— Tidak terikat gudang —</option>
                @foreach ($gudangs as $g)
                    <option value="{{ $g->id }}" @selected(old('gudang_id', $pegawai->gudang_id) == $g->id)>{{ $g->nama_gudang }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="label">Nomor Telepon</label>
            <input type="text" name="nomor_telepon" value="{{ old('nomor_telepon', $pegawai->nomor_telepon) }}" class="input">
        </div>
        <div>
            <label class="label">Email</label>
            <input type="email" name="email" value="{{ old('email', $pegawai->email) }}" class="input">
        </div>
        <div>
            <label class="label">Status</label>
            <select name="status" class="input">
                <option value="aktif" @selected(old('status', $pegawai->status) === 'aktif')>Aktif</option>
                <option value="nonaktif" @selected(old('status', $pegawai->status) === 'nonaktif')>Nonaktif</option>
            </select>
        </div>
    </div>

    <div class="flex justify-between pt-2">
        <a href="{{ route('pegawai.show', $pegawai) }}" class="btn-secondary">← Kembali</a>
        <button type="submit" class="btn-primary">💾 Simpan Perubahan</button>
    </div>
</form>

@endsection
