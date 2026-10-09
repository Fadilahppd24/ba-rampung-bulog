@extends('layouts.app')

@section('title', 'Tambah Gudang')

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
                Tambah <span class="text-[#F28C28]">Gudang</span>
            </h1>

            <p
                class="mt-2 text-sm text-white/85"
                style="text-shadow: 0 1px 8px rgba(3, 28, 55, .2);"
            >
                Tambahkan data gudang baru.
            </p>
        </div>

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
            <div class="mt-6 flex justify-between border-t border-slate-100 pt-6">

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