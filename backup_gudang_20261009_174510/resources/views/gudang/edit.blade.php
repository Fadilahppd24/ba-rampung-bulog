@extends('layouts.app')

@section('title', 'Edit Gudang')

@section('content')

<style>
    .gudang-edit-header {
        width: 100%;
        margin: 0 auto 22px;
        text-align: center;
    }

    .gudang-edit-eyebrow {
        margin-bottom: 5px;
        color: #dbeafe;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .28em;
        text-transform: uppercase;
    }

    .gudang-edit-title {
        margin: 0;
        font-family: Georgia, 'Times New Roman', serif;
        font-size: clamp(38px, 5vw, 52px);
        line-height: 1;
        font-weight: 500;
        color: #ffffff;
        text-shadow: 0 2px 12px rgba(0, 0, 0, .18);
    }

    .gudang-edit-title span { color: #F28C28; }

    .gudang-edit-subtitle {
        margin: 10px 0 0;
        color: rgba(255, 255, 255, .78);
        font-size: 13px;
        text-shadow: 0 1px 8px rgba(3, 28, 55, .2);
    }

    html.dark-theme .gudang-edit-eyebrow,
    html.dark-theme .gudang-edit-subtitle { color: #cbd5e1 !important; }

    html.dark-theme .gudang-edit-title { color: #ffffff !important; }

    /* Tombol pada halaman Edit Gudang */
    .gudang-edit-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        min-height: 42px;
        padding: 10px 16px;
        border: 1px solid #123F7A !important;
        border-radius: 10px;
        background: #123F7A !important;
        color: #ffffff !important;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        box-shadow: 0 4px 10px rgba(18, 63, 122, .14);
        transition: background-color .2s ease, transform .2s ease, box-shadow .2s ease;
    }

    .gudang-edit-button:hover {
        background: #0d2f5c !important;
        border-color: #0d2f5c !important;
        color: #ffffff !important;
        transform: translateY(-1px);
        box-shadow: 0 6px 14px rgba(18, 63, 122, .22);
    }

    .gudang-edit-button:focus-visible {
        outline: 3px solid rgba(18, 63, 122, .25);
        outline-offset: 2px;
    }
</style>

<div class="space-y-6">

    {{-- HEADER HALAMAN --}}
    <div class="gudang-edit-header pt-2">
        <div class="gudang-edit-eyebrow">MASTER DATA</div>
        <h1 class="gudang-edit-title">Edit <span>Gudang</span></h1>
        <p class="gudang-edit-subtitle">
            {{ $gudang->nama_gudang }} — {{ $gudang->kode_gudang }}
        </p>
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
                <a href="{{ route('gudang.index') }}" class="gudang-edit-button">← Kembali</a>
                <button type="submit" class="gudang-edit-button">💾 Simpan Perubahan</button>
            </div>

        </div>

    </form>

</div>

@endsection
