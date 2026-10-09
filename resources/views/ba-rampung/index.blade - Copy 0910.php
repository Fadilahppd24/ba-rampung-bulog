@extends('layouts.app')

@section('title', 'Daftar BA Rampung')

@section('content')

<style>
    .ba-rampung-page {
        --ba-navy: #123F7A;
        --ba-dark: #0B2545;
        --ba-orange: #F28C28;
    }

    /* ================================
       HERO TRANSPARENT
    ================================= */
    .ba-rampung-page .ba-hero {
        position: relative;
        overflow: hidden;
        min-height: 275px;
        border-radius: 2rem;
        border: 1px solid rgba(255,255,255,.25);
        background:
            linear-gradient(
                90deg,
                rgba(11, 37, 69, .88),
                rgba(18, 63, 122, .68),
                rgba(18, 63, 122, .35)
            );
        box-shadow: 0 18px 45px rgba(11,37,69,.16);
        backdrop-filter: blur(4px);
        -webkit-backdrop-filter: blur(4px);
    }

    .ba-rampung-page .ba-hero::before {
        content: "";
        position: absolute;
        width: 260px;
        height: 260px;
        right: -80px;
        top: -120px;
        border-radius: 999px;
        background: rgba(255,255,255,.08);
        border: 1px solid rgba(255,255,255,.08);
    }

    .ba-rampung-page .ba-hero::after {
        content: "";
        position: absolute;
        width: 180px;
        height: 180px;
        right: 120px;
        bottom: -110px;
        border-radius: 999px;
        background: rgba(242,140,40,.08);
    }

    .ba-rampung-page .ba-hero-content {
        position: relative;
        z-index: 5;
        min-height: 275px;
        display: flex;
        align-items: center;
        padding: 2.25rem 3rem;
    }

    .ba-rampung-page .ba-hero-title {
        font-size: clamp(3rem, 5vw, 4.7rem);
        line-height: .95;
        font-weight: 400;
        letter-spacing: -.035em;
        color: white;
    }

    .ba-rampung-page .ba-hero-title .orange {
        color: #F28C28;
    }

    .ba-rampung-page .ba-hero-desc {
        margin-top: 1.2rem;
        max-width: 760px;
        color: rgba(255,255,255,.88);
        font-size: .95rem;
        line-height: 1.7;
    }

    .ba-rampung-page .ba-hero-button {
        position: absolute;
        right: 2rem;
        bottom: 2rem;
        z-index: 10;
    }

    .ba-rampung-page .ba-hero-button a {
        display: inline-flex;
        align-items: center;
        gap: .55rem;
        padding: .85rem 1.35rem;
        border-radius: 1rem;
        background: #F28C28;
        color: white;
        font-size: .875rem;
        font-weight: 700;
        box-shadow: 0 10px 25px rgba(0,0,0,.16);
        transition: all .2s ease;
    }

    .ba-rampung-page .ba-hero-button a:hover {
        transform: translateY(-2px);
        background: #df7918;
        box-shadow: 0 14px 30px rgba(0,0,0,.2);
    }

    /* ================================
       INFO CARD
    ================================= */
    .ba-rampung-page .ba-info-card {
        border: 1px solid rgba(255,255,255,.7);
        background: rgba(255,255,255,.91);
        border-radius: 1.5rem;
        box-shadow: 0 12px 35px rgba(15,23,42,.08);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
    }

    /* ================================
       FILTER
    ================================= */
    .ba-rampung-page .ba-filter-card {
        overflow: hidden;
        border: 1px solid rgba(255,255,255,.75);
        border-radius: 1.5rem;
        background: rgba(255,255,255,.94);
        box-shadow: 0 12px 35px rgba(15,23,42,.08);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
    }

    .ba-rampung-page .ba-filter-head {
        border-bottom: 1px solid #edf1f6;
        background: rgba(245,248,253,.82);
    }

    .ba-rampung-page .ba-filter-input {
        width: 100%;
        border: 1px solid #dbe3ef;
        border-radius: .85rem;
        background: rgba(255,255,255,.92);
        padding: .7rem .9rem;
        font-size: .875rem;
        color: #334155;
        outline: none;
        transition: .2s ease;
    }

    .ba-rampung-page .ba-filter-input:focus {
        border-color: var(--ba-navy);
        box-shadow: 0 0 0 3px rgba(18,63,122,.10);
    }

    .ba-rampung-page .ba-label {
        display: block;
        margin-bottom: .45rem;
        font-size: .72rem;
        font-weight: 700;
        letter-spacing: .08em;
        text-transform: uppercase;
        color: #64748b;
    }

    /* ================================
       RESULT CARD
    ================================= */
    .ba-rampung-page .ba-result-card {
        overflow: hidden;
        border: 1px solid rgba(255,255,255,.8);
        border-radius: 1.5rem;
        background: rgba(255,255,255,.95);
        box-shadow: 0 12px 35px rgba(15,23,42,.08);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
    }

    /* ================================
       TABLE
    ================================= */
    .ba-rampung-page .ba-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .ba-rampung-page .ba-table th {
        white-space: nowrap;
        background: #f5f8fd;
        color: #475569;
        font-size: .7rem;
        font-weight: 800;
        letter-spacing: .07em;
        text-transform: uppercase;
    }

    .ba-rampung-page .ba-table td {
        border-top: 1px solid #edf1f6;
        vertical-align: middle;
    }

    .ba-rampung-page .ba-table tbody tr {
        transition: background .15s ease;
    }

    .ba-rampung-page .ba-table tbody tr:hover {
        background: #f8fbff;
    }

    /* ================================
       RESPONSIVE
    ================================= */
    @media (max-width: 1024px) {
        .ba-rampung-page .ba-hero-content {
            padding: 2rem 2rem;
        }

        .ba-rampung-page .ba-hero-button {
            right: 1.5rem;
            bottom: 1.5rem;
        }
    }

    @media (max-width: 640px) {
        .ba-rampung-page .ba-hero {
            min-height: 330px;
            border-radius: 1.5rem;
        }

        .ba-rampung-page .ba-hero-content {
            min-height: 330px;
            padding: 2rem 1.5rem 6rem;
            align-items: flex-start;
        }

        .ba-rampung-page .ba-hero-title {
            font-size: 3rem;
        }

        .ba-rampung-page .ba-hero-button {
            left: 1.5rem;
            right: auto;
            bottom: 1.5rem;
        }
    }


    /* =========================================================
       LIGHT MODE — PENYEMPURNAAN
       Off-white lembut, navy BULOG, aksen oranye secukupnya
       ========================================================= */
    .ba-rampung-page .ba-info-card,
    .ba-rampung-page .ba-filter-card,
    .ba-rampung-page .ba-result-card {
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(15,43,82,.07);
        box-shadow: 0 12px 35px rgba(15,23,42,.09);
        transition: background-color .2s ease, border-color .2s ease, box-shadow .2s ease;
    }

    .ba-rampung-page .ba-info-card   { background: rgba(250,251,253,.94); }
    .ba-rampung-page .ba-filter-card { background: rgba(250,251,253,.95); }
    .ba-rampung-page .ba-result-card { background: rgba(250,251,253,.96); }

    /* garis atas card: segmen oranye + navy */
    .ba-rampung-page .ba-info-card::before,
    .ba-rampung-page .ba-filter-card::before,
    .ba-rampung-page .ba-result-card::before {
        content: "";
        position: absolute;
        left: 0;
        right: 0;
        top: 0;
        height: 3px;
        z-index: 2;
        pointer-events: none;
        background: linear-gradient(90deg, #F28C28 0, #F28C28 84px, #123F7A 84px, rgba(18,63,122,.85) 100%);
    }

    /* garis kecil oranye pada label kicker di dalam card */
    .ba-rampung-page .ba-info-card .dashboard-kicker::before,
    .ba-rampung-page .ba-filter-card .dashboard-kicker::before,
    .ba-rampung-page .ba-result-card .dashboard-kicker::before {
        content: "";
        display: inline-block;
        width: 18px;
        height: 2px;
        margin-right: .6rem;
        vertical-align: middle;
        border-radius: 2px;
        background: #F28C28;
    }

    .ba-rampung-page .ba-filter-head {
        border-bottom-color: rgba(15,43,82,.07);
        background: rgba(241,245,250,.9);
    }

    .ba-rampung-page .ba-filter-input {
        background: #FDFEFF;
        border-color: #D9E1EC;
    }

    .ba-rampung-page .ba-filter-input:focus {
        border-color: #F28C28;
        box-shadow: 0 0 0 3px rgba(242,140,40,.18);
    }

    .ba-rampung-page .ba-count-badge {
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        background: #F1F5FA;
        border: 1px solid rgba(15,43,82,.08);
    }

    .ba-rampung-page .ba-count-badge::before {
        content: "";
        width: 7px;
        height: 7px;
        border-radius: 999px;
        background: #F28C28;
    }

    .ba-rampung-page .ba-table tbody {
        background: transparent;
    }

    .ba-rampung-page .ba-table th {
        background: #F1F5FA;
        border-bottom: 2px solid rgba(242,140,40,.30);
    }

    .ba-rampung-page .ba-table td {
        border-top-color: #E9EEF5;
    }

    .ba-rampung-page .ba-table tbody tr:hover {
        background: #F5F8FC;
    }

    .ba-rampung-page .ba-table tbody tr:hover td:first-child {
        box-shadow: inset 3px 0 0 #F28C28;
    }


    /* =========================================================
       DARK MODE
       Aktif jika .ba-rampung-page diberi class "is-dark" oleh
       script di bagian bawah file (mendeteksi mode gelap layout),
       atau jika penanda tema gelap umum ada di <html>/<body>.
       Semua aturan terkunci di dalam .ba-rampung-page, sehingga
       mode terang tidak terpengaruh.
       ========================================================= */

    /* ---------------------------------------------------------
       BACKGROUND IMAGE TETAP ADA.
       Mode gelap hanya menambah overlay navy transparan di atas
       gambar (pseudo-element terpisah). Tidak ada background-image
       atau background solid yang ditimpa.
       Atur kekuatan gelap lewat dua variabel di bawah.
       --------------------------------------------------------- */
    .ba-rampung-page {
        --ba-overlay-top: rgba(7, 20, 38, .62);
        --ba-overlay-bottom: rgba(7, 20, 38, .50);
        position: relative;
    }

    .ba-rampung-page::before {
        content: "";
        position: fixed;
        inset: 0;
        z-index: 0;
        pointer-events: none;
        background: linear-gradient(180deg, var(--ba-overlay-top), var(--ba-overlay-bottom));
        opacity: 0;                      /* mode terang: overlay tidak terlihat */
        transition: opacity .3s ease;
    }

    .ba-rampung-page > * {
        position: relative;
        z-index: 1;                      /* konten selalu di atas overlay */
    }

    :is(.ba-rampung-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-rampung-page)::before {
        opacity: 1;                      /* mode gelap: overlay aktif */
    }

    :is(.ba-rampung-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-rampung-page) {
        color: #E5E7EB;
        color-scheme: dark;
    }

    /* ---- Hero ---- */
    :is(.ba-rampung-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-rampung-page) .ba-hero {
        border-color: rgba(148,163,184,.18);
        background: linear-gradient(90deg, rgba(8,24,46,.80), rgba(14,48,96,.52), rgba(18,63,122,.18));
        box-shadow: 0 18px 45px rgba(0,0,0,.35);
    }

    /* ---- Card utama ---- */
    :is(.ba-rampung-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-rampung-page) .ba-info-card,
    :is(.ba-rampung-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-rampung-page) .ba-filter-card,
    :is(.ba-rampung-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-rampung-page) .ba-result-card {
        background: rgba(16,28,45,.95) !important;
        border-color: #263B55 !important;
        box-shadow: 0 14px 36px rgba(0,0,0,.30) !important;
    }

    :is(.ba-rampung-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-rampung-page) .ba-info-card::before,
    :is(.ba-rampung-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-rampung-page) .ba-filter-card::before,
    :is(.ba-rampung-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-rampung-page) .ba-result-card::before {
        background: linear-gradient(90deg, #F28C28 0, #F28C28 84px, rgba(96,165,250,.55) 84px, rgba(96,165,250,.10) 100%);
    }

    :is(.ba-rampung-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-rampung-page) .ba-filter-head {
        background: rgba(19,34,56,.96) !important;
        border-bottom-color: #263B55 !important;
    }

    /* ---- Form ---- */
    :is(.ba-rampung-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-rampung-page) .ba-label {
        color: #94A3B8;
    }

    :is(.ba-rampung-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-rampung-page) .ba-filter-input {
        background-color: #0B1728 !important;
        border-color: #263B55 !important;
        color: #F8FAFC !important;
    }

    :is(.ba-rampung-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-rampung-page) .ba-filter-input:focus {
        border-color: #F28C28 !important;
        box-shadow: 0 0 0 3px rgba(242,140,40,.22) !important;
    }

    :is(.ba-rampung-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-rampung-page) .ba-filter-input::placeholder {
        color: #94A3B8 !important;
        opacity: 1;
    }

    :is(.ba-rampung-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-rampung-page) .ba-filter-input option {
        background: #101C2D;
        color: #E5E7EB;
    }

    /* ---- Tabel ---- */
    :is(.ba-rampung-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-rampung-page) .ba-table th {
        background: rgba(19,34,56,.96) !important;
        color: #94A3B8 !important;
        border-bottom: 2px solid rgba(242,140,40,.35) !important;
    }

    :is(.ba-rampung-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-rampung-page) .ba-table tbody,
    :is(.ba-rampung-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-rampung-page) .ba-table tbody.bg-white {
        background: transparent !important;
    }

    :is(.ba-rampung-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-rampung-page) .ba-table tbody tr {
        background: transparent !important;
    }

    :is(.ba-rampung-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-rampung-page) .ba-table td {
        border-top-color: rgba(148,163,184,.12) !important;
    }

    :is(.ba-rampung-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-rampung-page) .ba-table tbody tr:hover {
        background: rgba(255,255,255,.04) !important;
    }

    :is(.ba-rampung-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-rampung-page) .ba-table tbody tr:hover td:first-child {
        box-shadow: inset 3px 0 0 #F28C28;
    }

    /* ---- Teks ---- */
    :is(.ba-rampung-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-rampung-page) .text-\[\#0B2545\] {
        color: #F8FAFC !important;
    }

    :is(.ba-rampung-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-rampung-page) .text-\[\#123F7A\] {
        color: #93C5FD !important;
    }

    :is(.ba-rampung-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-rampung-page) .text-slate-400,
    :is(.ba-rampung-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-rampung-page) .text-slate-500,
    :is(.ba-rampung-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-rampung-page) .text-gray-400,
    :is(.ba-rampung-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-rampung-page) .text-gray-500 {
        color: #94A3B8 !important;
    }

    :is(.ba-rampung-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-rampung-page) .text-slate-600,
    :is(.ba-rampung-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-rampung-page) .text-slate-700,
    :is(.ba-rampung-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-rampung-page) .text-slate-800,
    :is(.ba-rampung-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-rampung-page) .text-gray-600,
    :is(.ba-rampung-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-rampung-page) .text-gray-700 {
        color: #CBD5E1 !important;
    }

    /* ---- Background / border utilitas terang ---- */
    :is(.ba-rampung-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-rampung-page) .bg-white,
    :is(.ba-rampung-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-rampung-page) .bg-slate-50,
    :is(.ba-rampung-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-rampung-page) .bg-gray-50 {
        background-color: #101C2D !important;
    }

    :is(.ba-rampung-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-rampung-page) .bg-\[\#F5F8FD\],
    :is(.ba-rampung-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-rampung-page) .bg-slate-100,
    :is(.ba-rampung-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-rampung-page) .bg-gray-100 {
        background-color: #132238 !important;
    }

    :is(.ba-rampung-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-rampung-page) .bg-\[\#123F7A\]\/10 {
        background-color: rgba(96,165,250,.14) !important;
    }

    :is(.ba-rampung-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-rampung-page) .border-slate-100,
    :is(.ba-rampung-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-rampung-page) .border-slate-200,
    :is(.ba-rampung-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-rampung-page) .border-gray-100,
    :is(.ba-rampung-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-rampung-page) .border-gray-200,
    :is(.ba-rampung-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-rampung-page) .border-gray-300 {
        border-color: rgba(148,163,184,.18) !important;
    }

    :is(.ba-rampung-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-rampung-page) .ba-count-badge {
        background: #132238 !important;
        border-color: rgba(148,163,184,.18) !important;
    }

    /* ---- Tombol ---- */
    :is(.ba-rampung-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-rampung-page) .bg-\[\#123F7A\] {
        background-color: #1F5AA6 !important;
        color: #fff !important;
    }

    :is(.ba-rampung-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-rampung-page) .hover\:bg-\[\#0B315F\]:hover {
        background-color: #F28C28 !important;
        color: #fff !important;
    }

    :is(.ba-rampung-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-rampung-page) a.border-\[\#123F7A\] {
        border-color: rgba(96,165,250,.6) !important;
    }

    :is(.ba-rampung-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-rampung-page) .hover\:bg-\[\#123F7A\]\/5:hover {
        background-color: rgba(96,165,250,.14) !important;
    }

    :is(.ba-rampung-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-rampung-page) .hover\:bg-slate-50:hover,
    :is(.ba-rampung-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-rampung-page) .hover\:bg-gray-50:hover {
        background-color: rgba(255,255,255,.06) !important;
    }

    /* tombol reset */
    :is(.ba-rampung-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-rampung-page) a.bg-white {
        background-color: transparent !important;
    }

    /* tombol aksi lihat / edit / PDF / hapus */
    :is(.ba-rampung-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-rampung-page) .h-9.w-9 {
        background-color: rgba(255,255,255,.03) !important;
        border-color: rgba(148,163,184,.28) !important;
        color: #CBD5E1 !important;
    }

    :is(.ba-rampung-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-rampung-page) .h-9.w-9:hover {
        background-color: rgba(255,255,255,.07) !important;
    }

    :is(.ba-rampung-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-rampung-page) .hover\:border-\[\#123F7A\]:hover { border-color: #60A5FA !important; }
    :is(.ba-rampung-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-rampung-page) .hover\:text-\[\#123F7A\]:hover  { color: #93C5FD !important; }

    :is(.ba-rampung-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-rampung-page) .hover\:border-amber-400:hover   { border-color: #FBBF24 !important; }
    :is(.ba-rampung-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-rampung-page) .hover\:bg-amber-50:hover        { background-color: rgba(245,158,11,.16) !important; }
    :is(.ba-rampung-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-rampung-page) .hover\:text-amber-600:hover     { color: #FBBF24 !important; }

    :is(.ba-rampung-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-rampung-page) .hover\:border-rose-400:hover    { border-color: #FB7185 !important; }
    :is(.ba-rampung-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-rampung-page) .hover\:bg-rose-50:hover         { background-color: rgba(244,63,94,.16) !important; }
    :is(.ba-rampung-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-rampung-page) .hover\:text-rose-600:hover      { color: #FDA4AF !important; }

    :is(.ba-rampung-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-rampung-page) .hover\:border-red-400:hover     { border-color: #F87171 !important; }
    :is(.ba-rampung-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-rampung-page) .hover\:bg-red-50:hover          { background-color: rgba(239,68,68,.16) !important; }
    :is(.ba-rampung-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-rampung-page) .hover\:text-red-600:hover       { color: #FCA5A5 !important; }

    /* ---- Badge status (x-status-badge): warna status dipertahankan ---- */
    :is(.ba-rampung-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-rampung-page) .ba-table td:nth-child(6) > * {
        background-color: rgba(255,255,255,.08) !important;
        background-color: color-mix(in srgb, currentColor 18%, transparent) !important;
        border-color: color-mix(in srgb, currentColor 40%, transparent) !important;
        filter: brightness(1.6) saturate(1.1);
    }

    /* ---- Pagination ---- */
    :is(.ba-rampung-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-rampung-page) nav[role="navigation"] a,
    :is(.ba-rampung-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-rampung-page) nav[role="navigation"] span[aria-current] > span,
    :is(.ba-rampung-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-rampung-page) nav[role="navigation"] span[aria-disabled] > span {
        background-color: #101C2D !important;
        border-color: rgba(148,163,184,.22) !important;
        color: #CBD5E1 !important;
    }

    :is(.ba-rampung-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-rampung-page) nav[role="navigation"] a:hover {
        background-color: rgba(242,140,40,.14) !important;
        border-color: #F28C28 !important;
        color: #fff !important;
    }

    :is(.ba-rampung-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-rampung-page) nav[role="navigation"] span[aria-current] > span {
        background-color: #1F5AA6 !important;
        color: #fff !important;
    }

    /* ---- Empty state ---- */
    :is(.ba-rampung-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .ba-rampung-page) .ba-table tbody td[colspan] .bg-\[\#F5F8FD\] {
        background-color: #132238 !important;
    }
</style>


<div class="ba-rampung-page space-y-6">

    {{-- =========================================================
         HERO
         ========================================================= --}}
    <section class="ba-hero">

        <div class="ba-hero-content">

            <div class="max-w-4xl">

                <div class="dashboard-kicker mb-3 text-white/80">
                    Sistem BA Rampung
                </div>

                <h1 class="ba-hero-title dashboard-display">
                    Daftar
                    <span class="orange">BA Rampung.</span>
                </h1>

                <p class="ba-hero-desc">
                    Kelola, cari, dan pantau seluruh data Berita Acara Rampung
                    dengan lebih mudah dan terstruktur.
                </p>

            </div>

        </div>


        {{-- TOMBOL DI POJOK KANAN --}}
        @can('create', \App\Models\BaRampung::class)

            <div class="ba-hero-button hidden sm:block">

                <a href="{{ route('ba-rampung.create') }}">

                    <span class="text-lg leading-none">+</span>

                    Buat BA Rampung

                </a>

            </div>

        @endcan

    </section>



    {{-- =========================================================
         INFO
         ========================================================= --}}
    <section class="ba-info-card p-5 sm:p-6">

        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">

            <div class="flex items-start gap-4">

                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-[#123F7A]/10 text-[#123F7A]">

                    <svg class="h-6 w-6"
                         fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24">

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.8"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h6.5L19 6.5V19a2 2 0 01-2 2z"/>

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.8"
                            d="M13 3v4h4"/>

                    </svg>

                </div>


                <div>

                    <p class="dashboard-kicker text-[#123F7A]">
                        Data BA Rampung
                    </p>

                    <h2 class="dashboard-display mt-1 text-3xl font-normal text-[#0B2545] sm:text-4xl">
                        Kelola seluruh BA Rampung
                    </h2>

                    <p class="mt-1 text-sm text-slate-500">
                        Gunakan filter untuk menemukan data BA berdasarkan kebutuhan.
                    </p>

                </div>

            </div>


            {{-- MOBILE BUTTON --}}
            @can('create', \App\Models\BaRampung::class)

                <a
                    href="{{ route('ba-rampung.create') }}"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#123F7A] px-5 py-3 text-sm font-bold text-white shadow-md transition hover:bg-[#0B315F] sm:hidden"
                >

                    <span class="text-lg leading-none">+</span>

                    Buat BA Rampung

                </a>

            @endcan

        </div>

    </section>



    {{-- =========================================================
         FILTER
         ========================================================= --}}
    <section class="ba-filter-card">

        <div class="ba-filter-head px-5 py-4 sm:px-6">

            <div class="flex items-center gap-3">

                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#123F7A] text-white">

                    <svg class="h-5 w-5"
                         fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24">

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.8"
                            d="M3 5h18M6 12h12M10 19h4"/>

                    </svg>

                </div>


                <div>

                    <p class="dashboard-kicker text-[#123F7A]">
                        Filter Data
                    </p>

                    <h2 class="text-lg font-bold text-[#0B2545]">
                        Cari BA Rampung
                    </h2>

                </div>

            </div>

        </div>


        <form
            method="GET"
            action="{{ route('ba-rampung.index') }}"
            class="p-5 sm:p-6"
        >

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">


                {{-- SEARCH --}}
                <div class="lg:col-span-2">

                    <label class="ba-label">
                        Pencarian
                    </label>

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        class="ba-filter-input"
                        placeholder="Cari nomor BA, gudang, atau mitra..."
                    >

                </div>


                {{-- STATUS --}}
                <div>

                    <label class="ba-label">
                        Status Verifikasi
                    </label>

                    <select
                        name="status"
                        class="ba-filter-input"
                    >

                        <option value="">
                            Semua Status
                        </option>

                        @foreach(\App\Models\BaRampung::STATUSES as $status)

                            <option
                                value="{{ $status }}"
                                @selected(request('status') == $status)
                            >
                                {{ $status }}
                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- GUDANG --}}
                <div class="ba-searchable-filter" data-searchable-filter>

                    <label class="ba-label">
                        Gudang
                    </label>

                    <div class="ba-searchable-wrap">
                        <input
                            type="text"
                            class="ba-filter-input ba-searchable-input"
                            placeholder="Pilih Gudang"
                            autocomplete="off"
                            data-searchable-input
                            role="combobox"
                            aria-expanded="false"
                            aria-autocomplete="list"
                        >

                        <input
                            type="hidden"
                            name="gudang_id"
                            value="{{ request()->has('gudang_id') ? request('gudang_id') : '__NOT_SELECTED__' }}"
                            data-searchable-value
                        >

                        <button type="button" class="ba-searchable-arrow" data-searchable-toggle aria-label="Buka pilihan gudang">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path d="m6 9 6 6 6-6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>

                        <div class="ba-searchable-menu" data-searchable-menu role="listbox">
                            <button type="button" class="ba-searchable-option" data-value="" data-label="Semua Gudang" role="option">
                                Semua Gudang
                            </button>

                            @foreach($gudangs as $gudang)
                                <button
                                    type="button"
                                    class="ba-searchable-option"
                                    data-value="{{ $gudang->nama_gudang }}"
                                    data-label="{{ $gudang->nama_gudang }}"
                                    role="option"
                                >
                                    {{ $gudang->nama_gudang }}
                                </button>
                            @endforeach

                            <div class="ba-searchable-empty" data-searchable-empty>
                                Gudang tidak ditemukan
                            </div>
                        </div>
                    </div>
                </div>


                {{-- MITRA --}}
                <div class="ba-searchable-filter" data-searchable-filter>

                    <label class="ba-label">
                        Mitra Pengolahan
                    </label>

                    <div class="ba-searchable-wrap">
                        <input
                            type="text"
                            class="ba-filter-input ba-searchable-input"
                            placeholder="Pilih Mitra"
                            autocomplete="off"
                            data-searchable-input
                            role="combobox"
                            aria-expanded="false"
                            aria-autocomplete="list"
                        >

                        <input
                            type="hidden"
                            name="mitra_pengolahan_id"
                            value="{{ request()->has('mitra_pengolahan_id') ? request('mitra_pengolahan_id') : '__NOT_SELECTED__' }}"
                            data-searchable-value
                        >

                        <button type="button" class="ba-searchable-arrow" data-searchable-toggle aria-label="Buka pilihan mitra">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path d="m6 9 6 6 6-6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>

                        <div class="ba-searchable-menu" data-searchable-menu role="listbox">
                            <button type="button" class="ba-searchable-option" data-value="" data-label="Semua Mitra" role="option">
                                Semua Mitra
                            </button>

                            @foreach($mitras as $mitra)
                                <button
                                    type="button"
                                    class="ba-searchable-option"
                                    data-value="{{ $mitra->nama_mitra }}"
                                    data-label="{{ $mitra->nama_mitra }}"
                                    role="option"
                                >
                                    {{ $mitra->nama_mitra }}
                                </button>
                            @endforeach

                            <div class="ba-searchable-empty" data-searchable-empty>
                                Mitra tidak ditemukan
                            </div>
                        </div>
                    </div>
                </div>


                {{-- BULAN --}}
                <div>

                    <label class="ba-label">
                        Bulan
                    </label>

                    <select
                        name="bulan"
                        class="ba-filter-input"
                    >

                        <option value="" disabled @selected(!request()->has('bulan'))>
                            Pilih Bulan
                        </option>

                        <option value="" @selected(request()->has('bulan') && request('bulan') === '')>
                            Semua Bulan
                        </option>

                        @foreach(range(1, 12) as $bulan)

                            <option
                                value="{{ $bulan }}"
                                @selected(request('bulan') == $bulan)
                            >
                                {{ \Carbon\Carbon::create()->month($bulan)->translatedFormat('F') }}
                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- TAHUN --}}
                <div>

                    <label class="ba-label">
                        Tahun
                    </label>

                    <select
                        name="tahun"
                        class="ba-filter-input"
                    >

                        <option value="" disabled @selected(!request()->has('tahun'))>
                            Pilih Tahun
                        </option>

                        <option value="" @selected(request()->has('tahun') && request('tahun') === '')>
                            Semua Tahun
                        </option>

                        @foreach(range(now()->year, 2020) as $tahun)

                            <option
                                value="{{ $tahun }}"
                                @selected(request('tahun') == $tahun)
                            >
                                {{ $tahun }}
                            </option>

                        @endforeach

                    </select>

                </div>

            </div>


            {{-- BUTTON FILTER --}}
            <div class="mt-5 flex flex-col gap-3 border-t border-slate-100 pt-5 sm:flex-row sm:items-center sm:justify-between">

                <a
                    href="{{ route('ba-rampung.index') }}"
                    class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50"
                >
                    Reset
                </a>


                <div class="flex flex-col gap-3 sm:flex-row">

                    <a
                        href="{{ route('ba-rampung.export', request()->query()) }}"
                        class="inline-flex items-center justify-center gap-2 rounded-xl border border-[#123F7A] px-5 py-2.5 text-sm font-bold text-[#123F7A] transition hover:bg-[#123F7A]/5"
                    >
                        Export
                    </a>


                    <button
                        type="submit"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#123F7A] px-6 py-2.5 text-sm font-bold text-white shadow-md transition hover:bg-[#0B315F]"
                    >
                        Tampilkan Data
                    </button>

                </div>

            </div>

        </form>

    </section>



    {{-- =========================================================
         RESULTS
         ========================================================= --}}
    <section class="ba-result-card">

        <div class="flex flex-col gap-4 border-b border-slate-100 px-5 py-5 sm:px-6 lg:flex-row lg:items-center lg:justify-between">

            <div>

                <p class="dashboard-kicker text-[#123F7A]">
                    Data BA Rampung
                </p>

                <h2 class="dashboard-display mt-1 text-3xl font-normal text-[#0B2545] sm:text-4xl">
                    Daftar BA Rampung
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Data yang sesuai dengan filter ditampilkan pada tabel berikut.
                </p>

            </div>


            @if(method_exists($baList, 'total'))

                <div class="ba-count-badge rounded-xl bg-[#F5F8FD] px-4 py-2 text-sm font-semibold text-[#123F7A]">

                    {{ number_format($baList->total()) }} Data

                </div>

            @endif

        </div>


        <div class="overflow-x-auto">

            <table class="ba-table min-w-full text-left text-sm">

                <thead>

                    <tr>

                        <th class="px-5 py-4">
                            No.
                        </th>

                        <th class="px-5 py-4">
                            Nomor BA
                        </th>

                        <th class="px-5 py-4">
                            Tanggal BA
                        </th>

                        <th class="px-5 py-4">
                            Gudang
                        </th>

                        <th class="px-5 py-4">
                            Mitra Pengolahan
                        </th>

                        <th class="px-5 py-4">
                            Status Verifikasi
                        </th>

                        <th class="px-5 py-4 text-right">
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody class="bg-white">

                    @forelse($baList as $index => $ba)

                        <tr>

                            <td class="px-5 py-4 font-semibold text-slate-500">
                                {{ $baList->firstItem() + $index }}
                            </td>


                            <td class="px-5 py-4">

                                <div class="font-bold text-[#123F7A]">
                                    {{ $ba->nomor_ba }}
                                </div>

                            </td>


                            <td class="px-5 py-4 text-slate-600">
                                {{ optional($ba->tanggal_ba)->format('d/m/Y') ?? '-' }}
                            </td>


                            <td class="px-5 py-4 text-slate-700">
    {{ optional($ba->gudang)->nama_gudang ?? '-' }}
</td>


                            <td class="px-5 py-4 text-slate-700">
    {{ optional($ba->mitraPengolahan)->nama_mitra ?? '-' }}
</td>


                            <td class="px-5 py-4">

                                <x-status-badge
                                    :color="$ba->statusBadgeColor()"
                                    :label="$ba->statusLabel()"
                                />

                            </td>


                            <td class="px-5 py-4">

                                <div class="flex justify-end gap-2">


                                    {{-- LIHAT --}}
                                    @can('view', $ba)

                                        <a
                                            href="{{ route('ba-rampung.show', $ba) }}"
                                            title="Lihat"
                                            class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 text-slate-500 transition hover:border-[#123F7A] hover:bg-[#123F7A]/5 hover:text-[#123F7A]"
                                        >

                                            <svg
                                                class="h-4 w-4"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >

                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="1.8"
                                                    d="M2.5 12s3.5-6 9.5-6 9.5 6 9.5 6-3.5 6-9.5 6-9.5-6-9.5-6z"
                                                />

                                                <circle
                                                    cx="12"
                                                    cy="12"
                                                    r="2.5"
                                                    stroke-width="1.8"
                                                />

                                            </svg>

                                        </a>

                                    @endcan


                                    {{-- EDIT --}}
                                    @can('update', $ba)

                                        <a
                                            href="{{ route('ba-rampung.edit', $ba) }}"
                                            title="Edit"
                                            class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 text-slate-500 transition hover:border-amber-400 hover:bg-amber-50 hover:text-amber-600"
                                        >

                                            <svg
                                                class="h-4 w-4"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >

                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="1.8"
                                                    d="M12 20h9"
                                                />

                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="1.8"
                                                    d="M16.5 3.5a2.12 2.12 0 013 3L8 18l-4 1 1-4L16.5 3.5z"
                                                />

                                            </svg>

                                        </a>

                                    @endcan


                                    {{-- PDF: HANYA MUNCUL JIKA SUDAH TERVERIFIKASI --}}
                                    @if($ba->status === \App\Models\BaRampung::STATUS_TERVERIFIKASI)
                                        <a
                                            href="{{ route('ba-rampung.pdf', $ba) }}"
                                            title="PDF"
                                            target="_blank"
                                            class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 text-slate-500 transition hover:border-rose-400 hover:bg-rose-50 hover:text-rose-600"
                                        >
                                            <svg
                                                class="h-4 w-4"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="1.8"
                                                    d="M6 2.75h8l4 4V21.25H6z"
                                                />
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="1.8"
                                                    d="M14 2.75v4h4"
                                                />
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="1.8"
                                                    d="M8.5 15.5h2.2a1.5 1.5 0 000-3H8.5v5M13 12.5h1.5a2.5 2.5 0 010 5H13z"
                                                />
                                            </svg>
                                        </a>
                                    @endif


                                </div>

                            </td>

                        </tr>


                    @empty

                        <tr>

                            <td
                                colspan="7"
                                class="px-6 py-16 text-center"
                            >

                                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-[#F5F8FD] text-[#123F7A]">

                                    <svg
                                        class="h-7 w-7"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.8"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h6.5L19 6.5V19a2 2 0 01-2 2z"
                                        />

                                    </svg>

                                </div>

                                <h3 class="mt-4 font-bold text-[#0B2545]">
                                    Belum ada data BA Rampung
                                </h3>

                                <p class="mt-1 text-sm text-slate-500">
                                    Coba ubah filter pencarian atau tambahkan BA Rampung baru.
                                </p>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- PAGINATION --}}
        @if(method_exists($baList, 'links'))

            <div class="border-t border-slate-100 px-5 py-4 sm:px-6">

                {{ $baList->links() }}

            </div>

        @endif

    </section>

</div>

<style>
    /* =========================================================
       SEARCHABLE DROPDOWN — GUDANG & MITRA
       ========================================================= */
    .ba-searchable-wrap {
        position: relative;
    }

    .ba-searchable-input {
        width: 100%;
        padding-right: 48px !important;
        cursor: text;
    }

    .ba-searchable-input:focus {
        outline: none;
    }

    .ba-searchable-arrow {
        position: absolute;
        top: 50%;
        right: 10px;
        width: 34px;
        height: 34px;
        transform: translateY(-50%);
        display: flex;
        align-items: center;
        justify-content: center;
        border: 0;
        background: transparent;
        color: #64748b;
        cursor: pointer;
        z-index: 3;
        border-radius: 8px;
    }

    .ba-searchable-arrow:hover {
        background: rgba(18, 63, 122, .08);
        color: #123F7A;
    }

    .ba-searchable-arrow svg {
        width: 18px;
        height: 18px;
    }

    .ba-searchable-menu {
        position: absolute;
        left: 0;
        right: 0;
        top: calc(100% + 6px);
        max-height: 260px;
        overflow-y: auto;
        padding: 6px;
        border: 1px solid #dbe4ef;
        border-radius: 12px;
        background: #fff;
        box-shadow: 0 14px 35px rgba(15, 23, 42, .16);
        z-index: 100;
        display: none;
    }

    .ba-searchable-wrap.is-open .ba-searchable-menu {
        display: block;
    }

    .ba-searchable-option {
        display: block;
        width: 100%;
        padding: 10px 12px;
        border: 0;
        border-radius: 8px;
        background: transparent;
        color: #334155;
        text-align: left;
        font-size: 14px;
        line-height: 1.35;
        cursor: pointer;
    }

    .ba-searchable-option:hover,
    .ba-searchable-option.is-highlighted {
        background: #eef5ff;
        color: #123F7A;
    }

    .ba-searchable-empty {
        display: none;
        padding: 12px;
        color: #94a3b8;
        text-align: center;
        font-size: 13px;
    }

    .ba-searchable-menu::-webkit-scrollbar {
        width: 7px;
    }

    .ba-searchable-menu::-webkit-scrollbar-thumb {
        border-radius: 999px;
        background: #cbd5e1;
    }

    .ba-rampung-page.is-dark .ba-searchable-menu {
        border-color: #334155;
        background: #0f1f34;
        box-shadow: 0 14px 35px rgba(0, 0, 0, .35);
    }

    .ba-rampung-page.is-dark .ba-searchable-option {
        color: #e2e8f0;
    }

    .ba-rampung-page.is-dark .ba-searchable-option:hover,
    .ba-rampung-page.is-dark .ba-searchable-option.is-highlighted {
        background: #18365b;
        color: #fff;
    }

    .ba-rampung-page.is-dark .ba-searchable-empty {
        color: #94a3b8;
    }

    .ba-rampung-page.is-dark .ba-searchable-arrow {
        color: #94a3b8;
    }

    .ba-rampung-page.is-dark .ba-searchable-arrow:hover {
        background: rgba(255, 255, 255, .08);
        color: #fff;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('[data-searchable-filter]').forEach(function (filter) {

        const wrap = filter.querySelector('.ba-searchable-wrap');
        const input = filter.querySelector('[data-searchable-input]');
        const hidden = filter.querySelector('[data-searchable-value]');
        const toggle = filter.querySelector('[data-searchable-toggle]');
        const menu = filter.querySelector('[data-searchable-menu]');
        const options = Array.from(filter.querySelectorAll('.ba-searchable-option'));
        const empty = filter.querySelector('[data-searchable-empty]');

        if (!wrap || !input || !hidden || !toggle || !menu) return;

        const NOT_SELECTED = '__NOT_SELECTED__';
        let highlighted = -1;

        function setOpen(open) {
            wrap.classList.toggle('is-open', open);
            input.setAttribute('aria-expanded', open ? 'true' : 'false');
            if (open) {
                filterOptions('');
                highlighted = -1;
            }
        }

        function filterOptions(query) {
            const keyword = (query || '').trim().toLowerCase();
            let visible = 0;

            options.forEach(function (option) {
                const label = (option.dataset.label || option.textContent || '').trim();
                const show = !keyword || label.toLowerCase().includes(keyword);
                option.style.display = show ? '' : 'none';
                option.classList.remove('is-highlighted');
                if (show) visible++;
            });

            empty.style.display = visible ? 'none' : 'block';
            highlighted = -1;
        }

        function selectOption(option) {
            const value = option.dataset.value ?? '';
            const label = option.dataset.label || option.textContent.trim();

            hidden.value = value;
            input.value = label;
            input.dataset.selected = 'true';

            setOpen(false);
        }

        function resetSearchIfNeeded() {
            if (hidden.value === NOT_SELECTED) {
                hidden.value = '';
                input.value = '';
            }
        }

        // Kondisi awal: belum memilih apa pun.
        if (hidden.value === NOT_SELECTED) {
            hidden.value = '';
            input.value = '';
        } else if (hidden.value === '') {
            input.value = options[0]?.dataset.label || '';
        } else {
            const selected = options.find(function (option) {
                return option.dataset.value === hidden.value;
            });
            if (selected) input.value = selected.dataset.label;
        }

        input.addEventListener('focus', function () {
            resetSearchIfNeeded();
            setOpen(true);
            input.select();
        });

        input.addEventListener('input', function () {
            // Kalau user mulai mengetik setelah sebelumnya memilih item,
            // pencarian tidak langsung menghapus nilai sampai memilih hasil.
            setOpen(true);
            filterOptions(input.value);
        });

        toggle.addEventListener('click', function (event) {
            event.preventDefault();
            event.stopPropagation();

            if (wrap.classList.contains('is-open')) {
                setOpen(false);
            } else {
                setOpen(true);
                input.focus();
            }
        });

        options.forEach(function (option) {
            option.addEventListener('mousedown', function (event) {
                event.preventDefault();
            });

            option.addEventListener('click', function () {
                selectOption(option);
            });
        });

        input.addEventListener('keydown', function (event) {
            const visibleOptions = options.filter(function (option) {
                return option.style.display !== 'none';
            });

            if (event.key === 'ArrowDown') {
                event.preventDefault();
                if (!wrap.classList.contains('is-open')) setOpen(true);
                if (!visibleOptions.length) return;
                highlighted = Math.min(highlighted + 1, visibleOptions.length - 1);
                visibleOptions.forEach(function (option, index) {
                    option.classList.toggle('is-highlighted', index === highlighted);
                });
                visibleOptions[highlighted]?.scrollIntoView({ block: 'nearest' });
            }

            if (event.key === 'ArrowUp') {
                event.preventDefault();
                if (!wrap.classList.contains('is-open')) setOpen(true);
                if (!visibleOptions.length) return;
                highlighted = highlighted <= 0 ? visibleOptions.length - 1 : highlighted - 1;
                visibleOptions.forEach(function (option, index) {
                    option.classList.toggle('is-highlighted', index === highlighted);
                });
                visibleOptions[highlighted]?.scrollIntoView({ block: 'nearest' });
            }

            if (event.key === 'Enter') {
                if (wrap.classList.contains('is-open') && highlighted >= 0 && visibleOptions[highlighted]) {
                    event.preventDefault();
                    selectOption(visibleOptions[highlighted]);
                }
            }

            if (event.key === 'Escape') {
                setOpen(false);
                input.blur();
            }
        });

        document.addEventListener('click', function (event) {
            if (!filter.contains(event.target)) {
                setOpen(false);
            }
        });
    });
});
</script>

{{-- =========================================================
    DETEKSI MODE GELAP (khusus tampilan)
    Menambah / menghapus class "is-dark" pada .ba-rampung-page
    mengikuti mode yang sedang aktif di layout. Tidak berkaitan
    dengan filter, pencarian, export, pagination, maupun aksi.
========================================================= --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    const page = document.querySelector('.ba-rampung-page');
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
    // Jika layout menggelapkan "bg-white" atau menerangkan "text-slate-700",
    // berarti mode gelap sedang aktif (apa pun penandanya).
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
        bg:   document.createElement('span'),
        t1:   document.createElement('span'),
        t2:   document.createElement('span')
    };

    probes.bg.className = 'bg-white';
    probes.t1.className = 'text-slate-700';
    probes.t2.className = 'text-gray-700';

    // Probe diletakkan DI LUAR .ba-rampung-page. Jika di dalam, aturan gelap
    // milik halaman ikut mengenai probe dan mode gelap akan "terkunci".
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

    // ---------- sinkronisasi ----------
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
