@extends('layouts.app')

@section('title', 'Tambah Gudang')

@section('content')

<div class="max-w-3xl">

    <div class="mb-5">
        <h2 class="text-xl font-semibold text-gray-900">
            Tambah Gudang
        </h2>

        <p class="text-sm text-gray-500 mt-1">
            Tambahkan data gudang baru.
        </p>
    </div>

    <form
        method="POST"
        action="{{ route('gudang.store') }}"
        class="card p-6 space-y-5"
    >

        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

            {{-- KODE GUDANG --}}
            <div>
                <label class="label">
                    Kode Gudang
                </label>

                <input
                    type="text"
                    name="kode_gudang"
                    value="{{ old('kode_gudang') }}"
                    required
                    class="input"
                    placeholder="GDG-007"
                >

                @error('kode_gudang')
                    <p class="text-xs text-red-600 mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- NAMA GUDANG --}}
            <div>
                <label class="label">
                    Nama Gudang
                </label>

                <input
                    type="text"
                    name="nama_gudang"
                    value="{{ old('nama_gudang') }}"
                    required
                    class="input"
                    placeholder="Gudang Bulog Cikedung"
                >

                @error('nama_gudang')
                    <p class="text-xs text-red-600 mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- ALAMAT --}}
            <div class="md:col-span-2">
                <label class="label">
                    Alamat
                </label>

                <textarea
                    name="alamat"
                    rows="2"
                    class="input"
                    placeholder="Alamat lengkap gudang"
                >{{ old('alamat') }}</textarea>

                @error('alamat')
                    <p class="text-xs text-red-600 mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- KECAMATAN --}}
            <div>
                <label class="label">
                    Kecamatan
                </label>

                <input
                    type="text"
                    name="kecamatan"
                    value="{{ old('kecamatan') }}"
                    class="input"
                >

                @error('kecamatan')
                    <p class="text-xs text-red-600 mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- DESA --}}
            <div>
                <label class="label">
                    Desa
                </label>

                <input
                    type="text"
                    name="desa"
                    value="{{ old('desa') }}"
                    class="input"
                >

                @error('desa')
                    <p class="text-xs text-red-600 mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- TELEPON --}}
            <div>
                <label class="label">
                    Nomor Telepon
                </label>

                <input
                    type="text"
                    name="nomor_telepon"
                    value="{{ old('nomor_telepon') }}"
                    class="input"
                >

                @error('nomor_telepon')
                    <p class="text-xs text-red-600 mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- EMAIL --}}
            <div>
                <label class="label">
                    Email
                </label>

                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    class="input"
                >

                @error('email')
                    <p class="text-xs text-red-600 mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- KAPASITAS --}}
            <div>
                <label class="label">
                    Kapasitas (Ton)
                </label>

                <input
                    type="number"
                    step="0.01"
                    name="kapasitas"
                    value="{{ old('kapasitas') }}"
                    class="input"
                >

                @error('kapasitas')
                    <p class="text-xs text-red-600 mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- STATUS --}}
            <div>
                <label class="label">
                    Status
                </label>

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
                    <p class="text-xs text-red-600 mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>

        </div>

        <div class="flex justify-between pt-2">

            <a
                href="{{ route('gudang.index') }}"
                class="btn-secondary"
            >
                ← Kembali
            </a>

            <button
                type="submit"
                class="btn-primary"
            >
                💾 Simpan Gudang
            </button>

        </div>

    </form>

</div>

@endsection