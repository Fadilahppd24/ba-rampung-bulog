@extends('layouts.app')

@section('title', 'Pengaturan Sistem')

@section('content')


<style>
    /* =========================================================
       PENGATURAN SISTEM — LIGHT / DARK GLASS THEME
       Hanya mengatur tampilan halaman ini.
       Backend, route, action form, name input, dan Blade logic
       TIDAK diubah.
       ========================================================= */

    .settings-system-page {
        --sys-blue: #123f78;
        --sys-blue-2: #1d5b9f;
        --sys-orange: #ff9418;
        --sys-text: #102d4e;
        --sys-muted: #607896;
        --sys-border: rgba(18, 63, 120, .16);
        --sys-glass:
            linear-gradient(
                135deg,
                rgba(255, 255, 255, .72) 0%,
                rgba(238, 243, 248, .58) 52%,
                rgba(216, 224, 233, .46) 100%
            );
        --sys-input:
            linear-gradient(
                135deg,
                rgba(255, 255, 255, .74),
                rgba(235, 241, 247, .58)
            );
        color: var(--sys-text);
    }

    /* Wrapper utama */
    .settings-system-page .sys-card {
        border: 1px solid var(--sys-border);
        border-radius: 1.25rem;
        background: var(--sys-glass);
        box-shadow:
            0 16px 40px rgba(18, 45, 78, .10),
            inset 0 1px 0 rgba(255, 255, 255, .42);
        backdrop-filter: blur(18px) saturate(120%);
        -webkit-backdrop-filter: blur(18px) saturate(120%);
    }

    /* Catatan */
    .settings-system-page .sys-note {
        color: #31577f;
        background:
            linear-gradient(
                135deg,
                rgba(219, 234, 252, .72),
                rgba(241, 246, 252, .50)
            );
        border: 1px solid rgba(53, 112, 177, .16);
    }

    /* Label */
    .settings-system-page .label {
        color: #173a61 !important;
        font-weight: 600;
    }

    /* Input */
    .settings-system-page .input {
        color: #17324f !important;
        background: var(--sys-input) !important;
        border: 1px solid rgba(48, 86, 124, .22) !important;
        box-shadow: inset 0 1px 3px rgba(15, 43, 73, .04);
    }

    .settings-system-page .input::placeholder {
        color: #7890aa !important;
    }

    .settings-system-page .input:focus {
        border-color: rgba(255, 148, 24, .72) !important;
        box-shadow:
            0 0 0 3px rgba(255, 148, 24, .12),
            inset 0 1px 3px rgba(15, 43, 73, .04);
        outline: none;
    }

    /* Contoh format nomor BA */
    .settings-system-page .sys-example {
        color: #68809b !important;
        background:
            linear-gradient(
                135deg,
                rgba(255, 255, 255, .62),
                rgba(235, 241, 247, .48)
            ) !important;
        border: 1px solid rgba(75, 107, 137, .12);
    }

    .settings-system-page .sys-example strong {
        color: #315b87 !important;
    }

    /* Tombol simpan */
    .settings-system-page .btn-primary {
        background: linear-gradient(135deg, #174b88, #0d3769) !important;
        border: 1px solid rgba(255, 255, 255, .12);
        box-shadow: 0 8px 20px rgba(13, 55, 105, .22);
    }

    .settings-system-page .btn-primary:hover {
        background: linear-gradient(135deg, #205c9f, #123f78) !important;
        box-shadow: 0 10px 24px rgba(13, 55, 105, .28);
    }

    /* =========================================================
       DARK MODE
       ========================================================= */

    .settings-system-page[data-m-theme="dark"] {
        --sys-text: #f4f7fb;
        --sys-muted: #aabbd0;
        --sys-border: rgba(148, 190, 230, .18);
        --sys-glass:
            linear-gradient(
                135deg,
                rgba(8, 31, 58, .86) 0%,
                rgba(11, 45, 82, .74) 52%,
                rgba(17, 57, 97, .62) 100%
            );
        --sys-input:
            linear-gradient(
                135deg,
                rgba(5, 27, 51, .82),
                rgba(12, 45, 78, .72)
            );
    }

    .settings-system-page[data-m-theme="dark"] .sys-card {
        border-color: rgba(145, 190, 232, .18);
        box-shadow:
            0 18px 48px rgba(0, 8, 20, .38),
            inset 0 1px 0 rgba(255, 255, 255, .06);
        backdrop-filter: blur(20px) saturate(125%);
        -webkit-backdrop-filter: blur(20px) saturate(125%);
    }

    .settings-system-page[data-m-theme="dark"] .sys-note {
        color: #c7dcf4 !important;
        background:
            linear-gradient(
                135deg,
                rgba(20, 67, 117, .64),
                rgba(8, 39, 73, .58)
            ) !important;
        border-color: rgba(105, 164, 220, .20);
    }

    .settings-system-page[data-m-theme="dark"] .label {
        color: #dce9f7 !important;
    }

    .settings-system-page[data-m-theme="dark"] .input {
        color: #f5f8fc !important;
        background: var(--sys-input) !important;
        border-color: rgba(133, 181, 225, .20) !important;
        box-shadow:
            inset 0 1px 4px rgba(0, 0, 0, .18),
            0 1px 0 rgba(255, 255, 255, .03);
    }

    .settings-system-page[data-m-theme="dark"] .input::placeholder {
        color: #8ea7c1 !important;
    }

    .settings-system-page[data-m-theme="dark"] .input:focus {
        border-color: rgba(255, 148, 24, .78) !important;
        box-shadow:
            0 0 0 3px rgba(255, 148, 24, .13),
            inset 0 1px 4px rgba(0, 0, 0, .18);
    }

    .settings-system-page[data-m-theme="dark"] .sys-example {
        color: #9eb5cc !important;
        background:
            linear-gradient(
                135deg,
                rgba(9, 36, 66, .72),
                rgba(15, 52, 87, .58)
            ) !important;
        border-color: rgba(130, 175, 218, .13);
    }

    .settings-system-page[data-m-theme="dark"] .sys-example strong {
        color: #d9e9fa !important;
    }

    .settings-system-page[data-m-theme="dark"] .btn-primary {
        background: linear-gradient(135deg, #1c5a9b, #103f75) !important;
        box-shadow: 0 9px 24px rgba(0, 12, 30, .34);
    }


    /* =========================================================
       DARK MODE HARD OVERRIDE
       Memastikan card/form tidak kembali putih karena class
       .card, bg-white, atau style global dari layout.
       ========================================================= */

    .settings-system-page[data-m-theme="dark"] .sys-card,
    .settings-system-page[data-m-theme="dark"] .card.sys-card {
        background:
            linear-gradient(
                135deg,
                rgba(7, 27, 50, .90) 0%,
                rgba(9, 42, 76, .82) 52%,
                rgba(16, 57, 96, .72) 100%
            ) !important;
        color: #F4F7FB !important;
        border-color: rgba(129, 177, 222, .22) !important;
        box-shadow:
            0 18px 48px rgba(0, 8, 20, .38),
            inset 0 1px 0 rgba(255,255,255,.06) !important;
        backdrop-filter: blur(20px) saturate(125%) !important;
        -webkit-backdrop-filter: blur(20px) saturate(125%) !important;
    }

    .settings-system-page[data-m-theme="dark"] .sys-note {
        background:
            linear-gradient(
                135deg,
                rgba(16, 58, 101, .70),
                rgba(7, 32, 59, .62)
            ) !important;
        color: #C9DDF2 !important;
    }

    .settings-system-page[data-m-theme="dark"] .sys-example {
        background:
            linear-gradient(
                135deg,
                rgba(7, 29, 53, .78),
                rgba(13, 49, 84, .64)
            ) !important;
        color: #AFC4DA !important;
        border-color: rgba(129,177,222,.16) !important;
    }

    .settings-system-page[data-m-theme="dark"] .input,
    .settings-system-page[data-m-theme="dark"] input,
    .settings-system-page[data-m-theme="dark"] select,
    .settings-system-page[data-m-theme="dark"] textarea {
        background:
            linear-gradient(
                135deg,
                rgba(4, 22, 42, .92),
                rgba(9, 40, 70, .82)
            ) !important;
        color: #F5F8FC !important;
        border-color: rgba(129,177,222,.22) !important;
    }

    .settings-system-page[data-m-theme="dark"] .input::placeholder,
    .settings-system-page[data-m-theme="dark"] input::placeholder,
    .settings-system-page[data-m-theme="dark"] textarea::placeholder {
        color: #8EA7C1 !important;
    }

    .settings-system-page[data-m-theme="dark"] .label {
        color: #DCE9F7 !important;
    }

    /* Jika Tailwind/global CSS memberi bg putih langsung pada card */
    .settings-system-page[data-m-theme="dark"] .bg-white,
    .settings-system-page[data-m-theme="dark"] .bg-white\/95,
    .settings-system-page[data-m-theme="dark"] .bg-white\/90,
    .settings-system-page[data-m-theme="dark"] .bg-slate-50,
    .settings-system-page[data-m-theme="dark"] .bg-gray-50 {
        background-color: rgba(8, 30, 53, .82) !important;
        color: #F4F7FB !important;
    }


    /* =========================================================
       FINAL DARK THEME OVERRIDE
       Layout utama menggunakan <html class="dark-theme">.
       Karena itu halaman ini juga membaca class tersebut.
       ========================================================= */

    .settings-system-page.is-dark .sys-card,
    .settings-system-page.is-dark .card.sys-card {
        background:
            linear-gradient(
                135deg,
                rgba(6, 27, 50, .90) 0%,
                rgba(8, 40, 72, .82) 50%,
                rgba(13, 56, 94, .70) 100%
            ) !important;
        color: #F4F7FB !important;
        border: 1px solid rgba(135, 184, 228, .20) !important;
        box-shadow:
            0 18px 48px rgba(0, 8, 20, .40),
            inset 0 1px 0 rgba(255,255,255,.06) !important;
        backdrop-filter: blur(22px) saturate(130%) !important;
        -webkit-backdrop-filter: blur(22px) saturate(130%) !important;
    }

    .settings-system-page.is-dark .sys-note {
        background:
            linear-gradient(
                135deg,
                rgba(12, 52, 91, .78),
                rgba(6, 31, 57, .68)
            ) !important;
        color: #C9DDF2 !important;
        border-color: rgba(115,170,220,.20) !important;
    }

    .settings-system-page.is-dark .sys-example {
        background:
            linear-gradient(
                135deg,
                rgba(5, 25, 46, .82),
                rgba(10, 45, 78, .68)
            ) !important;
        color: #AFC4DA !important;
        border-color: rgba(130,175,218,.16) !important;
    }

    .settings-system-page.is-dark .label {
        color: #DCE9F7 !important;
    }

    .settings-system-page.is-dark .input,
    .settings-system-page.is-dark input,
    .settings-system-page.is-dark select,
    .settings-system-page.is-dark textarea {
        background:
            linear-gradient(
                135deg,
                rgba(3, 20, 38, .94),
                rgba(8, 38, 67, .84)
            ) !important;
        color: #F5F8FC !important;
        border-color: rgba(128,178,224,.22) !important;
    }

    .settings-system-page.is-dark .input::placeholder,
    .settings-system-page.is-dark input::placeholder,
    .settings-system-page.is-dark textarea::placeholder {
        color: #8EA7C1 !important;
    }

    .settings-system-page.is-dark .btn-primary {
        background: linear-gradient(135deg, #1C5A9B, #103F75) !important;
        color: #FFFFFF !important;
    }

    /* =========================================================
       THEME DETECTION
       Ikuti toggle tema layout: data-theme, data-m-theme,
       class dark/dark-mode/theme-dark, atau localStorage.
       ========================================================= */

    /* Hint orange yang halus di bagian bawah card */
    .settings-system-page .sys-card::after {
        content: "";
        position: absolute;
        width: 220px;
        height: 120px;
        right: -80px;
        bottom: -70px;
        border-radius: 999px;
        background: radial-gradient(
            ellipse,
            rgba(255, 148, 24, .10) 0%,
            rgba(255, 148, 24, .03) 48%,
            transparent 72%
        );
        pointer-events: none;
    }

    .settings-system-page .sys-card {
        position: relative;
        overflow: hidden;
    }
</style>

<div class="settings-system-page" data-m-theme="light">

@include('pengaturan._tabs')

<div class="card p-4 text-sm max-w-2xl sys-card sys-note">
    Catatan: mengubah nilai di bawah ini <strong>tidak mengubah retroaktif</strong> nomor BA yang sudah dibuat sebelumnya.
    Nomor BA yang sudah ada tetap seperti semula.
</div>

<form method="POST" action="{{ route('pengaturan.sistem.update') }}" class="card p-6 space-y-5 max-w-2xl sys-card">
    @csrf

    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <div>
            <label class="label">Prefix Nomor BA</label>
            <input type="text" name="prefix_nomor_ba" value="{{ old('prefix_nomor_ba', $pengaturan->prefix_nomor_ba) }}" required class="input" placeholder="BA">
        </div>
        <div>
            <label class="label">Suffix Nomor BA</label>
            <input type="text" name="suffix_nomor_ba" value="{{ old('suffix_nomor_ba', $pengaturan->suffix_nomor_ba) }}" required class="input" placeholder="GKP">
        </div>
        <div>
            <label class="label">Tahun Aktif</label>
            <input type="number" name="tahun_aktif" value="{{ old('tahun_aktif', $pengaturan->tahun_aktif) }}" required class="input">
        </div>
        <div>
            <label class="label">Item per Halaman (Pagination)</label>
            <input type="number" name="item_per_halaman" value="{{ old('item_per_halaman', $pengaturan->item_per_halaman) }}" min="5" max="100" required class="input">
        </div>
    </div>

    <div class="rounded-lg p-4 text-xs sys-example">
        Contoh format nomor BA saat ini: <strong>{{ $pengaturan->prefix_nomor_ba }}-007/07/{{ $pengaturan->tahun_aktif }}/10040/{{ $pengaturan->suffix_nomor_ba }}</strong>
    </div>

    <div class="flex justify-end pt-2">
        <button type="submit" class="btn-primary inline-flex items-center gap-2">
            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                <path d="M5 4.5A1.5 1.5 0 0 1 6.5 3h9.9a1.5 1.5 0 0 1 1.06.44l2.1 2.1A1.5 1.5 0 0 1 20 6.6v12.9A1.5 1.5 0 0 1 18.5 21h-13A1.5 1.5 0 0 1 4 19.5v-13A1.5 1.5 0 0 1 5.5 5H16v4H6V5"/>
                <path d="M8 21v-6h8v6M8 3v4"/>
            </svg>
            <span>Simpan Perubahan</span>
        </button>
    </div>
</form>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const page = document.querySelector('.settings-system-page');
    if (!page) return;

    function cookieTheme() {
        const match = document.cookie.match(/(?:^|;\s*)theme=([^;]+)/);
        return match ? decodeURIComponent(match[1]) : null;
    }

    function storedTheme() {
        try {
            return localStorage.getItem('theme') ||
                   localStorage.getItem('color-theme') ||
                   localStorage.getItem('app-theme');
        } catch (e) {
            return null;
        }
    }

    function hasDarkClass(el) {
        return !!el && el.classList &&
            (el.classList.contains('dark') ||
             el.classList.contains('dark-mode') ||
             el.classList.contains('theme-dark'));
    }

    function detectTheme() {
        const root = document.documentElement;
        const body = document.body;

        const attrs = [
            root.getAttribute('data-m-theme'),
            body.getAttribute('data-m-theme'),
            root.getAttribute('data-theme'),
            body.getAttribute('data-theme'),
            root.getAttribute('data-bs-theme'),
            body.getAttribute('data-bs-theme'),
            cookieTheme(),
            storedTheme()
        ].map(v => (v || '').toLowerCase());

        if (attrs.includes('dark')) return 'dark';
        if (attrs.includes('light')) return 'light';

        if (hasDarkClass(root) || hasDarkClass(body)) return 'dark';

        const scheme = getComputedStyle(root).colorScheme ||
                       getComputedStyle(body).colorScheme || '';
        if (scheme.toLowerCase().includes('dark')) return 'dark';

        return 'light';
    }

    function syncTheme() {
        const root = document.documentElement;
        const body = document.body;

        const dark =
            root.classList.contains('dark-theme') ||
            body.classList.contains('dark-theme') ||
            detectTheme() === 'dark';

        page.setAttribute('data-m-theme', dark ? 'dark' : 'light');
        page.classList.toggle('is-dark', dark);
    }

    syncTheme();

    const observer = new MutationObserver(syncTheme);

    observer.observe(document.documentElement, {
        attributes: true,
        attributeFilter: ['class', 'data-m-theme', 'data-theme', 'data-bs-theme']
    });

    observer.observe(document.body, {
        attributes: true,
        attributeFilter: ['class', 'data-m-theme', 'data-theme', 'data-bs-theme']
    });

    window.addEventListener('storage', syncTheme);

    /* Toggle tema kadang hanya mengubah localStorage tanpa
       memicu mutation pada DOM. Cek ringan setiap 300 ms. */
    setInterval(syncTheme, 300);
});
</script>

@endsection
