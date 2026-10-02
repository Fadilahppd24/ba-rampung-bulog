@extends('layouts.app')

@section('title', 'Buat BA Rampung')

@section('content')

<form
    method="POST"
    action="{{ route('ba-rampung.store') }}"
    x-data="baForm({
        gabah: {{ old('kuantum_gabah', 0) }},
        beras: {{ old('kuantum_beras', 0) }},
        menir: {{ old('kuantum_menir', 0) }},
        bekatul: {{ old('kuantum_bekatul', 0) }},
        tanggal: '{{ old('tanggal_ba', now()->toDateString()) }}'
    })"
    class="space-y-6 pb-10"
>

    @csrf


    {{-- =========================================================
         HEADER / INTRO
         Tampilan dibuat mengikuti halaman Master Data:
         background gambar berasal dari layouts.app,
         sedangkan hero menggunakan panel biru transparan.
    ========================================================== --}}
    <div
        class="
            relative
            overflow-hidden
            rounded-[30px]
            min-h-[250px]
            flex
            items-center
            bg-[#082F63]/25
            backdrop-blur-[2px]
            border
            border-white/20
            shadow-[0_20px_60px_rgba(8,47,99,0.14)]
        "
    >

        {{-- Soft blue glass --}}
        <div
            class="
                absolute
                inset-0
                bg-gradient-to-r
                from-[#082F63]/45
                via-[#082F63]/25
                to-[#082F63]/10
            "
        ></div>

        {{-- Decorative blur --}}
        <div
            class="
                absolute
                -right-16
                -top-20
                w-64
                h-64
                rounded-full
                bg-white/5
                blur-2xl
            "
        ></div>

        <div
            class="
                absolute
                -left-20
                -bottom-24
                w-72
                h-72
                rounded-full
                bg-[#4B8ACB]/10
                blur-3xl
            "
        ></div>

        {{-- Content --}}
        <div
            class="
                relative
                z-10
                w-full
                px-8
                py-10
                md:px-11
                md:py-11
                pr-8
                md:pr-[330px]
            "
        >

            <div class="max-w-3xl">

                <p
                    class="
                        text-[11px]
                        uppercase
                        tracking-[0.35em]
                        font-semibold
                        text-white/80
                        mb-3
                    "
                >
                    Sistem BA Rampung
                </p>

                <h1
                    class="
                        text-4xl
                        md:text-5xl
                        lg:text-[58px]
                        font-medium
                        leading-[0.95]
                        text-white
                        tracking-tight
                    "
                    style="font-family: 'Cormorant Garamond', serif;"
                >
                    Tambah
                    <span class="text-[#F28C28]">
                        BA Rampung.
                    </span>
                </h1>

                <p
                    class="
                        mt-4
                        max-w-2xl
                        text-sm
                        md:text-base
                        leading-relaxed
                        text-white/80
                    "
                >
                    Lengkapi informasi berikut untuk membuat
                    Berita Acara Rampung baru.
                </p>

            </div>

        </div>

        {{-- Back button: tetap di sisi kanan, tidak mengganggu judul --}}
        <a
            href="{{ route('ba-rampung.index') }}"
            class="
                absolute
                z-20
                right-7
                bottom-7
                md:right-9
                md:bottom-9
                inline-flex
                items-center
                justify-center
                gap-2
                rounded-full
                bg-white/95
                px-6
                py-3.5
                text-sm
                font-semibold
                text-[#082F63]
                shadow-[0_10px_30px_rgba(0,0,0,0.14)]
                border
                border-white/50
                backdrop-blur
                transition-all
                duration-200
                hover:bg-[#F28C28]
                hover:text-white
                hover:-translate-y-0.5
            "
        >
            ← Kembali ke Daftar BA
        </a>

    </div>



    {{-- =========================================================
         01. DATA BA RAMPUNG
    ========================================================== --}}
    <div
        class="
            rounded-[28px]
            bg-white/95
            backdrop-blur
            border
            border-white
            shadow-[0_15px_45px_rgba(8,47,99,0.08)]
            overflow-hidden
        "
    >

        {{-- Header --}}
        <div
            class="
                flex
                items-center
                gap-4
                px-7
                py-6
                border-b
                border-slate-100
            "
        >

            <div
                class="
                    w-11
                    h-11
                    rounded-2xl
                    bg-[#082F63]
                    text-white
                    flex
                    items-center
                    justify-center
                    font-semibold
                "
            >
                01
            </div>

            <div>

                <h2
                    class="
                        text-lg
                        font-semibold
                        text-[#082F63]
                    "
                >
                    Data BA Rampung
                </h2>

                <p class="text-xs text-slate-400 mt-0.5">
                    Informasi dasar Berita Acara Rampung.
                </p>

            </div>

        </div>


        {{-- Content --}}
        <div class="p-7">

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                {{-- Nomor BA --}}
                <div>

                    <label class="label">
                        Nomor BA (Otomatis)
                    </label>

                    <div
                        class="
                            relative
                            flex
                            items-center
                        "
                    >

                        <span
                            class="
                                absolute
                                left-4
                                text-[#082F63]/30
                            "
                        >
                            📄
                        </span>

                        <input
                            type="text"
                            disabled
                            value="Akan dibuat otomatis oleh sistem setelah disimpan"
                            class="
                                input
                                pl-11
                                bg-slate-50
                                text-slate-400
                                italic
                                text-xs
                            "
                        >

                    </div>

                </div>


                {{-- Tanggal --}}
                <div
                    class="
                        grid
                        grid-cols-1
                        sm:grid-cols-3
                        gap-3
                    "
                >

                    <div>

                        <label class="label">
                            Hari
                        </label>

                        <input
                            type="text"
                            :value="hariNama"
                            disabled
                            class="
                                input
                                bg-slate-50
                                text-slate-500
                            "
                        >

                    </div>


                    <div>

                        <label class="label">
                            Tanggal BA
                        </label>

                        <input
                            type="date"
                            name="tanggal_ba"
                            x-model="tanggal"
                            required
                            class="input"
                        >

                    </div>


                    <div>

                        <label class="label">
                            Tahun
                        </label>

                        <input
                            type="text"
                            :value="tahunNama"
                            disabled
                            class="
                                input
                                bg-slate-50
                                text-slate-500
                            "
                        >

                    </div>

                </div>


                {{-- MO --}}
                <div>

                    <label class="label">
                        Nomor Manufacturing Order (MO)
                    </label>

                    <input
                        type="text"
                        name="nomor_mo"
                        value="{{ old('nomor_mo') }}"
                        required
                        class="input"
                        placeholder="Masukkan nomor MO"
                    >

                </div>


                {{-- PO --}}
                <div>

                    <label class="label">
                        Nomor Purchase Order (PO)
                    </label>

                    <input
                        type="text"
                        name="nomor_po"
                        value="{{ old('nomor_po') }}"
                        required
                        class="input"
                        placeholder="Masukkan nomor PO"
                    >

                </div>

            </div>

        </div>

    </div>



    {{-- =========================================================
         02. PENGOLAHAN GABAH
    ========================================================== --}}
    <div
        class="
            rounded-[28px]
            bg-white/95
            backdrop-blur
            border
            border-white
            shadow-[0_15px_45px_rgba(8,47,99,0.08)]
            overflow-hidden
        "
    >

        {{-- Header --}}
        <div
            class="
                flex
                items-center
                gap-4
                px-7
                py-6
                border-b
                border-slate-100
            "
        >

            <div
                class="
                    w-11
                    h-11
                    rounded-2xl
                    bg-[#F28C28]
                    text-white
                    flex
                    items-center
                    justify-center
                    font-semibold
                "
            >
                02
            </div>

            <div>

                <h2
                    class="
                        text-lg
                        font-semibold
                        text-[#082F63]
                    "
                >
                    Pengolahan Gabah
                    <span class="text-[#F28C28]">
                        (GKP) → Beras Hasil Giling (HGL)
                    </span>
                </h2>

                <p class="text-xs text-slate-400 mt-0.5">
                    Masukkan data hasil pengolahan. Rendemen dihitung otomatis oleh sistem.
                </p>

            </div>

        </div>


        {{-- Table --}}
        <div class="p-7">

            <div
                class="
                    overflow-hidden
                    rounded-2xl
                    border
                    border-slate-100
                "
            >

                <div class="overflow-x-auto">

                    <table class="w-full text-sm">

                        <thead>

                            <tr
                                class="
                                    bg-[#F4F7FB]
                                    text-left
                                    text-[#082F63]
                                "
                            >

                                <th
                                    class="
                                        px-5
                                        py-4
                                        font-semibold
                                    "
                                    colspan="2"
                                >
                                    Sebelum Pengolahan
                                </th>

                                <th
                                    class="
                                        px-5
                                        py-4
                                        font-semibold
                                    "
                                    colspan="2"
                                >
                                    Setelah Pengolahan
                                </th>

                                <th
                                    class="
                                        px-5
                                        py-4
                                        font-semibold
                                    "
                                >
                                    Rendemen (%)
                                </th>

                            </tr>

                        </thead>


                        <tbody
                            class="
                                divide-y
                                divide-slate-100
                            "
                        >

                            {{-- GABAH / BERAS --}}
                            <tr class="hover:bg-slate-50/70 transition">

                                <td
                                    class="
                                        px-5
                                        py-4
                                        font-semibold
                                        text-slate-700
                                    "
                                >
                                    Gabah (GKP)
                                </td>

                                <td class="px-5 py-4 w-48">

                                    <input
                                        type="number"
                                        step="0.01"
                                        min="0.01"
                                        name="kuantum_gabah"
                                        x-model.number="gabah"
                                        required
                                        class="input"
                                        placeholder="0.00"
                                    >

                                </td>


                                <td
                                    class="
                                        px-5
                                        py-4
                                        font-semibold
                                        text-slate-700
                                    "
                                >
                                    Beras (HGL)
                                </td>

                                <td class="px-5 py-4 w-48">

                                    <input
                                        type="number"
                                        step="0.01"
                                        min="0"
                                        name="kuantum_beras"
                                        x-model.number="beras"
                                        required
                                        class="input"
                                        placeholder="0.00"
                                    >

                                </td>


                                <td
                                    class="
                                        px-5
                                        py-4
                                        font-semibold
                                        text-[#F28C28]
                                        whitespace-nowrap
                                    "
                                    x-text="rendemen(beras) + ' %'"
                                ></td>

                            </tr>


                            {{-- MENIR --}}
                            <tr class="hover:bg-slate-50/70 transition">

                                <td
                                    class="
                                        px-5
                                        py-4
                                    "
                                ></td>

                                <td
                                    class="
                                        px-5
                                        py-4
                                    "
                                ></td>

                                <td
                                    class="
                                        px-5
                                        py-4
                                        font-semibold
                                        text-slate-700
                                    "
                                >
                                    Menir
                                </td>

                                <td class="px-5 py-4">

                                    <input
                                        type="number"
                                        step="0.01"
                                        min="0"
                                        name="kuantum_menir"
                                        x-model.number="menir"
                                        class="input"
                                        placeholder="0.00"
                                    >

                                </td>

                                <td
                                    class="
                                        px-5
                                        py-4
                                        font-semibold
                                        text-[#F28C28]
                                    "
                                    x-text="rendemen(menir) + ' %'"
                                ></td>

                            </tr>


                            {{-- BEKATUL --}}
                            <tr class="hover:bg-slate-50/70 transition">

                                <td></td>

                                <td></td>

                                <td
                                    class="
                                        px-5
                                        py-4
                                        font-semibold
                                        text-slate-700
                                    "
                                >
                                    Bekatul
                                </td>

                                <td class="px-5 py-4">

                                    <input
                                        type="number"
                                        step="0.01"
                                        min="0"
                                        name="kuantum_bekatul"
                                        x-model.number="bekatul"
                                        class="input"
                                        placeholder="0.00"
                                    >

                                </td>

                                <td
                                    class="
                                        px-5
                                        py-4
                                        font-semibold
                                        text-[#F28C28]
                                    "
                                    x-text="rendemen(bekatul) + ' %'"
                                ></td>

                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>


            <div
                class="
                    mt-4
                    flex
                    items-center
                    gap-2
                    text-xs
                    text-slate-400
                "
            >
                <span
                    class="
                        w-5
                        h-5
                        rounded-full
                        bg-orange-50
                        text-[#F28C28]
                        flex
                        items-center
                        justify-center
                        font-bold
                    "
                >
                    i
                </span>

                Rendemen (%) dihitung otomatis oleh sistem.

            </div>

        </div>

    </div>



    {{-- =========================================================
         03 + 04. PIHAK TERLIBAT & PENANDATANGAN
    ========================================================== --}}
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">


        {{-- =====================================================
             03. PIHAK TERLIBAT
        ====================================================== --}}
        <div
            class="
                rounded-[28px]
                bg-white/95
                backdrop-blur
                border
                border-white
                shadow-[0_15px_45px_rgba(8,47,99,0.08)]
                overflow-hidden
            "
        >

            <div
                class="
                    flex
                    items-center
                    gap-4
                    px-7
                    py-6
                    border-b
                    border-slate-100
                "
            >

                <div
                    class="
                        w-11
                        h-11
                        rounded-2xl
                        bg-[#082F63]
                        text-white
                        flex
                        items-center
                        justify-center
                        font-semibold
                    "
                >
                    03
                </div>

                <div>

                    <h2
                        class="
                            text-lg
                            font-semibold
                            text-[#082F63]
                        "
                    >
                        Pihak yang Terlibat
                    </h2>

                    <p class="text-xs text-slate-400 mt-0.5">
                        Tentukan gudang dan mitra pengolahan.
                    </p>

                </div>

            </div>


            <div class="p-7 space-y-5">

                {{-- GUDANG --}}
                <div>

                    <label class="label">
                        Pihak Kesatu (Gudang)
                    </label>

                    <select
                        name="gudang_id"
                        required
                        class="input"
                    >

                        <option value="">
                            Pilih Gudang
                        </option>

                        @foreach ($gudangs as $g)

                            <option
                                value="{{ $g->id }}"
                                @selected(old('gudang_id') == $g->id)
                            >
                                {{ $g->nama_gudang }}
                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- MITRA --}}
                <div>

                    <label class="label">
                        Pihak Kedua (Mitra Pengolahan)
                    </label>

                    <select
                        name="mitra_pengolahan_id"
                        required
                        class="input"
                    >

                        <option value="">
                            Pilih Mitra Pengolahan
                        </option>

                        @foreach ($mitras as $m)

                            <option
                                value="{{ $m->id }}"
                                @selected(old('mitra_pengolahan_id') == $m->id)
                            >
                                {{ $m->nama_mitra }}
                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- INFO STATUS --}}
                <div
                    class="
                        rounded-2xl
                        bg-[#F4F7FB]
                        border
                        border-blue-100
                        p-4
                    "
                >

                    <div class="flex items-start gap-3">

                        <div
                            class="
                                w-9
                                h-9
                                rounded-xl
                                bg-white
                                text-[#082F63]
                                flex
                                items-center
                                justify-center
                                shadow-sm
                                shrink-0
                            "
                        >
                            ✓
                        </div>

                        <div>

                            <p
                                class="
                                    text-sm
                                    font-semibold
                                    text-[#082F63]
                                "
                            >
                                Status BA
                            </p>

                            <p
                                class="
                                    text-xs
                                    text-slate-500
                                    mt-1
                                    leading-relaxed
                                "
                            >
                                Status dokumen akan ditentukan otomatis
                                berdasarkan proses penyimpanan atau pengiriman
                                verifikasi.
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>



        {{-- =====================================================
             04. PENANDATANGAN
        ====================================================== --}}
        <div
            class="
                rounded-[28px]
                bg-white/95
                backdrop-blur
                border
                border-white
                shadow-[0_15px_45px_rgba(8,47,99,0.08)]
                overflow-hidden
            "
        >

            <div
                class="
                    flex
                    items-center
                    gap-4
                    px-7
                    py-6
                    border-b
                    border-slate-100
                "
            >

                <div
                    class="
                        w-11
                        h-11
                        rounded-2xl
                        bg-[#F28C28]
                        text-white
                        flex
                        items-center
                        justify-center
                        font-semibold
                    "
                >
                    04
                </div>

                <div>

                    <h2
                        class="
                            text-lg
                            font-semibold
                            text-[#082F63]
                        "
                    >
                        Penandatanganan
                    </h2>

                    <p class="text-xs text-slate-400 mt-0.5">
                        Data penandatangan pihak kesatu.
                    </p>

                </div>

            </div>


            <div class="p-7 space-y-5">

                {{-- NAMA PENANDATANGAN --}}
                <div>

                    <label class="label">
                        Nama Penandatangan
                    </label>

                    <input
                        type="text"
                        name="nama_penandatangan"
                        value="{{ old('nama_penandatangan') }}"
                        required
                        class="input"
                        placeholder="Masukkan nama penandatangan"
                    >

                </div>


                {{-- JABATAN --}}
                <div>

                    <label class="label">
                        Jabatan
                    </label>

                    <input
                        type="text"
                        name="jabatan_penandatangan"
                        value="{{ old('jabatan_penandatangan', 'Pengelola Gudang') }}"
                        required
                        class="input"
                        placeholder="Masukkan jabatan"
                    >

                </div>


                {{-- MENGETAHUI --}}
                <div
                    class="
                        pt-4
                        border-t
                        border-slate-100
                    "
                >

                    <div class="flex items-center gap-3 mb-4">

                        <div
                            class="
                                w-9
                                h-9
                                rounded-xl
                                bg-orange-50
                                text-[#F28C28]
                                flex
                                items-center
                                justify-center
                            "
                        >
                            ✓
                        </div>

                        <div>

                            <h3
                                class="
                                    font-semibold
                                    text-[#082F63]
                                "
                            >
                                05. Mengetahui
                            </h3>

                            <p
                                class="
                                    text-xs
                                    text-slate-400
                                "
                            >
                                Pimpinan Cabang BULOG
                            </p>

                        </div>

                    </div>


                    <label class="label">
                        Pimpinan Cabang BULOG
                    </label>

                    <select
                        name="pimpinan_cabang_id"
                        required
                        class="input"
                    >

                        <option value="">
                            Pilih Pimpinan Cabang
                        </option>

                        @foreach ($pimpinans as $p)

                            <option
                                value="{{ $p->id }}"
                                @selected(old('pimpinan_cabang_id') == $p->id)
                            >
                                {{ $p->nama }}
                            </option>

                        @endforeach

                    </select>

                </div>

            </div>

        </div>

    </div>



    {{-- =========================================================
         06. CATATAN
    ========================================================== --}}
    <div
        class="
            rounded-[28px]
            bg-white/95
            backdrop-blur
            border
            border-white
            shadow-[0_15px_45px_rgba(8,47,99,0.08)]
            p-7
        "
    >

        <div class="flex items-center gap-3 mb-4">

            <div
                class="
                    w-10
                    h-10
                    rounded-xl
                    bg-slate-100
                    text-[#082F63]
                    flex
                    items-center
                    justify-center
                "
            >
                📝
            </div>

            <div>

                <h3
                    class="
                        font-semibold
                        text-[#082F63]
                    "
                >
                    Catatan
                </h3>

                <p class="text-xs text-slate-400">
                    Tambahkan catatan jika diperlukan.
                </p>

            </div>

        </div>


        <textarea
            name="catatan"
            rows="4"
            class="input resize-none"
            placeholder="Tulis catatan tambahan..."
        >{{ old('catatan') }}</textarea>

    </div>



    {{-- =========================================================
         ACTION BUTTON
    ========================================================== --}}
    <div
        class="
            flex
            flex-col-reverse
            sm:flex-row
            sm:items-center
            sm:justify-between
            gap-4
            pt-2
        "
    >

        <a
            href="{{ route('ba-rampung.index') }}"
            class="
                inline-flex
                items-center
                justify-center
                gap-2
                rounded-2xl
                border
                border-slate-200
                bg-white
                px-6
                py-3.5
                text-sm
                font-semibold
                text-slate-600
                shadow-sm
                transition
                hover:border-[#082F63]
                hover:text-[#082F63]
            "
        >
            ← Kembali
        </a>


        <div
            class="
                flex
                flex-col
                sm:flex-row
                gap-3
            "
        >

            <button
                type="submit"
                name="action"
                value="draft"
                class="
                    inline-flex
                    items-center
                    justify-center
                    gap-2
                    rounded-2xl
                    border
                    border-[#082F63]
                    bg-white
                    px-6
                    py-3.5
                    text-sm
                    font-semibold
                    text-[#082F63]
                    shadow-sm
                    transition
                    hover:bg-[#082F63]
                    hover:text-white
                "
            >
                💾
                Simpan Draft
            </button>


            <button
                type="submit"
                name="action"
                value="submit"
                class="
                    inline-flex
                    items-center
                    justify-center
                    gap-2
                    rounded-2xl
                    bg-[#F28C28]
                    px-7
                    py-3.5
                    text-sm
                    font-semibold
                    text-white
                    shadow-[0_8px_25px_rgba(242,140,40,0.25)]
                    transition
                    hover:bg-[#e67d18]
                    hover:-translate-y-0.5
                "
            >
                🖨️
                Simpan &amp; Kirim Verifikasi
            </button>

        </div>

    </div>


</form>

@endsection