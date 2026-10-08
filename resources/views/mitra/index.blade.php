@extends('layouts.app')

@section('title', 'Data Mitra')

@section('content')


{{-- =========================================================
     POPUP NOTIFIKASI
     - Berhasil / Gagal
     - Mendukung session success, session error, dan validation error
========================================================== --}}
@if(session('success') || session('error') || $errors->any())
    <div id="mitra-alert" class="mitra-alert-overlay">
        <div class="mitra-alert-card">

            @if(session('success'))
                <div class="mitra-alert-icon success">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M5 12.5l4.2 4.2L19 7"></path>
                    </svg>
                </div>

                <h3 class="mitra-alert-title">Berhasil!</h3>

                <p class="mitra-alert-message">
                    {{ session('success') }}
                </p>
            @else
                <div class="mitra-alert-icon error">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M12 8v4"></path>
                        <path d="M12 16h.01"></path>
                    </svg>
                </div>

                <h3 class="mitra-alert-title">Gagal!</h3>

                <p class="mitra-alert-message">
                    {{ session('error') ?? $errors->first() }}
                </p>
            @endif

            <button
                type="button"
                class="mitra-alert-button"
                onclick="closeMitraAlert()"
            >
                OKE
            </button>

        </div>
    </div>
@endif


{{-- =========================================================
     STYLE KHUSUS HALAMAN MITRA (scoped di .mitra-page)
     - Hanya visual. Tidak menyentuh logic / backend.
     - Dark mode mengikuti sistem toggle yang sudah ada di layout
       (class/atribut dark pada <html>/<body>), jadi toggle tetap dua arah.
========================================================== --}}
<style>
    .mitra-page {
        --m-card: rgba(255, 255, 255, .96);
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
        --m-act-view-bg: #EAF2FC;
        --m-act-view-fg: #123F7A;
        --m-act-edit-bg: #FFF3E3;
        --m-act-edit-fg: #D97706;
        --m-act-tog-bg: #EEF2F6;
        --m-act-tog-fg: #5B6F89;
        --m-shadow: 0 10px 30px rgba(15, 42, 74, .08);
        --m-number: #123F7A;
        color: var(--m-text);
    }

    /* ---------- DARK MODE (mengikuti toggle existing) ---------- */
    .mitra-page[data-m-theme="dark"] {
        --m-card: rgba(16, 28, 45, .94);
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
        --m-act-view-bg: rgba(96, 165, 250, .14);
        --m-act-view-fg: #93C5FD;
        --m-act-edit-bg: rgba(242, 140, 40, .14);
        --m-act-edit-fg: #F6A94F;
        --m-act-tog-bg: rgba(148, 163, 184, .14);
        --m-act-tog-fg: #CBD5E1;
        --m-shadow: 0 14px 40px rgba(0, 8, 20, .45);
        --m-number: #F8FAFC;
        color-scheme: dark;
    }

    /* ---------- CARD ---------- */
    .mitra-page .m-card {
        position: relative;
        background: var(--m-card);
        border: 1px solid var(--m-border);
        border-radius: 24px;
        box-shadow: var(--m-shadow);
        backdrop-filter: blur(6px);
        -webkit-backdrop-filter: blur(6px);
        overflow: hidden;
    }
    .mitra-page .m-card-accent::before {
        content: "";
        position: absolute;
        left: 0; right: 0; top: 0;
        height: 3px;
        background: linear-gradient(90deg, #F28C28 0%, rgba(242, 140, 40, 0) 70%);
    }
    .mitra-page .m-divider { border-color: var(--m-border-soft); }

    /* ---------- TEKS ---------- */
    .mitra-page .m-eyebrow {
        font-size: 10px; font-weight: 700; letter-spacing: .25em; text-transform: uppercase;
        color: #F28C28;
    }
    .mitra-page .m-title { color: var(--m-text); }
    .mitra-page .m-sub { color: var(--m-text-2); }
    .mitra-page .m-muted { color: var(--m-muted); }
    .mitra-page .m-label {
        display: block; margin-bottom: 8px;
        font-size: 11px; font-weight: 700; letter-spacing: .12em; text-transform: uppercase;
        color: var(--m-text-2);
    }
    .mitra-page .m-number { color: var(--m-number); }
    .mitra-page .m-number-accent { color: #F28C28; }

    /* ---------- ICON ---------- */
    .mitra-page .mi { width: 1.25rem; height: 1.25rem; flex-shrink: 0; fill: none; stroke: currentColor; stroke-width: 1.8; stroke-linecap: round; stroke-linejoin: round; }
    .mitra-page .mi-sm { width: 1rem; height: 1rem; }
    .mitra-page .mi-lg { width: 1.5rem; height: 1.5rem; }
    .mitra-page .m-icon-box {
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        border-radius: 16px;
        background: var(--m-chip-bg); color: var(--m-chip-fg);
    }
    .mitra-page .m-icon-box.accent { background: var(--m-accent-bg); color: var(--m-accent-fg); }
    .mitra-page .m-icon-box.ok { background: var(--m-ok-bg); color: var(--m-ok-fg); }
    .mitra-page .m-icon-box.solid { background: #123F7A; color: #fff; }

    /* ---------- TOMBOL ---------- */
    .mitra-page .m-btn {
        display: inline-flex; align-items: center; justify-content: center; gap: 8px;
        border-radius: 14px; padding: 10px 20px;
        font-size: 14px; font-weight: 700; line-height: 1.2;
        transition: transform .18s ease, background-color .18s ease, box-shadow .18s ease, border-color .18s ease;
        cursor: pointer; text-decoration: none;
    }
    .mitra-page .m-btn-primary { background: #123F7A; color: #fff; box-shadow: 0 6px 16px rgba(18, 63, 122, .25); border: 1px solid transparent; }
    .mitra-page .m-btn-primary:hover { background: #0d3263; transform: translateY(-1px); }
    .mitra-page[data-m-theme="dark"] .m-btn-primary { background: #1B5199; }
    .mitra-page[data-m-theme="dark"] .m-btn-primary:hover { background: #2160B3; }
    .mitra-page .m-btn-accent { background: #F28C28; color: #fff; box-shadow: 0 8px 20px rgba(242, 140, 40, .32); border: 1px solid transparent; border-radius: 999px; padding: 12px 24px; }
    .mitra-page .m-btn-accent:hover { background: #DE7A18; transform: translateY(-2px); }
    .mitra-page .m-btn-ghost { background: var(--m-btn-ghost-bg); color: var(--m-text-2); border: 1px solid var(--m-border); }
    .mitra-page .m-btn-ghost:hover { background: var(--m-btn-ghost-hover); color: var(--m-text); }

    /* ---------- INPUT / SELECT ---------- */
    .mitra-page .m-input {
        width: 100%;
        border-radius: 16px;
        border: 1px solid var(--m-input-border) !important;
        background: var(--m-input-bg) !important;
        color: var(--m-text) !important;
        padding: 13px 16px;
        font-size: 14px;
        outline: none;
        transition: border-color .18s ease, box-shadow .18s ease, background-color .18s ease;
    }
    .mitra-page .m-input::placeholder { color: var(--m-muted); }
    .mitra-page .m-input:focus { border-color: #F28C28; box-shadow: 0 0 0 4px var(--m-focus-ring); }
    .mitra-page .m-input.has-icon { padding-left: 44px; }
    .mitra-page .m-input option { background: var(--m-input-bg); color: var(--m-text); }
    .mitra-page .m-input-icon { position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--m-muted); pointer-events: none; }

    /* ---------- KPI ---------- */
    .mitra-page .m-kpi { padding: 22px 24px; transition: transform .2s ease, border-color .2s ease; }
    .mitra-page .m-kpi:hover { transform: translateY(-3px); border-color: rgba(242, 140, 40, .55); }
    .mitra-page .m-kpi-glow {
        position: absolute; right: -34px; top: -34px; width: 120px; height: 120px; border-radius: 999px;
        background: var(--m-chip-bg); opacity: .65; pointer-events: none;
    }
    .mitra-page .m-kpi-glow.accent { background: var(--m-accent-bg); }
    .mitra-page .m-kpi-glow.ok { background: var(--m-ok-bg); }

    /* ---------- TABEL ---------- */
    .mitra-page .m-table { width: 100%; font-size: 14px; border-collapse: collapse; }
    .mitra-page .m-table thead tr { background: var(--m-head-bg); border-bottom: 1px solid var(--m-border); }
    .mitra-page .m-table th {
        padding: 16px 24px; text-align: left; white-space: nowrap;
        font-size: 10px; font-weight: 700; letter-spacing: .14em; text-transform: uppercase;
        color: var(--m-text-2);
    }
    .mitra-page .m-table th.right { text-align: right; }
    .mitra-page .m-table tbody tr { border-bottom: 1px solid var(--m-border-soft); transition: background-color .15s ease; }
    .mitra-page .m-table tbody tr:last-child { border-bottom: 0; }
    .mitra-page .m-table tbody tr:hover { background: var(--m-hover); }
    .mitra-page .m-table td { padding: 16px 24px; vertical-align: middle; color: var(--m-text-2); }
    .mitra-page .m-table td.strong { color: var(--m-text); font-weight: 600; }

    .mitra-page .m-code {
        display: inline-flex; border-radius: 10px; padding: 6px 12px;
        font-size: 12px; font-weight: 700; letter-spacing: .02em;
        background: var(--m-chip-bg); color: var(--m-chip-fg);
    }

    /* ---------- BADGE STATUS ---------- */
    .mitra-page .m-badge {
        display: inline-flex; align-items: center; gap: 8px;
        border-radius: 999px; padding: 5px 12px;
        font-size: 12px; font-weight: 600;
    }
    .mitra-page .m-badge .dot { width: 7px; height: 7px; border-radius: 999px; background: currentColor; }
    .mitra-page .m-badge.on { background: var(--m-ok-bg); color: var(--m-ok-fg); }
    .mitra-page .m-badge.off { background: var(--m-off-bg); color: var(--m-off-fg); }

    /* ---------- TOMBOL AKSI ---------- */
    .mitra-page .m-act {
        display: inline-flex; align-items: center; justify-content: center;
        width: 36px; height: 36px; border-radius: 12px; border: 0; cursor: pointer;
        transition: transform .15s ease, filter .15s ease;
    }
    .mitra-page .m-act:hover { transform: translateY(-1px); filter: brightness(.96); }
    .mitra-page[data-m-theme="dark"] .m-act:hover { filter: brightness(1.25); }
    .mitra-page .m-act.view { background: var(--m-act-view-bg); color: var(--m-act-view-fg); }
    .mitra-page .m-act.edit { background: var(--m-act-edit-bg); color: var(--m-act-edit-fg); }
    .mitra-page .m-act.tog  { background: var(--m-act-tog-bg);  color: var(--m-act-tog-fg); }

    /* ---------- PAGINATION (override tampilan bawaan Laravel) ---------- */
    .mitra-page .m-pagination nav { color: var(--m-text-2); }
    .mitra-page .m-pagination p,
    .mitra-page .m-pagination span,
    .mitra-page .m-pagination .text-gray-700,
    .mitra-page .m-pagination .text-gray-500 { color: var(--m-text-2) !important; }
    .mitra-page .m-pagination a,
    .mitra-page .m-pagination span[aria-current="page"] > span,
    .mitra-page .m-pagination span[aria-disabled="true"] > span,
    .mitra-page .m-pagination button {
        background-color: var(--m-btn-ghost-bg) !important;
        border-color: var(--m-border) !important;
        color: var(--m-text-2) !important;
    }
    .mitra-page .m-pagination a:hover { background-color: var(--m-btn-ghost-hover) !important; color: var(--m-text) !important; }
    .mitra-page .m-pagination span[aria-current="page"] > span {
        background-color: #123F7A !important; border-color: #123F7A !important; color: #fff !important;
    }
    .mitra-page .m-pagination .shadow-sm { box-shadow: none !important; }
    .mitra-page .m-pagination svg { color: currentColor; }

    @media (max-width: 640px) {
        .mitra-page .m-table th, .mitra-page .m-table td { padding: 14px 16px; }
    }

    /* =========================================================
       POPUP NOTIFIKASI
    ========================================================== */
    .mitra-alert-overlay {
        position: fixed;
        inset: 0;
        z-index: 99999;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        background: rgba(15, 23, 42, .52);
        backdrop-filter: blur(7px);
        -webkit-backdrop-filter: blur(7px);
    }

    .mitra-alert-card {
        width: min(380px, calc(100vw - 40px));
        padding: 30px 28px 26px;
        text-align: center;
        background: #fff;
        border-radius: 22px;
        box-shadow: 0 28px 80px rgba(15, 23, 42, .28);
        animation: mitraAlertPop .22s ease-out;
    }

    .mitra-alert-icon {
        width: 64px;
        height: 64px;
        margin: 0 auto 17px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .mitra-alert-icon.success {
        color: #16a34a;
        background: #dcfce7;
    }

    .mitra-alert-icon.error {
        color: #dc2626;
        background: #fee2e2;
    }

    .mitra-alert-icon svg {
        width: 31px;
        height: 31px;
        fill: none;
        stroke: currentColor;
        stroke-width: 2.7;
        stroke-linecap: round;
        stroke-linejoin: round;
    }

    .mitra-alert-title {
        margin: 0;
        color: #172033;
        font-size: 21px;
        font-weight: 750;
    }

    .mitra-alert-message {
        margin: 8px auto 22px;
        max-width: 310px;
        color: #64748b;
        font-size: 13.5px;
        line-height: 1.55;
    }

    .mitra-alert-button {
        width: 100%;
        min-height: 44px;
        border: 0;
        border-radius: 11px;
        background: #f28c28;
        color: #fff;
        font-size: 13.5px;
        font-weight: 700;
        cursor: pointer;
        transition: .2s ease;
    }

    .mitra-alert-button:hover {
        background: #df7614;
        transform: translateY(-1px);
    }

    /* Dark mode popup */
    .mitra-page[data-m-theme="dark"] ~ .mitra-alert-overlay .mitra-alert-card,
    html.dark-theme .mitra-alert-card,
    html.dark .mitra-alert-card,
    body.dark .mitra-alert-card {
        background: #172033;
    }

    html.dark-theme .mitra-alert-title,
    html.dark .mitra-alert-title,
    body.dark .mitra-alert-title {
        color: #f8fafc;
    }

    html.dark-theme .mitra-alert-message,
    html.dark .mitra-alert-message,
    body.dark .mitra-alert-message {
        color: #aab5c7;
    }

    @keyframes mitraAlertPop {
        from {
            opacity: 0;
            transform: translateY(8px) scale(.96);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    /* =========================================================
       MODAL KONFIRMASI HAPUS
    ========================================================== */
    /* ---------- MODAL KONFIRMASI AKTIF / NONAKTIF ---------- */
    .mitra-toggle-overlay {
        position: fixed; inset: 0; z-index: 99999;
        display: none; align-items: center; justify-content: center;
        padding: 20px; background: rgba(5,18,35,.62);
        backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px);
    }
    .mitra-toggle-overlay.show { display: flex; animation: mitraToggleFade .18s ease-out; }
    .mitra-toggle-card {
        position: relative; width: min(430px, calc(100vw - 40px));
        padding: 30px; border: 1px solid #E2E8F0; border-radius: 24px;
        background: #fff; text-align: center;
        box-shadow: 0 30px 90px rgba(0,0,0,.28);
        animation: mitraTogglePop .22s ease-out;
    }
    .mitra-toggle-close {
        position: absolute; top: 14px; right: 14px; width: 34px; height: 34px;
        display: flex; align-items: center; justify-content: center;
        border: 0; border-radius: 10px; background: #F1F5F9; color: #64748B; cursor: pointer;
    }
    .mitra-toggle-close:hover { background: #E2E8F0; color: #0F172A; }
    .mitra-toggle-close svg {
        width: 17px; height: 17px; fill: none; stroke: currentColor;
        stroke-width: 2; stroke-linecap: round;
    }
    .mitra-toggle-icon {
        width: 68px; height: 68px; margin: 4px auto 18px;
        display: flex; align-items: center; justify-content: center;
        border-radius: 50%; background: #FFF3E3; color: #D97706;
    }
    .mitra-toggle-icon.deactivate { background: #FEE2E2; color: #DC2626; }
    .mitra-toggle-icon svg {
        width: 32px; height: 32px; fill: none; stroke: currentColor;
        stroke-width: 1.9; stroke-linecap: round; stroke-linejoin: round;
    }
    .mitra-toggle-title { margin: 0; color: #172033; font-size: 21px; font-weight: 800; }
    .mitra-toggle-message {
        margin: 10px auto 24px; max-width: 350px; color: #64748B;
        font-size: 13.5px; line-height: 1.6;
    }
    .mitra-toggle-message strong { color: #172033; font-weight: 750; }
    .mitra-toggle-actions { display: flex; gap: 10px; }
    .mitra-toggle-cancel, .mitra-toggle-confirm {
        flex: 1; min-height: 44px; border: 0; border-radius: 11px;
        font-size: 13px; font-weight: 750; cursor: pointer; transition: .18s ease;
    }
    .mitra-toggle-cancel { background: #F1F5F9; color: #475569; }
    .mitra-toggle-cancel:hover { background: #E2E8F0; }
    .mitra-toggle-confirm {
        display: inline-flex; align-items: center; justify-content: center; gap: 7px;
        background: #123F7A; color: #fff; box-shadow: 0 8px 20px rgba(18,63,122,.20);
    }
    .mitra-toggle-confirm.deactivate { background: #DC2626; box-shadow: 0 8px 20px rgba(220,38,38,.20); }
    .mitra-toggle-confirm:hover { background: #0D3263; transform: translateY(-1px); }
    .mitra-toggle-confirm.deactivate:hover { background: #B91C1C; }
    html.dark-theme .mitra-toggle-card, html.dark .mitra-toggle-card, body.dark .mitra-toggle-card {
        background: #142238; border-color: #263B55;
    }
    html.dark-theme .mitra-toggle-title, html.dark .mitra-toggle-title, body.dark .mitra-toggle-title { color: #F8FAFC; }
    html.dark-theme .mitra-toggle-message, html.dark .mitra-toggle-message, body.dark .mitra-toggle-message { color: #AAB5C7; }
    html.dark-theme .mitra-toggle-message strong, html.dark .mitra-toggle-message strong, body.dark .mitra-toggle-message strong { color: #F8FAFC; }
    html.dark-theme .mitra-toggle-cancel, html.dark .mitra-toggle-cancel, body.dark .mitra-toggle-cancel {
        background: #24364F; color: #DBEAFE;
    }
    @keyframes mitraToggleFade { from { opacity: 0; } to { opacity: 1; } }
    @keyframes mitraTogglePop {
        from { opacity: 0; transform: translateY(10px) scale(.94); }
        to { opacity: 1; transform: translateY(0) scale(1); }
    }

    .mitra-delete-overlay {
        position: fixed;
        inset: 0;
        z-index: 99998;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
        background: rgba(5, 18, 35, .62);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
    }

    .mitra-delete-overlay.show {
        display: flex;
        animation: mitraDeleteFade .18s ease-out;
    }

    .mitra-delete-card {
        position: relative;
        width: min(430px, calc(100vw - 40px));
        padding: 30px;
        border: 1px solid #E2E8F0;
        border-radius: 24px;
        background: #FFFFFF;
        text-align: center;
        box-shadow: 0 30px 90px rgba(0, 0, 0, .28);
        animation: mitraDeletePop .22s ease-out;
    }

    .mitra-delete-close {
        position: absolute;
        top: 14px;
        right: 14px;
        width: 34px;
        height: 34px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 0;
        border-radius: 10px;
        background: #F1F5F9;
        color: #64748B;
        cursor: pointer;
    }

    .mitra-delete-close:hover {
        background: #E2E8F0;
        color: #0F172A;
    }

    .mitra-delete-close svg {
        width: 17px;
        height: 17px;
        fill: none;
        stroke: currentColor;
        stroke-width: 2;
        stroke-linecap: round;
    }

    .mitra-delete-icon {
        width: 68px;
        height: 68px;
        margin: 4px auto 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: #FEE2E2;
        color: #DC2626;
    }

    .mitra-delete-icon svg {
        width: 32px;
        height: 32px;
        fill: none;
        stroke: currentColor;
        stroke-width: 1.9;
        stroke-linecap: round;
        stroke-linejoin: round;
    }

    .mitra-delete-title {
        margin: 0;
        color: #172033;
        font-size: 21px;
        font-weight: 800;
    }

    .mitra-delete-message {
        margin: 10px auto 0;
        max-width: 340px;
        color: #64748B;
        font-size: 13.5px;
        line-height: 1.6;
    }

    .mitra-delete-message strong {
        color: #172033;
        font-weight: 750;
    }

    .mitra-delete-warning {
        margin: 10px 0 24px;
        color: #DC2626;
        font-size: 11.5px;
        font-weight: 600;
    }

    .mitra-delete-actions {
        display: flex;
        gap: 10px;
    }

    .mitra-delete-cancel,
    .mitra-delete-confirm {
        flex: 1;
        min-height: 44px;
        border: 0;
        border-radius: 11px;
        font-size: 13px;
        font-weight: 750;
        cursor: pointer;
        transition: .18s ease;
    }

    .mitra-delete-cancel {
        background: #F1F5F9;
        color: #475569;
    }

    .mitra-delete-cancel:hover {
        background: #E2E8F0;
    }

    .mitra-delete-confirm {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        background: #DC2626;
        color: #fff;
        box-shadow: 0 8px 20px rgba(220, 38, 38, .20);
    }

    .mitra-delete-confirm:hover {
        background: #B91C1C;
        transform: translateY(-1px);
    }

    .mitra-delete-confirm svg {
        width: 16px;
        height: 16px;
        fill: none;
        stroke: currentColor;
        stroke-width: 2;
        stroke-linecap: round;
        stroke-linejoin: round;
    }

    html.dark-theme .mitra-delete-card,
    html.dark .mitra-delete-card,
    body.dark .mitra-delete-card {
        background: #142238;
        border-color: #263B55;
    }

    html.dark-theme .mitra-delete-title,
    html.dark .mitra-delete-title,
    body.dark .mitra-delete-title {
        color: #F8FAFC;
    }

    html.dark-theme .mitra-delete-message,
    html.dark .mitra-delete-message,
    body.dark .mitra-delete-message {
        color: #AAB5C7;
    }

    html.dark-theme .mitra-delete-message strong,
    html.dark .mitra-delete-message strong,
    body.dark .mitra-delete-message strong {
        color: #F8FAFC;
    }

    html.dark-theme .mitra-delete-cancel,
    html.dark .mitra-delete-cancel,
    body.dark .mitra-delete-cancel {
        background: #24364F;
        color: #DBEAFE;
    }

    @keyframes mitraDeleteFade {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes mitraDeletePop {
        from {
            opacity: 0;
            transform: translateY(10px) scale(.94);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

</style>

<div class="mitra-page space-y-6 pb-12">

    {{-- =========================================================
         HERO / JUDUL
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
                        Mitra
                    </span>
                </h1>

                <p class="mt-4 max-w-2xl text-sm leading-6 text-white/85 sm:text-base">
                    Kelola data mitra pengolahan BA Rampung dengan mudah dan terstruktur.
                </p>

            </div>

            {{-- kanan --}}
            <div class="flex shrink-0 flex-col items-start gap-3 sm:items-end">

                <div
                    class="hidden rounded-[18px] border border-white/15 px-5 py-3 text-white sm:block"
                    style="
                        background:rgba(8,35,68,.42);
                        backdrop-filter:blur(12px);
                    "
                >
                    <p class="text-[10px] font-bold uppercase tracking-[0.20em] text-white/60">
                        STATUS DATA
                    </p>

                    <div class="mt-1 flex items-center gap-2 text-sm font-semibold">
                        <span class="h-2.5 w-2.5 rounded-full bg-emerald-400"></span>
                        Data mitra aktif
                    </div>
                </div>

                @role('admin_kantor', 'admin_gudang', 'admin_sistem')
                    <a
                        href="{{ route('mitra.create') }}"
                        class="m-btn m-btn-accent"
                    >
                        <svg class="mi mi-sm" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M12 4.5v15m7.5-7.5h-15"/>
                        </svg>
                        Tambah Mitra
                    </a>
                @endrole

            </div>

        </div>

    </section>


    {{-- =========================================================
         KPI
    ========================================================== --}}
    <section class="grid grid-cols-1 gap-4 md:grid-cols-2">

        {{-- TOTAL MITRA --}}
        <div class="m-card m-kpi">

            <div class="m-kpi-glow"></div>

            <div class="relative flex items-center justify-between gap-4">

                <div>
                    <p class="text-[10px] font-bold uppercase tracking-[0.18em] m-sub">
                        Total Mitra
                    </p>

                    <p class="dashboard-display m-number mt-2 text-4xl">
                        {{ number_format($mitras->total()) }}
                    </p>

                    <p class="m-muted mt-1 text-xs">
                        Mitra pengolahan terdaftar
                    </p>
                </div>

                <div class="m-icon-box h-14 w-14">
                    <svg class="mi mi-lg" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/>
                    </svg>
                </div>

            </div>

        </div>


        {{-- DATA DITAMPILKAN --}}
        <div class="m-card m-kpi">

            <div class="m-kpi-glow ok"></div>

            <div class="relative flex items-center justify-between gap-4">

                <div>
                    <p class="text-[10px] font-bold uppercase tracking-[0.18em] m-sub">
                        Data Ditampilkan
                    </p>

                    <p class="dashboard-display m-number mt-2 text-4xl">
                        {{ number_format($mitras->count()) }}
                    </p>

                    <p class="m-muted mt-1 text-xs">
                        Data pada halaman ini
                    </p>
                </div>

                <div class="m-icon-box ok h-14 w-14">
                    <svg class="mi mi-lg" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                </div>

            </div>

        </div>


    </section>


    {{-- =========================================================
         FILTER
    ========================================================== --}}
    <section class="m-card m-card-accent">

        <form
            method="GET"
            action="{{ route('mitra.index') }}"
        >

            {{-- HEADER FILTER --}}
            <div class="m-divider flex flex-col gap-4 border-b px-6 py-5 sm:flex-row sm:items-center sm:justify-between">

                <div class="flex items-center gap-4">

                    <div class="m-icon-box solid h-11 w-11">
                        <svg class="mi" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>
                        </svg>
                    </div>

                    <div>

                        <p class="m-eyebrow">
                            FILTER DATA
                        </p>

                        <h2 class="m-title mt-1 text-xl font-bold">
                            Cari Mitra
                        </h2>

                        <p class="m-muted mt-0.5 text-xs">
                            Cari dan saring data mitra pengolahan dengan lebih cepat.
                        </p>

                    </div>

                </div>


                <div class="flex items-center gap-2">

                    @if(request('search'))

                        <a
                            href="{{ route('mitra.index') }}"
                            class="m-btn m-btn-ghost"
                        >
                            <svg class="mi mi-sm" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99"/>
                            </svg>
                            Reset
                        </a>

                    @endif

                    <button
                        type="submit"
                        class="m-btn m-btn-primary"
                    >
                        <svg class="mi mi-sm" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>
                        </svg>
                        Cari
                    </button>

                </div>

            </div>


            {{-- FORM FILTER --}}
            <div class="grid grid-cols-1 gap-5 px-6 py-6 md:grid-cols-2">

                {{-- PENCARIAN --}}
                <div>

                    <label class="m-label">
                        Pencarian
                    </label>

                    <div class="relative">

                        <span class="m-input-icon">
                            <svg class="mi mi-sm" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>
                            </svg>
                        </span>

                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Cari nama mitra atau kode mitra..."
                            class="m-input has-icon"
                        >

                    </div>

                </div>


            </div>

        </form>

    </section>


    {{-- =========================================================
         DATA MITRA
    ========================================================== --}}
    <section class="m-card m-card-accent">

        {{-- HEADER DATA --}}
        <div class="m-divider flex flex-col gap-4 border-b px-6 py-5 sm:flex-row sm:items-center sm:justify-between">

            <div class="flex items-center gap-4">

                <div class="m-icon-box h-11 w-11">
                    <svg class="mi" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/>
                    </svg>
                </div>

                <div>

                    <p class="m-eyebrow">
                        MASTER DATA
                    </p>

                    <h2 class="m-title mt-1 text-xl font-bold">
                        Data Mitra
                    </h2>

                    <p class="m-muted mt-0.5 text-xs">
                        Menampilkan
                        {{ $mitras->firstItem() ?? 0 }}
                        –
                        {{ $mitras->lastItem() ?? 0 }}
                        dari
                        {{ $mitras->total() }}
                        data mitra.
                    </p>

                </div>

            </div>


            <div
                class="rounded-full px-4 py-2 text-xs font-semibold"
                style="background:var(--m-chip-bg); color:var(--m-chip-fg);"
            >
                {{ number_format($mitras->total()) }} Mitra
            </div>

        </div>


        {{-- TABLE --}}
        <div class="overflow-x-auto">

            <table class="m-table min-w-[1100px]">

                <thead>

                    <tr>

                        <th>No.</th>
                        <th>Kode Mitra</th>
                        <th>Nama Mitra</th>
                        <th>Alamat</th>
                        <th>Kontak</th>
                        <th>Status</th>
                        <th class="right">Aksi</th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($mitras as $i => $m)

                        <tr>

                            {{-- NO --}}
                            <td class="m-muted">
                                {{ $mitras->firstItem() + $i }}
                            </td>


                            {{-- KODE --}}
                            <td>
                                <span class="m-code">
                                    {{ $m->kode_mitra }}
                                </span>
                            </td>


                            {{-- NAMA --}}
                            <td class="strong">
                                {{ $m->nama_mitra }}
                            </td>


                            {{-- ALAMAT --}}
                            <td class="max-w-[320px]">
                                {{ $m->alamat ?? '-' }}
                            </td>


                            {{-- KONTAK --}}
                            <td>
                                {{ $m->nomor_telepon ?? '-' }}
                            </td>


                            {{-- STATUS --}}
                            <td>

                                <span class="m-badge {{ $m->status === 'aktif' ? 'on' : 'off' }}">
                                    <span class="dot"></span>
                                    {{ ucfirst($m->status) }}
                                </span>

                            </td>


                            {{-- AKSI --}}
                            <td>

                                <div class="flex justify-end gap-2">

                                    {{-- DETAIL --}}
                                    <a
                                        href="{{ route('mitra.show', $m) }}"
                                        title="Detail"
                                        class="m-act view"
                                    >
                                        <svg class="mi mi-sm" viewBox="0 0 24 24" aria-hidden="true">
                                            <path d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/>
                                            <path d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                        </svg>
                                    </a>


                                    @role('admin_kantor', 'admin_gudang', 'admin_sistem')

                                        {{-- EDIT --}}
                                        <a
                                            href="{{ route('mitra.edit', $m) }}"
                                            title="Edit"
                                            class="m-act edit"
                                        >
                                            <svg class="mi mi-sm" viewBox="0 0 24 24" aria-hidden="true">
                                                <path d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10"/>
                                            </svg>
                                        </a>


                                        {{-- TOGGLE STATUS --}}
                                        <form
                                            method="POST"
                                            action="{{ route('mitra.toggle-status', $m) }}"
                                            class="mitra-toggle-form inline"
                                        >

                                            @csrf
                                            @method('PATCH')

                                            <button
                                                type="button"
                                                title="{{ $m->status === 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }}"
                                                class="m-act tog"
                                                onclick="openMitraToggleModal(this)"
                                            >
                                                @if($m->status === 'aktif')
                                                    <svg class="mi mi-sm" viewBox="0 0 24 24" aria-hidden="true">
                                                        <path d="M15.75 5.25v13.5m-7.5-13.5v13.5"/>
                                                    </svg>
                                                @else
                                                    <svg class="mi mi-sm" viewBox="0 0 24 24" aria-hidden="true">
                                                        <path d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.347a1.125 1.125 0 0 1 0 1.972l-11.54 6.347a1.125 1.125 0 0 1-1.667-.986V5.653Z"/>
                                                    </svg>
                                                @endif
                                            </button>

                                        </form>

                                        {{-- HAPUS --}}
                                        <form
                                            method="POST"
                                            action="{{ route('mitra.destroy', $m) }}"
                                            class="mitra-delete-form inline"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="button"
                                                title="Hapus"
                                                class="m-act delete"
                                                onclick="openMitraDeleteModal(this)"
                                            >
                                                <svg class="mi mi-sm" viewBox="0 0 24 24" aria-hidden="true">
                                                    <path d="M3 6h18"/>
                                                    <path d="M8 6V4.5A1.5 1.5 0 0 1 9.5 3h5A1.5 1.5 0 0 1 16 4.5V6"/>
                                                    <path d="M19 6l-1 14H6L5 6"/>
                                                    <path d="M10 11v5"/>
                                                    <path d="M14 11v5"/>
                                                </svg>
                                            </button>
                                        </form>

                                    @endrole

                                </div>

                            </td>

                        </tr>


                    @empty

                        <tr>

                            <td
                                colspan="7"
                                class="px-6 py-20 text-center"
                            >

                                <div class="flex flex-col items-center">

                                    <div class="m-icon-box mb-4 h-16 w-16">
                                        <svg class="mi mi-lg" viewBox="0 0 24 24" aria-hidden="true">
                                            <path d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/>
                                        </svg>
                                    </div>

                                    <p class="m-title font-semibold">
                                        Belum ada data Mitra Pengolahan.
                                    </p>

                                    <p class="m-muted mt-1 text-sm">
                                        Data mitra akan tampil di sini.
                                    </p>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- PAGINATION --}}
        @if($mitras->hasPages())

            <div class="m-divider m-pagination border-t px-6 py-5">
                {{ $mitras->links() }}
            </div>

        @endif

    </section>

</div>


{{-- =========================================================
     MODAL KONFIRMASI HAPUS
========================================================== --}}
<div id="mitra-toggle-modal" class="mitra-toggle-overlay" aria-hidden="true">
    <div class="mitra-toggle-card" role="dialog" aria-modal="true" aria-labelledby="mitra-toggle-title">
        <button type="button" class="mitra-toggle-close" onclick="closeMitraToggleModal()" aria-label="Tutup">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6 6l12 12M18 6 6 18"></path></svg>
        </button>

        <div id="mitra-toggle-icon" class="mitra-toggle-icon">
            <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M15.75 5.25v13.5m-7.5-13.5v13.5"/>
            </svg>
        </div>

        <h3 id="mitra-toggle-title" class="mitra-toggle-title">Nonaktifkan Mitra?</h3>

        <p class="mitra-toggle-message">
            Apakah Anda yakin ingin <span id="mitra-toggle-action">menonaktifkan</span>
            mitra <strong id="mitra-toggle-name"></strong>?
        </p>

        <div class="mitra-toggle-actions">
            <button type="button" class="mitra-toggle-cancel" onclick="closeMitraToggleModal()">Batal</button>
            <button type="button" id="mitra-toggle-confirm" class="mitra-toggle-confirm" onclick="confirmMitraToggle()">
                Ya, Nonaktifkan
            </button>
        </div>
    </div>
</div>

<div id="mitra-delete-modal" class="mitra-delete-overlay" aria-hidden="true">
    <div
        class="mitra-delete-card"
        role="dialog"
        aria-modal="true"
        aria-labelledby="mitra-delete-title"
    >
        <button
            type="button"
            class="mitra-delete-close"
            onclick="closeMitraDeleteModal()"
            aria-label="Tutup"
        >
            <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M6 6l12 12M18 6 6 18"></path>
            </svg>
        </button>

        <div class="mitra-delete-icon">
            <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M12 9v4"></path>
                <path d="M12 17h.01"></path>
                <path d="M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0Z"></path>
            </svg>
        </div>

        <h3 id="mitra-delete-title" class="mitra-delete-title">
            Hapus Mitra?
        </h3>

        <p class="mitra-delete-message">
            Apakah Anda yakin ingin menghapus mitra
            <strong id="mitra-delete-name"></strong>?
        </p>

        <p class="mitra-delete-warning">
            Data yang sudah dihapus tidak dapat dikembalikan.
        </p>

        <div class="mitra-delete-actions">
            <button
                type="button"
                class="mitra-delete-cancel"
                onclick="closeMitraDeleteModal()"
            >
                Batal
            </button>

            <button
                type="button"
                class="mitra-delete-confirm"
                onclick="confirmMitraDelete()"
            >
                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M3 6h18"></path>
                    <path d="M8 6V4.5A1.5 1.5 0 0 1 9.5 3h5A1.5 1.5 0 0 1 16 4.5V6"></path>
                    <path d="M19 6l-1 14H6L5 6"></path>
                    <path d="M10 11v5"></path>
                    <path d="M14 11v5"></path>
                </svg>
                Ya, Hapus
            </button>
        </div>
    </div>
</div>

<script>
    let mitraToggleForm = null;

    function openMitraToggleModal(button) {
        mitraToggleForm = button.closest('.mitra-toggle-form');
        if (!mitraToggleForm) return;

        const row = button.closest('tr');
        const nameCell = row ? row.querySelector('td:nth-child(3)') : null;
        const name = nameCell ? nameCell.textContent.trim() : 'Mitra Pengolahan';
        const isActive = button.title === 'Nonaktifkan';

        const modal = document.getElementById('mitra-toggle-modal');
        const nameEl = document.getElementById('mitra-toggle-name');
        const titleEl = document.getElementById('mitra-toggle-title');
        const actionEl = document.getElementById('mitra-toggle-action');
        const confirmBtn = document.getElementById('mitra-toggle-confirm');
        const icon = document.getElementById('mitra-toggle-icon');

        nameEl.textContent = name;

        if (isActive) {
            titleEl.textContent = 'Nonaktifkan Mitra?';
            actionEl.textContent = 'menonaktifkan';
            confirmBtn.textContent = 'Ya, Nonaktifkan';
            confirmBtn.classList.add('deactivate');
            icon.classList.add('deactivate');
            icon.innerHTML = '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M15.75 5.25v13.5m-7.5-13.5v13.5"/></svg>';
        } else {
            titleEl.textContent = 'Aktifkan Mitra?';
            actionEl.textContent = 'mengaktifkan';
            confirmBtn.textContent = 'Ya, Aktifkan';
            confirmBtn.classList.remove('deactivate');
            icon.classList.remove('deactivate');
            icon.innerHTML = '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.347a1.125 1.125 0 0 1 0 1.972l-11.54 6.347a1.125 1.125 0 0 1-1.667-.986V5.653Z"/></svg>';
        }

        modal.classList.add('show');
        modal.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
    }

    function closeMitraToggleModal() {
        const modal = document.getElementById('mitra-toggle-modal');
        if (modal) {
            modal.classList.remove('show');
            modal.setAttribute('aria-hidden', 'true');
        }
        document.body.style.overflow = '';
        mitraToggleForm = null;
    }

    function confirmMitraToggle() {
        if (!mitraToggleForm) return;
        mitraToggleForm.submit();
    }

    let mitraDeleteForm = null;

    function closeMitraAlert() {
        const alert = document.getElementById('mitra-alert');
        if (alert) alert.remove();
    }

    function openMitraDeleteModal(button) {
        mitraDeleteForm = button.closest('.mitra-delete-form');
        if (!mitraDeleteForm) return;

        const row = button.closest('tr');
        const nameCell = row ? row.querySelector('td:nth-child(3)') : null;
        const name = nameCell
            ? nameCell.textContent.trim()
            : 'Mitra Pengolahan';

        const nameElement = document.getElementById('mitra-delete-name');
        const modal = document.getElementById('mitra-delete-modal');

        if (nameElement) nameElement.textContent = name;

        if (modal) {
            modal.classList.add('show');
            modal.setAttribute('aria-hidden', 'false');
        }

        document.body.style.overflow = 'hidden';
    }

    function closeMitraDeleteModal() {
        const modal = document.getElementById('mitra-delete-modal');

        if (modal) {
            modal.classList.remove('show');
            modal.setAttribute('aria-hidden', 'true');
        }

        document.body.style.overflow = '';
        mitraDeleteForm = null;
    }

    function confirmMitraDelete() {
        if (!mitraDeleteForm) return;
        mitraDeleteForm.submit();
    }

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            closeMitraToggleModal();
            closeMitraDeleteModal();
            closeMitraAlert();
        }
    });

    document.getElementById('mitra-toggle-modal')?.addEventListener('click', function (event) {
        if (event.target === this) {
            closeMitraToggleModal();
        }
    });

    document.getElementById('mitra-delete-modal')?.addEventListener('click', function (event) {
        if (event.target === this) {
            closeMitraDeleteModal();
        }
    });
</script>

{{-- =========================================================
     DETEKSI DARK MODE (hanya membaca status theme dari layout;
     tidak membuat toggle baru, tidak mengubah localStorage)
========================================================== --}}
<script>
    (function () {
        var page = document.querySelector('.mitra-page');
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
