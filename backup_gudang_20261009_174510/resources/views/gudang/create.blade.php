@extends('layouts.app')

@section('title', 'Tambah Gudang')

@section('content')

<style>
    /* Header halaman mengikuti gaya halaman Edit Pimpinan */
    .gudang-create-header {
        width: 100%;
        max-width: 760px;
        margin: 0 auto 22px auto;
        text-align: center;
        padding-top: 2px;
    }

    .gudang-create-eyebrow {
        margin-bottom: 5px;
        color: #dbeafe;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .28em;
        text-transform: uppercase;
    }

    .gudang-create-title {
        margin: 0;
        font-family: Georgia, 'Times New Roman', serif;
        font-size: clamp(38px, 5vw, 52px);
        line-height: 1;
        font-weight: 500;
        color: #ffffff;
        text-shadow: 0 2px 12px rgba(0, 0, 0, .18);
    }

    .gudang-create-title span {
        color: #F28C28;
    }

    .gudang-create-subtitle {
        margin: 10px 0 0;
        color: rgba(255, 255, 255, .78);
        font-size: 13px;
    }

    html.dark-theme .gudang-create-eyebrow {
        color: #cbd5e1 !important;
    }

    html.dark-theme .gudang-create-title {
        color: #ffffff !important;
    }

    html.dark-theme .gudang-create-subtitle {
        color: #cbd5e1 !important;
    }

    /* Tombol Tambah Gudang menggunakan warna navy yang konsisten */
    .gudang-create-actions .gudang-create-button {
        background-color: #123F7A !important;
        color: #ffffff !important;
        border: 1px solid #123F7A !important;
        transition: background-color .2s ease, transform .2s ease;
    }

    .gudang-create-actions .gudang-create-button:hover {
        background-color: #0D2F5B !important;
        border-color: #0D2F5B !important;
        color: #ffffff !important;
    }
</style>

<div class="space-y-6">

    {{-- =========================================================
         HERO / HEADER HALAMAN
    ========================================================== --}}
    <div class="gudang-create-header">
        <div class="gudang-create-eyebrow">MASTER DATA</div>
        <h1 class="gudang-create-title">
            Tambah <span>Gudang</span>
        </h1>
        <p class="gudang-create-subtitle">
            Tambahkan data gudang baru.
        </p>
    </div>


    {{-- =========================================================
         FORM
    ========================================================== --}}
    <form
        method="POST"
        action="{{ route('gudang.store') }}"
        class="space-y-6"
    >

        @csrf

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">

            {{-- HEADER CARD --}}
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
                        Informasi dasar gudang penyimpanan.
                    </p>
                </div>

            </div>


            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

                {{-- =================================================
                     KODE GUDANG
                ================================================== --}}
                <div>

                    <label class="label">
                        Kode Gudang
                    </label>

                    <input
                        type="text"
                        name="kode_gudang"
                        value="{{ $kodeGudang }}"
                        readonly
                        class="input cursor-not-allowed bg-slate-100 font-bold text-[#123F7A]"
                    >

                    <p class="mt-1 text-xs text-slate-500">
                        Kode gudang dibuat otomatis oleh sistem.
                    </p>

                    @error('kode_gudang')
                        <p class="mt-1 text-xs text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- =================================================
                     NAMA GUDANG
                ================================================== --}}
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
                        <p class="mt-1 text-xs text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- =================================================
                     JENIS GUDANG
                ================================================== --}}
                <div>

                    <label class="label">
                        Jenis Gudang
                    </label>

                    <select
                        name="jenis_gudang"
                        id="jenis_gudang"
                        class="input"
                        required
                    >

                        <option
                            value="utama"
                            @selected(old('jenis_gudang', 'utama') === 'utama')
                        >
                            Gudang Utama
                        </option>

                        <option
                            value="filial"
                            @selected(old('jenis_gudang') === 'filial')
                        >
                            Gudang Filial
                        </option>

                    </select>

                    @error('jenis_gudang')
                        <p class="mt-1 text-xs text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- =================================================
                     GUDANG INDUK
                ================================================== --}}
                <div id="gudang-induk-wrapper">

                    <label class="label">
                        Gudang Induk
                    </label>

                    <select
                        name="gudang_induk_id"
                        id="gudang_induk_id"
                        class="input"
                    >

                        <option value="">
                            Pilih Gudang Utama
                        </option>

                        @foreach ($gudangsUtama as $gudang)

                            <option
                                value="{{ $gudang->id }}"
                                data-kode="{{ $gudang->kode_gudang }}"
                                @selected(old('gudang_induk_id') == $gudang->id)
                            >
                                {{ $gudang->nama_gudang }}
                                ({{ $gudang->kode_gudang }})
                            </option>

                        @endforeach

                    </select>

                    @error('gudang_induk_id')
                        <p class="mt-1 text-xs text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- =================================================
                     ALAMAT
                ================================================== --}}
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
                        <p class="mt-1 text-xs text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- =================================================
                     KECAMATAN
                ================================================== --}}
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
                        <p class="mt-1 text-xs text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- =================================================
                     DESA
                ================================================== --}}
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
                        <p class="mt-1 text-xs text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- =================================================
                     TELEPON
                ================================================== --}}
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
                        <p class="mt-1 text-xs text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- =================================================
                     EMAIL
                ================================================== --}}
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
                        <p class="mt-1 text-xs text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- =================================================
                     KAPASITAS
                ================================================== --}}
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
                        <p class="mt-1 text-xs text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- =================================================
                     STATUS
                ================================================== --}}
                <div>

                    <label class="label">
                        Status
                    </label>

                    <select
                        name="status"
                        class="input"
                    >

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
                        <p class="mt-1 text-xs text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

            </div>


            {{-- =====================================================
                 BUTTON
            ====================================================== --}}
            <div class="gudang-create-actions mt-6 flex justify-between border-t border-slate-100 pt-6">

                <a
                    href="{{ route('gudang.index') }}"
                    class="btn-secondary gudang-create-button inline-flex items-center justify-center rounded-xl px-5 py-3 text-sm font-semibold"
                >
                    ← Kembali
                </a>

                <button
                    type="submit"
                    class="btn-primary gudang-create-button inline-flex items-center justify-center rounded-xl px-5 py-3 text-sm font-semibold"
                >
                    💾 Simpan Gudang
                </button>

            </div>

        </div>

    </form>

</div>


{{-- =============================================================
     SCRIPT JENIS GUDANG
============================================================= --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    const jenisGudang = document.getElementById('jenis_gudang');
    const wrapperInduk = document.getElementById('gudang-induk-wrapper');
    const gudangInduk = document.getElementById('gudang_induk_id');
    const kodeGudang = document.querySelector('input[name="kode_gudang"]');

    function updateKodeFilial() {
        const selectedOption = gudangInduk.options[gudangInduk.selectedIndex];
        const kodeInduk = selectedOption?.dataset?.kode || '';

        if (!kodeInduk) {
            kodeGudang.value = 'Otomatis';
            return;
        }

        kodeGudang.value = `${kodeInduk}-F01`;
    }

    function updateGudangInduk() {
        if (jenisGudang.value === 'filial') {
            wrapperInduk.style.display = 'block';
            gudangInduk.required = true;
            updateKodeFilial();
        } else {
            wrapperInduk.style.display = 'none';
            gudangInduk.required = false;
            gudangInduk.value = '';
            kodeGudang.value = @json($kodeGudang);
        }
    }

    gudangInduk.addEventListener('change', updateKodeFilial);
    jenisGudang.addEventListener('change', updateGudangInduk);
    updateGudangInduk();
});
</script>

@endsection