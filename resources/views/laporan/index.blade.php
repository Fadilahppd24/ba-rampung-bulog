@extends('layouts.app')

@section('title', 'Laporan')

@section('content')

{{-- =========================================================
     STYLE KHUSUS HALAMAN LAPORAN (scoped di .laporan-page)
     - Hanya visual. Tidak menyentuh logic / backend.
     - Gaya & mekanisme dark mode SAMA dengan halaman Mitra.
========================================================== --}}
<style>
    .laporan-page {
        --m-card: rgba(255, 255, 255, .76);
        --m-soft: rgba(255, 255, 255, .78);
        --m-section: #F5F7FA;
        --m-border: #D9E2EC;
        --m-border-soft: #E8EEF5;
        --m-text: #0F2A4A;
        --m-text-2: #5B6F89;
        --m-muted: #94A3B8;
        --m-head-bg: #F5F7FA;
        --m-hover: rgba(18, 63, 122, .045);
        --m-input-bg: #FFFFFF;
        --m-input-border: #D9E2EC;
        --m-focus-ring: rgba(18, 63, 122, .14);
        --m-chip-bg: #EAF2FC;
        --m-chip-fg: #123F7A;
        --m-accent-bg: #FFF3E3;
        --m-accent-fg: #D97706;
        --m-ok-bg: #E7F6EE;
        --m-ok-fg: #15803D;
        --m-off-bg: #EEF2F6;
        --m-off-fg: #64748B;
        --m-btn-ghost-bg: #FFFFFF;
        --m-btn-ghost-hover: #F5F7FA;
        --m-shadow: 0 10px 30px rgba(15, 42, 74, .08);
        --m-number: #123F7A;
        color: var(--m-text);
    }

    /* ---------- DARK MODE (dideteksi oleh script di bawah) ---------- */
    .laporan-page[data-m-theme="dark"] {
        --m-card: rgba(16, 28, 45, .72);
        --m-soft: rgba(16, 28, 45, .84);
        --m-section: #132238;
        --m-border: #263B55;
        --m-border-soft: #1E3149;
        --m-text: #F8FAFC;
        --m-text-2: #94A3B8;
        --m-muted: #7C8DA4;
        --m-head-bg: #18263A;
        --m-hover: rgba(96, 150, 220, .10);
        --m-input-bg: #111D2E;
        --m-input-border: #263B55;
        --m-focus-ring: rgba(242, 140, 40, .20);
        --m-chip-bg: rgba(96, 165, 250, .14);
        --m-chip-fg: #93C5FD;
        --m-accent-bg: rgba(242, 140, 40, .14);
        --m-accent-fg: #F6A94F;
        --m-ok-bg: rgba(52, 211, 153, .14);
        --m-ok-fg: #6EE7B7;
        --m-off-bg: rgba(148, 163, 184, .14);
        --m-off-fg: #AEBBCC;
        --m-btn-ghost-bg: #132238;
        --m-btn-ghost-hover: #18263A;
        --m-shadow: 0 14px 40px rgba(0, 8, 20, .45);
        --m-number: #F8FAFC;
        color-scheme: dark;
    }

    /* ---------- CARD ---------- */
    .laporan-page .m-card {
        position: relative;
        background: var(--m-card);
        border: 1px solid var(--m-border);
        border-radius: 24px;
        box-shadow: var(--m-shadow);
        backdrop-filter: blur(12px) saturate(115%);
        -webkit-backdrop-filter: blur(12px) saturate(115%);
        overflow: hidden;
    }
    /* HERO LAPORAN: glass transparan + gradasi seperti halaman Master Data Mitra */
    .laporan-page .m-hero-transparent {
        background:
            linear-gradient(
                105deg,
                rgba(8, 47, 99, 0.72) 0%,
                rgba(18, 63, 122, 0.52) 48%,
                rgba(38, 91, 150, 0.28) 100%
            ) !important;
        border: 1px solid rgba(255, 255, 255, 0.26) !important;
        box-shadow:
            0 18px 45px rgba(15, 23, 42, 0.14),
            inset 0 1px 0 rgba(255,255,255,0.12) !important;
        backdrop-filter: blur(10px) saturate(125%) !important;
        -webkit-backdrop-filter: blur(10px) saturate(125%) !important;
    }

    /* Pastikan judul dan subjudul terbaca di atas gradasi biru */
    .laporan-page .m-hero-transparent .m-title {
        color: #ffffff !important;
        text-shadow: 0 1px 10px rgba(0,0,0,.12);
    }

    .laporan-page .m-hero-transparent .m-sub {
        color: rgba(255,255,255,.92) !important;
        text-shadow: 0 1px 8px rgba(0,0,0,.12);
    }

    .laporan-page .m-hero-transparent .orange-text {
        color: #F28C28 !important;
    }

    .laporan-page[data-m-theme="dark"] .m-hero-transparent {
        background:
            linear-gradient(
                105deg,
                rgba(5, 22, 43, 0.78) 0%,
                rgba(8, 36, 70, 0.58) 50%,
                rgba(18, 58, 100, 0.34) 100%
            ) !important;
        border-color: rgba(110, 170, 225, 0.25) !important;
        box-shadow:
            0 18px 45px rgba(0, 0, 0, 0.28),
            inset 0 1px 0 rgba(255,255,255,0.08) !important;
    }

    .laporan-page[data-m-theme="dark"] .m-hero-transparent .m-title {
        color: #ffffff !important;
    }

    .laporan-page[data-m-theme="dark"] .m-hero-transparent .m-sub {
        color: rgba(235,243,252,.88) !important;
    }
    .laporan-page .m-card-accent::before {
        content: "";
        position: absolute;
        left: 0; right: 0; top: 0;
        height: 3px;
        background: linear-gradient(90deg, #F28C28 0%, rgba(242, 140, 40, 0) 70%);
        z-index: 1;
    }
    .laporan-page .m-divider { border-color: var(--m-border-soft); }
    .laporan-page .m-panel {
        background: var(--m-section);
        border: 1px solid var(--m-border-soft);
        border-radius: 20px;
    }

    /* ---------- TEKS ---------- */
    .laporan-page .m-eyebrow {
        font-size: 10px; font-weight: 700; letter-spacing: .25em; text-transform: uppercase;
        color: #F28C28;
    }
    .laporan-page .m-title { color: var(--m-text); }
    .laporan-page .m-sub { color: var(--m-text-2); }
    .laporan-page .m-muted { color: var(--m-muted); }
    .laporan-page .m-label {
        display: block; margin-bottom: 8px;
        font-size: 11px; font-weight: 700; letter-spacing: .12em; text-transform: uppercase;
        color: var(--m-text-2);
    }
    .laporan-page .m-number { color: var(--m-number); }
    .laporan-page .m-hl { color: var(--m-chip-fg); font-weight: 700; }

    /* ---------- ICON ---------- */
    .laporan-page .mi { width: 1.25rem; height: 1.25rem; flex-shrink: 0; fill: none; stroke: currentColor; stroke-width: 1.8; stroke-linecap: round; stroke-linejoin: round; }
    .laporan-page .mi-sm { width: 1rem; height: 1rem; }
    .laporan-page .mi-lg { width: 1.5rem; height: 1.5rem; }
    .laporan-page .m-icon-box {
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        border-radius: 16px;
        background: var(--m-chip-bg); color: var(--m-chip-fg);
    }
    .laporan-page .m-icon-box.accent { background: var(--m-accent-bg); color: var(--m-accent-fg); }
    .laporan-page .m-icon-box.ok { background: var(--m-ok-bg); color: var(--m-ok-fg); }
    .laporan-page .m-icon-box.off { background: var(--m-off-bg); color: var(--m-off-fg); }
    .laporan-page .m-icon-box.solid { background: #123F7A; color: #fff; }

    /* ---------- TOMBOL ---------- */
    .laporan-page .m-btn {
        display: inline-flex; align-items: center; justify-content: center; gap: 8px;
        border-radius: 14px; padding: 10px 20px;
        font-size: 14px; font-weight: 700; line-height: 1.2;
        transition: transform .18s ease, background-color .18s ease, box-shadow .18s ease, border-color .18s ease;
        cursor: pointer; text-decoration: none;
    }
    .laporan-page .m-btn-sm { padding: 9px 14px; font-size: 12px; border-radius: 12px; }
    .laporan-page .m-btn-primary { background: #123F7A; color: #fff; box-shadow: 0 6px 16px rgba(18, 63, 122, .25); border: 1px solid transparent; }
    .laporan-page .m-btn-primary:hover { background: #0d3263; transform: translateY(-1px); }
    .laporan-page[data-m-theme="dark"] .m-btn-primary { background: #1B5199; }
    .laporan-page[data-m-theme="dark"] .m-btn-primary:hover { background: #2160B3; }
    .laporan-page .m-btn-ghost { background: var(--m-btn-ghost-bg); color: var(--m-text-2); border: 1px solid var(--m-border); }
    .laporan-page .m-btn-ghost:hover { background: var(--m-btn-ghost-hover); color: var(--m-text); border-color: #F28C28; }

    /* ---------- INPUT / SELECT ---------- */
    .laporan-page .m-input {
        width: 100%;
        border-radius: 14px;
        border: 1px solid var(--m-input-border) !important;
        background: var(--m-input-bg) !important;
        color: var(--m-text) !important;
        padding: 12px 14px;
        font-size: 14px;
        outline: none;
        transition: border-color .18s ease, box-shadow .18s ease;
    }
    .laporan-page .m-input::placeholder { color: var(--m-muted); }
    .laporan-page .m-input:focus { border-color: #F28C28 !important; box-shadow: 0 0 0 4px var(--m-focus-ring); }
    .laporan-page .m-input[readonly] { opacity: .8; cursor: not-allowed; }
    .laporan-page .m-input option { background: var(--m-input-bg); color: var(--m-text); }

    /* ---------- PILIHAN JENIS LAPORAN (semua card seragam) ---------- */
    .laporan-page .m-choice { position: relative; display: block; cursor: pointer; }
    .laporan-page .m-choice-box {
        position: relative; height: 100%;
        border-radius: 18px; padding: 16px;
        background: var(--m-soft);
        border: 1.5px solid var(--m-border);
        transition: transform .18s ease, border-color .18s ease, box-shadow .18s ease, background-color .18s ease;
    }
    .laporan-page .m-choice:hover .m-choice-box { transform: translateY(-2px); border-color: rgba(242, 140, 40, .6); box-shadow: var(--m-shadow); }
    .laporan-page .m-choice input:checked + .m-choice-box {
        border-color: #F28C28;
        box-shadow: 0 0 0 3px rgba(242, 140, 40, .16);
    }
    .laporan-page .m-choice input:checked + .m-choice-box::after {
        content: "";
        position: absolute; top: 12px; right: 12px;
        width: 9px; height: 9px; border-radius: 999px;
        background: #F28C28;
        box-shadow: 0 0 0 4px rgba(242, 140, 40, .22);
    }
    .laporan-page .m-choice input:focus-visible + .m-choice-box { box-shadow: 0 0 0 4px var(--m-focus-ring); }

    /* ---------- KPI ---------- */
    .laporan-page .m-kpi { padding: 22px 24px; transition: transform .2s ease, border-color .2s ease; }
    .laporan-page .m-kpi:hover { transform: translateY(-3px); border-color: rgba(242, 140, 40, .55); }
    .laporan-page .m-kpi-glow {
        position: absolute; right: -34px; top: -34px; width: 120px; height: 120px; border-radius: 999px;
        background: var(--m-chip-bg); opacity: .65; pointer-events: none;
    }
    .laporan-page .m-kpi-glow.accent { background: var(--m-accent-bg); }
    .laporan-page .m-kpi-glow.ok { background: var(--m-ok-bg); }

    /* ---------- CHIP FILTER AKTIF ---------- */
    .laporan-page .m-pill {
        display: inline-flex; align-items: center;
        border-radius: 999px; padding: 6px 12px;
        font-size: 12px; font-weight: 600;
        background: var(--m-off-bg); color: var(--m-text-2);
    }
    .laporan-page .m-pill.hl { background: var(--m-chip-bg); color: var(--m-chip-fg); }

    /* ---------- TABEL ---------- */
    .laporan-page .m-table { width: 100%; font-size: 14px; border-collapse: collapse; }
    .laporan-page .m-table thead tr { background: var(--m-head-bg); border-bottom: 1px solid var(--m-border); }
    .laporan-page .m-table th {
        padding: 16px 20px; text-align: left; white-space: nowrap;
        font-size: 10px; font-weight: 700; letter-spacing: .14em; text-transform: uppercase;
        color: var(--m-text-2);
    }
    .laporan-page .m-table tbody tr { border-bottom: 1px solid var(--m-border-soft); transition: background-color .15s ease; }
    .laporan-page .m-table tbody tr:last-child { border-bottom: 0; }
    .laporan-page .m-table tbody tr:hover { background: var(--m-hover); }
    .laporan-page .m-table td { padding: 14px 20px; vertical-align: middle; color: var(--m-text); white-space: nowrap; }
    .laporan-page .m-table td.m-empty { white-space: normal; color: var(--m-text-2); }

    @media (max-width: 640px) {
        .laporan-page .m-table th, .laporan-page .m-table td { padding: 12px 14px; }
    }

    /* ---------- PRINT: selalu terang agar hasil cetak terbaca ---------- */
    @media print {
        body * { visibility: hidden !important; }
        .overflow-x-auto, .overflow-x-auto * { visibility: visible !important; }
        .overflow-x-auto { position: absolute; left: 0; top: 0; width: 100%; }
        .laporan-page .m-table, .laporan-page .m-table thead tr, .laporan-page .m-table tbody tr { background: #fff !important; }
        .laporan-page .m-table th, .laporan-page .m-table td { color: #0F172A !important; background: #fff !important; }
    }
</style>

<div class="laporan-page space-y-6 pb-8">

    {{-- HERO --}}
    {{-- Tidak menggunakan gambar di dalam card. Background halaman tetap mengikuti layout utama. --}}
    <section class="m-card m-card-accent m-hero-transparent relative overflow-hidden px-7 py-8 sm:px-10 sm:py-10 lg:px-12">
        <div class="pointer-events-none absolute -right-16 -top-20 h-48 w-48 rounded-full bg-[#123F7A]/10 dark:bg-[#5B9BE8]/10"></div>
        <div class="pointer-events-none absolute -bottom-20 left-1/3 h-40 w-40 rounded-full bg-[#F28C28]/10"></div>

        <div class="relative z-10">
            <div class="m-eyebrow mb-3">Laporan</div>
            <h1 class="dashboard-display m-title text-5xl font-normal leading-[.9] sm:text-6xl lg:text-[4.5rem]">
                Laporan <span class="orange-text">BA Rampung.</span>
            </h1>
            <p class="m-sub mt-4 max-w-2xl text-sm leading-7 sm:text-base">
                Pantau dan analisis data BA Rampung berdasarkan gudang, mitra, periode, dan jenis laporan.
            </p>
        </div>
    </section>

    {{-- INFO ROLE --}}
    <section class="m-card m-card-accent p-5 sm:p-6">
        <div class="flex items-start gap-4">
            <div class="m-icon-box h-11 w-11">
                <svg class="mi" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z"/>
                </svg>
            </div>
            <div>
                <p class="m-title font-bold">
                    {{ $isAdminGudang ? 'Laporan Gudang' : 'Laporan Seluruh Gudang' }}
                </p>
                <p class="m-sub mt-1 text-sm leading-6">
                    @if ($isAdminGudang)
                        Laporan hanya menampilkan data dari
                        <span class="m-hl">{{ $gudangUser?->nama_gudang ?? 'gudang Anda' }}</span>.
                    @else
                        Laporan dapat menampilkan data dari seluruh gudang sesuai hak akses Anda.
                    @endif
                </p>
            </div>
        </div>
    </section>

    {{-- PILIH JENIS + FILTER --}}
    <section class="m-card m-card-accent">
        <div class="m-divider border-b px-6 py-5 sm:px-7">
            <div class="flex items-center gap-4">
                <div class="m-icon-box h-11 w-11">
                    <svg class="mi" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/>
                    </svg>
                </div>
                <div>
                    <p class="m-eyebrow">Jenis Laporan</p>
                    <h2 class="m-title mt-1 text-xl font-bold">Pilih Jenis Laporan</h2>
                    <p class="m-muted mt-0.5 text-xs">Tentukan data yang ingin kamu lihat.</p>
                </div>
            </div>
        </div>

        <form method="GET" action="{{ route('laporan.index') }}" class="p-6 sm:p-7">
            <div class="grid grid-cols-1 gap-3 md:grid-cols-2 xl:grid-cols-4">
                @foreach ($jenisList as $val => $label)
                    @if ($isAdminGudang && $val === 'per_gudang')
                        @continue
                    @endif
                    @php
                        $iconPath = match ($val) {
                            'ba_rampung' => 'M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z',
                            'per_mitra' => 'M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z',
                            'per_gudang' => 'M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z',
                            'catatan' => 'M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z',
                            default => 'M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z',
                        };
                        $desc = match ($val) {
                            'ba_rampung' => 'Rekap seluruh BA Rampung',
                            'per_mitra' => 'Rekap berdasarkan mitra',
                            'per_gudang' => 'Rekap berdasarkan gudang',
                            'catatan' => 'Daftar BA yang memiliki catatan',
                            default => 'Ringkasan data laporan',
                        };
                    @endphp
                    <label class="m-choice">
                        <input type="radio" name="jenis" value="{{ $val }}" class="sr-only" @checked($jenis === $val)>
                        <div class="m-choice-box">
                            <div class="flex items-start gap-3">
                                <div class="m-icon-box h-11 w-11" style="border-radius:14px;">
                                    <svg class="mi" viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="{{ $iconPath }}"/>
                                    </svg>
                                </div>
                                <div class="min-w-0 pr-4">
                                    <p class="m-title text-sm font-bold">{{ $label }}</p>
                                    <p class="m-muted mt-1 text-xs leading-5">{{ $desc }}</p>
                                </div>
                            </div>
                        </div>
                    </label>
                @endforeach
            </div>

            <div class="m-panel mt-7 p-5">
                <div class="mb-4 flex items-center gap-3">
                    <div class="m-icon-box h-9 w-9" style="border-radius:12px;">
                        <svg class="mi mi-sm" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M10.5 6h9.75M10.5 6a1.5 1.5 0 1 1-3 0m3 0a1.5 1.5 0 1 0-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-9.75 0h9.75"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="m-title text-sm font-bold">Filter Data</h3>
                        <p class="m-muted text-xs">Gunakan filter berikut untuk menampilkan data yang ingin dilihat.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
                    <div>
                        <label class="m-label">Gudang</label>
                        @if ($isAdminGudang)
                            <input type="text" class="m-input" value="{{ $gudangUser?->nama_gudang ?? '-' }}" readonly>
                            <input type="hidden" name="gudang_id" value="{{ $gudangUser?->id }}">
                        @else
                            <select name="gudang_id" class="m-input">
                                <option value="">Semua Gudang</option>
                                @foreach ($gudangs as $g)
                                    <option value="{{ $g->id }}" @selected(request('gudang_id') == $g->id)>{{ $g->nama_gudang }}</option>
                                @endforeach
                            </select>
                        @endif
                    </div>
                    <div>
                        <label class="m-label">Mitra Pengolahan</label>
                        <select name="mitra_pengolahan_id" class="m-input">
                            <option value="">Semua Mitra</option>
                            @foreach ($mitras as $m)
                                <option value="{{ $m->id }}" @selected(request('mitra_pengolahan_id') == $m->id)>{{ $m->nama_mitra }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="m-label">Bulan</label>
                        <select name="bulan" class="m-input">
                            <option value="">Semua Bulan</option>
                            @foreach (range(1, 12) as $bln)
                                <option value="{{ $bln }}" @selected((string) request('bulan') === (string) $bln)>{{ \Carbon\Carbon::create()->month($bln)->translatedFormat('F') }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="m-label">Tahun</label>
                        <select name="tahun" class="m-input">
                            <option value="">Semua Tahun</option>
                            @foreach (range(now()->year, now()->year - 3) as $y)
                                <option value="{{ $y }}" @selected((string) request('tahun') === (string) $y)>{{ $y }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="m-divider mt-5 flex flex-col gap-3 border-t pt-4 sm:flex-row sm:items-center sm:justify-between">
                    <a href="{{ route('laporan.index') }}" class="m-btn m-btn-ghost">
                        <svg class="mi mi-sm" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99"/>
                        </svg>
                        Reset Filter
                    </a>
                    <button type="submit" name="tampilkan" value="1" class="m-btn m-btn-primary">
                        <svg class="mi mi-sm" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z"/>
                        </svg>
                        Tampilkan Laporan
                    </button>
                </div>
            </div>
        </form>
    </section>

    @if ($sudahFilter)
        {{-- RINGKASAN --}}
        <section class="space-y-4">
            <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <div class="dashboard-kicker m-sub">Ringkasan Laporan</div>
                    <h2 class="m-title mt-1 text-2xl font-bold">{{ $jenisList[$jenis] }}</h2>
                    <p class="m-sub mt-1 text-sm">Berikut adalah ringkasan data berdasarkan filter yang dipilih.</p>
                </div>
                <div class="m-muted text-xs">Diperbarui: {{ now()->translatedFormat('d F Y, H:i') }}</div>
            </div>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

                <div class="m-card m-kpi">
                    <div class="m-kpi-glow"></div>
                    <div class="relative flex items-center justify-between gap-3">
                        <span class="m-sub text-[10px] font-bold uppercase tracking-[0.18em]">Total Data</span>
                        <span class="m-icon-box h-10 w-10" style="border-radius:13px;">
                            <svg class="mi" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/>
                            </svg>
                        </span>
                    </div>
                    <div class="dashboard-display m-number relative mt-4 text-4xl">{{ $rows->count() }}</div>
                    <p class="m-muted relative mt-1 text-xs">Data pada laporan aktif</p>
                </div>

                <div class="m-card m-kpi">
                    <div class="m-kpi-glow ok"></div>
                    <div class="relative flex items-center justify-between gap-3">
                        <span class="m-sub text-[10px] font-bold uppercase tracking-[0.18em]">Total Gudang</span>
                        <span class="m-icon-box ok h-10 w-10" style="border-radius:13px;">
                            <svg class="mi" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z"/>
                            </svg>
                        </span>
                    </div>
                    <div class="dashboard-display m-number relative mt-4 text-4xl">{{ $gudangs->count() }}</div>
                    <p class="relative mt-1 text-xs" style="color:var(--m-ok-fg);">Data gudang tersedia</p>
                </div>

                <div class="m-card m-kpi">
                    <div class="m-kpi-glow accent"></div>
                    <div class="relative flex items-center justify-between gap-3">
                        <span class="m-sub text-[10px] font-bold uppercase tracking-[0.18em]">Total Mitra</span>
                        <span class="m-icon-box accent h-10 w-10" style="border-radius:13px;">
                            <svg class="mi" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/>
                            </svg>
                        </span>
                    </div>
                    <div class="dashboard-display relative mt-4 text-4xl" style="color:#F28C28;">{{ $mitras->count() }}</div>
                    <p class="relative mt-1 text-xs" style="color:var(--m-accent-fg);">Data mitra tersedia</p>
                </div>

                <div class="m-card m-kpi">
                    <div class="m-kpi-glow"></div>
                    <div class="relative flex items-center justify-between gap-3">
                        <span class="m-sub text-[10px] font-bold uppercase tracking-[0.18em]">Periode</span>
                        <span class="m-icon-box h-10 w-10" style="border-radius:13px;">
                            <svg class="mi" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/>
                            </svg>
                        </span>
                    </div>
                    <div class="dashboard-display m-number relative mt-4 text-3xl">{{ request('tahun') ?: 'Semua' }}</div>
                    <p class="m-muted relative mt-1 text-xs">{{ request('bulan') ? \Carbon\Carbon::create()->month((int) request('bulan'))->translatedFormat('F') : 'Semua bulan' }}</p>
                </div>

            </div>
        </section>

        {{-- HASIL --}}
        <section class="m-card m-card-accent">
            <div class="m-divider flex flex-col gap-4 border-b p-6 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="m-eyebrow">Hasil</p>
                    <h3 class="m-title mt-1 text-xl font-bold">Hasil Laporan</h3>
                    <p class="m-muted mt-0.5 text-xs">Data sesuai filter yang dipilih.</p>
                </div>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('laporan.export-excel', request()->query()) }}" class="m-btn m-btn-sm m-btn-ghost">
                        <svg class="mi mi-sm" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3"/>
                        </svg>
                        Export Excel
                    </a>
                    <a href="{{ route('laporan.export-pdf', request()->query()) }}" target="_blank" class="m-btn m-btn-sm m-btn-ghost">
                        <svg class="mi mi-sm" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/>
                        </svg>
                        Export PDF
                    </a>
                    <button type="button" onclick="window.print()" class="m-btn m-btn-sm m-btn-primary">
                        <svg class="mi mi-sm" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z"/>
                        </svg>
                        Print
                    </button>
                </div>
            </div>

            <div class="m-divider flex flex-wrap gap-2 border-b px-6 py-4">
                @if ($isAdminGudang && $gudangUser)
                    <span class="m-pill hl">Gudang: {{ $gudangUser->nama_gudang }}</span>
                @elseif (request('gudang_id'))
                    @php $gudangAktif = $gudangs->firstWhere('id', request('gudang_id')); @endphp
                    @if ($gudangAktif)<span class="m-pill">Gudang: {{ $gudangAktif->nama_gudang }}</span>@endif
                @else
                    <span class="m-pill">Gudang: Semua</span>
                @endif
                @if (request('mitra_pengolahan_id'))
                    @php $mitraAktif = $mitras->firstWhere('id', request('mitra_pengolahan_id')); @endphp
                    @if ($mitraAktif)<span class="m-pill">Mitra: {{ $mitraAktif->nama_mitra }}</span>@endif
                @else
                    <span class="m-pill">Mitra: Semua</span>
                @endif
                @if (request('bulan'))
                    <span class="m-pill">Bulan: {{ \Carbon\Carbon::create()->month((int) request('bulan'))->translatedFormat('F') }}</span>
                @else
                    <span class="m-pill">Bulan: Semua</span>
                @endif
                @if (request('tahun'))
                    <span class="m-pill">Tahun: {{ request('tahun') }}</span>
                @else
                    <span class="m-pill">Tahun: Semua</span>
                @endif
            </div>

            <div class="overflow-x-auto">
                <table class="m-table min-w-[760px]">
                    <thead>
                        <tr>
                            @foreach ($headings as $h)
                                <th>{{ $h }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($rows as $row)
                            <tr>
                                @foreach ($row as $cell)
                                    <td>{{ $cell }}</td>
                                @endforeach
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ count($headings) }}" class="m-empty px-5 py-16 text-center">
                                    <div class="m-icon-box mx-auto h-14 w-14">
                                        <svg class="mi mi-lg" viewBox="0 0 24 24" aria-hidden="true">
                                            <path d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/>
                                        </svg>
                                    </div>
                                    <p class="m-title mt-3 font-semibold">Tidak ada data</p>
                                    <p class="m-muted mt-1 text-sm">Tidak ditemukan data untuk filter yang dipilih.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    @endif

</div>

{{-- =========================================================
     DETEKSI DARK MODE (hanya membaca status theme dari layout;
     tidak membuat toggle baru, tidak mengubah localStorage)
========================================================== --}}
<script>
    (function () {
        var page = document.querySelector('.laporan-page');
        if (!page) return;

        var probe = null;

        // 1) Cek class / atribut pada <html> dan <body> yang menandakan dark
        function nameDark(el) {
            if (!el) return false;
            var tokens = (el.getAttribute('class') || '').split(/\s+/);
            for (var i = 0; i < tokens.length; i++) {
                if (/(^|[-_])(dark|night)([-_]|$)/i.test(tokens[i])) return true;
            }
            var attrs = el.attributes;
            for (var j = 0; j < attrs.length; j++) {
                var n = attrs[j].name.toLowerCase();
                var v = String(attrs[j].value).toLowerCase();
                if (n === 'class' || n === 'style') continue;
                if (v === 'dark' || v === 'night') return true;
                if (/dark/.test(n) && v !== 'false' && v !== '0') return true;
            }
            return false;
        }

        function parseLum(c) {
            var m = String(c).match(/rgba?\(([^)]+)\)/);
            if (!m) return null;
            var p = m[1].split(/[ ,\/]+/).filter(Boolean).map(parseFloat);
            if (p.length >= 4 && p[3] === 0) return null; // transparan
            return 0.299 * p[0] + 0.587 * p[1] + 0.114 * p[2];
        }

        // 2) Fallback: baca tampilan input global dari layout (di luar halaman ini)
        function probeDark() {
            try {
                if (!probe) {
                    probe = document.createElement('input');
                    probe.type = 'text';
                    probe.tabIndex = -1;
                    probe.setAttribute('aria-hidden', 'true');
                    probe.style.cssText = 'position:fixed;left:-9999px;top:0;width:1px;height:1px;opacity:0;pointer-events:none;';
                    document.body.appendChild(probe);
                }
                var lum = parseLum(getComputedStyle(probe).backgroundColor);
                return lum !== null && lum < 110;
            } catch (e) {
                return false;
            }
        }

        function colorSchemeDark() {
            try {
                return /dark/.test(getComputedStyle(document.documentElement).colorScheme || '');
            } catch (e) {
                return false;
            }
        }

        function apply() {
            var dark = nameDark(document.documentElement) || nameDark(document.body) || colorSchemeDark() || probeDark();
            page.setAttribute('data-m-theme', dark ? 'dark' : 'light');
        }

        apply();

        var opts = { attributes: true };
        try {
            new MutationObserver(apply).observe(document.documentElement, opts);
            new MutationObserver(apply).observe(document.body, opts);
        } catch (e) {}

        // Toggle yang mengubah theme lewat cara lain: cek ulang setelah klik / perubahan storage
        document.addEventListener('click', function () {
            setTimeout(apply, 60);
            setTimeout(apply, 350);
        }, true);
        window.addEventListener('storage', apply);
        window.addEventListener('pageshow', apply);
    })();
</script>

@endsection
