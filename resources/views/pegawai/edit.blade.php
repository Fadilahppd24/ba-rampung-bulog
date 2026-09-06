@extends('layouts.app')

@section('title', 'Edit Pegawai')

@section('content')

<form method="POST" action="{{ route('pegawai.update', $pegawai) }}" class="card p-6 space-y-5 max-w-3xl">

    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

        {{-- NIP --}}
        <div>
            <label class="label">NIP</label>
            <input
                type="text"
                name="nip"
                value="{{ old('nip', $pegawai->nip) }}"
                required
                class="input"
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
                value="{{ old('nama', $pegawai->nama) }}"
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
                value="{{ old('jabatan', $pegawai->jabatan) }}"
                required
                class="input"
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
                        @selected(old('gudang_id', $pegawai->gudang_id) == $g->id)
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
                value="{{ old('nomor_telepon', $pegawai->nomor_telepon) }}"
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
                value="{{ old('email', $pegawai->email) }}"
                required
                class="input"
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
                    @selected(old('role', $pegawai->user?->role) === 'admin_gudang')
                >
                    Admin Gudang
                </option>

                <option
                    value="admin_kantor"
                    @selected(old('role', $pegawai->user?->role) === 'admin_kantor')
                >
                    Admin Kantor
                </option>

                <option
                    value="pimpinan_cabang"
                    @selected(old('role', $pegawai->user?->role) === 'pimpinan_cabang')
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
                    @selected(old('status', $pegawai->status) === 'aktif')
                >
                    Aktif
                </option>

                <option
                    value="nonaktif"
                    @selected(old('status', $pegawai->status) === 'nonaktif')
                >
                    Nonaktif
                </option>

            </select>

            @error('status')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Password baru --}}
        <div>
            <label class="label">Password Baru</label>

            <input
                type="password"
                name="password"
                class="input"
                placeholder="Kosongkan jika tidak ingin mengubah"
            >

            @error('password')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Konfirmasi password --}}
        <div>
            <label class="label">Konfirmasi Password Baru</label>

            <input
                type="password"
                name="password_confirmation"
                class="input"
                placeholder="Ulangi password baru"
            >
        </div>

    </div>

    {{-- Informasi akun --}}
    <div class="rounded-lg bg-blue-50 border border-blue-200 p-4 text-sm text-blue-700">

        <p class="font-semibold mb-1">
            Informasi Akun
        </p>

        <p>
            Password hanya perlu diisi jika ingin mengganti password akun.
            Password lama tidak dapat ditampilkan kembali.
        </p>

    </div>

    <div class="flex justify-between pt-2">

        <a
            href="{{ route('pegawai.show', $pegawai) }}"
            class="btn-secondary"
        >
            ← Kembali
        </a>

        <button
            type="submit"
            class="btn-primary"
        >
            💾 Simpan Perubahan
        </button>

    </div>

</form>

@endsection