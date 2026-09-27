@extends('layouts.app')

@section('title', 'Edit Gudang')

@section('content')

<div class="space-y-6">

    {{-- =========================================================
         HERO / HEADER HALAMAN
    ========================================================== --}}
    <div class="flex flex-col gap-4 pt-2 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="dashboard-kicker text-white/75">
                Master Data
            </p>

            <h1 class="dashboard-display mt-2 text-4xl leading-tight text-white sm:text-5xl">
                Edit <span class="text-[#F28C28]">Gudang</span>
            </h1>

            <p class="mt-2 text-sm text-white/85" style="text-shadow: 0 1px 8px rgba(3, 28, 55, .2);">
                {{ $gudang->nama_gudang }} — {{ $gudang->kode_gudang }}
            </p>
        </div>

        <a
            href="{{ route('gudang.show', $gudang) }}"
            class="inline-flex items-center justify-center gap-2 rounded-full bg-white px-5 py-3 text-sm font-bold text-[#123F7A] shadow-lg transition hover:-translate-y-0.5 hover:bg-slate-50"
        >
            ← Kembali
        </a>
    </div>


    {{-- =========================================================
         FORM
         action, method, @csrf, @method, name attribute
         SEMUA DIPERTAHANKAN PERSIS SEPERTI SEBELUMNYA.
    ========================================================== --}}
    <form method="POST" action="{{ route('gudang.update', $gudang) }}" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">

            <div class="mb-6 flex items-center gap-3">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#123F7A] text-base font-bold text-white">
                    01
                </div>
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-xl">
                    🏭
                </div>
                <div>
                    <h3 class="text-base font-bold text-gray-900">
                        Data Gudang
                    </h3>
                    <p class="text-xs text-gray-500">
                        Perbarui informasi gudang.
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="label">Kode Gudang</label>
                    <input type="text" name="kode_gudang" value="{{ old('kode_gudang', $gudang->kode_gudang) }}" required class="input">
                    @error('kode_gudang')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="label">Nama Gudang</label>
                    <input type="text" name="nama_gudang" value="{{ old('nama_gudang', $gudang->nama_gudang) }}" required class="input">
                    @error('nama_gudang')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="md:col-span-2">
                    <label class="label">Alamat</label>
                    <textarea name="alamat" rows="2" class="input">{{ old('alamat', $gudang->alamat) }}</textarea>
                    @error('alamat')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="label">Kecamatan</label>
                    <input type="text" name="kecamatan" value="{{ old('kecamatan', $gudang->kecamatan) }}" class="input">
                    @error('kecamatan')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="label">Desa</label>
                    <input type="text" name="desa" value="{{ old('desa', $gudang->desa) }}" class="input">
                    @error('desa')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="label">Nomor Telepon</label>
                    <input type="text" name="nomor_telepon" value="{{ old('nomor_telepon', $gudang->nomor_telepon) }}" class="input">
                    @error('nomor_telepon')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="label">Email</label>
                    <input type="email" name="email" value="{{ old('email', $gudang->email) }}" class="input">
                    @error('email')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="label">Kapasitas (Ton)</label>
                    <input type="number" step="0.01" name="kapasitas" value="{{ old('kapasitas', $gudang->kapasitas) }}" class="input">
                    @error('kapasitas')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="label">Status</label>
                    <select name="status" class="input">
                        <option value="aktif" @selected(old('status', $gudang->status) === 'aktif')>Aktif</option>
                        <option value="nonaktif" @selected(old('status', $gudang->status) === 'nonaktif')>Nonaktif</option>
                    </select>
                    @error('status')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6 flex justify-between border-t border-slate-100 pt-6">
                <a href="{{ route('gudang.show', $gudang) }}" class="btn-secondary">← Kembali</a>
                <button type="submit" class="btn-primary">💾 Simpan Perubahan</button>
            </div>

        </div>

    </form>

</div>

@endsection
