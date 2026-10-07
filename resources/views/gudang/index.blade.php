@extends('layouts.app')

@section('title', 'Gudang')

@section('content')
{{-- POPUP NOTIFIKASI --}}
@if(session('success') || session('error') || $errors->any())
<div id="gudang-alert" class="gd-alert-overlay">
  <div class="gd-alert-card">
    @if(session('success'))
      <div class="gd-alert-icon gd-alert-success"><svg viewBox="0 0 24 24" fill="none"><path d="m5 12 4 4L19 6" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
      <h3 class="gd-alert-title">Berhasil!</h3>
      <p class="gd-alert-message">{{ session('success') }}</p>
    @else
      <div class="gd-alert-icon gd-alert-error"><svg viewBox="0 0 24 24" fill="none"><path d="M6 6l12 12M18 6 6 18" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/></svg></div>
      <h3 class="gd-alert-title">Gagal!</h3>
      <p class="gd-alert-message">{{ session('error') ?? $errors->first() }}</p>
    @endif
    <button type="button" class="gd-alert-button" onclick="document.getElementById('gudang-alert')?.remove()">OK</button>
  </div>
</div>
@endif
<style>
.gd-alert-overlay{position:fixed;inset:0;z-index:99999;display:flex;align-items:center;justify-content:center;padding:1rem;background:rgba(2,12,27,.48);backdrop-filter:blur(4px);animation:gdFade .2s ease-out}.gd-alert-card{width:min(100%,390px);border:1px solid rgba(15,43,82,.1);border-radius:1.35rem;background:#fff;padding:1.75rem;text-align:center;box-shadow:0 25px 70px rgba(2,12,27,.22);animation:gdScale .22s ease-out}.gd-alert-icon{display:flex;width:4rem;height:4rem;margin:0 auto 1rem;align-items:center;justify-content:center;border-radius:999px}.gd-alert-icon svg{width:2rem;height:2rem}.gd-alert-success{color:#059669;background:#ecfdf5}.gd-alert-error{color:#dc2626;background:#fef2f2}.gd-alert-title{margin:0;color:#0b2545;font-size:1.15rem;font-weight:800}.gd-alert-message{margin:.5rem 0 0;color:#64748b;font-size:.875rem;line-height:1.55}.gd-alert-button{width:100%;margin-top:1.25rem;border:0;border-radius:.8rem;background:#123f7a;color:#fff;padding:.7rem 1rem;font-size:.875rem;font-weight:700;cursor:pointer;transition:.2s}.gd-alert-button:hover{background:#0d3263;transform:translateY(-1px)}html.dark-theme .gd-alert-card{border-color:#263b55;background:#101c2d;box-shadow:0 25px 70px rgba(0,0,0,.45)}html.dark-theme .gd-alert-title{color:#f8fafc}html.dark-theme .gd-alert-message{color:#94a3b8}html.dark-theme .gd-alert-success{color:#6ee7b7;background:rgba(52,211,153,.14)}html.dark-theme .gd-alert-error{color:#fca5a5;background:rgba(239,68,68,.14)}html.dark-theme .gd-alert-button{background:#1f5aa6}html.dark-theme .gd-alert-button:hover{background:#f28c28}@keyframes gdFade{from{opacity:0}to{opacity:1}}@keyframes gdScale{from{opacity:0;transform:scale(.94) translateY(8px)}to{opacity:1;transform:scale(1) translateY(0)}}
</style>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const alert = document.getElementById('gudang-alert');

    // Popup TIDAK ditutup otomatis.
    // Popup hanya hilang setelah tombol OK diklik.
});
</script>


