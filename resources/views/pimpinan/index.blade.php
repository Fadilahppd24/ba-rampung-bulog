@extends('layouts.app')

@section('title', 'Data Pimpinan')

@section('content')

{{-- =========================================================
     STYLE KHUSUS HALAMAN PIMPINAN (scoped di .pimpinan-page)
     - Hanya visual. Tidak menyentuh logic / backend.
     - Gaya & mekanisme dark mode SAMA dengan halaman Mitra.
========================================================== --}}
<style>
    .pimpinan-page {
        --m-card: rgba(255, 255, 255, .96);
        --m-section: #F5F7FA;
        --m-border: #D9E2EC;
        --m-border-soft: #E8EEF5;
        --m-text: #0F2A4A;
        --m-text-2: #5B6F89;
        --m-muted: #94A3B8;
        --m-head-bg: #F5F7FA;
        --m-hover: rgba(18, 63, 122, .045);
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
        --m-act-view-bg: #EAF2FC;
        --m-act-view-fg: #123F7A;
        --m-act-edit-bg: #FFF3E3;
        --m-act-edit-fg: #D97706;
        --m-shadow: 0 10px 30px rgba(15, 42, 74, .08);
        --m-number: #123F7A;
        color: var(--m-text);
    }

    /* ---------- DARK MODE (dideteksi oleh script di bawah) ---------- */
    .pimpinan-page[data-m-theme="dark"] {
        --m-card: rgba(16, 28, 45, .94);
        --m-section: #132238;
        --m-border: #263B55;
        --m-border-soft: #1E3149;
        --m-text: #F8FAFC;
        --m-text-2: #94A3B8;
        --m-muted: #7C8DA4;
        --m-head-bg: #18263A;
        --m-hover: rgba(96, 150, 220, .10);
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
        --m-act-view-bg: rgba(96, 165, 250, .14);
        --m-act-view-fg: #93C5FD;
        --m-act-edit-bg: rgba(242, 140, 40, .14);
        --m-act-edit-fg: #F6A94F;
        --m-shadow: 0 14px 40px rgba(0, 8, 20, .45);
        --m-number: #F8FAFC;
        color-scheme: dark;
    }

    /* ---------- CARD ---------- */
    .pimpinan-page .m-card {
        position: relative;
        background: var(--m-card);
        border: 1px solid var(--m-border);
        border-radius: 24px;
        box-shadow: var(--m-shadow);
        backdrop-filter: blur(6px);
        -webkit-backdrop-filter: blur(6px);
        overflow: hidden;
    }
    .pimpinan-page .m-card-accent::before {
        content: "";
        position: absolute;
        left: 0; right: 0; top: 0;
        height: 3px;
        background: linear-gradient(90deg, #F28C28 0%, rgba(242, 140, 40, 0) 70%);
    }
    .pimpinan-page .m-divider { border-color: var(--m-border-soft); }

    /* ---------- TEKS ---------- */
    .pimpinan-page .m-eyebrow {
        font-size: 10px; font-weight: 700; letter-spacing: .25em; text-transform: uppercase;
        color: #F28C28;
    }
    .pimpinan-page .m-title { color: var(--m-text); }
    .pimpinan-page .m-sub { color: var(--m-text-2); }
    .pimpinan-page .m-muted { color: var(--m-muted); }
    .pimpinan-page .m-number { color: var(--m-number); }
    .pimpinan-page .m-number-accent { color: #F28C28; }
    .pimpinan-page .m-number-ok { color: var(--m-ok-fg); }

    /* ---------- ICON ---------- */
    .pimpinan-page .mi { width: 1.25rem; height: 1.25rem; flex-shrink: 0; fill: none; stroke: currentColor; stroke-width: 1.8; stroke-linecap: round; stroke-linejoin: round; }
    .pimpinan-page .mi-sm { width: 1rem; height: 1rem; }
    .pimpinan-page .mi-lg { width: 1.5rem; height: 1.5rem; }
    .pimpinan-page .m-icon-box {
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        border-radius: 16px;
        background: var(--m-chip-bg); color: var(--m-chip-fg);
    }
    .pimpinan-page .m-icon-box.accent { background: var(--m-accent-bg); color: var(--m-accent-fg); }
    .pimpinan-page .m-icon-box.ok { background: var(--m-ok-bg); color: var(--m-ok-fg); }
    .pimpinan-page .m-icon-box.off { background: var(--m-off-bg); color: var(--m-off-fg); }

    /* ---------- TOMBOL ---------- */
    .pimpinan-page .m-btn {
        display: inline-flex; align-items: center; justify-content: center; gap: 8px;
        border-radius: 14px; padding: 10px 20px;
        font-size: 14px; font-weight: 700; line-height: 1.2;
        transition: transform .18s ease, background-color .18s ease, box-shadow .18s ease, border-color .18s ease;
        cursor: pointer; text-decoration: none;
    }
    .pimpinan-page .m-btn-accent { background: #F28C28; color: #fff; box-shadow: 0 8px 20px rgba(242, 140, 40, .32); border: 1px solid transparent; border-radius: 999px; padding: 12px 24px; }
    .pimpinan-page .m-btn-accent:hover { background: #DE7A18; transform: translateY(-2px); }
    .pimpinan-page .m-btn-ghost { background: var(--m-btn-ghost-bg); color: var(--m-chip-fg); border: 1px solid var(--m-border); }
    .pimpinan-page .m-btn-ghost:hover { background: var(--m-btn-ghost-hover); border-color: #F28C28; }

    .pimpinan-page .m-link {
        display: inline-flex; align-items: center; gap: 6px; white-space: nowrap;
        font-size: 13px; font-weight: 700; text-decoration: none;
        color: var(--m-chip-fg);
        border-radius: 999px; padding: 7px 12px;
        background: var(--m-chip-bg);
        transition: background-color .18s ease, color .18s ease;
    }
    .pimpinan-page .m-link:hover { background: var(--m-accent-bg); color: var(--m-accent-fg); }

    /* ---------- KPI ---------- */
    .pimpinan-page .m-kpi { padding: 22px 24px; transition: transform .2s ease, border-color .2s ease; }
    .pimpinan-page .m-kpi:hover { transform: translateY(-3px); border-color: rgba(242, 140, 40, .55); }
    .pimpinan-page .m-kpi-glow {
        position: absolute; right: -34px; top: -34px; width: 120px; height: 120px; border-radius: 999px;
        background: var(--m-chip-bg); opacity: .65; pointer-events: none;
    }
    .pimpinan-page .m-kpi-glow.accent { background: var(--m-accent-bg); }
    .pimpinan-page .m-kpi-glow.ok { background: var(--m-ok-bg); }
    .pimpinan-page .m-kpi-glow.off { background: var(--m-off-bg); }

    /* ---------- PROFIL ---------- */
    .pimpinan-page .m-avatar {
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        width: 68px; height: 68px; border-radius: 22px;
        background: var(--m-chip-bg); color: var(--m-chip-fg);
        border: 1px solid var(--m-border);
        font-size: 30px; line-height: 1;
    }
    .pimpinan-page .m-info-label {
        font-size: 10px; font-weight: 700; letter-spacing: .14em; text-transform: uppercase;
        color: var(--m-muted);
    }
    .pimpinan-page .m-info-value {
        margin-top: 4px; font-size: 14px; line-height: 1.55; word-break: break-word;
        color: var(--m-text);
    }
    .pimpinan-page .m-empty-box {
        border-radius: 18px; padding: 48px 20px; text-align: center; font-size: 14px;
        background: var(--m-section); color: var(--m-text-2);
        border: 1px dashed var(--m-border);
    }

    /* ---------- TABEL ---------- */
    .pimpinan-page .m-table { width: 100%; font-size: 14px; border-collapse: collapse; }
    .pimpinan-page .m-table thead tr { background: var(--m-head-bg); border-bottom: 1px solid var(--m-border); }
    .pimpinan-page .m-table th {
        padding: 16px 24px; text-align: left; white-space: nowrap;
        font-size: 10px; font-weight: 700; letter-spacing: .14em; text-transform: uppercase;
        color: var(--m-text-2);
    }
    .pimpinan-page .m-table th.right { text-align: right; }
    .pimpinan-page .m-table tbody tr { border-bottom: 1px solid var(--m-border-soft); transition: background-color .15s ease; }
    .pimpinan-page .m-table tbody tr:last-child { border-bottom: 0; }
    .pimpinan-page .m-table tbody tr:hover { background: var(--m-hover); }
    .pimpinan-page .m-table td { padding: 16px 24px; vertical-align: middle; color: var(--m-text-2); }
    .pimpinan-page .m-table td.strong { color: var(--m-text); font-weight: 600; }

    .pimpinan-page .m-num {
        display: inline-flex; align-items: center; justify-content: center;
        width: 30px; height: 30px; border-radius: 10px;
        background: var(--m-chip-bg); color: var(--m-chip-fg);
        font-size: 12px; font-weight: 700;
    }

    /* ---------- BADGE STATUS ---------- */
    .pimpinan-page .m-badge {
        display: inline-flex; align-items: center; gap: 8px;
        border-radius: 999px; padding: 5px 12px;
        font-size: 12px; font-weight: 600;
    }
    .pimpinan-page .m-badge .dot { width: 7px; height: 7px; border-radius: 999px; background: currentColor; }
    .pimpinan-page .m-badge.on { background: var(--m-ok-bg); color: var(--m-ok-fg); }
    .pimpinan-page .m-badge.off { background: var(--m-off-bg); color: var(--m-off-fg); }

    /* ---------- TOMBOL AKSI ---------- */
    .pimpinan-page .m-act {
        display: inline-flex; align-items: center; justify-content: center;
        width: 36px; height: 36px; border-radius: 12px; border: 0; cursor: pointer;
        transition: transform .15s ease, filter .15s ease;
    }
    .pimpinan-page .m-act:hover { transform: translateY(-1px); filter: brightness(.96); }
    .pimpinan-page[data-m-theme="dark"] .m-act:hover { filter: brightness(1.25); }
    .pimpinan-page .m-act.view { background: var(--m-act-view-bg); color: var(--m-act-view-fg); }
    .pimpinan-page .m-act.edit { background: var(--m-act-edit-bg); color: var(--m-act-edit-fg); }

    /* ---------- PAGINATION (override tampilan bawaan Laravel) ---------- */
    .pimpinan-page .m-pagination nav { color: var(--m-text-2); }
    .pimpinan-page .m-pagination p,
    .pimpinan-page .m-pagination span,
    .pimpinan-page .m-pagination .text-gray-700,
    .pimpinan-page .m-pagination .text-gray-500 { color: var(--m-text-2) !important; }
    .pimpinan-page .m-pagination a,
    .pimpinan-page .m-pagination span[aria-current="page"] > span,
    .pimpinan-page .m-pagination span[aria-disabled="true"] > span,
    .pimpinan-page .m-pagination button {
        background-color: var(--m-btn-ghost-bg) !important;
        border-color: var(--m-border) !important;
        color: var(--m-text-2) !important;
    }
    .pimpinan-page .m-pagination a:hover { background-color: var(--m-btn-ghost-hover) !important; color: var(--m-text) !important; }
    .pimpinan-page .m-pagination span[aria-current="page"] > span {
        background-color: #123F7A !important; border-color: #123F7A !important; color: #fff !important;
    }
    .pimpinan-page .m-pagination .shadow-sm { box-shadow: none !important; }
    .pimpinan-page .m-pagination svg { color: currentColor; }

    @media (max-width: 640px) {
        .pimpinan-page .m-table th, .pimpinan-page .m-table td { padding: 14px 16px; }
    }
</style>

<div class="pimpinan-page space-y-6 pb-12">

    {{-- =========================================================
         HERO
    ========================================================== --}}
    <section
        class="relative overflow-hidden rounded-[30px] border border-white/20"
        style="
            min-height: 210px;
            background:
                linear-gradient(
                    90deg,
                    rgba(7, 48, 91, .90) 0%,
                    rgba(15, 61, 110, .74) 52%,
                    rgba(15, 61, 110, .40) 100%
                );
            box-shadow: 0 18px 50px rgba(15, 61, 110, .18);
            backdrop-filter: blur(3px);
        "
    >

        {{-- efek kabut / glass --}}
        <div
            class="pointer-events-none absolute inset-0"
            style="
                background:
                    radial-gradient(circle at 15% 40%, rgba(255,255,255,.12), transparent 34%),
                    radial-gradient(circle at 85% 20%, rgba(255,255,255,.07), transparent 30%),
                    linear-gradient(180deg, rgba(255,255,255,.05), rgba(0,25,55,.18));
            "
        ></div>

        {{-- aksen orange --}}
        <div
            class="pointer-events-none absolute left-0 right-0 top-0"
            style="height:3px; background:linear-gradient(90deg,#F28C28 0%, rgba(242,140,40,0) 65%);"
        ></div>

        {{-- cahaya lembut --}}
        <div
            class="pointer-events-none absolute -right-20 -top-24 h-72 w-72 rounded-full"
            style="background:rgba(255,255,255,.06); filter:blur(45px);"
        ></div>

        <div class="relative z-10 flex min-h-[210px] flex-col justify-center gap-6 px-8 py-8 sm:flex-row sm:items-center sm:justify-between sm:gap-8 sm:px-10 lg:px-11">

            {{-- kiri --}}
            <div class="min-w-0">

                <p class="mb-2 text-[10px] font-bold uppercase tracking-[0.30em] text-white/75">
                    MASTER DATA
                </p>

                <h1 class="dashboard-display text-5xl leading-none text-white sm:text-6xl">
                    Data
                    <span class="text-[#F28C28]">
                        Pimpinan
                    </span>
                </h1>

                <p class="mt-4 max-w-2xl text-sm leading-6 text-white/85 sm:text-base">
                    Kelola data pimpinan cabang dan riwayat kepemimpinan
                    dengan lebih mudah dan terstruktur.
                </p>

            </div>

            {{-- kanan --}}
            @if(auth()->check() && auth()->user()->role === 'admin_kantor')
                <div class="flex shrink-0 flex-col items-start gap-3 sm:items-end">

                    <a
                        href="{{ route('pimpinan.create') }}"
                        class="m-btn m-btn-accent"
                    >
                        <svg class="mi mi-sm" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M12 4.5v15m7.5-7.5h-15"/>
                        </svg>
                        Tambah Pimpinan
                    </a>

                </div>
            @endif

        </div>

    </section>


    {{-- =========================================================
         KPI
    ========================================================== --}}
    <section class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

        {{-- TOTAL RIWAYAT --}}
        <div class="m-card m-kpi">

            <div class="m-kpi-glow"></div>

            <div class="relative flex items-center justify-between gap-4">

                <div>
                    <p class="text-[10px] font-bold uppercase tracking-[0.18em] m-sub">
                        Total Riwayat
                    </p>

                    <p class="dashboard-display m-number mt-2 text-4xl">
                        {{ number_format($riwayat->total()) }}
                    </p>

                    <p class="m-muted mt-1 text-xs">
                        Seluruh riwayat pimpinan
                    </p>
                </div>

                <div class="m-icon-box h-14 w-14">
                    <svg class="mi mi-lg" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/>
                    </svg>
                </div>

            </div>

        </div>


        {{-- PIMPINAN AKTIF --}}
        <div class="m-card m-kpi">

            <div class="m-kpi-glow ok"></div>

            <div class="relative flex items-center justify-between gap-4">

                <div>
                    <p class="text-[10px] font-bold uppercase tracking-[0.18em] m-sub">
                        Pimpinan Aktif
                    </p>

                    <p class="dashboard-display m-number-ok mt-2 text-4xl">
                        {{ $pimpinanAktif ? 1 : 0 }}
                    </p>

                    <p class="m-muted mt-1 text-xs">
                        Pimpinan yang sedang menjabat
                    </p>
                </div>

                <div class="m-icon-box ok h-14 w-14">
                    <svg class="mi mi-lg" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                </div>

            </div>

        </div>


        {{-- RIWAYAT SELESAI --}}
        <div class="m-card m-kpi">

            <div class="m-kpi-glow off"></div>

            <div class="relative flex items-center justify-between gap-4">

                <div>
                    <p class="text-[10px] font-bold uppercase tracking-[0.18em] m-sub">
                        Riwayat Selesai
                    </p>

                    <p class="dashboard-display m-number mt-2 text-4xl">
                        {{ number_format(max($riwayat->total() - ($pimpinanAktif ? 1 : 0), 0)) }}
                    </p>

                    <p class="m-muted mt-1 text-xs">
                        Periode kepemimpinan selesai
                    </p>
                </div>

                <div class="m-icon-box off h-14 w-14">
                    <svg class="mi mi-lg" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                </div>

            </div>

        </div>


        {{-- PERIODE AKTIF --}}
        <div class="m-card m-kpi">

            <div class="m-kpi-glow accent"></div>

            <div class="relative flex items-center justify-between gap-4">

                <div>
                    <p class="text-[10px] font-bold uppercase tracking-[0.18em] m-sub">
                        Periode Aktif
                    </p>

                    <p class="dashboard-display m-number-accent mt-2 text-4xl">
                        {{ $pimpinanAktif?->periode_mulai?->format('Y') ?? '—' }}
                    </p>

                    <p class="m-muted mt-1 text-xs">
                        Tahun mulai menjabat
                    </p>
                </div>

                <div class="m-icon-box accent h-14 w-14">
                    <svg class="mi mi-lg" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/>
                    </svg>
                </div>

            </div>

        </div>

    </section>


    {{-- =========================================================
         PROFILE + HISTORY
    ========================================================== --}}
    <div class="grid grid-cols-1 gap-5 xl:grid-cols-[360px_minmax(0,1fr)]">


        {{-- =====================================================
             PIMPINAN AKTIF
        ====================================================== --}}
        <section class="m-card m-card-accent self-start">

            <div class="m-divider border-b px-6 py-5">

                <div class="flex items-center justify-between gap-3">

                    <div>

                        <p class="m-eyebrow">
                            Pimpinan Aktif
                        </p>

                        <h2 class="m-title mt-1 text-xl font-bold">
                            Informasi Pimpinan Cabang
                        </h2>

                    </div>

                    @if(auth()->check() && auth()->user()->role === 'admin_kantor')

                        <a
                            href="{{ route('pimpinan.create') }}"
                            class="m-link"
                        >
                            <svg class="mi mi-sm" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M12 4.5v15m7.5-7.5h-15"/>
                            </svg>
                            Riwayat
                        </a>

                    @endif

                </div>

            </div>


            @if($pimpinanAktif)

                <div class="p-6">

                    {{-- PROFILE HEADER --}}
                    <div class="m-divider flex items-center gap-4 border-b pb-5">

                        <div class="m-avatar dashboard-display">
                            {{ strtoupper(substr($pimpinanAktif->nama, 0, 1)) }}
                        </div>

                        <div class="min-w-0">

                            <div class="m-title truncate text-lg font-bold">
                                {{ $pimpinanAktif->nama }}
                            </div>

                            <div class="m-sub mt-1 text-xs">
                                {{ $pimpinanAktif->jabatan }}
                            </div>

                            <span class="m-badge on mt-2.5">
                                <span class="dot"></span>
                                Aktif
                            </span>

                        </div>

                    </div>


                    {{-- INFORMATION --}}
                    <div class="mt-5 grid gap-5">

                        <div>
                            <div class="m-info-label">
                                Email
                            </div>

                            <div class="m-info-value">
                                {{ $pimpinanAktif->email ?? '-' }}
                            </div>
                        </div>


                        <div>
                            <div class="m-info-label">
                                Telepon
                            </div>

                            <div class="m-info-value">
                                {{ $pimpinanAktif->nomor_telepon ?? '-' }}
                            </div>
                        </div>


                        <div>
                            <div class="m-info-label">
                                Alamat Kantor
                            </div>

                            <div class="m-info-value">
                                {{ $pimpinanAktif->alamat ?? '-' }}
                            </div>
                        </div>


                        <div>
                            <div class="m-info-label">
                                Menjabat Sejak
                            </div>

                            <div class="m-info-value">
                                {{ $pimpinanAktif->periode_mulai?->format('d/m/Y') ?? '-' }}
                            </div>
                        </div>

                    </div>


                    {{-- EDIT --}}
                    @if(auth()->check() && auth()->user()->role === 'admin_kantor')

                        <a
                            href="{{ route('pimpinan.edit', $pimpinanAktif) }}"
                            class="m-btn m-btn-ghost mt-6 w-full"
                        >
                            <svg class="mi mi-sm" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10"/>
                            </svg>
                            Edit Profil
                        </a>

                    @endif

                </div>

            @else

                <div class="p-6">

                    <div class="m-empty-box">

                        <div class="m-icon-box mx-auto mb-3 h-14 w-14">
                            <svg class="mi mi-lg" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>
                            </svg>
                        </div>

                        Belum ada Pimpinan Cabang aktif.

                    </div>

                </div>

            @endif

        </section>


        {{-- =====================================================
             RIWAYAT PIMPINAN
        ====================================================== --}}
        <section class="m-card m-card-accent">

            <div class="m-divider border-b px-6 py-5">

                <div class="flex items-center gap-4">

                    <div class="m-icon-box h-11 w-11">
                        <svg class="mi" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>
                        </svg>
                    </div>

                    <div>

                        <p class="m-eyebrow">
                            Master Data
                        </p>

                        <h2 class="m-title mt-1 text-xl font-bold">
                            Riwayat Pimpinan
                        </h2>

                        <p class="m-muted mt-0.5 text-xs">
                            Menampilkan seluruh riwayat pimpinan cabang.
                        </p>

                    </div>

                </div>

            </div>


            <div class="overflow-x-auto">

                <table class="m-table min-w-[700px]">

                    <thead>

                        <tr>

                            <th style="width:70px;">No.</th>
                            <th>Nama</th>
                            <th>Periode</th>
                            <th>Status</th>
                            <th class="right">Aksi</th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($riwayat as $i => $p)

                            <tr>

                                {{-- NO --}}
                                <td>
                                    <span class="m-num">
                                        {{ $riwayat->firstItem() + $i }}
                                    </span>
                                </td>


                                {{-- NAMA --}}
                                <td class="strong">
                                    {{ $p->nama }}
                                </td>


                                {{-- PERIODE --}}
                                <td class="whitespace-nowrap">

                                    {{ $p->periode_mulai?->format('Y') ?? '-' }}

                                    <span class="m-muted mx-1">
                                        –
                                    </span>

                                    {{ $p->periode_selesai?->format('Y') ?? 'Sekarang' }}

                                </td>


                                {{-- STATUS --}}
                                <td>

                                    <span class="m-badge {{ $p->status === 'aktif' ? 'on' : 'off' }}">
                                        <span class="dot"></span>
                                        {{ ucfirst($p->status) }}
                                    </span>

                                </td>


                                {{-- AKSI --}}
                                <td>

                                    <div class="flex justify-end gap-2">

                                        <a
                                            href="{{ route('pimpinan.show', $p) }}"
                                            title="Lihat"
                                            class="m-act view"
                                        >
                                            <svg class="mi mi-sm" viewBox="0 0 24 24" aria-hidden="true">
                                                <path d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/>
                                                <path d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                            </svg>
                                        </a>


                                        @if(auth()->check() && auth()->user()->role === 'admin_kantor')

                                            <a
                                                href="{{ route('pimpinan.edit', $p) }}"
                                                title="Edit"
                                                class="m-act edit"
                                            >
                                                <svg class="mi mi-sm" viewBox="0 0 24 24" aria-hidden="true">
                                                    <path d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10"/>
                                                </svg>
                                            </a>

                                        @endif

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="5"
                                    class="px-6 py-16 text-center"
                                >

                                    <div class="flex flex-col items-center">

                                        <div class="m-icon-box mb-4 h-16 w-16">
                                            <svg class="mi mi-lg" viewBox="0 0 24 24" aria-hidden="true">
                                                <path d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>
                                            </svg>
                                        </div>

                                        <p class="m-title font-semibold">
                                            Belum ada riwayat Pimpinan Cabang.
                                        </p>

                                    </div>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- PAGINATION --}}
            @if($riwayat->hasPages())

                <div class="m-divider m-pagination border-t px-6 py-5">

                    {{ $riwayat->links() }}

                </div>

            @endif

        </section>

    </div>

</div>

{{-- =========================================================
     DETEKSI DARK MODE (hanya membaca status theme dari layout;
     tidak membuat toggle baru, tidak mengubah localStorage)
========================================================== --}}
<script>
    (function () {
        var page = document.querySelector('.pimpinan-page');
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
