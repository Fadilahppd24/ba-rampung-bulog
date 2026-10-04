@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

{{-- =========================================================
    FONT & STYLE KHUSUS DASHBOARD
    Tidak mengubah fungsi/backend
========================================================= --}}
<style>
    @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Manrope:wght@400;500;600;700&display=swap');

    .dashboard-page {
        font-family: 'Manrope', sans-serif;
        width: 100%;
        max-width: none;
    }

    /* Lepas batas lebar dari wrapper layout (jika wrapper memakai max-width) */
    main:has(> .dashboard-page),
    .container:has(> .dashboard-page),
    [class*="max-w-"]:has(> .dashboard-page) {
        max-width: none !important;
        width: 100% !important;
    }

    .dashboard-display {
        font-family: 'Cormorant Garamond', Georgia, serif;
    }

    .dashboard-kicker {
        letter-spacing: .28em;
        text-transform: uppercase;
        font-size: 10px;
        font-weight: 700;
    }

    .glass-card {
        background: rgba(255,255,255,.92);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255,255,255,.8);
        box-shadow: 0 18px 50px rgba(15, 43, 82, .08);
    }

    .soft-card {
        background: rgba(255,255,255,.96);
        border: 1px solid rgba(15,43,82,.07);
        box-shadow: 0 10px 30px rgba(15,43,82,.06);
    }


    /* =========================================================
       DARK MODE — DASHBOARD ONLY
       Navbar + hero tidak disentuh.
    ========================================================= */

    /* Background area dashboard, bukan body/navbar */
    .dashboard-page.is-dark {
        color: #E5E7EB !important;
        background: #0B1120 !important;
        color-scheme: dark;
    }

    /* Jika theme toggle menaruh .dark di html/body, tetap scope ke dashboard */
    html.dark .dashboard-page,
    body.dark .dashboard-page,
    html.dark-mode .dashboard-page,
    body.dark-mode .dashboard-page,
    html.theme-dark .dashboard-page,
    body.theme-dark .dashboard-page,
    html[data-theme="dark"] .dashboard-page,
    body[data-theme="dark"] .dashboard-page,
    html[data-bs-theme="dark"] .dashboard-page,
    body[data-bs-theme="dark"] .dashboard-page {
        color: #E5E7EB !important;
        background: #0B1120 !important;
        color-scheme: dark;
    }

    /* CARD */
    .dashboard-page.is-dark .soft-card,
    .dashboard-page.is-dark .glass-card,
    html.dark .dashboard-page .soft-card,
    html.dark .dashboard-page .glass-card,
    body.dark .dashboard-page .soft-card,
    body.dark .dashboard-page .glass-card,
    html.dark-mode .dashboard-page .soft-card,
    body.dark-mode .dashboard-page .glass-card,
    html.theme-dark .dashboard-page .soft-card,
    body.theme-dark .dashboard-page .glass-card,
    html[data-theme="dark"] .dashboard-page .soft-card,
    body[data-theme="dark"] .dashboard-page .soft-card,
    html[data-bs-theme="dark"] .dashboard-page .soft-card,
    body[data-bs-theme="dark"] .dashboard-page .soft-card {
        background: #111827 !important;
        border-color: #263449 !important;
        box-shadow: 0 12px 32px rgba(0,0,0,.28) !important;
        backdrop-filter: none;
        -webkit-backdrop-filter: none;
    }

    /* KPI */
    .dashboard-page.is-dark .dash-kpi-card,
    html.dark .dashboard-page .dash-kpi-card,
    body.dark .dashboard-page .dash-kpi-card,
    html.dark-mode .dashboard-page .dash-kpi-card,
    body.dark-mode .dashboard-page .dash-kpi-card,
    html.theme-dark .dashboard-page .dash-kpi-card,
    body.theme-dark .dashboard-page .dash-kpi-card,
    html[data-theme="dark"] .dashboard-page .dash-kpi-card,
    body[data-theme="dark"] .dashboard-page .dash-kpi-card,
    html[data-bs-theme="dark"] .dashboard-page .dash-kpi-card,
    body[data-bs-theme="dark"] .dashboard-page .dash-kpi-card {
        background: #111827 !important;
        border-color: #263449 !important;
        box-shadow: 0 8px 24px rgba(0,0,0,.28) !important;
    }

    /* Teks utama dashboard */
    .dashboard-page.is-dark h2,
    .dashboard-page.is-dark .dash-kpi-number,
    html.dark .dashboard-page h2,
    html.dark .dashboard-page .dash-kpi-number,
    body.dark .dashboard-page h2,
    body.dark .dashboard-page .dash-kpi-number,
    html.dark-mode .dashboard-page h2,
    html.dark-mode .dashboard-page .dash-kpi-number,
    body.dark-mode .dashboard-page h2,
    body.dark-mode .dashboard-page .dash-kpi-number,
    html.theme-dark .dashboard-page h2,
    html.theme-dark .dashboard-page .dash-kpi-number,
    body.theme-dark .dashboard-page h2,
    body.theme-dark .dashboard-page .dash-kpi-number,
    html[data-theme="dark"] .dashboard-page h2,
    html[data-theme="dark"] .dashboard-page .dash-kpi-number,
    body[data-theme="dark"] .dashboard-page h2,
    body[data-theme="dark"] .dashboard-page .dash-kpi-number {
        color: #F8FAFC !important;
    }

    .dashboard-page.is-dark .text-\[\#123F7A\],
    html.dark .dashboard-page .text-\[\#123F7A\],
    body.dark .dashboard-page .text-\[\#123F7A\],
    html.dark-mode .dashboard-page .text-\[\#123F7A\],
    body.dark-mode .dashboard-page .text-\[\#123F7A\],
    html.theme-dark .dashboard-page .text-\[\#123F7A\],
    body.theme-dark .dashboard-page .text-\[\#123F7A\],
    html[data-theme="dark"] .dashboard-page .text-\[\#123F7A\],
    body[data-theme="dark"] .dashboard-page .text-\[\#123F7A\] {
        color: #93C5FD !important;
    }

    .dashboard-page.is-dark .text-slate-300,
    .dashboard-page.is-dark .text-slate-400,
    .dashboard-page.is-dark .text-slate-500,
    .dashboard-page.is-dark .text-gray-400,
    .dashboard-page.is-dark .text-gray-500,
    html.dark .dashboard-page .text-slate-300,
    html.dark .dashboard-page .text-slate-400,
    html.dark .dashboard-page .text-slate-500,
    html.dark .dashboard-page .text-gray-400,
    html.dark .dashboard-page .text-gray-500,
    body.dark .dashboard-page .text-slate-300,
    body.dark .dashboard-page .text-slate-400,
    body.dark .dashboard-page .text-slate-500,
    body.dark .dashboard-page .text-gray-400,
    body.dark .dashboard-page .text-gray-500 {
        color: #94A3B8 !important;
    }

    .dashboard-page.is-dark .text-slate-600,
    .dashboard-page.is-dark .text-slate-700,
    .dashboard-page.is-dark .text-slate-800,
    .dashboard-page.is-dark .text-slate-900,
    .dashboard-page.is-dark .text-gray-600,
    .dashboard-page.is-dark .text-gray-700,
    .dashboard-page.is-dark .text-gray-800,
    .dashboard-page.is-dark .text-gray-900,
    html.dark .dashboard-page .text-slate-600,
    html.dark .dashboard-page .text-slate-700,
    html.dark .dashboard-page .text-slate-800,
    html.dark .dashboard-page .text-slate-900,
    html.dark .dashboard-page .text-gray-600,
    html.dark .dashboard-page .text-gray-700,
    html.dark .dashboard-page .text-gray-800,
    html.dark .dashboard-page .text-gray-900 {
        color: #E5E7EB !important;
    }

    /* Background putih hanya di dalam dashboard */
    .dashboard-page.is-dark .bg-white,
    .dashboard-page.is-dark .bg-slate-50,
    .dashboard-page.is-dark .bg-gray-50,
    html.dark .dashboard-page .bg-white,
    html.dark .dashboard-page .bg-slate-50,
    html.dark .dashboard-page .bg-gray-50,
    body.dark .dashboard-page .bg-white,
    body.dark .dashboard-page .bg-slate-50,
    body.dark .dashboard-page .bg-gray-50 {
        background-color: #111827 !important;
    }

    .dashboard-page.is-dark .bg-slate-100,
    .dashboard-page.is-dark .bg-gray-100,
    html.dark .dashboard-page .bg-slate-100,
    html.dark .dashboard-page .bg-gray-100,
    body.dark .dashboard-page .bg-slate-100,
    body.dark .dashboard-page .bg-gray-100 {
        background-color: #172033 !important;
    }

    /* Border */
    .dashboard-page.is-dark .border-slate-50,
    .dashboard-page.is-dark .border-slate-100,
    .dashboard-page.is-dark .border-slate-200,
    .dashboard-page.is-dark .border-gray-100,
    .dashboard-page.is-dark .border-gray-200,
    html.dark .dashboard-page .border-slate-50,
    html.dark .dashboard-page .border-slate-100,
    html.dark .dashboard-page .border-slate-200,
    html.dark .dashboard-page .border-gray-100,
    html.dark .dashboard-page .border-gray-200,
    body.dark .dashboard-page .border-slate-50,
    body.dark .dashboard-page .border-slate-100,
    body.dark .dashboard-page .border-slate-200,
    body.dark .dashboard-page .border-gray-100,
    body.dark .dashboard-page .border-gray-200 {
        border-color: #263449 !important;
    }

    /* Filter tahun / input yang memang berada di dashboard */
    .dashboard-page.is-dark select,
    .dashboard-page.is-dark input,
    .dashboard-page.is-dark textarea,
    html.dark .dashboard-page select,
    html.dark .dashboard-page input,
    html.dark .dashboard-page textarea,
    body.dark .dashboard-page select,
    body.dark .dashboard-page input,
    body.dark .dashboard-page textarea {
        color: #E5E7EB !important;
        background-color: transparent;
    }

    .dashboard-page.is-dark select,
    html.dark .dashboard-page select,
    body.dark .dashboard-page select {
        color: #93C5FD !important;
    }

    .dashboard-page.is-dark option,
    html.dark .dashboard-page option,
    body.dark .dashboard-page option {
        background: #111827;
        color: #E5E7EB;
    }

    /* TABEL */
    .dashboard-page.is-dark table thead,
    .dashboard-page.is-dark table thead tr,
    .dashboard-page.is-dark table thead th,
    html.dark .dashboard-page table thead,
    html.dark .dashboard-page table thead tr,
    html.dark .dashboard-page table thead th,
    body.dark .dashboard-page table thead,
    body.dark .dashboard-page table thead tr,
    body.dark .dashboard-page table thead th {
        background: #1A2436 !important;
        color: #94A3B8 !important;
        border-color: #263449 !important;
    }

    .dashboard-page.is-dark table tbody tr,
    html.dark .dashboard-page table tbody tr,
    body.dark .dashboard-page table tbody tr {
        border-color: #263449 !important;
    }

    /* Status badge tetap kontras */
    .dashboard-page.is-dark .bg-green-50,
    .dashboard-page.is-dark .bg-green-100,
    html.dark .dashboard-page .bg-green-50,
    html.dark .dashboard-page .bg-green-100 {
        background-color: rgba(34,197,94,.14) !important;
    }

    .dashboard-page.is-dark .text-green-600,
    .dashboard-page.is-dark .text-green-700,
    .dashboard-page.is-dark .text-green-800,
    html.dark .dashboard-page .text-green-600,
    html.dark .dashboard-page .text-green-700,
    html.dark .dashboard-page .text-green-800 {
        color: #86EFAC !important;
    }

    .dashboard-page.is-dark .bg-yellow-50,
    .dashboard-page.is-dark .bg-yellow-100,
    html.dark .dashboard-page .bg-yellow-50,
    html.dark .dashboard-page .bg-yellow-100 {
        background-color: rgba(234,179,8,.14) !important;
    }

    .dashboard-page.is-dark .text-yellow-600,
    .dashboard-page.is-dark .text-yellow-700,
    .dashboard-page.is-dark .text-yellow-800,
    html.dark .dashboard-page .text-yellow-600,
    html.dark .dashboard-page .text-yellow-700,
    html.dark .dashboard-page .text-yellow-800 {
        color: #FDE68A !important;
    }

    /* KPI icon/badge */
    .dashboard-page.is-dark .dash-kpi-icon.bg-blue-50,
    html.dark .dashboard-page .dash-kpi-icon.bg-blue-50,
    body.dark .dashboard-page .dash-kpi-icon.bg-blue-50 {
        background-color: rgba(59,130,246,.16) !important;
    }

    .dashboard-page.is-dark .dash-kpi-icon.bg-orange-50,
    html.dark .dashboard-page .dash-kpi-icon.bg-orange-50,
    body.dark .dashboard-page .dash-kpi-icon.bg-orange-50 {
        background-color: rgba(249,115,22,.16) !important;
    }

    /* PENTING:
       Jangan memberi background/filter/warna ke navbar atau hero.
       Hero dan navbar berada di luar target card dashboard.
    */
    .dashboard-page.is-dark .hero-dashboard,
    html.dark .dashboard-page .hero-dashboard,
    body.dark .dashboard-page .hero-dashboard {
        background: transparent !important;
    }

    .navy-gradient {
        background:
            linear-gradient(
                135deg,
                rgba(8,36,82,.98),
                rgba(20,71,137,.94)
            );
    }

    .orange-text {
        color: #F59E0B;
    }

    .orange-bg {
        background: #F59E0B;
    }

    .bulog-blue {
        color: #123F7A;
    }

    .bulog-blue-bg {
        background: #123F7A;
    }

    .hero-dashboard {
        position: relative;
        overflow: hidden;
        border-radius: 28px;
        min-height: 340px;
        width: 100%;
        max-width: 100%;
        background: #123F7A;
        isolation: isolate;
    }

    .hero-dashboard-image {
        position: absolute !important;
        inset: 0 !important;
        width: 100% !important;
        height: 100% !important;
        display: block !important;
        visibility: visible !important;
        opacity: 1 !important;
        object-fit: cover !important;
        object-position: center !important;
        z-index: 0 !important;
    }

    .hero-dashboard-overlay {
        position: absolute;
        inset: 0;
        z-index: 1;
        background:
            linear-gradient(
                90deg,
                rgba(5,28,62,.58) 0%,
                rgba(9,44,87,.25) 48%,
                rgba(9,44,87,.04) 100%
            );
        pointer-events: none;
    }

    .hero-content {
        position: relative;
        z-index: 2;
    }

    .dash-kpi-icon {
        width: 46px;
        height: 46px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .dash-kpi-icon svg {
        width: 22px;
        height: 22px;
    }

    .dash-kpi-card {
        display: block !important;
        position: relative;
        overflow: hidden;
        background: #fff;
        border: 1px solid rgba(15,43,82,.08);
        border-radius: 20px;
        padding: 24px 24px 20px;
        box-shadow: 0 1px 2px rgba(15,43,82,.04), 0 8px 24px rgba(15,43,82,.05);
        transition: box-shadow .2s ease, transform .2s ease;
    }

    .dash-kpi-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 1px 2px rgba(15,43,82,.04), 0 14px 32px rgba(15,43,82,.09);
    }

    .dash-kpi-card::before {
        content: '';
        position: absolute;
        left: 0;
        right: 0;
        top: 0;
        height: 4px;
        background: linear-gradient(90deg, #123F7A, #2B67A5);
    }

    .dash-kpi-card.dash-kpi-accent::before {
        background: linear-gradient(90deg, #F59E0B, #F97316);
    }

    .dash-kpi-number {
        font-family: 'Manrope', sans-serif;
        font-weight: 700;
        font-size: 2.75rem;
        line-height: 1;
        letter-spacing: -0.03em;
        color: #123F7A;
    }

    .dash-kpi-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border-radius: 999px;
        padding: 3px 10px;
        font-size: 11px;
        font-weight: 700;
        background: rgba(18,63,122,.08);
        color: #123F7A;
    }

    .dash-kpi-badge.dash-kpi-badge-orange {
        background: rgba(245,158,11,.14);
        color: #B45309;
    }

    .dash-kpi-badge i {
        width: 6px;
        height: 6px;
        border-radius: 999px;
        background: currentColor;
        display: inline-block;
    }

    .dash-kpi-bars {
        display: flex;
        align-items: flex-end;
        gap: 4px;
        height: 34px;
    }

    .dash-kpi-bars span {
        flex: 1;
        min-height: 3px;
        border-radius: 3px;
        background: rgba(18,63,122,.22);
    }

    .dash-kpi-bars span:last-child {
        background: #123F7A;
    }

    .dash-kpi-track {
        height: 6px;
        border-radius: 999px;
        background: rgba(18,63,122,.08);
        overflow: hidden;
    }

    .dash-kpi-track > span {
        display: block;
        height: 100%;
        width: 100%;
        border-radius: 999px;
        background: linear-gradient(90deg, #123F7A, #2B67A5);
    }

    .dash-kpi-track.dash-kpi-track-orange > span {
        background: linear-gradient(90deg, #F59E0B, #F97316);
    }

    .chart-card {
        min-height: 430px;
    }

    .activity-row:hover {
        background: rgba(18,63,122,.035);
    }
</style>


<div class="dashboard-page space-y-7">

    {{-- =====================================================
        HERO
    ====================================================== --}}
<section class="hero-dashboard">

    <img
        src="{{ asset('images/dashboard-bulog.jpg') }}"
        alt="Gudang BULOG"
        class="hero-dashboard-image"
    >

    <div class="hero-dashboard-overlay"></div>

    <div class="hero-content p-7 sm:p-10 lg:p-12">

            <div class="max-w-4xl">

                <div class="dashboard-kicker text-white/75 mb-4">
                    Sistem BA Rampung
                </div>

                <h1
                    class="dashboard-display text-white text-5xl sm:text-6xl lg:text-7xl leading-[.9] font-medium"
                >
                    Mengelola Data,
                    <br>

                    <span class="orange-text">
                        Menguatkan Ketahanan Pangan.
                    </span>
                </h1>

                <p class="mt-6 text-white/80 text-sm sm:text-base max-w-2xl leading-7">
                    Pantau dan kelola proses pengolahan gabah menjadi beras
                    hasil giling dengan lebih mudah, cepat, dan terintegrasi.
                </p>
            </div>

        </div>

    </section>


    {{-- =====================================================
        FILTER TAHUN
    ====================================================== --}}
    <div class="flex justify-end">

        <form method="GET">

            <div
                class="
                    flex items-center gap-3
                    rounded-full
                    bg-white
                    border border-slate-200
                    px-4 py-2
                    shadow-sm
                "
            >

                <span class="text-xs text-slate-500">
                    Tahun
                </span>

                <select
                    name="tahun"
                    onchange="this.form.submit()"
                    class="
                        border-0
                        outline-none
                        bg-transparent
                        text-sm
                        font-semibold
                        text-[#123F7A]
                        focus:ring-0
                    "
                >

                    @for($i=date('Y'); $i>=date('Y')-5; $i--)

                        <option
                            value="{{ $i }}"
                            @selected($tahun == $i)
                        >
                            {{ $i }}
                        </option>

                    @endfor

                </select>

            </div>

        </form>

    </div>


    {{-- =====================================================
        KPI
    ====================================================== --}}
    @php
        // Hanya untuk visual mini bar (memakai variabel $perBulan yang sudah ada)
        $miniBars = collect($perBulan)->pluck('jumlah')->values();
        $miniMax  = max((float) $miniBars->max(), 1);
    @endphp

    <section
        class="
            grid
            grid-cols-1
            md:grid-cols-3
            gap-5
        "
    >

        {{-- TOTAL BA --}}
        <div class="dash-kpi-card">

            <div class="flex items-start justify-between gap-4">

                <div>

                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">
                        Total BA Rampung
                    </p>

                    <p class="dash-kpi-number mt-3">
                        {{ number_format($kpi['total_ba']) }}
                    </p>

                </div>

                <div class="dash-kpi-icon bg-blue-50 text-[#123F7A]">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8z"/>
                        <path d="M14 3v5h5"/>
                        <path d="M9 13h6M9 17h4"/>
                    </svg>
                </div>

            </div>

            <div class="mt-5 flex items-end justify-between gap-4">

                <div>
                    <span class="dash-kpi-badge"><i></i> Dokumen terdaftar</span>
                    <p class="text-[11px] text-slate-400 mt-2">
                        Tren bulanan {{ $tahun }}
                    </p>
                </div>

                <div class="dash-kpi-bars w-28">
                    @foreach($miniBars as $v)
                        <span style="height: {{ max(8, round(((float) $v / $miniMax) * 100)) }}%"></span>
                    @endforeach
                </div>

            </div>

        </div>


        {{-- GUDANG --}}
        <div class="dash-kpi-card dash-kpi-accent">

            <div class="flex items-start justify-between gap-4">

                <div>

                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">
                        Gudang Aktif
                    </p>

                    <p class="dash-kpi-number mt-3">
                        {{ number_format($kpi['gudang_aktif']) }}
                    </p>

                </div>

                <div class="dash-kpi-icon bg-orange-50 text-orange-500">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 10l9-6 9 6"/>
                        <path d="M5 10v10h14V10"/>
                        <path d="M9 20v-6h6v6"/>
                    </svg>
                </div>

            </div>

            <div class="mt-5">

                <span class="dash-kpi-badge dash-kpi-badge-orange"><i></i> Gudang terdaftar</span>

                <div class="dash-kpi-track dash-kpi-track-orange mt-4">
                    <span></span>
                </div>

            </div>

        </div>


        {{-- MITRA --}}
        <div class="dash-kpi-card">

            <div class="flex items-start justify-between gap-4">

                <div>

                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">
                        Mitra Pengolahan
                    </p>

                    <p class="dash-kpi-number mt-3">
                        {{ number_format($kpi['mitra_pengolahan']) }}
                    </p>

                </div>

                <div class="dash-kpi-icon bg-blue-50 text-[#123F7A]">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="9" cy="8" r="3.2"/>
                        <path d="M3 20v-1a5 5 0 0 1 5-5h2a5 5 0 0 1 5 5v1"/>
                        <circle cx="17" cy="9" r="2.4"/>
                        <path d="M17 14a4 4 0 0 1 4 4v2"/>
                    </svg>
                </div>

            </div>

            <div class="mt-5">

                <span class="dash-kpi-badge"><i></i> Mitra terdaftar</span>

                <div class="dash-kpi-track mt-4">
                    <span></span>
                </div>

            </div>

        </div>

    </section>


    {{-- =====================================================
        CHART AREA
    ====================================================== --}}
    <section
        class="
            grid
            grid-cols-1
            xl:grid-cols-3
            gap-6
        "
    >

        {{-- BAR CHART --}}
        <div
            class="
                soft-card
                rounded-3xl
                p-6
                xl:col-span-2
                chart-card
            "
        >

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">

                <div>

                    <p class="dashboard-kicker text-[#123F7A]">
                        Statistik
                    </p>

                    <h2
                        class="
                            dashboard-display
                            text-3xl
                            text-[#123F7A]
                            font-semibold
                        "
                    >
                        Rekap BA Rampung
                    </h2>

                    <p class="text-xs text-slate-400 mt-1">
                        Per bulan tahun {{ $tahun }}
                    </p>

                </div>

            </div>

            <div class="h-[330px]">

                <canvas id="chartPerBulan"></canvas>

            </div>

        </div>


        {{-- DONUT --}}
        <div
            class="
                soft-card
                rounded-3xl
                p-6
                chart-card
            "
        >

            <div>

                <p class="dashboard-kicker text-[#123F7A]">
                    Distribusi
                </p>

                <h2
                    class="
                        dashboard-display
                        text-3xl
                        text-[#123F7A]
                        font-semibold
                    "
                >
                    Pergudangan
                </h2>

                <p class="text-xs text-slate-400 mt-1">
                    Distribusi BA berdasarkan gudang
                </p>

            </div>


            <div class="relative h-[260px] mt-4">

                <canvas id="chartGudang"></canvas>

                <div
                    class="
                        absolute
                        inset-0
                        flex
                        items-center
                        justify-center
                        pointer-events-none
                    "
                >

                    <div class="text-center">

                        <p
                            class="
                                dashboard-display
                                text-5xl
                                font-semibold
                                text-[#123F7A]
                            "
                        >
                            {{ $kpi['total_ba'] }}
                        </p>

                        <p class="text-xs text-slate-500">
                            BA Rampung
                        </p>

                    </div>

                </div>

            </div>


            <div class="mt-5 space-y-3">

                @foreach($distribusiGudang as $d)

                    <div
                        class="
                            flex
                            justify-between
                            items-center
                            text-sm
                            py-1
                        "
                    >

                        <div class="flex items-center gap-2">

                            <span
                                class="
                                    w-2
                                    h-2
                                    rounded-full
                                    bg-[#123F7A]
                                "
                            ></span>

                            <span class="text-slate-600">
                                {{ $d->nama_gudang }}
                            </span>

                        </div>

                        <span class="font-semibold text-[#123F7A]">
                            {{ $d->jumlah }}
                        </span>

                    </div>

                @endforeach

            </div>

        </div>

    </section>


    {{-- =====================================================
        DATA BAWAH
    ====================================================== --}}
    <section
        class="
            grid
            grid-cols-1
            xl:grid-cols-3
            gap-6
        "
    >

        {{-- BA TERBARU --}}
        <div
            class="
                soft-card
                rounded-3xl
                p-6
                xl:col-span-3
            "
        >

            <div class="flex items-center justify-between mb-5">

                <div>

                    <p class="dashboard-kicker text-[#123F7A]">
                        Aktivitas
                    </p>

                    <h2
                        class="
                            dashboard-display
                            text-3xl
                            font-semibold
                            text-[#123F7A]
                        "
                    >
                        BA Rampung Terbaru
                    </h2>

                </div>

                <a
                    href="{{ route('ba-rampung.index') }}"
                    class="
                        text-sm
                        font-semibold
                        text-[#123F7A]
                        hover:text-orange-500
                        transition
                    "
                >
                    Lihat Semua →
                </a>

            </div>


            <div class="overflow-x-auto">

                <table class="w-full text-sm">

                    <thead>

                        <tr
                            class="
                                border-b
                                border-slate-100
                                text-[11px]
                                uppercase
                                tracking-wider
                                text-slate-400
                            "
                        >

                            <th class="py-3 text-left">
                                No
                            </th>

                            <th class="py-3 text-left">
                                Nomor BA
                            </th>

                            <th class="py-3 text-left">
                                Gudang
                            </th>

                            <th class="py-3 text-left">
                                Status
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @foreach($baTerbaru as $key => $ba)

                            <tr
                                class="
                                    activity-row
                                    border-b
                                    border-slate-50
                                    transition
                                "
                            >

                                <td class="py-4 text-slate-400">
                                    {{ $key + 1 }}
                                </td>

                                <td class="py-4 font-semibold text-[#123F7A]">
                                    {{ $ba->nomor_ba }}
                                </td>

                                <td class="py-4 text-slate-600">
                                    {{ $ba->gudang->nama_gudang ?? '-' }}
                                </td>

                                <td class="py-4">

                                    <x-status-badge
                                        :color="$ba->statusBadgeColor()"
                                        :label="$ba->statusLabel()"
                                    />

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    </section>


    {{-- =====================================================
        AKTIVITAS SISTEM
    ====================================================== --}}
    <section
        class="
            soft-card
            rounded-3xl
            p-6
        "
    >

        <div class="flex items-center justify-between mb-5">

            <div>

                <p class="dashboard-kicker text-[#123F7A]">
                    Sistem
                </p>

                <h2
                    class="
                        dashboard-display
                        text-3xl
                        font-semibold
                        text-[#123F7A]
                    "
                >
                    Aktivitas Terbaru
                </h2>

            </div>

        </div>


        <div class="space-y-1">

            @foreach($aktivitasTerbaru as $log)

                <div
                    class="
                        activity-row
                        flex
                        gap-4
                        items-start
                        rounded-2xl
                        p-4
                        transition
                    "
                >

                    <span
                        class="
                            mt-2
                            w-2
                            h-2
                            rounded-full
                            bg-orange-400
                            flex-shrink-0
                        "
                    ></span>

                    <div class="flex-1">

                        <p class="text-sm text-slate-700">

                            <b class="text-[#123F7A]">
                                {{ $log->user->name ?? 'System' }}
                            </b>

                            {{ $log->aktivitas }}

                        </p>

                        <p class="text-xs text-slate-400 mt-1">
                            {{ $log->created_at->diffForHumans() }}
                        </p>

                    </div>

                </div>

            @endforeach

        </div>

    </section>

</div>


{{-- =========================================================
    CHART.JS
    LOGIKA LAMA TETAP DIPERTAHANKAN
========================================================= --}}

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

document.addEventListener('DOMContentLoaded', function () {

    // ======================================================
    // BAR CHART BA PER BULAN
    // ======================================================

    const chartPerBulan =
        document.getElementById('chartPerBulan');

    if (chartPerBulan) {

        new Chart(chartPerBulan, {

            type: 'bar',

            data: {

                labels: @json(
                    collect($perBulan)->pluck('bulan')
                ),

                datasets: [{

                    label: 'Jumlah BA',

                    data: @json(
                        collect($perBulan)->pluck('jumlah')
                    ),

                    backgroundColor: '#123F7A',

                    borderRadius: 10,

                    barThickness: 25

                }]

            },

            options: {

                responsive: true,

                maintainAspectRatio: false,

                plugins: {

                    legend: {
                        display: false
                    }

                },

                scales: {

                    x: {

                        grid: {
                            display: false
                        },

                        ticks: {
                            font: {
                                family: 'Manrope'
                            }
                        }

                    },

                    y: {

                        beginAtZero: true,

                        ticks: {

                            precision: 0,

                            font: {
                                family: 'Manrope'
                            }

                        },

                        grid: {
                            color: 'rgba(18,63,122,.08)'
                        }

                    }

                }

            }

        });

    }


    // ======================================================
    // DONUT GUDANG
    // ======================================================

    const chartGudang =
        document.getElementById('chartGudang');

    if (chartGudang) {

        new Chart(chartGudang, {

            type: 'doughnut',

            data: {

                labels: @json(
                    $distribusiGudang->pluck('nama_gudang')
                ),

                datasets: [{

                    data: @json(
                        $distribusiGudang->pluck('jumlah')
                    ),

                    backgroundColor: [

                        '#123F7A',
                        '#2B67A5',
                        '#F59E0B',
                        '#4A90D9',
                        '#F97316'

                    ],

                    borderWidth: 0

                }]

            },

            options: {

                responsive: true,

                maintainAspectRatio: false,

                cutout: '70%',

                plugins: {

                    legend: {

                        display: false

                    }

                }

            }

        });

    }

});

</script>

{{-- =========================================================
    DETEKSI MODE GELAP + WARNA CHART
    - Menandai .dashboard-page dengan class "is-dark" saat layout
      berada di mode gelap (apa pun penanda yang dipakai layout).
    - Hanya mengubah warna visual chart; data & logic chart asli
      tidak diubah.
========================================================= --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    const page = document.querySelector('.dashboard-page');
    if (!page) return;

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

    function isDark() {

        // penanda pada html / body / pembungkus layout
        for (let el = page.parentElement; el; el = el.parentElement) {
            if (elementIsDark(el)) return true;
        }

        // color-scheme: dark yang diset layout
        const root = getComputedStyle(document.documentElement).colorScheme || '';
        const body = getComputedStyle(document.body).colorScheme || '';
        return root.trim() === 'dark' || body.trim() === 'dark';
    }

    window.dashboardIsDark = isDark;

    // ---------- warna chart ----------
    const hasChart = typeof Chart !== 'undefined' && typeof Chart.getChart === 'function';

    const THEME = hasChart ? {
        light: {
            bar:  '#123F7A',
            tick: Chart.defaults.color,
            grid: 'rgba(18,63,122,.08)',
            donut: ['#123F7A', '#2B67A5', '#F59E0B', '#4A90D9', '#F97316']
        },
        dark: {
            bar:  '#60A5FA',
            tick: '#94A3B8',
            grid: 'rgba(148,163,184,.14)',
            donut: ['#60A5FA', '#3B82F6', '#F59E0B', '#93C5FD', '#F97316']
        }
    } : null;

    function applyChartTheme(dark) {

        if (!hasChart) return;

        const t = dark ? THEME.dark : THEME.light;

        const bar = Chart.getChart('chartPerBulan');

        if (bar) {
            bar.data.datasets[0].backgroundColor = t.bar;
            bar.options.scales.x.ticks.color = t.tick;
            bar.options.scales.y.ticks.color = t.tick;
            bar.options.scales.y.grid.color  = t.grid;
            bar.update('none');
        }

        const donut = Chart.getChart('chartGudang');

        if (donut) {
            donut.data.datasets[0].backgroundColor = t.donut;
            donut.update('none');
        }
    }

    // ---------- sinkronisasi ----------
    let last = null;

    function sync() {

        const dark = isDark();

        if (dark === last) return;

        last = dark;
        page.classList.toggle('is-dark', dark);
        applyChartTheme(dark);
    }

    let raf = null;

    function schedule() {
        if (raf) cancelAnimationFrame(raf);
        raf = requestAnimationFrame(sync);
    }

    sync();

    // pantau perubahan atribut pada html, body, dan pembungkus dashboard
    const observer = new MutationObserver(schedule);

    for (let el = page.parentElement; el; el = el.parentElement) {
        observer.observe(el, { attributes: true });
    }

    // cadangan: cek ulang setelah klik (tombol tema) & perubahan storage / preferensi sistem
    document.addEventListener('click', function () {
        [50, 250, 600].forEach(ms => setTimeout(schedule, ms));
    });

    window.addEventListener('storage', schedule);

    if (window.matchMedia) {
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', schedule);
    }

});
</script>

@endsection
