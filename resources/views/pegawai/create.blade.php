@extends('layouts.app')

@section('title', 'Tambah Pegawai')

@section('content')

<form method="POST" action="{{ route('pegawai.store') }}" class="card p-6 space-y-5 max-w-3xl">
    @csrf

    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <div>
            <label class="label">NIP</label>
            <input type="text" name="nip" value="{{ old('nip') }}" required class="input" placeholder="199801012010031001">
        </div>
        <div>
            <label class="label">Nama Pegawai</label>
            <input type="text" name="nama" value="{{ old('nama') }}" required class="input">
        </div>
        <div>
            <label class="label">Jabatan</label>
            <input type="text" name="jabatan" value="{{ old('jabatan') }}" required class="input" placeholder="Staff Administrasi">
        </div>
        <div>
            <label class="label">Gudang</label>
            <select name="gudang_id" class="input">
                <option value="">— Tidak terikat gudang —</option>
                @foreach ($gudangs as $g)
                    <option value="{{ $g->id }}" @selected(old('gudang_id') == $g->id)>{{ $g->nama_gudang }}</option>
                @endforeach
            </select>
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
        <a href="{{ route('pegawai.index') }}" class="btn-secondary">← Kembali</a>
        <button type="submit" class="btn-primary">💾 Simpan Pegawai</button>
    </div>
</form>

@endsection
