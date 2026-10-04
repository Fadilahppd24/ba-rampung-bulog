@extends('layouts.app')

@section('title', 'Buat BA Rampung')

@section('content')

<style>
    /* =========================================================
       TAMBAH BA RAMPUNG — LIGHT / DARK MODE
       Tema sama dengan halaman Daftar BA Rampung:
       navy BULOG + aksen oranye. Hanya tampilan; fungsi form
       tidak diubah.
       ========================================================= */

    .ba-create-page {
        --ba-overlay-top: rgba(7, 20, 38, .62);
        --ba-overlay-bottom: rgba(7, 20, 38, .50);
        position: relative;
    }

    /* Overlay mode gelap (gambar latar dari layout tetap terlihat) */
    .ba-create-page::before {
        content: "";
        position: fixed;
        inset: 0;
        z-index: 0;
        pointer-events: none;
        background: linear-gradient(180deg, var(--ba-overlay-top), var(--ba-overlay-bottom));
        opacity: 0;                      /* mode terang: tidak terlihat */
        transition: opacity .3s ease;
    }

    .ba-create-page > * {
        position: relative;
        z-index: 1;                      /* konten di atas overlay */
    }

    /* ---------------- LIGHT MODE ---------------- */

    .ba-create-page .rounded-\[28px\] {
        position: relative;
        overflow: hidden;
        background: rgba(250,251,253,.95);
        border-color: rgba(15,43,82,.07);
        box-shadow: 0 12px 35px rgba(15,23,42,.09);
        transition: background-color .2s ease, border-color .2s ease, box-shadow .2s ease;
    }

    /* garis atas card: segmen oranye + navy */
    .ba-create-page .rounded-\[28px\]::before {
        content: "";
        position: absolute;
        left: 0;
        right: 0;
        top: 0;
        height: 3px;
        z-index: 2;
        pointer-events: none;
        background: linear-gradient(90deg, #F28C28 0, #F28C28 84px, #082F63 84px, rgba(8,47,99,.85) 100%);
    }

    .ba-create-page .rounded-\[28px\] .border-slate-100 {
        border-color: rgba(15,43,82,.07);
    }

    .ba-create-page .label {
        display: block;
        margin-bottom: .45rem;
        font-size: .72rem;
        font-weight: 700;
        letter-spacing: .08em;
        text-transform: uppercase;
        color: #64748b;
    }

    .ba-create-page .input {
        border: 1px solid #D9E2EC;
        border-radius: .85rem;
        background-color: #F8FAFC;
        color: #0B2545;
        outline: none;
        transition: border-color .2s ease, box-shadow .2s ease, background-color .2s ease;
    }

    .ba-create-page .input::placeholder {
        color: #94A3B8;
    }

    .ba-create-page .input:focus {
        border-color: #F28C28;
        background-color: #fff;
        box-shadow: 0 0 0 3px rgba(242,140,40,.18);
    }

    .ba-create-page .input:disabled {
        background-color: #F1F5F9;
        color: #94A3B8;
        cursor: not-allowed;
    }

    .ba-create-page thead th {
        border-bottom: 2px solid rgba(242,140,40,.30);
    }

    .ba-create-page tbody tr:hover td:first-child {
        box-shadow: inset 3px 0 0 #F28C28;
    }


    /* ---------------- DARK MODE ----------------
       Aktif jika .ba-create-page diberi class "is-dark" oleh script
       di bawah (mengikuti mode gelap layout) atau jika penanda tema
       gelap umum ada di <html>/<body>. Semua aturan terkunci di dalam
       .ba-create-page, sehingga mode terang tidak terpengaruh.
       Background image dari layout TIDAK diganti — hanya diberi overlay. */

    :is(.ba-create-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-create-page)::before {
        opacity: 1;
    }

    :is(.ba-create-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-create-page) {
        color: #E5E7EB;
        color-scheme: dark;
    }

    /* hero */
    :is(.ba-create-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-create-page) .rounded-\[30px\] {
        background-color: rgba(8,24,46,.50) !important;
        border-color: rgba(148,163,184,.20) !important;
        box-shadow: 0 20px 60px rgba(0,0,0,.35) !important;
    }

    :is(.ba-create-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-create-page) a.bg-white\/95 {
        background-color: rgba(16,28,45,.82) !important;
        border-color: rgba(148,163,184,.30) !important;
        color: #F8FAFC !important;
    }

    :is(.ba-create-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-create-page) a.bg-white\/95:hover {
        background-color: #F28C28 !important;
        border-color: #F28C28 !important;
        color: #fff !important;
    }

    /* card */
    :is(.ba-create-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-create-page) .rounded-\[28px\] {
        background: rgba(16,28,45,.95) !important;
        border-color: #263B55 !important;
        box-shadow: 0 14px 36px rgba(0,0,0,.30) !important;
    }

    :is(.ba-create-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-create-page) .rounded-\[28px\]::before {
        background: linear-gradient(90deg, #F28C28 0, #F28C28 84px, rgba(96,165,250,.55) 84px, rgba(96,165,250,.10) 100%);
    }

    :is(.ba-create-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-create-page) .border-slate-100,
    :is(.ba-create-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-create-page) .border-slate-200,
    :is(.ba-create-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-create-page) .border-blue-100 {
        border-color: #263B55 !important;
    }

    :is(.ba-create-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-create-page) .divide-slate-100 > :not([hidden]) ~ :not([hidden]) {
        border-color: rgba(148,163,184,.16) !important;
    }

    /* form */
    :is(.ba-create-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-create-page) .label {
        color: #94A3B8;
    }

    :is(.ba-create-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-create-page) .input {
        background-color: #111D2E !important;
        border-color: #2B405A !important;
        color: #F8FAFC !important;
    }

    :is(.ba-create-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-create-page) .input::placeholder {
        color: #94A3B8 !important;
        opacity: 1;
    }

    :is(.ba-create-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-create-page) .input:focus {
        border-color: #F28C28 !important;
        background-color: #0F1A2B !important;
        box-shadow: 0 0 0 3px rgba(242,140,40,.22) !important;
    }

    :is(.ba-create-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-create-page) .input:disabled {
        background-color: rgba(17,29,46,.55) !important;
        color: #94A3B8 !important;
    }

    :is(.ba-create-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-create-page) .input option {
        background: #101C2D;
        color: #F8FAFC;
    }

    /* tabel pengolahan */
    :is(.ba-create-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-create-page) .bg-\[\#F4F7FB\] {
        background-color: rgba(19,34,56,.96) !important;
    }

    :is(.ba-create-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-create-page) thead th {
        border-bottom-color: rgba(242,140,40,.35) !important;
    }

    :is(.ba-create-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-create-page) .hover\:bg-slate-50\/70:hover {
        background-color: rgba(255,255,255,.04) !important;
    }

    /* teks */
    :is(.ba-create-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-create-page) .text-\[\#082F63\] {
        color: #93C5FD !important;
    }

    :is(.ba-create-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-create-page) h2.text-\[\#082F63\],
    :is(.ba-create-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-create-page) h3.text-\[\#082F63\],
    :is(.ba-create-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-create-page) p.text-\[\#082F63\] {
        color: #F8FAFC !important;
    }

    :is(.ba-create-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-create-page) .text-\[\#082F63\]\/30 {
        color: #64748B !important;
    }

    :is(.ba-create-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-create-page) .text-slate-400,
    :is(.ba-create-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-create-page) .text-slate-500 {
        color: #94A3B8 !important;
    }

    :is(.ba-create-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-create-page) .text-slate-600,
    :is(.ba-create-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-create-page) .text-slate-700 {
        color: #E2E8F0 !important;
    }

    /* permukaan terang lain */
    :is(.ba-create-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-create-page) .bg-white,
    :is(.ba-create-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-create-page) .bg-slate-50 {
        background-color: #0B1728 !important;
    }

    :is(.ba-create-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-create-page) .bg-slate-100 {
        background-color: #132238 !important;
        color: #93C5FD !important;
    }

    :is(.ba-create-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-create-page) .bg-orange-50 {
        background-color: rgba(242,140,40,.14) !important;
    }

    /* badge nomor section */
    :is(.ba-create-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-create-page) .bg-\[\#082F63\] {
        background-color: #1F5AA6 !important;
        color: #fff !important;
    }

    /* tombol */
    :is(.ba-create-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-create-page) a.bg-white,
    :is(.ba-create-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-create-page) button.bg-white {
        background-color: transparent !important;
        border-color: #2B405A !important;
        color: #E2E8F0 !important;
    }

    :is(.ba-create-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-create-page) a.bg-white:hover {
        border-color: #F28C28 !important;
        color: #fff !important;
    }

    :is(.ba-create-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-create-page) button.bg-white {
        border-color: rgba(96,165,250,.6) !important;
        color: #93C5FD !important;
    }

    :is(.ba-create-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-create-page) button.bg-white:hover {
        background-color: #1F5AA6 !important;
        border-color: #1F5AA6 !important;
        color: #fff !important;
    }

    :is(.ba-create-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-create-page) button.bg-\[\#F28C28\]:hover {
        background-color: #F59E3F !important;
    }

    /* pesan error / validasi (jika ditampilkan) */
    :is(.ba-create-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-create-page) .bg-red-50,
    :is(.ba-create-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-create-page) .bg-rose-50 {
        background-color: rgba(239,68,68,.14) !important;
        border-color: rgba(239,68,68,.35) !important;
    }

    :is(.ba-create-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-create-page) .text-red-500,
    :is(.ba-create-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-create-page) .text-red-600,
    :is(.ba-create-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-create-page) .text-red-700,
    :is(.ba-create-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-create-page) .text-rose-600,
    :is(.ba-create-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-create-page) .text-rose-700 {
        color: #FCA5A5 !important;
    }
</style>

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
    class="ba-create-page space-y-6 pb-10"
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
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 12H5M11 6l-6 6 6 6"/></svg> Kembali ke Daftar BA
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
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h6.5L19 6.5V19a2 2 0 01-2 2z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13 3v4h4"/></svg>
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
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5 13l4 4L19 7"/></svg>
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
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5 13l4 4L19 7"/></svg>
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
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 12H5M11 6l-6 6 6 6"/></svg> Kembali
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
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5 3h11l3 3v15H5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 3v5h7V3M8 21v-6h8v6"/></svg>
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
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M22 2L11 13"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M22 2l-7 20-4-9-9-4 20-7z"/></svg>
                Simpan &amp; Kirim Verifikasi
            </button>

        </div>

    </div>


</form>

{{-- =========================================================
    DETEKSI MODE GELAP (khusus tampilan)
    Menambah / menghapus class "is-dark" pada .ba-create-page
    mengikuti mode yang sedang aktif di layout (tombol toggle
    di navbar). Tidak berkaitan dengan fungsi form.
========================================================= --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    const page = document.querySelector('.ba-create-page');
    if (!page) return;

    // ---------- penanda tema pada html / body / pembungkus ----------
    const CLASS_OK  = /(dark|night)/i;
    const CLASS_BAD = /:|^(bg|text|border|btn|navbar|table|fill|stroke|ring|from|to|via|hover|focus|placeholder|divide|shadow|outline|alert|badge)[-_]/i;
    const ATTR_OK   = /^(dark|night)([-_ ]?(mode|theme))?$/i;

    function elementIsDark(el) {

        for (const t of el.classList) {
            if (CLASS_OK.test(t) && !CLASS_BAD.test(t)) return true;
        }

        for (const a of el.attributes) {
            if ((a.name.startsWith('data-') || a.name === 'theme') && ATTR_OK.test((a.value || '').trim())) {
                return true;
            }
        }

        return false;
    }

    function markerDark() {

        for (let el = page.parentElement; el; el = el.parentElement) {
            if (elementIsDark(el)) return true;
        }

        const root = getComputedStyle(document.documentElement).colorScheme || '';
        const body = getComputedStyle(document.body).colorScheme || '';

        return root.trim() === 'dark' || body.trim() === 'dark';
    }

    // ---------- probe: bagaimana layout me-render utilitas terang ----------
    // Probe diletakkan DI LUAR .ba-create-page agar tidak terkena aturan
    // gelap milik halaman ini (jika di dalam, mode gelap akan "terkunci").
    const canvas = document.createElement('canvas');
    canvas.width = canvas.height = 1;
    const ctx = canvas.getContext('2d', { willReadFrequently: true });

    function rgba(color) {
        ctx.clearRect(0, 0, 1, 1);
        ctx.fillStyle = '#000';
        ctx.fillStyle = color;
        ctx.fillRect(0, 0, 1, 1);
        const d = ctx.getImageData(0, 0, 1, 1).data;
        return { r: d[0], g: d[1], b: d[2], a: d[3] / 255 };
    }

    function luminance(c) {
        return (0.2126 * c.r + 0.7152 * c.g + 0.0722 * c.b) / 255;
    }

    const probes = {
        bg: document.createElement('span'),
        t1: document.createElement('span'),
        t2: document.createElement('span')
    };

    probes.bg.className = 'bg-white';
    probes.t1.className = 'text-slate-700';
    probes.t2.className = 'text-gray-700';

    Object.values(probes).forEach(function (p) {
        p.hidden = true;
        p.setAttribute('aria-hidden', 'true');
        page.parentElement.insertBefore(p, page);
    });

    function probeDark() {

        const bg = rgba(getComputedStyle(probes.bg).backgroundColor);
        if (bg.a > 0.5 && luminance(bg) < 0.45) return true;

        const t1 = rgba(getComputedStyle(probes.t1).color);
        if (t1.a > 0.5 && luminance(t1) > 0.6) return true;

        const t2 = rgba(getComputedStyle(probes.t2).color);
        if (t2.a > 0.5 && luminance(t2) > 0.6) return true;

        return false;
    }

    function isDark() {
        return markerDark() || probeDark();
    }

    // ---------- sinkronisasi dua arah ----------
    let last = null;

    function sync() {

        const dark = isDark();

        if (dark === last) return;

        last = dark;
        page.classList.toggle('is-dark', dark);
    }

    let raf = null;

    function schedule() {
        if (raf) cancelAnimationFrame(raf);
        raf = requestAnimationFrame(sync);
    }

    sync();

    const observer = new MutationObserver(schedule);

    for (let el = page.parentElement; el; el = el.parentElement) {
        observer.observe(el, { attributes: true });
    }

    // cadangan: cek ulang setelah klik (tombol tema), perubahan storage, preferensi sistem
    document.addEventListener('click', function () {
        [50, 250, 600].forEach(function (ms) { setTimeout(schedule, ms); });
    });

    window.addEventListener('storage', schedule);

    if (window.matchMedia) {
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', schedule);
    }

});
</script>

@endsection
