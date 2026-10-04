@extends('layouts.app')

@section('title', 'Backup & Restore')

@section('content')


<style>
    /* =========================================================
       BACKUP & RESTORE — GLASS LIGHT / DARK THEME
       Tampilan saja. Backend, route, form, action, dan logic
       Blade dipertahankan.
       ========================================================= */

    .backup-restore-page {
        --br-text: #173654;
        --br-muted: #647d99;
        --br-border: rgba(29, 73, 116, .16);
        --br-card:
            linear-gradient(
                135deg,
                rgba(255,255,255,.76) 0%,
                rgba(239,244,249,.62) 52%,
                rgba(220,228,237,.50) 100%
            );
        --br-input:
            linear-gradient(
                135deg,
                rgba(255,255,255,.78),
                rgba(232,239,246,.60)
            );
    }

    .backup-restore-page .br-card {
        position: relative;
        overflow: hidden;
        border: 1px solid var(--br-border);
        border-radius: 1.25rem;
        background: var(--br-card);
        box-shadow:
            0 16px 40px rgba(18,45,78,.10),
            inset 0 1px 0 rgba(255,255,255,.45);
        backdrop-filter: blur(18px) saturate(120%);
        -webkit-backdrop-filter: blur(18px) saturate(120%);
    }

    .backup-restore-page .br-card::after {
        content: "";
        position: absolute;
        width: 260px;
        height: 150px;
        right: -100px;
        bottom: -90px;
        border-radius: 999px;
        background: radial-gradient(
            ellipse,
            rgba(255,148,24,.12) 0%,
            rgba(255,148,24,.035) 48%,
            transparent 72%
        );
        pointer-events: none;
    }

    .backup-restore-page .br-title {
        color: #153a63 !important;
        position: relative;
        z-index: 1;
    }

    .backup-restore-page .br-text {
        color: var(--br-muted) !important;
        position: relative;
        z-index: 1;
    }

    .backup-restore-page .br-text strong {
        color: #345a7f !important;
    }

    .backup-restore-page .br-action {
        position: relative;
        z-index: 1;
    }

    .backup-restore-page .br-upload {
        color: #536d88 !important;
        background: var(--br-input) !important;
        border: 1px solid rgba(45,85,123,.20) !important;
        border-radius: .85rem;
    }

    .backup-restore-page .br-upload:focus {
        outline: none;
        border-color: rgba(255,148,24,.72) !important;
        box-shadow: 0 0 0 3px rgba(255,148,24,.12);
    }

    .backup-restore-page .btn-primary {
        background: linear-gradient(135deg,#174b88,#0d3769) !important;
        border: 1px solid rgba(255,255,255,.12);
        box-shadow: 0 8px 20px rgba(13,55,105,.22);
    }

    .backup-restore-page .btn-primary:hover {
        background: linear-gradient(135deg,#205c9f,#123f78) !important;
    }

    .backup-restore-page .btn-secondary {
        background: linear-gradient(
            135deg,
            rgba(255,255,255,.74),
            rgba(232,239,246,.58)
        ) !important;
        color: #174578 !important;
        border: 1px solid rgba(31,80,128,.18) !important;
        box-shadow: 0 6px 16px rgba(18,45,78,.07);
    }

    .backup-restore-page .btn-secondary:hover {
        border-color: rgba(255,148,24,.58) !important;
        background: linear-gradient(
            135deg,
            rgba(255,255,255,.88),
            rgba(240,244,248,.70)
        ) !important;
    }

    /* =========================================================
       DARK MODE
       ========================================================= */

    /* Deteksi lokal dari halaman, sama seperti halaman lain yang
       sudah stabil: class is-dark menjadi sumber utama styling. */
    .backup-restore-page.is-dark {
        --br-text: #F8FAFC;
        --br-muted: #A9BDD1;
        --br-border: rgba(126,177,225,.20);
        --br-card: linear-gradient(135deg, rgba(8,27,49,.90) 0%, rgba(10,43,78,.84) 55%, rgba(18,58,98,.74) 100%);
        --br-input: linear-gradient(135deg, rgba(5,27,51,.92), rgba(12,45,78,.82));
    }

    .backup-restore-page.is-dark .br-card {
        background: var(--br-card) !important;
        background-color: transparent !important;
        border-color: rgba(126,177,225,.22) !important;
        box-shadow: 0 18px 48px rgba(0,8,20,.40), inset 0 1px 0 rgba(255,255,255,.055) !important;
        backdrop-filter: blur(20px) saturate(130%) !important;
        -webkit-backdrop-filter: blur(20px) saturate(130%) !important;
    }

    .backup-restore-page.is-dark .br-title {
        color: #F8FAFC !important;
    }

    .backup-restore-page.is-dark .br-text {
        color: #A9BDD1 !important;
    }

    .backup-restore-page.is-dark .br-text strong {
        color: #E2EDF8 !important;
    }

    .backup-restore-page.is-dark .br-upload {
        color: #DCE9F7 !important;
        background: var(--br-input) !important;
        background-color: transparent !important;
        border-color: rgba(133,181,225,.22) !important;
    }

    .backup-restore-page.is-dark .btn-secondary {
        color: #DCEAF8 !important;
        background: linear-gradient(135deg, rgba(18,62,105,.78), rgba(9,39,72,.74)) !important;
        border-color: rgba(126,177,225,.22) !important;
    }

    .backup-restore-page[data-m-theme="dark"] {
        --br-text: #f4f8fc;
        --br-muted: #a9bdd1;
        --br-border: rgba(143,190,232,.18);
        --br-card:
            linear-gradient(
                135deg,
                rgba(7,29,54,.88) 0%,
                rgba(10,43,78,.76) 52%,
                rgba(17,58,98,.64) 100%
            );
        --br-input:
            linear-gradient(
                135deg,
                rgba(5,27,51,.84),
                rgba(12,45,78,.72)
            );
    }

    .backup-restore-page[data-m-theme="dark"] .br-card {
        border-color: rgba(143,190,232,.18);
        box-shadow:
            0 18px 48px rgba(0,8,20,.38),
            inset 0 1px 0 rgba(255,255,255,.055);
        backdrop-filter: blur(20px) saturate(125%);
        -webkit-backdrop-filter: blur(20px) saturate(125%);
    }

    .backup-restore-page[data-m-theme="dark"] .br-title {
        color: #f2f7fc !important;
    }

    .backup-restore-page[data-m-theme="dark"] .br-text {
        color: #a9bdd1 !important;
    }

    .backup-restore-page[data-m-theme="dark"] .br-text strong {
        color: #dbe9f7 !important;
    }

    .backup-restore-page[data-m-theme="dark"] .br-upload {
        color: #dce9f7 !important;
        background: var(--br-input) !important;
        border-color: rgba(133,181,225,.20) !important;
    }

    .backup-restore-page[data-m-theme="dark"] .btn-primary {
        background: linear-gradient(135deg,#1c5a9b,#103f75) !important;
        box-shadow: 0 9px 24px rgba(0,12,30,.34);
    }

    .backup-restore-page[data-m-theme="dark"] .btn-secondary {
        color: #dceaf8 !important;
        background: linear-gradient(
            135deg,
            rgba(18,62,105,.70),
            rgba(9,39,72,.68)
        ) !important;
        border-color: rgba(126,177,225,.20) !important;
    }

    .backup-restore-page[data-m-theme="dark"] .btn-secondary:hover {
        border-color: rgba(255,148,24,.64) !important;
        background: linear-gradient(
            135deg,
            rgba(25,77,127,.76),
            rgba(12,49,86,.72)
        ) !important;
    }

    /* Icon modern menggantikan emoji */
    .backup-restore-page .br-icon {
        width: 17px;
        height: 17px;
        display: inline-block;
        vertical-align: middle;
        flex: 0 0 auto;
    }

    /* =========================================================
       OVERRIDE: DARK MODE GLOBAL SELECTORS
       Theme pada layout utama dapat menggunakan class .dark
       atau attribute data-theme/data-m-theme.
       ========================================================= */

    html.dark .backup-restore-page .br-card,
    body.dark .backup-restore-page .br-card,
    html[data-theme="dark"] .backup-restore-page .br-card,
    body[data-theme="dark"] .backup-restore-page .br-card,
    html[data-m-theme="dark"] .backup-restore-page .br-card,
    body[data-m-theme="dark"] .backup-restore-page .br-card {
        background:
            linear-gradient(
                135deg,
                rgba(7, 29, 54, .90) 0%,
                rgba(9, 43, 77, .82) 52%,
                rgba(16, 57, 96, .72) 100%
            ) !important;
        border-color: rgba(126, 177, 225, .20) !important;
        box-shadow:
            0 18px 48px rgba(0, 8, 20, .38),
            inset 0 1px 0 rgba(255,255,255,.055) !important;
        backdrop-filter: blur(20px) saturate(125%);
        -webkit-backdrop-filter: blur(20px) saturate(125%);
    }

    html.dark .backup-restore-page .br-title,
    body.dark .backup-restore-page .br-title,
    html[data-theme="dark"] .backup-restore-page .br-title,
    body[data-theme="dark"] .backup-restore-page .br-title,
    html[data-m-theme="dark"] .backup-restore-page .br-title,
    body[data-m-theme="dark"] .backup-restore-page .br-title {
        color: #f2f7fc !important;
    }

    html.dark .backup-restore-page .br-text,
    body.dark .backup-restore-page .br-text,
    html[data-theme="dark"] .backup-restore-page .br-text,
    body[data-theme="dark"] .backup-restore-page .br-text,
    html[data-m-theme="dark"] .backup-restore-page .br-text,
    body[data-m-theme="dark"] .backup-restore-page .br-text {
        color: #a9bdd1 !important;
    }

    html.dark .backup-restore-page .br-text strong,
    body.dark .backup-restore-page .br-text strong,
    html[data-theme="dark"] .backup-restore-page .br-text strong,
    body[data-theme="dark"] .backup-restore-page .br-text strong,
    html[data-m-theme="dark"] .backup-restore-page .br-text strong,
    body[data-m-theme="dark"] .backup-restore-page .br-text strong {
        color: #dbe9f7 !important;
    }

    html.dark .backup-restore-page .br-upload,
    body.dark .backup-restore-page .br-upload,
    html[data-theme="dark"] .backup-restore-page .br-upload,
    body[data-theme="dark"] .backup-restore-page .br-upload,
    html[data-m-theme="dark"] .backup-restore-page .br-upload,
    body[data-m-theme="dark"] .backup-restore-page .br-upload {
        color: #dce9f7 !important;
        background: linear-gradient(
            135deg,
            rgba(5,27,51,.88),
            rgba(12,45,78,.76)
        ) !important;
        border-color: rgba(133,181,225,.20) !important;
    }

    html.dark .backup-restore-page .btn-secondary,
    body.dark .backup-restore-page .btn-secondary,
    html[data-theme="dark"] .backup-restore-page .btn-secondary,
    body[data-theme="dark"] .backup-restore-page .btn-secondary,
    html[data-m-theme="dark"] .backup-restore-page .btn-secondary,
    body[data-m-theme="dark"] .backup-restore-page .btn-secondary {
        color: #dceaf8 !important;
        background: linear-gradient(
            135deg,
            rgba(18,62,105,.72),
            rgba(9,39,72,.70)
        ) !important;
        border-color: rgba(126,177,225,.20) !important;
    }

    /* Area halaman dibuat cukup tinggi agar footer tetap berada
       di bagian bawah viewport saat isi halaman pendek. */
    .backup-restore-page {
        min-height: calc(100vh - 250px);
        padding-bottom: 42px;
    }

    /* Jangan biarkan card backup/restore memaksa tinggi yang aneh. */
    .backup-restore-page > .grid {
        align-items: stretch;
    }

</style>

<div class="backup-restore-page" data-m-theme="{{ request()->cookie('theme', 'light') }}">

@include('pengaturan._tabs')

<div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
    <div class="card p-6 br-card">
        <h3 class="font-semibold mb-2 br-title flex items-center gap-2">
        <svg class="br-icon" viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <path d="M5 4h11l3 3v13H5V4Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
            <path d="M8 4v5h8V4M8 20v-6h8v6" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
        </svg>
        Backup Data
    </h3>
        <p class="text-sm mb-4 br-text">
            Mengunduh salinan data master (Gudang, Mitra Pengolahan, Pegawai, Pimpinan Cabang) dalam format JSON.
            Ini adalah backup logis data master, bukan dump SQL mentah — cukup untuk memulihkan data master jika hilang.
        </p>
        <a href="{{ route('pengaturan.backup.download') }}" class="btn-primary br-action inline-flex items-center gap-2">
        <svg class="br-icon" viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <path d="M12 3v11" stroke="currentColor" stroke-width="1.9" stroke-linecap="round"/>
            <path d="m7.5 10 4.5 4.5 4.5-4.5" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M5 20h14" stroke="currentColor" stroke-width="1.9" stroke-linecap="round"/>
        </svg>
        Download Backup (.json)
    </a>
    </div>

    <div class="card p-6 br-card">
        <h3 class="font-semibold mb-2 br-title flex items-center gap-2">
        <svg class="br-icon" viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <path d="M12 4v11" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
            <path d="m7.5 11 4.5 4.5 4.5-4.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M5 4h14v16H5V4Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
        </svg>
        Restore Data
    </h3>
        <p class="text-sm mb-4 br-text">
            Mengunggah file backup (.json). Proses ini <strong>hanya menambahkan</strong> data yang belum ada
            (berdasarkan Kode Gudang / Kode Mitra / NIP) — data yang sudah ada di database <strong>tidak akan diubah atau ditimpa</strong>.
        </p>
        <form method="POST" action="{{ route('pengaturan.restore') }}" enctype="multipart/form-data" class="space-y-3">
            @csrf
            <input type="file" name="file" accept="application/json" required class="input br-upload">
            <button type="submit" class="btn-secondary br-action inline-flex items-center gap-2" onclick="return confirm('Lanjutkan restore dari file ini? Data yang sudah ada tidak akan diubah, hanya data baru yang ditambahkan.');">
                <svg class="br-icon" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path d="M12 3v11" stroke="currentColor" stroke-width="1.9" stroke-linecap="round"/>
                    <path d="m7.5 10 4.5 4.5 4.5-4.5" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M5 20h14" stroke="currentColor" stroke-width="1.9" stroke-linecap="round"/>
                </svg>
                Restore dari File
            </button>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const page = document.querySelector('.backup-restore-page');
    if (!page) return;

    function elementIsDark(el) {
        if (!el) return false;

        if (el.classList.contains('dark') ||
            el.classList.contains('dark-mode') ||
            el.classList.contains('theme-dark') ||
            el.classList.contains('is-dark')) {
            return true;
        }

        const ATTR_OK = /^(dark|true|1)$/i;
        for (const a of el.attributes) {
            const name = a.name.toLowerCase();
            const value = (a.value || '').trim();
            if ((name === 'data-theme' ||
                 name === 'data-m-theme' ||
                 name === 'data-bs-theme' ||
                 name === 'theme') && ATTR_OK.test(value)) {
                return true;
            }
        }

        return false;
    }

    function markerDark() {
        for (let el = page.parentElement; el; el = el.parentElement) {
            if (elementIsDark(el)) return true;
        }

        const rootScheme = getComputedStyle(document.documentElement).colorScheme || '';
        const bodyScheme = getComputedStyle(document.body).colorScheme || '';
        return rootScheme.trim() === 'dark' || bodyScheme.trim() === 'dark';
    }

    // Fallback: baca tampilan utilitas Tailwind yang dipakai layout.
    const probe = document.createElement('span');
    probe.className = 'bg-white text-slate-700';
    probe.style.cssText = 'position:absolute;left:-99999px;top:-99999px;width:1px;height:1px;visibility:hidden;';
    document.body.appendChild(probe);

    function rgbLuma(color) {
        const m = color.match(/rgba?\(([^)]+)\)/);
        if (!m) return null;
        const p = m[1].split(',').map(v => parseFloat(v.trim()));
        if (p.length < 3) return null;
        return (0.2126*p[0] + 0.7152*p[1] + 0.0722*p[2]) / 255;
    }

    function probeDark() {
        const bg = getComputedStyle(probe).backgroundColor;
        const lum = rgbLuma(bg);
        return lum !== null && lum < 0.45;
    }

    function syncTheme() {
        const dark = markerDark() || probeDark();
        page.classList.toggle('is-dark', dark);
        page.setAttribute('data-m-theme', dark ? 'dark' : 'light');
    }

    syncTheme();

    const observer = new MutationObserver(syncTheme);
    let el = page.parentElement;
    while (el) {
        observer.observe(el, { attributes: true, attributeFilter: ['class', 'data-theme', 'data-m-theme', 'data-bs-theme', 'theme'] });
        el = el.parentElement;
    }
    observer.observe(document.documentElement, { attributes: true, attributeFilter: ['class', 'data-theme', 'data-m-theme', 'data-bs-theme', 'theme'] });
    observer.observe(document.body, { attributes: true, attributeFilter: ['class', 'data-theme', 'data-m-theme', 'data-bs-theme', 'theme'] });
});
</script>

@endsection
