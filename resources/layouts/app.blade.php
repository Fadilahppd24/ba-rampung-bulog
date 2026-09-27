<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @yield('title', 'BA Rampung BULOG')
    </title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] {
            display: none !important;
        }

        /* =========================================================
           GLOBAL PAGE BACKGROUND
        ========================================================= */
        .app-page-wrapper {
            min-height: 100vh;
            background:
                linear-gradient(
                    to bottom,
                    rgba(245, 242, 235, .20),
                    rgba(245, 242, 235, .96) 520px
                ),
                url('{{ asset('images/dashboard-bulog.jpg') }}');
            background-size: cover;
            background-position: center top;
            background-attachment: fixed;
        }

        /* =========================================================
           TOP NAVBAR
        ========================================================= */
        .app-top-navbar {
            position: sticky;
            top: 0;
            z-index: 1000;
            width: 100%;
            background: rgba(255,255,255,.94);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            border-bottom: 1px solid rgba(8,47,99,.08);
            box-shadow: 0 8px 30px rgba(8,47,99,.07);
        }

        .app-nav-inner {
            max-width: 1450px;
            margin: 0 auto;
            min-height: 78px;
            padding: 0 28px;

            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 25px;
        }

        .app-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            flex-shrink: 0;
        }

        .app-brand img {
            width: 48px;
            height: 48px;
            object-fit: contain;
        }

        .app-brand-text {
            display: flex;
            flex-direction: column;
            line-height: 1.05;
        }

        .app-brand-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 24px;
            font-weight: 700;
            color: #082f63;
            letter-spacing: -.3px;
        }

        .app-brand-subtitle {
            margin-top: 4px;
            font-family: 'Manrope', sans-serif;
            font-size: 9px;
            font-weight: 800;
            color: #f28c28;
            text-transform: uppercase;
            letter-spacing: 1.4px;
        }

        .app-main-nav {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            flex: 1;
        }

        .app-nav-link {
            position: relative;
            display: inline-flex;
            align-items: center;
            gap: 7px;

            padding: 11px 15px;
            border-radius: 12px;

            color: #42526b;
            font-size: 13px;
            font-weight: 700;

            text-decoration: none;
            transition: all .2s ease;
        }

        .app-nav-link:hover {
            color: #082f63;
            background: #f3f6fa;
        }

        .app-nav-link.active {
            color: #082f63;
            background: #eef4fb;
        }

        .app-nav-link.active::after {
            content: "";
            position: absolute;
            left: 15px;
            right: 15px;
            bottom: 5px;
            height: 2px;
            border-radius: 99px;
            background: #f28c28;
        }

        /* =========================================================
           DROPDOWN
        ========================================================= */
        .app-dropdown {
            position: relative;
        }

        .app-dropdown-menu {
            position: absolute;
            top: calc(100% + 10px);
            left: 0;

            min-width: 220px;
            padding: 8px;

            background: rgba(255,255,255,.98);
            border: 1px solid rgba(8,47,99,.08);
            border-radius: 16px;

            box-shadow: 0 20px 45px rgba(8,47,99,.14);

            opacity: 0;
            visibility: hidden;
            transform: translateY(-5px);

            transition: all .2s ease;
        }

        .app-dropdown:hover .app-dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .app-dropdown-item {
            display: flex;
            align-items: center;
            gap: 10px;

            padding: 11px 12px;
            border-radius: 10px;

            color: #43536a;
            text-decoration: none;

            font-size: 12px;
            font-weight: 700;

            transition: all .18s ease;
        }

        .app-dropdown-item:hover {
            background: #f3f6fa;
            color: #082f63;
        }

        .app-dropdown-item svg {
            width: 16px;
            height: 16px;
            flex-shrink: 0;
        }

        /* =========================================================
           USER AREA
        ========================================================= */
        .app-user-area {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-shrink: 0;
        }

        .app-user-info {
            display: flex;
            flex-direction: column;
            text-align: right;
            line-height: 1.15;
        }

        .app-user-name {
            font-size: 12px;
            font-weight: 800;
            color: #082f63;
        }

        .app-user-role {
            margin-top: 4px;
            font-size: 9px;
            font-weight: 700;
            color: #7a8798;
            text-transform: uppercase;
            letter-spacing: .7px;
        }

        .app-user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;

            display: flex;
            align-items: center;
            justify-content: center;

            background: #082f63;
            color: white;

            font-size: 13px;
            font-weight: 800;

            border: 3px solid #f1f5f9;
        }

        .app-logout {
            width: 38px;
            height: 38px;
            border: 0;
            border-radius: 11px;

            display: flex;
            align-items: center;
            justify-content: center;

            background: #fff3e8;
            color: #e77d17;

            cursor: pointer;
            transition: all .2s ease;
        }

        .app-logout:hover {
            background: #f28c28;
            color: white;
        }

        /* =========================================================
           MOBILE BUTTON
        ========================================================= */
        .app-mobile-button {
            display: none;
            width: 42px;
            height: 42px;
            border: 0;
            border-radius: 12px;
            background: #eef4fb;
            color: #082f63;
            cursor: pointer;
        }

        /* =========================================================
           PAGE HERO
        ========================================================= */
        .app-page-hero {
            max-width: 1450px;
            margin: 0 auto;
            padding: 55px 28px 35px;
        }

        .app-page-hero-inner {
            max-width: 780px;
        }

        .app-page-kicker {
            display: inline-flex;
            align-items: center;
            gap: 8px;

            margin-bottom: 10px;

            color: #f28c28;
            font-size: 10px;
            font-weight: 900;
            letter-spacing: 1.7px;
            text-transform: uppercase;
        }

        .app-page-kicker::before {
            content: "";
            width: 28px;
            height: 2px;
            border-radius: 99px;
            background: #f28c28;
        }

        .app-page-title {
            margin: 0;
            color: #082f63;

            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(38px, 5vw, 58px);
            font-weight: 700;
            line-height: .95;
            letter-spacing: -1px;
        }

        .app-page-description {
            max-width: 650px;
            margin-top: 14px;

            color: #526176;
            font-size: 13px;
            line-height: 1.7;
        }

        /* =========================================================
           CONTENT
        ========================================================= */
        .app-page-main {
            max-width: 1450px;
            margin: 0 auto;
            padding: 0 28px 60px;
        }

        .app-content-card {
            background: rgba(255,255,255,.96);
            border: 1px solid rgba(8,47,99,.07);
            border-radius: 24px;
            box-shadow: 0 18px 45px rgba(8,47,99,.09);
        }

        /* =========================================================
           ALERT
        ========================================================= */
        .app-alert {
            max-width: 1450px;
            margin: 0 auto 20px;
            padding: 0 28px;
        }

        .app-alert-box {
            border-radius: 15px;
            padding: 14px 18px;
            font-size: 13px;
            font-weight: 700;
        }

        .app-alert-success {
            background: #ecfdf5;
            color: #047857;
            border: 1px solid #a7f3d0;
        }

        .app-alert-error {
            background: #fef2f2;
            color: #b91c1c;
            border: 1px solid #fecaca;
        }

        /* =========================================================
           FOOTER
        ========================================================= */
        .app-footer {
            max-width: 1450px;
            margin: 0 auto;
            padding: 0 28px 30px;
        }

        .app-footer-inner {
            padding-top: 22px;
            border-top: 1px solid rgba(8,47,99,.08);

            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;

            color: #788598;
            font-size: 11px;
            font-weight: 600;
        }

        .app-footer strong {
            color: #082f63;
        }

        /* =========================================================
           RESPONSIVE
        ========================================================= */
        @media (max-width: 1100px) {
            .app-main-nav {
                gap: 0;
            }

            .app-nav-link {
                padding-left: 10px;
                padding-right: 10px;
            }

            .app-user-info {
                display: none;
            }
        }

        @media (max-width: 900px) {
            .app-mobile-button {
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .app-main-nav {
                display: none;
                position: absolute;
                top: 78px;
                left: 15px;
                right: 15px;

                flex-direction: column;
                align-items: stretch;

                padding: 10px;

                background: rgba(255,255,255,.98);
                border: 1px solid rgba(8,47,99,.08);
                border-radius: 18px;

                box-shadow: 0 20px 45px rgba(8,47,99,.14);
            }

            .app-main-nav.mobile-open {
                display: flex;
            }

            .app-dropdown-menu {
                position: static;
                display: none;
                margin-top: 5px;
                box-shadow: none;
                border: 0;
                background: #f7f9fc;
            }

            .app-dropdown:hover .app-dropdown-menu {
                display: block;
            }

            .app-nav-link {
                width: 100%;
            }

            .app-page-hero {
                padding-top: 40px;
            }
        }

        @media (max-width: 640px) {
            .app-nav-inner {
                min-height: 68px;
                padding: 0 16px;
            }

            .app-brand img {
                width: 40px;
                height: 40px;
            }

            .app-brand-title {
                font-size: 20px;
            }

            .app-brand-subtitle {
                font-size: 7px;
            }

            .app-page-hero {
                padding: 35px 18px 25px;
            }

            .app-page-main {
                padding: 0 18px 40px;
            }

            .app-alert {
                padding: 0 18px;
            }

            .app-footer {
                padding: 0 18px 25px;
            }

            .app-footer-inner {
                flex-direction: column;
                align-items: flex-start;
            }

            .app-user-avatar {
                width: 36px;
                height: 36px;
            }
        }
    </style>
</head>

<body class="antialiased">

@php
    $user = auth()->user();
@endphp

@if(request()->routeIs('dashboard'))

    {{-- =========================================================
         DASHBOARD
         Bagian dashboard lama tetap dipertahankan
    ========================================================== --}}

    {{-- DASHBOARD WRAPPER
         Hero/foto dashboard dikelola oleh dashboard/index.blade.php
         agar hanya ada SATU hero.
    --}}
    <div class="min-h-screen bg-[#F4F1EA]">

    {{-- TOP NAVBAR DASHBOARD --}}
<nav
    class="dashboard-navbar relative"
    style="z-index: 20;"
>            <div class="dashboard-navbar-inner">

                <a href="{{ route('dashboard') }}" class="dashboard-brand">
                    <img
                        src="{{ asset('assets/images/bulog-logo.png') }}"
                        alt="BULOG"
                    >

                    <div>
                        <div class="dashboard-brand-title">
                            BA Rampung
                        </div>

                        <div class="dashboard-brand-subtitle">
                            Perum BULOG
                        </div>
                    </div>
                </a>

                <div class="dashboard-nav-links">

                    <a
                        href="{{ route('dashboard') }}"
                        class="dashboard-nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                    >
                        Home
                    </a>

                    @if($user && ($user->hasRole('admin_gudang') || $user->hasRole('admin_kantor') || $user->hasRole('pimpinan_cabang')))
                        <a
                            href="{{ route('ba-rampung.index') }}"
                            class="dashboard-nav-link {{ request()->routeIs('ba-rampung.*') ? 'active' : '' }}"
                        >
                            BA Rampung
                        </a>
                    @endif

                    @if($user && $user->hasRole('admin_kantor'))
                        <div class="app-dropdown">
                            <a
                                href="#"
                                class="dashboard-nav-link {{ request()->routeIs('gudang.*', 'mitra.*', 'pimpinan.*') ? 'active' : '' }}"
                            >
                                Master Data
                            </a>

                            <div class="app-dropdown-menu">
                                <a
                                    href="{{ route('gudang.index') }}"
                                    class="app-dropdown-item"
                                >
                                    Gudang
                                </a>

                                <a
                                    href="{{ route('mitra.index') }}"
                                    class="app-dropdown-item"
                                >
                                    Mitra
                                </a>

                                <a
                                    href="{{ route('pimpinan.index') }}"
                                    class="app-dropdown-item"
                                >
                                    Pimpinan
                                </a>
                            </div>
                        </div>
                    @endif

                    @if($user && ($user->hasRole('admin_gudang') || $user->hasRole('admin_kantor') || $user->hasRole('pimpinan_cabang')))
                        <a
                            href="{{ route('laporan.index') }}"
                            class="dashboard-nav-link {{ request()->routeIs('laporan.*') ? 'active' : '' }}"
                        >
                            Laporan
                        </a>
                    @endif

                    @if($user && $user->hasRole('admin_kantor'))
                        <a
                            href="{{ route('pengaturan.umum') }}"
                            class="dashboard-nav-link {{ request()->routeIs('pengaturan.*') ? 'active' : '' }}"
                        >
                            Pengaturan
                        </a>
                    @endif

                </div>

                <div class="dashboard-user-area">

                    <div class="dashboard-user-info">
                        <div class="dashboard-user-name">
                            {{ $user?->name ?? 'User' }}
                        </div>

                        <div class="dashboard-user-role">
                            {{ $user?->roleLabel() ?? 'Pengguna' }}
                        </div>
                    </div>

                    <div class="dashboard-user-avatar">
                        {{ strtoupper(substr($user?->name ?? 'U', 0, 1)) }}
                    </div>

                    <form
                        action="{{ route('logout') }}"
                        method="POST"
                    >
                        @csrf

                        <button
                            type="submit"
                            class="dashboard-logout"
                            title="Keluar"
                        >
                            <svg
                                width="18"
                                height="18"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                                <polyline points="16 17 21 12 16 7"/>
                                <line x1="21" y1="12" x2="9" y2="12"/>
                            </svg>
                        </button>
                    </form>

                </div>
            </div>
        </nav>

        {{-- DASHBOARD CONTENT --}}
<main
    class="relative"
    style="z-index: 20;"
>

            @if(session('success'))
                <div class="px-6 pt-6">
                    <div class="rounded-xl bg-green-50 border border-green-200 px-5 py-4 text-sm font-semibold text-green-700">
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="px-6 pt-6">
                    <div class="rounded-xl bg-red-50 border border-red-200 px-5 py-4 text-sm font-semibold text-red-700">
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="px-6 pt-6">
                    <div class="rounded-xl bg-red-50 border border-red-200 px-5 py-4 text-sm text-red-700">
                        <div class="font-bold mb-2">
                            Terjadi kesalahan:
                        </div>

                        <ul class="list-disc ml-5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            @yield('content')

        </main>

<footer
    class="dashboard-footer relative"
    style="z-index: 20;"
>            <div>
                <strong>BA Rampung BULOG</strong>
                &copy; {{ date('Y') }}
            </div>

            <div>
                Sistem Administrasi Berita Acara Rampung
            </div>
        </footer>

    </div>

@else

    {{-- =========================================================
         GLOBAL NON-DASHBOARD LAYOUT
         SIDEBAR LAMA DIHILANGKAN DARI TAMPILAN
    ========================================================== --}}

    <div
        class="app-page-wrapper"
        x-data="{ mobileMenu: false }"
    >

        {{-- =====================================================
             TOP NAVBAR
        ====================================================== --}}
        <header class="app-top-navbar">

            <div class="app-nav-inner">

                {{-- BRAND --}}
                <a
                    href="{{ route('dashboard') }}"
                    class="app-brand"
                >
                    <img
                        src="{{ asset('assets/images/bulog-logo.png') }}"
                        alt="Logo BULOG"
                    >

                    <div class="app-brand-text">
                        <span class="app-brand-title">
                            BA Rampung
                        </span>

                        <span class="app-brand-subtitle">
                            Perum BULOG
                        </span>
                    </div>
                </a>

                {{-- MOBILE BUTTON --}}
                <button
                    type="button"
                    class="app-mobile-button"
                    @click="mobileMenu = !mobileMenu"
                    aria-label="Menu"
                >
                    <svg
                        x-show="!mobileMenu"
                        width="21"
                        height="21"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <line x1="4" y1="6" x2="20" y2="6"/>
                        <line x1="4" y1="12" x2="20" y2="12"/>
                        <line x1="4" y1="18" x2="20" y2="18"/>
                    </svg>

                    <svg
                        x-show="mobileMenu"
                        x-cloak
                        width="21"
                        height="21"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <line x1="6" y1="6" x2="18" y2="18"/>
                        <line x1="18" y1="6" x2="6" y2="18"/>
                    </svg>
                </button>

                {{-- NAVIGATION --}}
                <nav
                    class="app-main-nav"
                    :class="{ 'mobile-open': mobileMenu }"
                >

                    {{-- HOME --}}
                    <a
                        href="{{ route('dashboard') }}"
                        class="app-nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                    >
                        <svg
                            width="16"
                            height="16"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path d="m3 10 9-7 9 7"/>
                            <path d="M5 9v11h14V9"/>
                        </svg>

                        Home
                    </a>

                    {{-- BA RAMPUNG --}}
                    @if($user && (
                        $user->hasRole('admin_gudang') ||
                        $user->hasRole('admin_kantor') ||
                        $user->hasRole('pimpinan_cabang')
                    ))

                        <div class="app-dropdown">

                            <a
                                href="{{ route('ba-rampung.index') }}"
                                class="app-nav-link {{ request()->routeIs('ba-rampung.*') ? 'active' : '' }}"
                            >
                                <svg
                                    width="16"
                                    height="16"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                >
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                    <polyline points="14 2 14 8 20 8"/>
                                    <line x1="8" y1="13" x2="16" y2="13"/>
                                    <line x1="8" y1="17" x2="14" y2="17"/>
                                </svg>

                                BA Rampung
                            </a>

                            <div class="app-dropdown-menu">

                                <a
                                    href="{{ route('ba-rampung.index') }}"
                                    class="app-dropdown-item"
                                >
                                    Daftar BA Rampung
                                </a>

                                @if($user->hasRole('admin_gudang') || $user->hasRole('admin_kantor'))
                                    <a
                                        href="{{ route('ba-rampung.create') }}"
                                        class="app-dropdown-item"
                                    >
                                        Tambah BA Rampung
                                    </a>
                                @endif

                            </div>
                        </div>

                    @endif

                    {{-- MASTER DATA --}}
                    @if($user && $user->hasRole('admin_kantor'))

                        <div class="app-dropdown">

                            <a
                                href="#"
                                class="app-nav-link {{ request()->routeIs('gudang.*', 'mitra.*', 'pimpinan.*') ? 'active' : '' }}"
                            >
                                <svg
                                    width="16"
                                    height="16"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                >
                                    <path d="M3 21h18"/>
                                    <path d="M5 21V8l7-4 7 4v13"/>
                                    <path d="M9 21v-5h6v5"/>
                                </svg>

                                Master Data
                            </a>

                            <div class="app-dropdown-menu">

                                <a
                                    href="{{ route('gudang.index') }}"
                                    class="app-dropdown-item"
                                >
                                    Gudang
                                </a>

                                <a
                                    href="{{ route('mitra.index') }}"
                                    class="app-dropdown-item"
                                >
                                    Mitra
                                </a>

                                <a
                                    href="{{ route('pimpinan.index') }}"
                                    class="app-dropdown-item"
                                >
                                    Pimpinan
                                </a>

                            </div>
                        </div>

                    @endif

                    {{-- LAPORAN --}}
                    @if($user && (
                        $user->hasRole('admin_gudang') ||
                        $user->hasRole('admin_kantor') ||
                        $user->hasRole('pimpinan_cabang')
                    ))

                        <a
                            href="{{ route('laporan.index') }}"
                            class="app-nav-link {{ request()->routeIs('laporan.*') ? 'active' : '' }}"
                        >
                            <svg
                                width="16"
                                height="16"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <line x1="18" y1="20" x2="18" y2="10"/>
                                <line x1="12" y1="20" x2="12" y2="4"/>
                                <line x1="6" y1="20" x2="6" y2="14"/>
                            </svg>

                            Laporan
                        </a>

                    @endif

                    {{-- PENGATURAN --}}
                    @if($user && $user->hasRole('admin_kantor'))

                        <a
                            href="{{ route('pengaturan.umum') }}"
                            class="app-nav-link {{ request()->routeIs('pengaturan.*') ? 'active' : '' }}"
                        >
                            <svg
                                width="16"
                                height="16"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <circle cx="12" cy="12" r="3"/>
                                <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06-1.42 1.42-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21h-2v-.08a1.65 1.65 0 0 0-1-1.51 1.65 1.65 0 0 0-1.82.33l-.06.06-1.42-1.42.06-.06A1.65 1.65 0 0 0 8.6 15a1.65 1.65 0 0 0-1.51-1H7v-2h.09a1.65 1.65 0 0 0 1.51-1 1.65 1.65 0 0 0-.33-1.82l-.06-.06 1.42-1.42.06.06A1.65 1.65 0 0 0 11.5 8.6a1.65 1.65 0 0 0 1-1.51V7h2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06 1.42 1.42-.06.06A1.65 1.65 0 0 0 18.4 12c.1.55.56 1 1.11 1H20v2h-.09a1.65 1.65 0 0 0-.51 0z"/>
                            </svg>

                            Pengaturan
                        </a>

                    @endif

                </nav>

                {{-- USER --}}
                <div class="app-user-area">

                    <div class="app-user-info">
                        <span class="app-user-name">
                            {{ $user?->name ?? 'User' }}
                        </span>

                        <span class="app-user-role">
                            {{ $user?->roleLabel() ?? 'Pengguna' }}
                        </span>
                    </div>

                    <div class="app-user-avatar">
                        {{ strtoupper(substr($user?->name ?? 'U', 0, 1)) }}
                    </div>

                    <form
                        action="{{ route('logout') }}"
                        method="POST"
                    >
                        @csrf

                        <button
                            type="submit"
                            class="app-logout"
                            title="Keluar"
                        >
                            <svg
                                width="17"
                                height="17"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                                <polyline points="16 17 21 12 16 7"/>
                                <line x1="21" y1="12" x2="9" y2="12"/>
                            </svg>
                        </button>
                    </form>

                </div>

            </div>

        </header>


        {{-- =====================================================
             PAGE HERO
        ====================================================== --}}

        @php
            $pageTitle = trim($__env->yieldContent('title'));

            if (!$pageTitle) {
                $pageTitle = 'BA Rampung BULOG';
            }

            $pageDescription = trim($__env->yieldContent('page-description'));
        @endphp

        <section class="app-page-hero">

            <div class="app-page-hero-inner">

                <div class="app-page-kicker">
                    Sistem Administrasi BULOG
                </div>

                <h1 class="app-page-title">
                    {{ $pageTitle }}
                </h1>

                @if($pageDescription)
                    <p class="app-page-description">
                        {{ $pageDescription }}
                    </p>
                @endif

            </div>

        </section>


        {{-- =====================================================
             ALERT
        ====================================================== --}}

        @if(session('success'))
            <div class="app-alert">
                <div class="app-alert-box app-alert-success">
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="app-alert">
                <div class="app-alert-box app-alert-error">
                    {{ session('error') }}
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="app-alert">

                <div class="app-alert-box app-alert-error">

                    <div style="font-weight:900;margin-bottom:7px;">
                        Terjadi kesalahan:
                    </div>

                    <ul style="margin:0;padding-left:20px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>

                </div>

            </div>
        @endif


        {{-- =====================================================
             MAIN CONTENT
        ====================================================== --}}

        <main class="app-page-main">

            @yield('content')

        </main>


        {{-- =====================================================
             FOOTER
        ====================================================== --}}

        <footer class="app-footer">

            <div class="app-footer-inner">

                <div>
                    <strong>BA Rampung BULOG</strong>
                    &copy; {{ date('Y') }}
                </div>

                <div>
                    Sistem Administrasi Berita Acara Rampung
                </div>

            </div>

        </footer>

    </div>

@endif

</body>
</html>