<style>
    /* =========================================================
       MASTER DATA — GUDANG : LIGHT / DARK MODE + ACCORDION
       Tema sama dengan halaman Daftar BA Rampung.
       Hanya tampilan; data, route, dan aksi tidak diubah.
       ========================================================= */

    .gd-page {
        --ba-overlay-top: rgba(7, 20, 38, .62);
        --ba-overlay-bottom: rgba(7, 20, 38, .50);
        position: relative;
    }

    /* Overlay mode gelap (gambar latar dari layout tetap terlihat) */
    .gd-page::before {
        content: "";
        position: fixed;
        inset: 0;
        z-index: 0;
        pointer-events: none;
        background: linear-gradient(180deg, var(--ba-overlay-top), var(--ba-overlay-bottom));
        opacity: 0;
        transition: opacity .3s ease;
    }

    .gd-page > * {
        position: relative;
        z-index: 1;
    }

    /* ---------------- LIGHT MODE ---------------- */

    .gd-page .gd-panel,
    .gd-page .gd-card {
        position: relative;
        background: rgba(250,251,253,.96);
        border-color: rgba(15,43,82,.07);
        transition: background-color .2s ease, border-color .2s ease, box-shadow .2s ease, transform .2s ease;
    }

    .gd-page .gd-panel {
        box-shadow: 0 12px 35px rgba(15,23,42,.09);
    }

    .gd-page .gd-panel::before {
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

    .gd-page .gd-panel .dashboard-kicker::before {
        content: "";
        display: inline-block;
        width: 18px;
        height: 2px;
        margin-right: .6rem;
        vertical-align: middle;
        border-radius: 2px;
        background: #F28C28;
    }

    .gd-page input:focus,
    .gd-page select:focus {
        border-color: #F28C28 !important;
        box-shadow: 0 0 0 3px rgba(242,140,40,.18) !important;
    }

    /* ---- Accordion ---- */
    .gd-acc {
        display: flex;
        flex-direction: column;
        gap: .75rem;
        padding: 1.25rem 1.5rem 1.5rem;
    }

    .gd-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: .75rem;
        flex-wrap: wrap;
    }

    .gd-ghost-btn {
        border: 1px solid #D9E2EC;
        border-radius: .7rem;
        background: transparent;
        padding: .4rem .85rem;
        font-size: .75rem;
        font-weight: 700;
        color: #123F7A;
        transition: border-color .2s ease, color .2s ease, background-color .2s ease;
    }

    .gd-ghost-btn:hover {
        border-color: #F28C28;
        color: #C2610A;
        background: rgba(242,140,40,.08);
    }

    .gd-group {
        overflow: hidden;
        border: 1px solid #E3EAF3;
        border-radius: 1.1rem;
        background: #fff;
        transition: border-color .25s ease, box-shadow .25s ease;
    }

    .gd-group.is-open {
        border-color: rgba(242,140,40,.50);
        box-shadow: 0 10px 28px rgba(15,23,42,.07);
    }

    .gd-group-head {
        display: flex;
        width: 100%;
        align-items: center;
        gap: .9rem;
        padding: 1rem 1.15rem;
        text-align: left;
        background: transparent;
        cursor: pointer;
        transition: background-color .2s ease;
    }

    .gd-group-head:hover {
        background: rgba(18,63,122,.035);
    }

    .gd-group-head:focus-visible {
        outline: 2px solid #F28C28;
        outline-offset: -2px;
    }

    .gd-chev {
        display: inline-flex;
        height: 1.85rem;
        width: 1.85rem;
        flex-shrink: 0;
        align-items: center;
        justify-content: center;
        border-radius: .65rem;
        background: #EEF3FA;
        color: #123F7A;
        transition: transform .25s ease, background-color .2s ease, color .2s ease;
    }

    .gd-group.is-open .gd-chev {
        transform: rotate(90deg);           /* ▶ tertutup  →  ▼ terbuka */
        background: #F28C28;
        color: #fff;
    }

    .gd-ware-icon {
        display: inline-flex;
        height: 2.5rem;
        width: 2.5rem;
        flex-shrink: 0;
        align-items: center;
        justify-content: center;
        border-radius: .85rem;
        background: #EAF1FB;
        color: #123F7A;
    }

    .gd-group-name {
        font-weight: 700;
        color: #0B2545;
        overflow-wrap: anywhere;
    }

    .gd-badge-utama {
        border-radius: 999px;
        background: #EAF1FB;
        padding: .2rem .65rem;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: .06em;
        text-transform: uppercase;
        color: #123F7A;
    }

    .gd-count {
        display: inline-flex;
        flex-shrink: 0;
        align-items: baseline;
        gap: .35rem;
        border-radius: 999px;
        background: rgba(242,140,40,.12);
        padding: .3rem .8rem;
        font-size: .85rem;
        font-weight: 800;
        color: #B45309;
    }

    .gd-count-label {
        font-size: .65rem;
        font-weight: 700;
        letter-spacing: .06em;
        text-transform: uppercase;
    }

    /* animasi buka / tutup (tanpa plugin) */
    .gd-panel-wrap {
        display: grid;
        grid-template-rows: 1fr;
        transition: grid-template-rows .3s ease;
    }

    .gd-panel-wrap.is-collapsed {
        grid-template-rows: 0fr;
    }

    .gd-panel-inner {
        min-height: 0;
        overflow: hidden;
    }

    .gd-panel-wrap.is-collapsed .gd-panel-inner {
        visibility: hidden;
        transition: visibility 0s linear .3s;
    }

    .gd-filial-list {
        border-top: 1px solid #E3EAF3;
        background: #F8FAFC;
    }

    .gd-empty-filial {
        padding: 1.25rem 1.5rem;
        font-size: .8rem;
        color: #94A3B8;
    }

    /* baris filial */
    .gd-cols,
    .gd-row {
        display: grid;
        align-items: center;
        gap: .6rem 1rem;
    }

    .gd-cols {
        display: none;
        padding: .7rem 1.15rem;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: .12em;
        text-transform: uppercase;
        color: #64748B;
        background: #F1F5FA;
        border-bottom: 2px solid rgba(242,140,40,.28);
    }

    .gd-row {
        grid-template-columns: repeat(2, minmax(0, 1fr));
        padding: .95rem 1.15rem;
        border-top: 1px solid #E9EEF5;
        transition: background-color .15s ease;
    }

    .gd-filial-list > .gd-row:first-of-type {
        border-top: 0;
    }

    .gd-row:hover {
        background: #F2F6FB;
        box-shadow: inset 3px 0 0 #F28C28;
    }

    .gd-cell {
        min-width: 0;
        font-size: .875rem;
    }

    .gd-cell[data-label]::before {
        content: attr(data-label);
        display: block;
        margin-bottom: .15rem;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: .1em;
        text-transform: uppercase;
        color: #94A3B8;
    }

    .gd-no {
        display: none;
        color: #94A3B8;
    }

    .gd-nama {
        grid-column: 1 / -1;
    }

    .gd-aksi {
        grid-column: 1 / -1;
    }

    @media (min-width: 640px) {
        .gd-row {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }

    @media (min-width: 1024px) {

        .gd-cols,
        .gd-row {
            grid-template-columns: 2.25rem 6.5rem minmax(0, 2.2fr) minmax(0, 1fr) minmax(0, 1fr) 7.5rem 6rem 9rem;
        }

        .gd-cols {
            display: grid;
        }

        .gd-no {
            display: block;
        }

        .gd-nama,
        .gd-aksi {
            grid-column: auto;
        }

        .gd-cell[data-label]::before {
            display: none;
        }
    }

    @media (max-width: 639px) {
        .gd-acc {
            padding: 1rem;
        }

        .gd-group-head {
            padding: .85rem .9rem;
            gap: .65rem;
        }

        .gd-ware-icon {
            display: none;
        }
    }

    @media (prefers-reduced-motion: reduce) {

        .gd-panel-wrap,
        .gd-chev,
        .gd-group,
        .gd-row {
            transition: none;
        }
    }


    /* ---------------- DARK MODE ----------------
       Aktif jika .gd-page diberi class "is-dark" oleh script di bawah
       (mengikuti mode gelap layout) atau jika penanda tema gelap umum
       ada di <html>/<body>. Semua aturan terkunci di dalam .gd-page,
       sehingga mode terang tidak terpengaruh. Background image dari
       layout TIDAK diganti — hanya diberi overlay. */

    :is(.gd-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .gd-page)::before {
        opacity: 1;
    }

    :is(.gd-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .gd-page) {
        color: #E5E7EB;
        color-scheme: dark;
    }

    /* hero */
    :is(.gd-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .gd-page) .gd-hero {
        background-color: rgba(8,24,46,.50) !important;
        border-color: rgba(148,163,184,.20) !important;
        box-shadow: 0 20px 60px rgba(0,0,0,.35) !important;
    }

    /* card & panel */
    :is(.gd-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .gd-page) .gd-panel,
    :is(.gd-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .gd-page) .gd-card {
        background: rgba(16,28,45,.95) !important;
        border-color: #263B55 !important;
        box-shadow: 0 14px 36px rgba(0,0,0,.30) !important;
    }

    :is(.gd-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .gd-page) .gd-panel::before {
        background: linear-gradient(90deg, #F28C28 0, #F28C28 84px, rgba(96,165,250,.55) 84px, rgba(96,165,250,.10) 100%);
    }

    :is(.gd-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .gd-page) .border-slate-100,
    :is(.gd-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .gd-page) .border-slate-200,
    :is(.gd-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .gd-page) .border-slate-200\/80 {
        border-color: #263B55 !important;
    }

    /* teks */
    :is(.gd-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .gd-page) .text-\[\#0B2545\] {
        color: #F8FAFC !important;
    }

    :is(.gd-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .gd-page) .text-\[\#123F7A\] {
        color: #93C5FD !important;
    }

    :is(.gd-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .gd-page) .gd-card .text-3xl.text-\[\#123F7A\] {
        color: #F8FAFC !important;
    }

    :is(.gd-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .gd-page) .text-slate-300,
    :is(.gd-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .gd-page) .text-slate-400,
    :is(.gd-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .gd-page) .text-slate-500 {
        color: #94A3B8 !important;
    }

    :is(.gd-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .gd-page) .text-slate-600,
    :is(.gd-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .gd-page) .text-slate-700 {
        color: #E2E8F0 !important;
    }

    :is(.gd-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .gd-page) .text-emerald-600 { color: #6EE7B7 !important; }
    :is(.gd-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .gd-page) .text-amber-600   { color: #FCD34D !important; }
    :is(.gd-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .gd-page) .text-indigo-600  { color: #A5B4FC !important; }
    :is(.gd-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .gd-page) .text-orange-600  { color: #FDBA74 !important; }
    :is(.gd-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .gd-page) .text-red-500     { color: #FCA5A5 !important; }

    /* permukaan terang lain */
    :is(.gd-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .gd-page) .bg-white,
    :is(.gd-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .gd-page) .bg-slate-50 {
        background-color: #101C2D !important;
    }

    :is(.gd-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .gd-page) .bg-blue-50   { background-color: rgba(96,165,250,.14) !important; }
    :is(.gd-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .gd-page) .bg-indigo-50 { background-color: rgba(129,140,248,.16) !important; }
    :is(.gd-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .gd-page) .bg-emerald-50{ background-color: rgba(52,211,153,.14) !important; }
    :is(.gd-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .gd-page) .bg-amber-50  { background-color: rgba(245,158,11,.16) !important; }
    :is(.gd-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .gd-page) .bg-orange-50 { background-color: rgba(242,140,40,.16) !important; }
    :is(.gd-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .gd-page) .bg-red-50    { background-color: rgba(239,68,68,.16) !important; }

    /* form */
    :is(.gd-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .gd-page) label {
        color: #94A3B8 !important;
    }

    :is(.gd-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .gd-page) input[type="text"],
    :is(.gd-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .gd-page) select {
        background-color: #111D2E !important;
        border-color: #2B405A !important;
        color: #F8FAFC !important;
    }

    :is(.gd-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .gd-page) input[type="text"]:focus,
    :is(.gd-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .gd-page) select:focus {
        background-color: #0F1A2B !important;
        border-color: #F28C28 !important;
        box-shadow: 0 0 0 3px rgba(242,140,40,.22) !important;
    }

    :is(.gd-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .gd-page) input::placeholder {
        color: #94A3B8 !important;
        opacity: 1;
    }

    :is(.gd-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .gd-page) option {
        background: #101C2D;
        color: #F8FAFC;
    }

    /* tombol */
    :is(.gd-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .gd-page) .bg-\[\#123F7A\] {
        background-color: #1F5AA6 !important;
        color: #fff !important;
    }

    :is(.gd-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .gd-page) .hover\:bg-\[\#0d3263\]:hover {
        background-color: #F28C28 !important;
        color: #fff !important;
    }

    :is(.gd-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .gd-page) a.bg-white,
    :is(.gd-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .gd-page) a.bg-white.hover\:bg-slate-50 {
        background-color: transparent !important;
        border-color: #2B405A !important;
        color: #E2E8F0 !important;
    }

    :is(.gd-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .gd-page) .hover\:bg-slate-50:hover {
        background-color: rgba(255,255,255,.06) !important;
    }

    /* tombol aksi (lihat / edit / status) */
    :is(.gd-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .gd-page) .hover\:bg-\[\#123F7A\]:hover { background-color: #1F5AA6 !important; }
    :is(.gd-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .gd-page) .hover\:bg-orange-500:hover   { background-color: #F28C28 !important; }
    :is(.gd-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .gd-page) .hover\:bg-red-500:hover      { background-color: #EF4444 !important; }
    :is(.gd-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .gd-page) .hover\:bg-emerald-500:hover  { background-color: #10B981 !important; }
    :is(.gd-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .gd-page) .hover\:text-white:hover      { color: #fff !important; }

    /* accordion */
    :is(.gd-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .gd-page) .gd-ghost-btn {
        border-color: #2B405A;
        color: #93C5FD;
    }

    :is(.gd-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .gd-page) .gd-ghost-btn:hover {
        border-color: #F28C28;
        color: #fff;
        background: rgba(242,140,40,.14);
    }

    :is(.gd-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .gd-page) .gd-group {
        background: #101C2D;
        border-color: #263B55;
    }

    :is(.gd-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .gd-page) .gd-group.is-open {
        border-color: rgba(242,140,40,.55);
        box-shadow: 0 10px 28px rgba(0,0,0,.35);
    }

    :is(.gd-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .gd-page) .gd-group-head:hover {
        background: rgba(96,165,250,.07);
    }

    :is(.gd-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .gd-page) .gd-chev {
        background: rgba(96,165,250,.14);
        color: #93C5FD;
    }

    :is(.gd-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .gd-page) .gd-group.is-open .gd-chev {
        background: #F28C28;
        color: #fff;
    }

    :is(.gd-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .gd-page) .gd-ware-icon {
        background: rgba(96,165,250,.14);
        color: #93C5FD;
    }

    :is(.gd-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .gd-page) .gd-group-name {
        color: #F8FAFC;
    }

    :is(.gd-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .gd-page) .gd-badge-utama {
        background: rgba(96,165,250,.14);
        color: #93C5FD;
    }

    :is(.gd-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .gd-page) .gd-count {
        background: rgba(242,140,40,.16);
        color: #FDBA74;
    }

    :is(.gd-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .gd-page) .gd-filial-list {
        background: #132238;
        border-top-color: #263B55;
    }

    :is(.gd-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .gd-page) .gd-cols {
        background: rgba(11,23,40,.55);
        color: #94A3B8;
        border-bottom-color: rgba(242,140,40,.35);
    }

    :is(.gd-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .gd-page) .gd-row {
        border-top-color: rgba(148,163,184,.14);
    }

    :is(.gd-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .gd-page) .gd-row:hover {
        background: rgba(255,255,255,.04);
    }

    :is(.gd-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .gd-page) .gd-no,
    :is(.gd-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .gd-page) .gd-cell[data-label]::before,
    :is(.gd-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .gd-page) .gd-empty-filial {
        color: #94A3B8;
    }

    /* badge status (x-status-badge): warna status dipertahankan */
    :is(.gd-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .gd-page) .gd-status > * {
        background-color: rgba(255,255,255,.08) !important;
        background-color: color-mix(in srgb, currentColor 18%, transparent) !important;
        border-color: color-mix(in srgb, currentColor 40%, transparent) !important;
        filter: brightness(1.6) saturate(1.1);
    }

    /* pagination */
    :is(.gd-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .gd-page) nav[role="navigation"] a,
    :is(.gd-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .gd-page) nav[role="navigation"] span[aria-current] > span,
    :is(.gd-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .gd-page) nav[role="navigation"] span[aria-disabled] > span {
        background-color: #101C2D !important;
        border-color: rgba(148,163,184,.22) !important;
        color: #CBD5E1 !important;
    }

    :is(.gd-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .gd-page) nav[role="navigation"] a:hover {
        background-color: rgba(242,140,40,.14) !important;
        border-color: #F28C28 !important;
        color: #fff !important;
    }

    :is(.gd-page.is-dark, :is(.dark, .dark-mode, .theme-dark, [data-theme="dark"], [data-bs-theme="dark"]) .gd-page) nav[role="navigation"] span[aria-current] > span {
        background-color: #1F5AA6 !important;
        color: #fff !important;
    }
</style>

<div class="gd-page space-y-6">

    {{-- =========================================================
         HERO / HEADER
    ========================================================== --}}
    <section class="gd-hero relative overflow-hidden rounded-[2rem] border border-white/20 bg-[#0B315F]/20 shadow-xl">

        {{-- Overlay supaya tulisan tetap terbaca --}}
        <div class="absolute inset-0 bg-gradient-to-r from-[#06254A]/75 via-[#0B3D73]/45 to-transparent"></div>

        <div class="relative px-6 py-8 sm:px-8 sm:py-10 lg:px-10">

            <div class="flex flex-col gap-7 lg:flex-row lg:items-end lg:justify-between">

                <div class="max-w-3xl">

                    <p class="dashboard-kicker text-white/75">
                        MASTER DATA
                    </p>

                    <h1 class="dashboard-display mt-2 text-4xl leading-tight text-white sm:text-5xl lg:text-6xl">
                        Data <span class="text-[#F28C28]">Gudang</span>
                    </h1>

                    <p
                        class="mt-3 max-w-xl text-sm leading-6 text-white/85 sm:text-base"
                        style="text-shadow: 0 1px 8px rgba(3, 28, 55, .25);"
                    >
                        Kelola data gudang penyimpanan BA Rampung dengan mudah dan terstruktur.
                    </p>

                </div>


                <div class="flex flex-col items-start gap-3 sm:flex-row sm:items-center lg:flex-col lg:items-end">

                    <div class="rounded-2xl border border-white/20 bg-[#082F63]/60 px-5 py-3 text-white backdrop-blur-md">

                        <p class="text-[10px] font-bold uppercase tracking-[.2em] text-white/55">
                            STATUS DATA
                        </p>

                        <div class="mt-1.5 flex items-center gap-2">

                            <span class="h-2.5 w-2.5 rounded-full bg-emerald-400 shadow-[0_0_0_4px_rgba(52,211,153,.15)]"></span>

                            <span class="text-sm font-semibold">
                                Data gudang aktif
                            </span>

                        </div>

                    </div>


                    @role('admin_kantor')

                        <a
                            href="{{ route('gudang.create') }}"
                            class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#123F7A] px-5 py-3 text-sm font-bold text-white shadow-lg transition duration-200 hover:-translate-y-0.5 hover:bg-[#0d3263]"
                        >
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 5v14M5 12h14"/></svg>
                            Tambah Gudang
                        </a>

                    @endrole

                </div>

            </div>

        </div>

    </section>



    {{-- =========================================================
         KPI
    ========================================================== --}}
    <section class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

        @php
            // Total gudang induk berasal dari daftar gudang utama yang
            // memang sudah disediakan oleh controller untuk filter.
            $totalGudangInduk = $gudangsUtama->count();

            // Total gudang pada KPI mencakup induk + filial.
            // Jadi jumlah filial dihitung dari selisihnya.
            $totalGudangFilial = max(0, (int) $kpi['total'] - $totalGudangInduk);
        @endphp

        {{-- TOTAL GUDANG INDUK --}}
        <div class="gd-card group rounded-[1.35rem] border border-slate-200/80 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:shadow-lg">

            <div class="flex items-start justify-between">

                <div>

                    <p class="text-[10px] font-bold uppercase tracking-[.15em] text-slate-400">
                        Total Gudang Induk
                    </p>

                    <p class="mt-2 text-3xl font-bold tracking-tight text-[#123F7A]">
                        {{ number_format($totalGudangInduk) }}
                    </p>

                    <p class="mt-1 text-xs text-slate-400">
                        Gudang utama dalam sistem
                    </p>

                </div>

                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-blue-50 text-[#123F7A] transition group-hover:scale-105">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 21V9l9-5 9 5v12"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 21v-7h10v7M7 17h10"/></svg>
                </div>

            </div>

        </div>


        {{-- TOTAL GUDANG FILIAL --}}
        <div class="gd-card group rounded-[1.35rem] border border-slate-200/80 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:shadow-lg">

            <div class="flex items-start justify-between">

                <div>

                    <p class="text-[10px] font-bold uppercase tracking-[.15em] text-slate-400">
                        Total Gudang Filial
                    </p>

                    <p class="mt-2 text-3xl font-bold tracking-tight text-emerald-600">
                        {{ number_format($totalGudangFilial) }}
                    </p>

                    <div class="mt-1 flex items-center gap-1.5 text-xs text-emerald-600">

                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>

                        Gudang Filial

                    </div>

                </div>

                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5 13l4 4L19 7"/></svg>
                </div>

            </div>

        </div>


        {{-- DOKUMEN --}}
        <div class="gd-card group rounded-[1.35rem] border border-slate-200/80 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:shadow-lg">

            <div class="flex items-start justify-between">

                <div>

                    <p class="text-[10px] font-bold uppercase tracking-[.15em] text-slate-400">
                        Total Dokumen BA
                    </p>

                    <p class="mt-2 text-3xl font-bold tracking-tight text-[#123F7A]">
                        {{ number_format($kpi['total_dokumen']) }}
                    </p>

                    <p class="mt-1 text-xs text-slate-400">
                        Terkait data gudang
                    </p>

                </div>

                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-600">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h6.5L19 6.5V19a2 2 0 01-2 2z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13 3v4h4"/></svg>
                </div>

            </div>

        </div>


        {{-- PROSES --}}
        <div class="gd-card group rounded-[1.35rem] border border-slate-200/80 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:shadow-lg">

            <div class="flex items-start justify-between">

                <div>

                    <p class="text-[10px] font-bold uppercase tracking-[.15em] text-slate-400">
                        Sedang Diproses
                    </p>

                    <p class="mt-2 text-3xl font-bold tracking-tight text-amber-600">
                        {{ number_format($kpi['dengan_proses']) }}
                    </p>

                    <p class="mt-1 text-xs text-slate-400">
                        Dokumen masih diproses
                    </p>

                </div>

                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-amber-50 text-amber-600">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="9" stroke-width="1.8"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 7v5l3 2"/></svg>
                </div>

            </div>

        </div>

    </section>



    {{-- =========================================================
         FILTER
    ========================================================== --}}
    <section class="gd-panel overflow-hidden rounded-[1.5rem] border border-slate-200/80 bg-white shadow-lg">

        <form
            method="GET"
            action="{{ route('gudang.index') }}"
            class="p-5 sm:p-6"
        >

            <div class="flex flex-col gap-4 border-b border-slate-100 pb-5 sm:flex-row sm:items-center sm:justify-between">

                <div class="flex items-center gap-3">

                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-[#123F7A]">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="7" stroke-width="1.8"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M20 20l-3.5-3.5"/></svg>
                    </div>

                    <div>

                        <p class="dashboard-kicker text-[#123F7A]">
                            Filter Data
                        </p>

                        <h2 class="mt-0.5 text-lg font-bold text-[#0B2545]">
                            Cari Gudang
                        </h2>

                        <p class="mt-0.5 text-xs text-slate-400">
                            Gunakan filter untuk menemukan gudang dengan lebih cepat.
                        </p>

                    </div>

                </div>


                <div class="flex flex-wrap gap-2">

                    @if(request('gudang_utama_id') || request('search'))

                        <a
                            href="{{ route('gudang.index') }}"
                            class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50"
                        >
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 4v6h6"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M20 12a8 8 0 10-2.3 5.7"/></svg>
                            Reset
                        </a>

                    @endif


                    <button
                        type="submit"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#123F7A] px-5 py-2.5 text-sm font-bold text-white shadow-sm transition hover:-translate-y-0.5 hover:bg-[#0d3263]"
                    >
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="7" stroke-width="1.8"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M20 20l-3.5-3.5"/></svg>
                        Cari
                    </button>

                </div>

            </div>



            <div class="mt-5 grid grid-cols-1 gap-4 lg:grid-cols-2">

                {{-- SEARCH --}}
                <div>

                    <label class="mb-2 block text-xs font-bold uppercase tracking-wide text-slate-500">
                        Pencarian
                    </label>

                    <div class="relative">

                        <span class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="7" stroke-width="1.8"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M20 20l-3.5-3.5"/></svg>
                        </span>

                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Cari nama gudang atau kode gudang..."
                            class="w-full rounded-xl border border-slate-200 bg-slate-50/60 py-3 pl-11 pr-4 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-[#123F7A] focus:bg-white focus:ring-4 focus:ring-blue-50"
                        >

                    </div>

                </div>


                {{-- GUDANG UTAMA --}}
                <div>

                    <label class="mb-2 block text-xs font-bold uppercase tracking-wide text-slate-500">
                        Gudang Utama
                    </label>

                    <select
                        name="gudang_utama_id"
                        class="w-full rounded-xl border border-slate-200 bg-slate-50/60 px-4 py-3 text-sm text-slate-700 outline-none transition focus:border-[#123F7A] focus:bg-white focus:ring-4 focus:ring-blue-50"
                    >

                        <option value="">
                            Semua Gudang Utama
                        </option>

                        @foreach($gudangsUtama as $gudangUtama)

                            <option
                                value="{{ $gudangUtama->id }}"
                                @selected(request('gudang_utama_id') == $gudangUtama->id)
                            >
                                {{ $gudangUtama->nama_gudang }}
                            </option>

                        @endforeach

                    </select>

                </div>

            </div>

        </form>

    </section>



    {{-- =========================================================
         DATA GUDANG
    ========================================================== --}}
    <section class="gd-panel overflow-hidden rounded-[1.5rem] border border-slate-200/80 bg-white shadow-lg">

        {{-- HEADER TABLE --}}
        <div class="flex flex-col gap-4 border-b border-slate-100 px-5 py-5 sm:px-6 lg:flex-row lg:items-center lg:justify-between">

            <div class="flex items-center gap-3">

                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-[#123F7A]">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 21V9l9-5 9 5v12"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 21v-7h10v7M7 17h10"/></svg>
                </div>

                <div>

                    <p class="dashboard-kicker text-[#123F7A]">
                        Master Data
                    </p>

                    <h2 class="dashboard-display mt-0.5 text-2xl font-normal text-[#0B2545] sm:text-3xl">
                        Data Gudang
                    </h2>

                    <p class="mt-1 text-xs text-slate-400">
                        Gudang utama dan gudang filial yang terdaftar dalam sistem.
                    </p>

                </div>

            </div>


            @role('admin_kantor')

                <a
                    href="{{ route('gudang.create') }}"
                    class="inline-flex items-center justify-center gap-2 self-start rounded-xl bg-[#123F7A] px-4 py-2.5 text-sm font-bold text-white shadow-sm transition hover:-translate-y-0.5 hover:bg-[#0d3263] lg:self-center"
                >
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 5v14M5 12h14"/></svg>
                    Tambah Gudang
                </a>

            @endrole

        </div>



        {{-- =====================================================
             DAFTAR GUDANG — ACCORDION
             Gudang induk ditampilkan lebih dulu; klik untuk membuka
             gudang filial di bawahnya. Data diambil dari $gudangs
             yang sama (hubungan: gudang_induk_id / gudangInduk).
        ====================================================== --}}
        @php
            $gdGroups = [];

            foreach ($gudangs as $gdRow) {

                if (is_null($gdRow->gudang_induk_id)) {

                    $gdKey = $gdRow->id;

                    if (! isset($gdGroups[$gdKey])) {
                        $gdGroups[$gdKey] = ['induk' => $gdRow, 'filial' => []];
                    } else {
                        $gdGroups[$gdKey]['induk'] = $gdRow;
                    }

                } else {

                    $gdKey = $gdRow->gudang_induk_id;

                    if (! isset($gdGroups[$gdKey])) {
                        $gdGroups[$gdKey] = ['induk' => null, 'filial' => []];
                    }

                    $gdGroups[$gdKey]['filial'][] = $gdRow;
                }
            }

            // Saat pencarian / filter aktif, grup langsung terbuka agar hasilnya terlihat
            $gdAutoOpen = (bool) (request('gudang_utama_id') || request('search'));
        @endphp

        <div x-data class="gd-acc">

            @if(count($gdGroups) > 0)

                <div class="gd-toolbar">

                    <p class="text-xs text-slate-400">
                        {{ count($gdGroups) }} gudang utama
                    </p>

                    <div class="flex items-center gap-2">

                        <button
                            type="button"
                            class="gd-ghost-btn"
                            @click="$dispatch('gudang-toggle-all', true)"
                        >
                            Buka Semua
                        </button>

                        <button
                            type="button"
                            class="gd-ghost-btn"
                            @click="$dispatch('gudang-toggle-all', false)"
                        >
                            Tutup Semua
                        </button>

                    </div>

                </div>

            @endif


            @forelse($gdGroups as $group)

                @php
                    $induk       = $group['induk'];
                    $firstFilial = $group['filial'][0] ?? null;

                    $indukNama = $induk->nama_gudang
                        ?? optional(optional($firstFilial)->gudangInduk)->nama_gudang
                        ?? '-';

                    $indukKode = $induk->kode_gudang
                        ?? optional(optional($firstFilial)->gudangInduk)->kode_gudang;
                @endphp


                {{-- =================================================
                     GUDANG UTAMA (INDUK)
                ================================================== --}}
                <div
                    x-data="{ open: @json($gdAutoOpen) }"
                    @gudang-toggle-all.window="open = $event.detail"
                    :class="{ 'is-open': open }"
                    class="gd-group {{ $gdAutoOpen ? 'is-open' : '' }}"
                >

                    <div
                        class="gd-group-head"
                        @click="open = !open"
                        :aria-expanded="open.toString()"
                        role="button"
                        tabindex="0"
                        @keydown.enter="open = !open"
                        @keydown.space.prevent="open = !open"
                    >

                        <span class="gd-chev">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M9 5l7 7-7 7"/></svg>
                        </span>

                        <span class="gd-ware-icon">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 21V9l9-5 9 5v12"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 21v-7h10v7M7 17h10"/></svg>
                        </span>

                        <span class="min-w-0 flex-1">

                            <span class="flex flex-wrap items-center gap-2">

                                <span class="gd-group-name">
                                    {{ $indukNama }}
                                </span>

                                <span class="gd-badge-utama">
                                    Gudang Utama
                                </span>

                            </span>

                            @if($indukKode)

                                <span class="mt-0.5 block text-xs text-slate-400">
                                    {{ $indukKode }}
                                </span>

                            @endif

                        </span>

                        <span class="gd-count">
                            {{ count($group['filial']) }}
                            <span class="gd-count-label">Filial</span>
                        </span>

                        @if($induk)
                            @role('admin_kantor')
                                <span
                                    class="ml-3 flex shrink-0 items-center gap-1.5"
                                    @click.stop
                                    @keydown.stop
                                >

                                    {{-- EDIT GUDANG UTAMA --}}
                                    <a
                                        href="{{ route('gudang.edit', $induk) }}"
                                        title="Edit Gudang Utama"
                                        class="flex h-9 w-9 items-center justify-center rounded-xl bg-orange-50 text-orange-600 transition hover:bg-orange-500 hover:text-white"
                                        @click.stop
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 15.07a4.5 4.5 0 0 1-1.897 1.13L6 17l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-7.931Z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 7.5 16.5 4.5"/>
                                        </svg>
                                    </a>

                                    {{-- TOGGLE STATUS GUDANG UTAMA --}}
                                    <form
                                        method="POST"
                                        action="{{ route('gudang.toggle-status', $induk) }}"
                                        class="inline"
                                        @click.stop
                                        onsubmit="event.preventDefault(); openGudangStatusModal(this.querySelector('button'));"
                                        data-gudang-name="{{ $induk->nama_gudang }}"
                                        data-gudang-code="{{ $induk->kode_gudang }}"
                                        data-status="{{ $induk->status }}"
                                    >
                                        @csrf
                                        @method('PATCH')

                                        <button
                                            type="button"
                                            title="{{ $induk->status === 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }}"
                                            class="flex h-9 w-9 items-center justify-center rounded-xl transition
                                            {{ $induk->status === 'aktif'
                                                ? 'bg-red-50 text-red-500 hover:bg-red-500 hover:text-white'
                                                : 'bg-emerald-50 text-emerald-600 hover:bg-emerald-500 hover:text-white'
                                            }}"
                                            data-gudang-name="{{ $induk->nama_gudang }}"
                                            data-gudang-code="{{ $induk->kode_gudang }}"
                                            data-status="{{ $induk->status }}"
                                            onclick="event.stopPropagation(); openGudangStatusModal(this);"
                                        >
                                            @if($induk->status === 'aktif')
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 1 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636"/>
                                                </svg>
                                            @else
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 12l4 4L19 6"/>
                                                </svg>
                                            @endif
                                        </button>
                                    </form>

                                    {{-- HAPUS GUDANG UTAMA --}}
                                    <form
                                        method="POST"
                                        action="{{ route('gudang.destroy', $induk) }}"
                                        class="inline"
                                        data-gudang-name="{{ $induk->nama_gudang }}"
                                        data-gudang-code="{{ $induk->kode_gudang }}"
                                        @click.stop
                                        onsubmit="event.preventDefault(); openGudangDeleteModal(this);"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            title="Hapus Gudang Utama"
                                            class="flex h-9 w-9 items-center justify-center rounded-xl bg-red-50 text-red-500 transition hover:bg-red-500 hover:text-white"
                                            onclick="event.stopPropagation();"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 7h16"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 7V4h6v3M7 7l1 14h8l1-14"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 11v6M14 11v6"/>
                                            </svg>
                                        </button>
                                    </form>

                                </span>
                            @endrole
                        @endif

                    </div>


                    {{-- =============================================
                         GUDANG FILIAL
                    ============================================== --}}
                    <div
                        class="gd-panel-wrap {{ $gdAutoOpen ? '' : 'is-collapsed' }}"
                        :class="{ 'is-collapsed': !open }"
                    >

                        <div class="gd-panel-inner">

                            <div class="gd-filial-list">

                                @if(count($group['filial']) > 0)

                                    <div class="gd-cols" aria-hidden="true">
                                        <span>No.</span>
                                        <span>Kode</span>
                                        <span>Nama Gudang</span>
                                        <span>Kecamatan</span>
                                        <span>Desa</span>
                                        <span>Kapasitas</span>
                                        <span>Status</span>
                                        <span class="text-right">Aksi</span>
                                    </div>


                                    @foreach($group['filial'] as $filial)

                                        <div class="gd-row">

                                            {{-- NO --}}
                                            <div class="gd-cell gd-no">
                                                {{ $loop->iteration }}
                                            </div>


                                            {{-- KODE --}}
                                            <div class="gd-cell gd-kode" data-label="Kode">

                                                <span class="font-bold text-[#123F7A]">
                                                    {{ $filial->kode_gudang }}
                                                </span>

                                            </div>


                                            {{-- NAMA --}}
                                            <div class="gd-cell gd-nama">

                                                <p class="font-semibold text-[#0B2545]">
                                                    {{ $filial->nama_gudang }}
                                                </p>

                                                @if($filial->alamat)

                                                    <p class="mt-0.5 truncate text-xs text-slate-400" title="{{ $filial->alamat }}">
                                                        {{ $filial->alamat }}
                                                    </p>

                                                @endif

                                            </div>


                                            {{-- KECAMATAN --}}
                                            <div class="gd-cell text-slate-600" data-label="Kecamatan">
                                                {{ $filial->kecamatan ?? '-' }}
                                            </div>


                                            {{-- DESA --}}
                                            <div class="gd-cell text-slate-600" data-label="Desa">
                                                {{ $filial->desa ?? '-' }}
                                            </div>


                                            {{-- KAPASITAS --}}
                                            <div class="gd-cell" data-label="Kapasitas">

                                                @if($filial->kapasitas !== null)

                                                    <span class="font-medium text-slate-700">
                                                        {{ number_format($filial->kapasitas, 2, ',', '.') }}
                                                    </span>

                                                    <span class="text-xs text-slate-400">
                                                        Ton
                                                    </span>

                                                @else

                                                    <span class="text-slate-400">
                                                        -
                                                    </span>

                                                @endif

                                            </div>


                                            {{-- STATUS --}}
                                            <div class="gd-cell gd-status" data-label="Status">

                                                <x-status-badge
                                                    :color="$filial->status === 'aktif' ? 'green' : 'gray'"
                                                    :label="ucfirst($filial->status)"
                                                />

                                            </div>


                                            {{-- AKSI --}}
                                            <div class="gd-cell gd-aksi">

                                                <div class="flex items-center justify-end gap-2">






                                                    @role('admin_kantor')


                                                        {{-- EDIT --}}
                                                        <a
                                                            href="{{ route('gudang.edit', $filial) }}"
                                                            title="Edit Gudang"
                                                            class="flex h-9 w-9 items-center justify-center rounded-xl bg-orange-50 text-orange-600 transition hover:bg-orange-500 hover:text-white"
                                                        >
                                                            <svg
                                                                xmlns="http://www.w3.org/2000/svg"
                                                                class="h-4 w-4"
                                                                fill="none"
                                                                viewBox="0 0 24 24"
                                                                stroke="currentColor"
                                                                stroke-width="1.8"
                                                            >
                                                                <path
                                                                    stroke-linecap="round"
                                                                    stroke-linejoin="round"
                                                                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 15.07a4.5 4.5 0 0 1-1.897 1.13L6 17l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-7.931Z"
                                                                />
                                                                <path
                                                                    stroke-linecap="round"
                                                                    stroke-linejoin="round"
                                                                    d="M19.5 7.5 16.5 4.5"
                                                                />
                                                            </svg>
                                                        </a>



                                                        {{-- TOGGLE STATUS --}}
                                                        <form
                                                            method="POST"
                                                            action="{{ route('gudang.toggle-status', $filial) }}"
                                                            class="inline"
                                                        >

                                                            @csrf

                                                            @method('PATCH')

                                                            <button
                                                                type="submit"
                                                                title="{{ $filial->status === 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }}"
                                                                class="flex h-9 w-9 items-center justify-center rounded-xl transition
                                                                {{ $filial->status === 'aktif'
                                                                    ? 'bg-red-50 text-red-500 hover:bg-red-500 hover:text-white'
                                                                    : 'bg-emerald-50 text-emerald-600 hover:bg-emerald-500 hover:text-white'
                                                                }}"
                                                                onclick="openGudangStatusModal(this); return false;"
                                                                data-gudang-name="{{ $filial->nama_gudang }}"
                                                                data-gudang-code="{{ $filial->kode_gudang }}"
                                                                data-status="{{ $filial->status }}"
                                                            >

                                                                @if($filial->status === 'aktif')

                                                                    <svg
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        class="h-4 w-4"
                                                                        fill="none"
                                                                        viewBox="0 0 24 24"
                                                                        stroke="currentColor"
                                                                        stroke-width="1.8"
                                                                    >
                                                                        <path
                                                                            stroke-linecap="round"
                                                                            stroke-linejoin="round"
                                                                            d="M18.364 18.364A9 9 0 1 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636"
                                                                        />
                                                                    </svg>

                                                                @else

                                                                    <svg
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        class="h-4 w-4"
                                                                        fill="none"
                                                                        viewBox="0 0 24 24"
                                                                        stroke="currentColor"
                                                                        stroke-width="1.8"
                                                                    >
                                                                        <path
                                                                            stroke-linecap="round"
                                                                            stroke-linejoin="round"
                                                                            d="m4.5 12.75 6 6 9-13.5"
                                                                        />
                                                                    </svg>

                                                                @endif

                                                            </button>

                                                        </form>

                                                        {{-- HAPUS --}}
                                                        <form
                                                            method="POST"
                                                            action="{{ route('gudang.destroy', $filial) }}"
                                                            class="inline"
                                                            onsubmit="openGudangDeleteModal(this); return false;"
                                                            data-gudang-name="{{ $filial->nama_gudang }}"
                                                            data-gudang-code="{{ $filial->kode_gudang }}"
                                                        >
                                                            @csrf
                                                            @method('DELETE')

                                                            <button
                                                                type="submit"
                                                                title="Hapus Gudang"
                                                                class="flex h-9 w-9 items-center justify-center rounded-xl bg-red-50 text-red-500 transition hover:bg-red-500 hover:text-white"
                                                            >
                                                                <svg
                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                    class="h-4 w-4"
                                                                    fill="none"
                                                                    viewBox="0 0 24 24"
                                                                    stroke="currentColor"
                                                                    stroke-width="1.8"
                                                                >
                                                                    <path
                                                                        stroke-linecap="round"
                                                                        stroke-linejoin="round"
                                                                        d="M6 7h12M10 11v6M14 11v6M9 7V4h6v3M7 7l1 14h8l1-14"
                                                                    />
                                                                </svg>
                                                            </button>
                                                        </form>


                                                    @endrole

                                                </div>

                                            </div>

                                        </div>

                                    @endforeach

                                @else

                                    <p class="gd-empty-filial">
                                        Belum ada gudang filial yang ditampilkan untuk gudang utama ini.
                                    </p>

                                @endif

                            </div>

                        </div>

                    </div>

                </div>

            @empty

                {{-- EMPTY STATE --}}
                <div class="px-5 py-16 text-center">

                    <div class="mx-auto flex max-w-sm flex-col items-center">

                        <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-blue-50 text-[#123F7A]">
                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 21V9l9-5 9 5v12"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 21v-7h10v7M7 17h10"/></svg>
                        </div>

                        <p class="mt-4 font-bold text-[#0B2545]">
                            Belum ada data gudang
                        </p>

                        <p class="mt-1 text-sm text-slate-400">
                            Belum terdapat data gudang yang dapat ditampilkan.
                        </p>


                        @role('admin_kantor')

                            <a
                                href="{{ route('gudang.create') }}"
                                class="mt-5 inline-flex items-center gap-2 rounded-xl bg-[#123F7A] px-5 py-2.5 text-sm font-bold text-white transition hover:bg-[#0d3263]"
                            >
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 5v14M5 12h14"/></svg>
                                Tambah Gudang
                            </a>

                        @endrole

                    </div>

                </div>

            @endforelse

        </div>



        {{-- FOOTER TABLE --}}
        @if($gudangs->count() > 0)

            <div class="flex flex-col gap-3 border-t border-slate-100 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">

                <p class="text-xs text-slate-400">
                    Menampilkan data gudang yang tersedia dalam sistem.
                </p>

                @if(method_exists($gudangs, 'links'))

                    <div>
                        {{ $gudangs->withQueryString()->links() }}
                    </div>

                @endif

            </div>

        @endif

    </section>

</div>

{{-- =========================================================
    MODAL KONFIRMASI STATUS GUDANG
========================================================= --}}
<div id="gudang-status-modal" class="gd-status-modal" aria-hidden="true">
    <div class="gd-status-backdrop" onclick="closeGudangStatusModal()"></div>

    <div class="gd-status-card" role="dialog" aria-modal="true" aria-labelledby="gudang-status-title">
        <button type="button" class="gd-status-close" onclick="closeGudangStatusModal()" aria-label="Tutup">
            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                <path d="M6 6l12 12M18 6 6 18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            </svg>
        </button>

        <div class="gd-status-icon">
            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                <path d="M12 8v4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                <path d="M12 16h.01" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/>
                <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.8"/>
            </svg>
        </div>

        <p class="gd-status-kicker">Konfirmasi Status</p>

        <h3 id="gudang-status-title" class="gd-status-title">
            Apakah Anda yakin ingin mengubah status gudang?
        </h3>

        <div class="gd-status-info">
            <p id="gudang-status-name" class="gd-status-name">-</p>
            <span id="gudang-status-code" class="gd-status-code">-</span>
        </div>

        <p id="gudang-status-message" class="gd-status-message">
            Status gudang akan diubah.
        </p>

        <div class="gd-status-actions">
            <button type="button" class="gd-status-btn gd-status-cancel" onclick="closeGudangStatusModal()">
                Batal
            </button>

            <button type="button" id="gudang-status-confirm" class="gd-status-btn gd-status-confirm" onclick="confirmGudangStatus()">
                Ya, Nonaktifkan
            </button>
        </div>
    </div>
</div>

<style>
.gd-status-modal{position:fixed;inset:0;z-index:100000;display:none;align-items:center;justify-content:center;padding:1rem}
.gd-status-modal.is-open{display:flex}
.gd-status-backdrop{position:absolute;inset:0;background:rgba(2,12,27,.58);backdrop-filter:blur(5px);animation:gdStatusFade .18s ease-out}
.gd-status-card{position:relative;z-index:1;width:min(100%,430px);border:1px solid rgba(15,43,82,.10);border-radius:1.5rem;background:#fff;padding:2rem;text-align:center;box-shadow:0 28px 80px rgba(2,12,27,.28);animation:gdStatusScale .2s ease-out}
.gd-status-close{position:absolute;top:1rem;right:1rem;display:flex;width:2rem;height:2rem;align-items:center;justify-content:center;border:0;border-radius:.65rem;background:transparent;color:#94a3b8;cursor:pointer;transition:.2s ease}
.gd-status-close:hover{background:#f1f5f9;color:#475569}
.gd-status-close svg{width:1rem;height:1rem}
.gd-status-icon{display:flex;width:4.25rem;height:4.25rem;margin:0 auto 1rem;align-items:center;justify-content:center;border-radius:999px;background:#fff7ed;color:#f28c28;box-shadow:0 0 0 8px rgba(242,140,40,.08)}
.gd-status-icon svg{width:2.15rem;height:2.15rem}
.gd-status-kicker{margin:0;color:#f28c28;font-size:.68rem;font-weight:800;letter-spacing:.14em;text-transform:uppercase}
.gd-status-title{margin:.45rem auto 0;max-width:330px;color:#0b2545;font-size:1.15rem;line-height:1.45;font-weight:800}
.gd-status-info{margin:1rem auto 0;width:100%;border:1px solid #e2e8f0;border-radius:1rem;background:#f8fafc;padding:.85rem 1rem}
.gd-status-name{margin:0;color:#0f172a;font-size:.9rem;font-weight:750}
.gd-status-code{display:inline-block;margin-top:.3rem;border-radius:999px;background:#eaf1fb;padding:.22rem .65rem;color:#123f7a;font-size:.68rem;font-weight:800;letter-spacing:.06em}
.gd-status-message{margin:.9rem 0 0;color:#64748b;font-size:.82rem;line-height:1.55}
.gd-status-actions{display:grid;grid-template-columns:1fr 1fr;gap:.7rem;margin-top:1.35rem}
.gd-status-btn{min-height:2.75rem;border:0;border-radius:.8rem;padding:.7rem 1rem;font-size:.84rem;font-weight:750;cursor:pointer;transition:transform .18s ease,background-color .18s ease,box-shadow .18s ease}
.gd-status-btn:hover{transform:translateY(-1px)}
.gd-status-cancel{border:1px solid #dbe3ec;background:#fff;color:#475569}
.gd-status-cancel:hover{background:#f8fafc}
.gd-status-confirm{background:#dc2626;color:#fff;box-shadow:0 8px 20px rgba(220,38,38,.18)}
.gd-status-confirm:hover{background:#b91c1c}
.gd-status-confirm.is-activate{background:#059669;box-shadow:0 8px 20px rgba(5,150,105,.18)}
.gd-status-confirm.is-activate:hover{background:#047857}
html.dark-theme .gd-status-card{border-color:#263b55;background:#101c2d;box-shadow:0 28px 80px rgba(0,0,0,.5)}
html.dark-theme .gd-status-close{color:#94a3b8}
html.dark-theme .gd-status-close:hover{background:rgba(255,255,255,.07);color:#f8fafc}
html.dark-theme .gd-status-icon{background:rgba(242,140,40,.14);color:#fbbf24;box-shadow:0 0 0 8px rgba(242,140,40,.06)}
html.dark-theme .gd-status-title{color:#f8fafc}
html.dark-theme .gd-status-info{border-color:#263b55;background:#132238}
html.dark-theme .gd-status-name{color:#f1f5f9}
html.dark-theme .gd-status-code{background:rgba(96,165,250,.14);color:#93c5fd}
html.dark-theme .gd-status-message{color:#94a3b8}
html.dark-theme .gd-status-cancel{border-color:#334155;background:#17263a;color:#e2e8f0}
html.dark-theme .gd-status-cancel:hover{background:#203249}
@keyframes gdStatusFade{from{opacity:0}to{opacity:1}}
@keyframes gdStatusScale{from{opacity:0;transform:translateY(8px) scale(.96)}to{opacity:1;transform:translateY(0) scale(1)}}
@media (max-width:480px){.gd-status-card{padding:1.5rem;border-radius:1.25rem}.gd-status-actions{grid-template-columns:1fr}}
</style>

<script>
let gudangStatusForm = null;

function openGudangStatusModal(button) {
    gudangStatusForm = button.closest('form');

    const modal = document.getElementById('gudang-status-modal');
    const name = button.dataset.gudangName || 'Gudang';
    const code = button.dataset.gudangCode || '-';
    const status = button.dataset.status || 'aktif';

    document.getElementById('gudang-status-name').textContent = name;
    document.getElementById('gudang-status-code').textContent = code;

    const message = document.getElementById('gudang-status-message');
    const confirmButton = document.getElementById('gudang-status-confirm');

    if (status === 'aktif') {
        message.textContent = 'Gudang akan dinonaktifkan dan tidak lagi berstatus aktif di dalam sistem.';
        confirmButton.textContent = 'Ya, Nonaktifkan';
        confirmButton.classList.remove('is-activate');
    } else {
        message.textContent = 'Gudang akan diaktifkan kembali dan dapat digunakan di dalam sistem.';
        confirmButton.textContent = 'Ya, Aktifkan';
        confirmButton.classList.add('is-activate');
    }

    modal.classList.add('is-open');
    modal.setAttribute('aria-hidden', 'false');
    document.body.classList.add('overflow-hidden');
}

function closeGudangStatusModal() {
    const modal = document.getElementById('gudang-status-modal');
    if (!modal) return;

    modal.classList.remove('is-open');
    modal.setAttribute('aria-hidden', 'true');
    document.body.classList.remove('overflow-hidden');
    gudangStatusForm = null;
}

function confirmGudangStatus() {
    if (!gudangStatusForm) return;
    const form = gudangStatusForm;
    gudangStatusForm = null;
    form.submit();
}

document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') closeGudangStatusModal();
});
</script>

{{-- =========================================================
    MODAL KONFIRMASI HAPUS GUDANG
========================================================= --}}
<div id="gudang-delete-modal" class="gd-status-modal" aria-hidden="true">
    <div class="gd-status-backdrop" onclick="closeGudangDeleteModal()"></div>

    <div class="gd-status-card" role="dialog" aria-modal="true" aria-labelledby="gudang-delete-title">
        <button type="button" class="gd-status-close" onclick="closeGudangDeleteModal()" aria-label="Tutup">
            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                <path d="M6 6l12 12M18 6 6 18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            </svg>
        </button>

        <div class="gd-delete-icon">
            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                <path d="M4 7h16" stroke="currentColor" stroke-width="1.9" stroke-linecap="round"/>
                <path d="M9 7V4h6v3M7 7l1 14h8l1-14" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M10 11v6M14 11v6" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
            </svg>
        </div>

        <p class="gd-delete-kicker">Hapus Gudang</p>

        <h3 id="gudang-delete-title" class="gd-status-title">
            Apakah Anda yakin ingin menghapus gudang ini?
        </h3>

        <div class="gd-status-info gd-delete-info">
            <p id="gudang-delete-name" class="gd-status-name">-</p>
            <span id="gudang-delete-code" class="gd-status-code">-</span>
        </div>

        <p class="gd-status-message">
            Data gudang yang dihapus tidak dapat digunakan lagi dalam sistem.
        </p>

        <div class="gd-status-actions">
            <button type="button" class="gd-status-btn gd-status-cancel" onclick="closeGudangDeleteModal()">
                Batal
            </button>

            <button type="button" class="gd-status-btn gd-delete-confirm" onclick="confirmGudangDelete()">
                Ya, Hapus
            </button>
        </div>
    </div>
</div>

<style>
.gd-delete-icon{
    display:flex;
    width:4.25rem;
    height:4.25rem;
    margin:0 auto 1rem;
    align-items:center;
    justify-content:center;
    border-radius:999px;
    background:#fef2f2;
    color:#dc2626;
    box-shadow:0 0 0 8px rgba(220,38,38,.07);
}
.gd-delete-icon svg{width:2.15rem;height:2.15rem}
.gd-delete-kicker{
    margin:0;
    color:#dc2626;
    font-size:.68rem;
    font-weight:800;
    letter-spacing:.14em;
    text-transform:uppercase;
}
.gd-delete-confirm{
    background:#dc2626;
    color:#fff;
    box-shadow:0 8px 20px rgba(220,38,38,.18);
}
.gd-delete-confirm:hover{background:#b91c1c}
html.dark-theme .gd-delete-icon{
    background:rgba(239,68,68,.14);
    color:#fca5a5;
    box-shadow:0 0 0 8px rgba(239,68,68,.05);
}
</style>

<script>
let gudangDeleteForm = null;

function openGudangDeleteModal(form) {
    gudangDeleteForm = form;

    const modal = document.getElementById('gudang-delete-modal');
    document.getElementById('gudang-delete-name').textContent =
        form.dataset.gudangName || 'Gudang';
    document.getElementById('gudang-delete-code').textContent =
        form.dataset.gudangCode || '-';

    modal.classList.add('is-open');
    modal.setAttribute('aria-hidden', 'false');
    document.body.classList.add('overflow-hidden');
}

function closeGudangDeleteModal() {
    const modal = document.getElementById('gudang-delete-modal');
    if (!modal) return;

    modal.classList.remove('is-open');
    modal.setAttribute('aria-hidden', 'true');
    document.body.classList.remove('overflow-hidden');
    gudangDeleteForm = null;
}

function confirmGudangDelete() {
    if (!gudangDeleteForm) return;

    const form = gudangDeleteForm;
    gudangDeleteForm = null;
    form.onsubmit = null;
    form.submit();
}
</script>

{{-- =========================================================
    DETEKSI MODE GELAP (khusus tampilan)
    Menambah / menghapus class "is-dark" pada .gd-page mengikuti
    mode yang sedang aktif di layout (tombol toggle di navbar).
    Tidak berkaitan dengan data atau aksi gudang.
========================================================= --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    const page = document.querySelector('.gd-page');
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
    // Probe diletakkan DI LUAR .gd-page agar tidak terkena aturan gelap
    // milik halaman ini (jika di dalam, mode gelap akan "terkunci").
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
