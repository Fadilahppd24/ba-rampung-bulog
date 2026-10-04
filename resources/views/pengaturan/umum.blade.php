@extends('layouts.app')

@section('title', 'Pengaturan Umum')

@section('content')

{{-- =========================================================
     STYLE KHUSUS HALAMAN PENGATURAN UMUM (scoped di .settings-page)
     - Hanya visual. Tidak menyentuh logic / backend / CSS global.
     - Class global `.input` ditimpa hanya di dalam .settings-page
       lewat .m-input (!important), jadi halaman lain tidak terpengaruh.
     - Dark mode mengikuti toggle yang sudah ada di layout.
========================================================== --}}
<style>
    .settings-page {
        --m-card-bg: linear-gradient(135deg, rgba(255,255,255,.66) 0%, rgba(255,255,255,.52) 62%, rgba(255,148,24,.12) 100%);
        --m-border: rgba(255, 255, 255, .78);
        --m-line: rgba(15, 42, 74, .12);
        --m-text: #0B2545;
        --m-text-2: #3F5673;
        --m-muted: #5B6F89;
        --m-input-bg: rgba(255, 255, 255, .58);
        --m-input-border: rgba(15, 42, 74, .16);
        --m-panel: rgba(255, 255, 255, .42);
        --m-focus-ring: rgba(255, 148, 24, .22);
        --m-chip-bg: rgba(18, 63, 122, .10);
        --m-chip-fg: #123F7A;
        --m-accent-bg: rgba(255, 148, 24, .16);
        --m-accent-fg: #C26A00;
        --m-off-bg: rgba(15, 42, 74, .07);
        --m-shadow: 0 14px 40px rgba(15, 42, 74, .14);
        --m-blur: 16px;
        color: var(--m-text);
    }

    /* ---------- DARK MODE (dideteksi oleh script di bawah) ---------- */
    .settings-page[data-m-theme="dark"] {
        --m-card-bg: linear-gradient(135deg, rgba(11,27,48,.80) 0%, rgba(7,20,38,.78) 62%, rgba(255,148,24,.08) 100%);
        --m-border: rgba(255, 255, 255, .10);
        --m-line: rgba(255, 255, 255, .10);
        --m-text: #F8FAFC;
        --m-text-2: #CBD5E1;
        --m-muted: #9FB0C6;
        --m-input-bg: rgba(8, 24, 43, .80);
        --m-input-border: rgba(255, 255, 255, .10);
        --m-panel: rgba(8, 24, 43, .72);
        --m-focus-ring: rgba(255, 148, 24, .24);
        --m-chip-bg: rgba(96, 165, 250, .14);
        --m-chip-fg: #93C5FD;
        --m-accent-bg: rgba(255, 148, 24, .16);
        --m-accent-fg: #FFB454;
        --m-off-bg: rgba(148, 163, 184, .14);
        --m-shadow: 0 16px 44px rgba(0, 8, 20, .50);
        --m-blur: 18px;
        color-scheme: dark;
    }

    /* ---------- CARD (glassmorphism) ---------- */
    .settings-page .m-card {
        position: relative;
        background: var(--m-card-bg);
        border: 1px solid var(--m-border);
        border-radius: 24px;
        box-shadow: var(--m-shadow);
        backdrop-filter: blur(var(--m-blur));
        -webkit-backdrop-filter: blur(var(--m-blur));
        overflow: hidden;
    }
    .settings-page .m-card-accent::before {
        content: "";
        position: absolute;
        left: 0; right: 0; top: 0;
        height: 3px;
        background: linear-gradient(90deg, #FF9418 0%, rgba(255, 148, 24, 0) 70%);
        z-index: 1;
    }
    .settings-page .m-card-accent::after {
        content: "";
        position: absolute;
        right: -60px; top: -60px;
        width: 180px; height: 180px; border-radius: 999px;
        background: radial-gradient(circle, rgba(255, 148, 24, .16), transparent 70%);
        pointer-events: none;
    }
    .settings-page .m-line { border-color: var(--m-line); }
    .settings-page .m-panel {
        background: var(--m-panel);
        border: 1px solid var(--m-line);
        border-radius: 18px;
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
    }

    /* ---------- TEKS ---------- */
    .settings-page .m-title { color: var(--m-text); }
    .settings-page .m-sub { color: var(--m-text-2); }
    .settings-page .m-muted { color: var(--m-muted); }
    .settings-page .m-label {
        display: block; margin-bottom: 8px;
        font-size: 11px; font-weight: 700; letter-spacing: .12em; text-transform: uppercase;
        color: var(--m-text-2);
    }

    /* ---------- ICON ---------- */
    .settings-page .mi { width: 1.25rem; height: 1.25rem; flex-shrink: 0; fill: none; stroke: currentColor; stroke-width: 1.8; stroke-linecap: round; stroke-linejoin: round; }
    .settings-page .mi-sm { width: 1rem; height: 1rem; }
    .settings-page .m-icon-box {
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        border-radius: 14px;
        background: var(--m-chip-bg); color: var(--m-chip-fg);
    }
    .settings-page .m-icon-box.accent { background: var(--m-accent-bg); color: var(--m-accent-fg); }

    /* ---------- TOMBOL ---------- */
    .settings-page .m-btn {
        display: inline-flex; align-items: center; justify-content: center; gap: 8px;
        border-radius: 14px; padding: 11px 22px;
        font-size: 14px; font-weight: 700; line-height: 1.2;
        transition: transform .18s ease, background-color .18s ease, box-shadow .18s ease;
        cursor: pointer; text-decoration: none; border: 1px solid transparent;
    }
    .settings-page .m-btn-accent { background: #FF9418; color: #fff; box-shadow: 0 8px 22px rgba(255, 148, 24, .34); }
    .settings-page .m-btn-accent:hover { background: #E8830C; transform: translateY(-1px); }

    /* ---------- INPUT / TEXTAREA / FILE (menimpa .input global hanya di halaman ini) ---------- */
    .settings-page .m-input {
        width: 100%;
        border-radius: 14px;
        border: 1px solid var(--m-input-border) !important;
        background: var(--m-input-bg) !important;
        color: var(--m-text) !important;
        padding: 12px 14px;
        font-size: 14px;
        outline: none;
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        box-shadow: none;
        transition: border-color .18s ease, box-shadow .18s ease;
    }
    .settings-page .m-input::placeholder { color: var(--m-muted); opacity: 1; }
    .settings-page .m-input:focus { border-color: #FF9418 !important; box-shadow: 0 0 0 4px var(--m-focus-ring); }
    .settings-page .m-input[type="file"] { padding: 8px 10px; cursor: pointer; }
    .settings-page .m-input[type="file"]::file-selector-button {
        margin-right: 12px; cursor: pointer;
        border: 0; border-radius: 10px; padding: 7px 14px;
        font-size: 12px; font-weight: 700;
        background: var(--m-chip-bg); color: var(--m-chip-fg);
        transition: background-color .18s ease;
    }
    .settings-page .m-input[type="file"]::file-selector-button:hover { background: var(--m-accent-bg); color: var(--m-accent-fg); }

    .settings-page .m-color {
        height: 44px; width: 64px; cursor: pointer;
        border-radius: 12px; padding: 4px;
        border: 1px solid var(--m-input-border);
        background: var(--m-input-bg);
    }

    .settings-page .m-dropzone {
        border: 1.5px dashed var(--m-input-border);
        background: var(--m-panel);
        border-radius: 18px;
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
    }
    .settings-page .m-logo-img {
        background: var(--m-input-bg);
        border: 1px solid var(--m-line);
    }

    /* ---------- HERO ---------- */
    /*
     * Hero Pengaturan dibuat TANPA foto.
     * Background halaman/layout tetap menggunakan foto BULOG,
     * sedangkan hero menjadi card glass transparan dengan gradasi abu-abu.
     */
    .settings-page .m-settings-hero {
        position: relative;
        overflow: hidden;
        border-radius: 2rem;
        border: 1px solid rgba(255, 255, 255, .24);
        background:
            linear-gradient(
                115deg,
                rgba(7, 43, 82, .82) 0%,
                rgba(18, 63, 122, .68) 42%,
                rgba(28, 76, 133, .52) 70%,
                rgba(255, 148, 24, .12) 100%
            );
        box-shadow:
            0 18px 48px rgba(5, 25, 50, .22),
            inset 0 1px 0 rgba(255, 255, 255, .10);
        backdrop-filter: blur(20px) saturate(125%);
        -webkit-backdrop-filter: blur(20px) saturate(125%);
    }

    .settings-page .m-settings-hero::after {
        content: "";
        position: absolute;
        width: 340px;
        height: 340px;
        right: -120px;
        top: -170px;
        border-radius: 999px;
        background:
            radial-gradient(
                circle,
                rgba(255, 255, 255, .16) 0%,
                rgba(120, 170, 220, .10) 28%,
                rgba(255, 148, 24, .10) 48%,
                transparent 72%
            );
        pointer-events: none;
    }

    .settings-page .m-settings-hero::before {
        content: "";
        position: absolute;
        left: 28%;
        bottom: -120px;
        width: 420px;
        height: 240px;
        border-radius: 999px;
        background: radial-gradient(
            ellipse,
            rgba(75, 145, 210, .18) 0%,
            rgba(75, 145, 210, .07) 45%,
            transparent 72%
        );
        pointer-events: none;
    }

    .settings-page[data-m-theme="dark"] .m-settings-hero {
        border-color: rgba(255, 255, 255, .13);
        background:
            linear-gradient(
                115deg,
                rgba(4, 25, 49, .88) 0%,
                rgba(8, 43, 82, .78) 42%,
                rgba(13, 55, 99, .66) 70%,
                rgba(255, 148, 24, .10) 100%
            );
        box-shadow:
            0 18px 50px rgba(0, 8, 20, .48),
            inset 0 1px 0 rgba(255, 255, 255, .07);
        backdrop-filter: blur(20px) saturate(120%);
        -webkit-backdrop-filter: blur(20px) saturate(120%);
    }

    .settings-page[data-m-theme="dark"] .m-settings-hero::after {
        background: radial-gradient(
            circle,
            rgba(255, 148, 24, .13) 0%,
            rgba(255, 148, 24, .035) 48%,
            transparent 72%
        );
    }

    .settings-page .m-settings-hero-accent {
        position: absolute;
        left: 0;
        right: 0;
        top: 0;
        height: 3px;
        background: linear-gradient(
            90deg,
            #FF9418 0%,
            rgba(255, 148, 24, .55) 38%,
            rgba(255, 148, 24, 0) 78%
        );
        z-index: 2;
    }

    .settings-page .m-settings-hero-kicker {
        color: rgba(255, 255, 255, .78);
    }

    .settings-page .m-settings-hero-title {
        color: #FFFFFF;
    }

    .settings-page .m-settings-hero-sub {
        color: rgba(255, 255, 255, .86);
    }

    .settings-page[data-m-theme="dark"] .m-settings-hero-kicker {
        color: #CBD5E1;
    }

    .settings-page[data-m-theme="dark"] .m-settings-hero-title {
        color: #F8FAFC;
    }

    .settings-page[data-m-theme="dark"] .m-settings-hero-sub {
        color: #CBD5E1;
    }

    /* ---------- PREVIEW ---------- */
    .settings-page .m-prev-wrap { border: 1px solid var(--m-line); border-radius: 18px; overflow: hidden; }
    .settings-page .m-prev-tile { height: 48px; border-radius: 12px; }
    .settings-page .m-prev-tile.t1 { background: var(--m-chip-bg); }
    .settings-page .m-prev-tile.t2 { background: var(--m-accent-bg); }
    .settings-page .m-prev-tile.t3 { background: var(--m-off-bg); }
</style>

<div class="settings-page space-y-6 pb-8">

    {{-- HERO --}}
    {{-- Hero sengaja TANPA gambar. Foto BULOG tetap menjadi background halaman dari layout. --}}
    <section class="m-settings-hero">
        <div class="m-settings-hero-accent pointer-events-none"></div>

        <div class="relative z-10 flex min-h-[250px] items-end px-7 py-8 sm:px-10 lg:px-12">
            <div>
                <div class="dashboard-kicker m-settings-hero-kicker mb-3">PENGATURAN</div>

                <h1 class="dashboard-display m-settings-hero-title text-5xl font-normal leading-[.9] sm:text-6xl lg:text-[4.5rem]">
                    Pengaturan <span class="text-[#FF9418]">Umum.</span>
                </h1>

                <p class="m-settings-hero-sub mt-4 max-w-2xl text-sm leading-7 sm:text-base">
                    Kelola informasi dan konfigurasi dasar sistem BA Rampung.
                </p>
            </div>
        </div>
    </section>

    @include('pengaturan._tabs')

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-[minmax(0,1.35fr)_minmax(320px,.65fr)]">

        {{-- FORM --}}
        <form method="POST"
              action="{{ route('pengaturan.umum.update') }}"
              enctype="multipart/form-data"
              class="m-card m-card-accent p-6 sm:p-7">
            @csrf

            <div class="relative mb-6">
                <div class="flex items-center gap-4">
                    <div class="m-icon-box h-11 w-11">
                        <svg class="mi" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M3 21h18M5 21V6a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v15M9 8h2m-2 4h2m2-4h2m-2 4h2"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="m-title text-xl font-bold">Informasi Cabang</h2>
                        <p class="m-sub mt-0.5 text-sm">Kelola informasi dasar cabang BULOG.</p>
                    </div>
                </div>
            </div>

            <div class="relative space-y-5">

                <div>
                    <label class="m-label">Nama Cabang</label>
                    <input type="text"
                           name="nama_cabang"
                           value="{{ old('nama_cabang', $pengaturan->nama_cabang) }}"
                           required
                           class="input m-input">
                </div>

                <div>
                    <label class="m-label">Alamat Kantor</label>
                    <textarea name="alamat_kantor"
                              rows="4"
                              class="input m-input">{{ old('alamat_kantor', $pengaturan->alamat_kantor) }}</textarea>
                </div>

                <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                    <div>
                        <label class="m-label">Telepon</label>
                        <input type="text"
                               name="telepon"
                               value="{{ old('telepon', $pengaturan->telepon) }}"
                               class="input m-input">
                    </div>

                    <div>
                        <label class="m-label">Email</label>
                        <input type="email"
                               name="email"
                               value="{{ old('email', $pengaturan->email) }}"
                               class="input m-input">
                    </div>
                </div>

                <div class="m-line border-t pt-5">
                    <label class="m-label">Logo Cabang</label>

                    <div class="m-dropzone p-4">
                        <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
                            @if ($pengaturan->logo_path)
                                <img src="{{ \Illuminate\Support\Facades\Storage::url($pengaturan->logo_path) }}"
                                     alt="Logo"
                                     class="m-logo-img h-16 w-16 rounded-2xl object-contain p-2 shadow-sm">
                            @else
                                <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-[#123F7A] text-xl font-bold text-white shadow-sm">
                                    B
                                </div>
                            @endif

                            <div class="min-w-0 flex-1">
                                <input type="file"
                                       name="logo"
                                       accept="image/*"
                                       class="input m-input">
                                <p class="m-muted mt-2 text-xs">Format JPG/PNG, ukuran maksimal 2MB.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="m-label">Warna Tema</label>

                    <div class="m-panel flex flex-wrap items-center gap-3 p-4">
                        <input type="color"
                               name="warna_tema"
                               value="{{ old('warna_tema', $pengaturan->warna_tema) }}"
                               class="m-color">

                        <div>
                            <p class="m-title text-sm font-semibold">Warna utama sistem</p>
                            <p class="m-muted text-xs">{{ old('warna_tema', $pengaturan->warna_tema) }}</p>
                        </div>
                    </div>
                </div>

                <div class="m-line flex justify-end border-t pt-5">
                    <button type="submit" class="m-btn m-btn-accent">
                        <svg class="mi mi-sm" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M5 12l4 4L19 6"/>
                        </svg>
                        Simpan Perubahan
                    </button>
                </div>

            </div>
        </form>

        {{-- PREVIEW --}}
        <div class="space-y-6">

            <div class="m-card m-card-accent">

                <div class="m-line relative border-b p-5">
                    <h2 class="m-title text-lg font-bold">Preview Tampilan</h2>
                    <p class="m-sub mt-1 text-sm">Contoh tampilan dengan pengaturan cabang saat ini.</p>
                </div>

                <div class="relative p-5">
                    <div class="m-prev-wrap shadow-sm">

                        <div class="relative h-40 overflow-hidden">
                            <img src="{{ asset('images/dashboard-bulog.jpg') }}"
                                 alt="Preview"
                                 class="absolute inset-0 h-full w-full object-cover">

                            <div class="absolute inset-0 bg-gradient-to-r from-[#082F63]/80 via-[#123F7A]/40 to-transparent"></div>
                            <div class="m-hero-tint pointer-events-none absolute inset-0"></div>

                            <div class="relative z-10 p-5 text-white">
                                <div class="text-[10px] font-semibold uppercase tracking-[.2em] text-white/70">Sistem BA Rampung</div>
                                <div class="mt-2 text-2xl font-semibold">{{ $pengaturan->nama_cabang ?: 'BULOG Indramayu' }}</div>
                            </div>
                        </div>

                        <div class="grid grid-cols-3 gap-2 p-3" style="background:var(--m-panel); backdrop-filter:blur(12px); -webkit-backdrop-filter:blur(12px);">
                            <div class="m-prev-tile t1"></div>
                            <div class="m-prev-tile t2"></div>
                            <div class="m-prev-tile t3"></div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- INFO --}}
            <div class="m-card m-card-accent p-5">
                <div class="relative flex items-start gap-4">
                    <div class="m-icon-box accent h-10 w-10">
                        <svg class="mi" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M12 18h.01M9.09 9a3 3 0 1 1 5.82 1c0 2-2.91 2-2.91 4"/>
                            <circle cx="12" cy="12" r="9"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="m-title font-bold">Panduan Singkat</h3>
                        <p class="m-sub mt-2 text-sm leading-6">
                            Beberapa pengaturan dapat memengaruhi tampilan seluruh sistem.
                            Pastikan data yang dimasukkan sudah benar sebelum menyimpan perubahan.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- =========================================================
     DETEKSI DARK MODE (hanya membaca status theme dari layout;
     tidak membuat toggle baru, tidak mengubah localStorage)
========================================================== --}}
<script>
    (function () {
        var page = document.querySelector('.settings-page');
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
