@extends('layouts.app')

@section('title', 'Tambah Pegawai')

@section('content')

<form method="POST" action="{{ route('pegawai.store') }}" class="card p-6 space-y-5 max-w-3xl">
    @csrf

    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

        {{-- NIP --}}
        <div>
            <label class="label">NIP</label>
            <input
                type="text"
                name="nip"
                value="{{ old('nip') }}"
                required
                class="input"
                placeholder="199801012010031001"
            >
            @error('nip')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Nama --}}
        <div>
            <label class="label">Nama Pegawai</label>
            <input
                type="text"
                name="nama"
                value="{{ old('nama') }}"
                required
                class="input"
            >
            @error('nama')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Jabatan --}}
        <div>
            <label class="label">Jabatan</label>
            <input
                type="text"
                name="jabatan"
                value="{{ old('jabatan') }}"
                required
                class="input"
                placeholder="Staff Administrasi"
            >
            @error('jabatan')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Gudang --}}
        <div>
            <label class="label">Gudang</label>
            <select name="gudang_id" class="input">
                <option value="">— Tidak terikat gudang —</option>

                @foreach ($gudangs as $g)
                    <option
                        value="{{ $g->id }}"
                        @selected(old('gudang_id') == $g->id)
                    >
                        {{ $g->nama_gudang }}
                    </option>
                @endforeach
            </select>

            @error('gudang_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Nomor Telepon --}}
        <div>
            <label class="label">Nomor Telepon</label>
            <input
                type="text"
                name="nomor_telepon"
                value="{{ old('nomor_telepon') }}"
                class="input"
            >
            @error('nomor_telepon')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Email --}}
        <div>
            <label class="label">Email Login</label>
            <input
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                class="input"
                placeholder="pegawai@contoh.com"
            >
            @error('email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Role --}}
        <div>
            <label class="label">Role Akun</label>

            <select name="role" class="input" required>
                <option value="">— Pilih Role —</option>

                <option
                    value="admin_gudang"
                    @selected(old('role') === 'admin_gudang')
                >
                    Admin Gudang
                </option>

                <option
                    value="admin_kantor"
                    @selected(old('role') === 'admin_kantor')
                >
                    Admin Kantor
                </option>

                <option
                    value="pimpinan_cabang"
                    @selected(old('role') === 'pimpinan_cabang')
                >
                    Pimpinan Cabang
                </option>
            </select>

            @error('role')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Status --}}
        <div>
            <label class="label">Status</label>

            <select name="status" class="input">
                <option
                    value="aktif"
                    @selected(old('status', 'aktif') === 'aktif')
                >
                    Aktif
                </option>

                <option
                    value="nonaktif"
                    @selected(old('status') === 'nonaktif')
                >
                    Nonaktif
                </option>
            </select>

            @error('status')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Password --}}
        <div>
            <label class="label">Password Awal</label>

            <input
                type="password"
                name="password"
                required
                class="input"
                placeholder="Minimal 8 karakter"
            >

            @error('password')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Konfirmasi Password --}}
        <div>
            <label class="label">Konfirmasi Password</label>

            <input
                type="password"
                name="password_confirmation"
                required
                class="input"
                placeholder="Ulangi password"
            >
        </div>

    </div>

    {{-- Informasi akun --}}
    <div class="rounded-lg bg-blue-50 border border-blue-200 p-4 text-sm text-blue-700">
        <p class="font-semibold mb-1">Informasi Akun</p>
        <p>
            Data pegawai dan akun login akan dibuat sekaligus.
            Password akan disimpan secara aman dan tidak dapat dilihat kembali.
            Jika pegawai lupa password, Admin Kantor dapat melakukan reset password.
        </p>
    </div>

    <div class="flex justify-between pt-2">
        <a
            href="{{ route('pegawai.index') }}"
            class="btn-secondary"
        >
            ← Kembali
        </a>

        <button
            type="submit"
            class="btn-primary"
        >
            💾 Simpan Pegawai & Akun
        </button>
    </div>

</form>

@endsection