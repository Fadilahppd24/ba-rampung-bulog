<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <title>
        @yield('title', 'Dashboard') — Sistem BA Rampung BULOG Indramayu
    </title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

    {{-- Sembunyikan elemen Alpine (modal logout, dropdown notifikasi) sebelum Alpine siap --}}
    <style>[x-cloak] { display: none !important; }
        /* Popup konfirmasi logout: aturan khusus agar kontras mode gelap selalu terbaca. */
        html.dark-theme .logout-confirm-modal {
            background-color: #0b2949 !important;
            color: #f3f7fb !important;
            border: 1px solid rgba(203, 213, 225, 0.24) !important;
        }

        html.dark-theme .logout-confirm-modal h3 {
            color: #ffffff !important;
            -webkit-text-fill-color: #ffffff !important;
        }

        html.dark-theme .logout-confirm-modal p {
            color: #d5e0ec !important;
            -webkit-text-fill-color: #d5e0ec !important;
        }

        html.dark-theme .logout-confirm-modal > div:last-child > button {
            background-color: rgba(255, 255, 255, 0.08) !important;
            color: #ffffff !important;
            border-color: rgba(203, 213, 225, 0.32) !important;
        }

        html.dark-theme .logout-confirm-modal > div:last-child > button:hover {
            background-color: rgba(255, 255, 255, 0.15) !important;
        }

        html.dark-theme .logout-confirm-modal form button {
            background-color: #F28C28 !important;
            color: #ffffff !important;
            border-color: #F28C28 !important;
        }
</style>


    <style>
        /*
         * BA RAMPUNG BACKGROUND ONLY
         * Navbar tidak diubah.
         * Gambar gudang tetap diam ketika halaman di-scroll.
         */
        .ba-rampung-fixed-bg {
            min-height: 100vh;

            background-image:
                linear-gradient(
                    180deg,
                    rgba(244, 241, 234, 0.10) 0%,
                    rgba(244, 241, 234, 0.30) 45%,
                    rgba(244, 241, 234, 0.88) 100%
                ),
                url('/images/dashboard-bulog.jpg');

            background-size: cover;
            background-position: center top;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

        @media (max-width: 1023px) {
            .ba-rampung-fixed-bg {
                background-attachment: scroll;
            }
        }

        /* =========================================================
         * DARK / LIGHT MODE
         * Hanya mengubah tampilan. Backend, route, form dan database
         * tidak diubah.
         * ========================================================= */

        html {
            color-scheme: light;
        }

        html.dark-theme {
            color-scheme: dark;
        }

        html.dark-theme body {
            background-color: #071a2e !important;
            color: #e7eef7 !important;
        }

        html.dark-theme .ba-rampung-fixed-bg {
            background-image:
                linear-gradient(
                    180deg,
                    rgba(3, 17, 33, 0.28) 0%,
                    rgba(3, 17, 33, 0.48) 48%,
                    rgba(3, 17, 33, 0.88) 100%
                ),
                url('/images/dashboard-bulog.jpg');
        }

        /* Avatar inisial navbar: pastikan kontras tetap jelas pada mode gelap. */
        html.dark-theme .user-avatar-initial {
            background-color: rgba(255, 255, 255, .14) !important;
            color: #FFFFFF !important;
            border-color: rgba(255, 255, 255, .45) !important;
            opacity: 1 !important;
            -webkit-text-fill-color: #FFFFFF !important;
        }

        /* Card putih */
        html.dark-theme .bg-white {
            background-color: rgba(10, 31, 54, 0.88) !important;
            color: #e7eef7;
        }

        html.dark-theme [class~="bg-white/80"] {
            background-color: rgba(7, 26, 46, 0.82) !important;
        }

        html.dark-theme [class~="bg-white/95"] {
            background-color: rgba(7, 26, 46, 0.96) !important;
        }

        /* Teks */
        html.dark-theme .text-gray-900,
        html.dark-theme .text-gray-800,
        html.dark-theme .text-gray-700,
        html.dark-theme .text-slate-900,
        html.dark-theme .text-slate-800,
        html.dark-theme .text-slate-700,
        html.dark-theme .text-slate-600 {
            color: #e7eef7 !important;
        }

        html.dark-theme .text-slate-500,
        html.dark-theme .text-gray-500,
        html.dark-theme .text-slate-400,
        html.dark-theme .text-gray-400 {
            color: #9fb1c7 !important;
        }

        /* Border */
        html.dark-theme .border-slate-200,
        html.dark-theme .border-gray-200 {
            border-color: rgba(148, 163, 184, 0.20) !important;
        }

        /* Dropdown */
        html.dark-theme .group-hover\:block > div,
        html.dark-theme .absolute .bg-white {
            background-color: #0b2949 !important;
            border-color: rgba(148, 163, 184, 0.20) !important;
        }

        /* Modal Semua Notifikasi */
        html.dark-theme .dark-notification-modal {
            background-color: #0b2949 !important;
            border-color: rgba(148, 163, 184, 0.22) !important;
            color: #e7eef7 !important;
        }

        html.dark-theme .dark-notification-modal .border-slate-200,
        html.dark-theme .dark-notification-modal .border-slate-100 {
            border-color: rgba(148, 163, 184, 0.18) !important;
        }

        html.dark-theme .dark-notification-modal .text-\[\#082F63\] {
            color: #f3f7fb !important;
        }

        html.dark-theme .dark-notification-modal .text-slate-600,
        html.dark-theme .dark-notification-modal .text-slate-500,
        html.dark-theme .dark-notification-modal .text-slate-400 {
            color: #aebfd1 !important;
        }

        html.dark-theme .dark-notification-modal .hover\:bg-slate-50:hover {
            background-color: rgba(148, 163, 184, 0.08) !important;
        }

        html.dark-theme .dark-notification-modal .bg-slate-100 {
            background-color: rgba(148, 163, 184, 0.12) !important;
        }

        html.dark-theme .dark-notification-modal .bg-slate-50 {
            background-color: rgba(148, 163, 184, 0.08) !important;
        }

        html.dark-theme .dark-notification-modal .border-orange-200 {
            border-color: rgba(242, 140, 40, 0.30) !important;
        }

        html.dark-theme .hover\:bg-slate-50:hover,
        html.dark-theme .bg-slate-50 {
            background-color: rgba(148, 163, 184, 0.10) !important;
        }

        /* Input / select / textarea */
        html.dark-theme input,
        html.dark-theme select,
        html.dark-theme textarea {
            background-color: rgba(5, 24, 43, 0.78) !important;
            color: #e7eef7 !important;
            border-color: rgba(148, 163, 184, 0.28) !important;
        }

        html.dark-theme input::placeholder,
        html.dark-theme textarea::placeholder {
            color: #7890aa !important;
        }

        html.dark-theme option {
            background-color: #0b2949;
            color: #e7eef7;
        }

        /* Tabel */
        html.dark-theme table {
            color: #e7eef7;
        }

        html.dark-theme thead,
        html.dark-theme [class*="bg-gray-50"] {
            background-color: rgba(148, 163, 184, 0.06) !important;
        }

        html.dark-theme tr {
            border-color: rgba(148, 163, 184, 0.14) !important;
        }

        /* Footer */
        html.dark-theme footer {
            background-color: rgba(7, 26, 46, 0.88) !important;
            border-color: rgba(148, 163, 184, 0.16) !important;
            color: #9fb1c7 !important;
        }

        /* Tombol mode */
        .theme-toggle {
            width: 38px;
            height: 38px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 9999px;
            border: 1px solid rgba(255,255,255,.35);
            background: rgba(255,255,255,.12);
            color: #fff;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            transition: .2s ease;
            cursor: pointer;
            flex-shrink: 0;
        }

        .theme-toggle:hover {
            background: rgba(255,255,255,.22);
            transform: translateY(-1px);
        }

        .theme-toggle .theme-icon-sun {
            display: inline-flex;
        }

        .theme-toggle .theme-icon-moon {
            display: none;
        }

        html.dark-theme .theme-toggle .theme-icon-sun {
            display: none;
        }

        html.dark-theme .theme-toggle .theme-icon-moon {
            display: inline-flex;
        }

        html.dark-theme .theme-toggle {
            border-color: rgba(255,255,255,.20);
            background: rgba(255,255,255,.10);
        }

        /* Dropdown notifikasi: pastikan semua teks terbaca pada mode gelap */
        html.dark-theme .dark-notification-dropdown {
            background-color: #0b2949 !important;
            color: #f3f7fb !important;
            border-color: rgba(203, 213, 225, 0.22) !important;
        }

        html.dark-theme .dark-notification-dropdown h3,
        html.dark-theme .dark-notification-dropdown .text-\\[\\#082f63\\],
        html.dark-theme .dark-notification-dropdown .text-\\[\\#123F7A\\],
        html.dark-theme .dark-notification-dropdown .text-slate-700,
        html.dark-theme .dark-notification-dropdown .text-slate-600 {
            color: #f3f7fb !important;
        }

        html.dark-theme .dark-notification-dropdown .text-slate-500,
        html.dark-theme .dark-notification-dropdown .text-slate-400 {
            color: #b7c7d9 !important;
        }

        html.dark-theme .dark-notification-dropdown .border-slate-100,
        html.dark-theme .dark-notification-dropdown .border-slate-200 {
            border-color: rgba(203, 213, 225, 0.16) !important;
        }

        html.dark-theme .dark-notification-dropdown .bg-white,
        html.dark-theme .dark-notification-dropdown .bg-slate-50,
        html.dark-theme .dark-notification-dropdown .bg-slate-50\\/70 {
            background-color: rgba(255, 255, 255, 0.045) !important;
        }

        html.dark-theme .dark-notification-dropdown .hover\\:bg-slate-50:hover {
            background-color: rgba(255, 255, 255, 0.09) !important;
        }

        html.dark-theme .dark-notification-dropdown .bg-orange-50\\/50 {
            background-color: rgba(242, 140, 40, 0.13) !important;
        }

        html.dark-theme .dark-notification-dropdown .text-\\[\\#F28C28\\] {
            color: #ffb45e !important;
        }



        /* =========================================================
         * PERBAIKAN KONTRAS DROPDOWN NOTIFIKASI MODE GELAP
         * Selector dibuat spesifik agar tidak kalah oleh utility Tailwind.
         * Mode terang tetap menggunakan style bawaan.
         * ========================================================= */
        html.dark-theme .dark-notification-dropdown {
            background: #0b2949 !important;
            color: #f3f7fb !important;
        }

        html.dark-theme .dark-notification-dropdown h3,
        html.dark-theme .dark-notification-dropdown p,
        html.dark-theme .dark-notification-dropdown button,
        html.dark-theme .dark-notification-dropdown span {
            text-shadow: none;
        }

        html.dark-theme .dark-notification-dropdown h3,
        html.dark-theme .dark-notification-dropdown .text-\[\#082f63\],
        html.dark-theme .dark-notification-dropdown .text-\[\#123F7A\],
        html.dark-theme .dark-notification-dropdown .text-slate-600,
        html.dark-theme .dark-notification-dropdown .text-slate-700 {
            color: #f3f7fb !important;
        }

        html.dark-theme .dark-notification-dropdown .text-slate-500,
        html.dark-theme .dark-notification-dropdown .text-slate-400,
        html.dark-theme .dark-notification-dropdown p {
            color: #c2d0df !important;
        }

        html.dark-theme .dark-notification-dropdown form > button {
            background-color: #0b2949 !important;
            color: #f3f7fb !important;
        }

        html.dark-theme .dark-notification-dropdown form > button.bg-orange-50\/50,
        html.dark-theme .dark-notification-dropdown form > button[class*="bg-orange-50"] {
            background-color: rgba(242, 140, 40, 0.13) !important;
        }

        html.dark-theme .dark-notification-dropdown form > button.bg-white,
        html.dark-theme .dark-notification-dropdown form > button[class*="bg-white"] {
            background-color: rgba(255, 255, 255, 0.035) !important;
        }

        html.dark-theme .dark-notification-dropdown form > button:hover {
            background-color: rgba(148, 163, 184, 0.16) !important;
        }

        html.dark-theme .dark-notification-dropdown form > button p {
            color: #d5e0ec !important;
        }

        html.dark-theme .dark-notification-dropdown form > button p.text-slate-400 {
            color: #aebfd1 !important;
        }

        html.dark-theme .dark-notification-dropdown form > button .text-\[\#082f63\] {
            color: #ffffff !important;
        }

        html.dark-theme .dark-notification-dropdown > div:first-child button,
        html.dark-theme .dark-notification-dropdown > div:last-child button {
            color: #ffffff !important;
        }

        html.dark-theme .dark-notification-dropdown > div:last-child {
            background-color: #102f50 !important;
            border-color: rgba(203, 213, 225, 0.20) !important;
        }

        html.dark-theme .dark-notification-dropdown .border-slate-100,
        html.dark-theme .dark-notification-dropdown .border-slate-200 {
            border-color: rgba(203, 213, 225, 0.18) !important;
        }

        html.dark-theme .dark-notification-dropdown .bg-slate-100 {
            background-color: rgba(226, 232, 240, 0.12) !important;
            color: #d5e0ec !important;
        }
    </style>


    <script>
        (function () {
            try {
                if (localStorage.getItem('bulog-theme') === 'dark') {
                    document.documentElement.classList.add('dark-theme');
                }
            } catch (e) {}
        })();
    </script>

</head>


<body
    class="
        text-gray-900
        antialiased
        bg-[#F4F1EA]
    "
    x-data="{ sidebarOpen: false }"
>


{{-- =========================================================
     DASHBOARD MODERN
     
     HANYA AKTIF UNTUK /dashboard
     
     HALAMAN LAIN TETAP MEMAKAI SIDEBAR + HEADER LAMA
========================================================= --}}

@if(request()->routeIs('dashboard') || request()->routeIs('ba-rampung.*') || request()->routeIs('gudang.*') || request()->routeIs('mitra.*') || request()->routeIs('pimpinan.*') || request()->routeIs('pengaturan.*'))


<div class="min-h-screen flex flex-col {{ request()->routeIs('ba-rampung.*') || request()->routeIs('gudang.*') || request()->routeIs('mitra.*') || request()->routeIs('pimpinan.*') || request()->routeIs('pengaturan.*') ? 'ba-rampung-fixed-bg' : '' }}">


    {{-- NAVBAR DASHBOARD --}}

        <header
            class="
                absolute
                inset-x-0
                top-0
                z-30
                w-full
                max-w-[1500px]
                mx-auto
                px-6
                py-5
                lg:px-10
            "
            style="
                background: transparent;
            "
        >

            <div
                class="
                    flex
                    items-center
                    justify-between
                    gap-5
                "
            >


                {{-- LOGO --}}

                <a
                    href="{{ route('dashboard') }}"
                    class="shrink-0"
                >

                    <img
                        src="{{ asset('assets/images/bulog-logo.png') }}"
                        alt="BULOG"
                        class="
                            w-[125px]
                            lg:w-[145px]
                            h-auto
                            object-contain
                        "
                    >

                </a>



                {{-- DESKTOP NAV --}}

                <nav
                    class="
                        hidden
                        lg:flex
                        items-center
                        gap-1
                    "
                >

                    {{-- HOME --}}

                    <a
                        href="{{ route('dashboard') }}"
                        class="
                            dashboard-nav-link
                            {{ request()->routeIs('dashboard') ? 'dashboard-nav-active' : '' }}
                        "
                    >
                        Home
                    </a>


                    {{-- BA RAMPUNG --}}
<a
    href="{{ route('ba-rampung.index') }}"
    class="dashboard-nav-link {{ request()->routeIs('ba-rampung.*') ? 'dashboard-nav-active' : '' }}"
>
    BA Rampung
</a>

                    {{-- MASTER DATA --}}

                    @if(auth()->user()?->isAdminKantor())
                        <div class="relative group">
                            <a href="#" class="dashboard-nav-link inline-flex items-center gap-1 {{ request()->routeIs('gudang.*') || request()->routeIs('mitra.*') || request()->routeIs('pimpinan.*') ? 'dashboard-nav-active' : '' }}">
                                Master Data
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="m6 9 6 6 6-6"/>
                                </svg>
                            </a>

                            <div class="absolute left-0 top-full z-[100] hidden min-w-[220px] pt-2 group-hover:block">
                                <div class="rounded-2xl border border-slate-200 bg-white p-2 shadow-2xl">
                                    <a href="{{ route('gudang.index') }}" class="block rounded-xl px-4 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50 hover:text-[#123F7A] {{ request()->routeIs('gudang.*') ? 'bg-slate-50 text-[#123F7A]' : '' }}">Gudang</a>
                                    <a href="{{ route('mitra.index') }}" class="block rounded-xl px-4 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50 hover:text-[#123F7A] {{ request()->routeIs('mitra.*') ? 'bg-slate-50 text-[#123F7A]' : '' }}">Mitra</a>
                                    <a href="{{ route('pimpinan.index') }}" class="block rounded-xl px-4 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50 hover:text-[#123F7A] {{ request()->routeIs('pimpinan.*') ? 'bg-slate-50 text-[#123F7A]' : '' }}">Pimpinan</a>
                                </div>
                            </div>
                        </div>
                    @endif
                    {{-- PENGATURAN --}}

                    @if(auth()->user()?->isAdminKantor())
                        <a
href="{{ route('pengaturan.users.index') }}"                            class="dashboard-nav-link {{ request()->routeIs('pengaturan.*') ? 'dashboard-nav-active' : '' }}"
                        >
                            Pengaturan
                        </a>
                    @endif

                </nav>



                {{-- RIGHT NAV --}}

                <div
                    class="
                        hidden
                        lg:flex
                        items-center
                        gap-4
                    "
                >






                    {{-- THEME TOGGLE --}}

                    <button
                        type="button"
                        id="themeToggle"
                        class="theme-toggle"
                        aria-label="Ganti mode tampilan"
                        title="Ganti mode tampilan"
                    >
                        <span class="theme-icon-sun" aria-hidden="true">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <circle cx="12" cy="12" r="4"></circle>
                                <path d="M12 2v2M12 20v2M4.93 4.93l1.42 1.42M17.65 17.65l1.42 1.42M2 12h2M20 12h2M4.93 19.07l1.42-1.42M17.65 6.35l1.42-1.42"></path>
                            </svg>
                        </span>
                        <span class="theme-icon-moon" aria-hidden="true">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <path d="M21 12.8A8.5 8.5 0 1 1 11.2 3 6.7 6.7 0 0 0 21 12.8Z"></path>
                            </svg>
                        </span>
                    </button>

                    {{-- =================================================
                         NOTIFIKASI
                    ================================================== --}}
                    @php
                        $notifikasiTerbaru = \App\Models\Notification::query()
                            ->where('user_id', auth()->id())
                            ->latest()
                            ->take(5)
                            ->get();

                        $jumlahNotifikasi = \App\Models\Notification::query()
                            ->where('user_id', auth()->id())
                            ->where('is_read', false)
                            ->count();

                        $semuaNotifikasi = \App\Models\Notification::query()
                            ->where('user_id', auth()->id())
                            ->latest()
                            ->get();
                    @endphp

                    <div
                        class="relative"
                        x-data="{ notificationOpen: false, showAllNotifications: false, notificationFilter: 'all' }"
                        @click.outside="notificationOpen = false"
                    >
                        {{-- TOMBOL BELL --}}
                        <button
                            type="button"
                            @click="notificationOpen = !notificationOpen"
                            class="relative text-white hover:text-orange-300 transition"
                            title="Notifikasi"
                            aria-label="Notifikasi"
                            id="ba-notification-bell"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-6 w-6"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-width="1.7"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9"
                                />
                                <path
                                    stroke-width="1.7"
                                    stroke-linecap="round"
                                    d="M10 21h4"
                                />
                            </svg>

                            @if($jumlahNotifikasi > 0)
                                <span
                                    class="
                                        absolute
                                        -right-2
                                        -top-2
                                        min-w-[18px]
                                        h-[18px]
                                        rounded-full
                                        bg-[#F28C28]
                                        px-1
                                        text-[10px]
                                        font-bold
                                        text-white
                                        flex
                                        items-center
                                        justify-center
                                        ring-2
                                        ring-[#082F63]
                                    "
                                >
                                    {{ $jumlahNotifikasi > 99 ? '99+' : $jumlahNotifikasi }}
                                </span>
                            @endif
                        </button>

                        {{-- DROPDOWN NOTIFIKASI --}}
                        <div
                            x-show="notificationOpen"
                            x-cloak
                            x-transition.origin.top.right
                            class="
                                absolute
                                right-0
                                top-[calc(100%+12px)]
                                z-[999]
                                w-[360px]
                                max-w-[calc(100vw-32px)]
                                overflow-hidden
                                rounded-2xl
                                border
                                border-slate-200
                                bg-white
                                shadow-2xl
                                dark-notification-dropdown
                            "
                        >
                            {{-- HEADER --}}
                            <div
                                class="
                                    flex
                                    items-center
                                    justify-between
                                    border-b
                                    border-slate-100
                                    px-4
                                    py-3
                                "
                            >
                                <div>
                                    <h3 class="text-sm font-bold text-[#082f63]">
                                        Notifikasi
                                    </h3>
                                    <p class="mt-0.5 text-[11px] text-slate-400">
                                        <span id="ba-notification-unread">{{ $jumlahNotifikasi }}</span> belum dibaca
                                    </p>
                                </div>

                                @if($jumlahNotifikasi > 0)
                                    <form
                                        method="POST"
                                        action="{{ route('notifications.read-all') }}"
                                    >
                                        @csrf
                                        @method('PATCH')

                                        <button
                                            type="submit"
                                            class="
                                                text-[11px]
                                                font-semibold
                                                text-[#123F7A]
                                                hover:text-[#F28C28]
                                                transition
                                            "
                                        >
                                            Tandai semua
                                        </button>
                                    </form>
                                @endif
                            </div>

                            {{-- DAFTAR --}}
                            <div id="ba-notification-latest" class="max-h-[380px] overflow-y-auto">
                                @forelse($notifikasiTerbaru as $notification)
                                    <form
                                        method="POST"
                                        action="{{ route('notifications.read', $notification) }}"
                                    >
                                        @csrf
                                        @method('PATCH')

                                        <button
                                            type="submit"
                                            class="
                                                group
                                                flex
                                                w-full
                                                items-start
                                                gap-3
                                                border-b
                                                border-slate-100
                                                px-4
                                                py-3.5
                                                text-left
                                                transition
                                                hover:bg-slate-50
                                                {{ !$notification->is_read
                                                    ? 'bg-orange-50/50'
                                                    : 'bg-white' }}
                                            "
                                        >
                                            <div
                                                class="
                                                    mt-0.5
                                                    flex
                                                    h-9
                                                    w-9
                                                    flex-shrink-0
                                                    items-center
                                                    justify-center
                                                    rounded-xl
                                                    {{ !$notification->is_read
                                                        ? 'bg-orange-100 text-[#F28C28]'
                                                        : 'bg-slate-100 text-slate-400' }}
                                                "
                                            >
                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    fill="none"
                                                    viewBox="0 0 24 24"
                                                    stroke-width="1.8"
                                                    stroke="currentColor"
                                                    class="h-4 w-4"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        d="M9 12.75 11.25 15 15 9.75"
                                                    />
                                                </svg>
                                            </div>

                                            <div class="min-w-0 flex-1">
                                                <div class="flex items-start justify-between gap-2">
                                                    <p
                                                        class="
                                                            text-xs
                                                            font-bold
                                                            {{ !$notification->is_read
                                                                ? 'text-[#082f63]'
                                                                : 'text-slate-600' }}
                                                        "
                                                    >
                                                        {{ $notification->title }}
                                                    </p>

                                                    @if(!$notification->is_read)
                                                        <span
                                                            class="
                                                                mt-1
                                                                h-2
                                                                w-2
                                                                flex-shrink-0
                                                                rounded-full
                                                                bg-[#F28C28]
                                                            "
                                                        ></span>
                                                    @endif
                                                </div>

                                                <p
                                                    class="
                                                        mt-1
                                                        line-clamp-2
                                                        text-[11px]
                                                        leading-relaxed
                                                        text-slate-500
                                                    "
                                                >
                                                    {{ $notification->message }}
                                                </p>

                                                <p class="mt-1.5 text-[10px] text-slate-400">
                                                    {{ $notification->created_at->diffForHumans() }}
                                                </p>
                                            </div>
                                        </button>
                                    </form>
                                @empty
                                    <div class="px-5 py-10 text-center">
                                        <div
                                            class="
                                                mx-auto
                                                flex
                                                h-12
                                                w-12
                                                items-center
                                                justify-center
                                                rounded-full
                                                bg-slate-100
                                                text-slate-400
                                            "
                                        >
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke-width="1.6"
                                                stroke="currentColor"
                                                class="h-5 w-5"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M14.857 17.082a23.848 23.848 0 0 1-5.714 0A2.25 2.25 0 0 1 7.5 14.85V11a4.5 4.5 0 1 1 9 0v3.85a2.25 2.25 0 0 1-1.643 2.232ZM9.75 18.75a2.25 2.25 0 0 0 4.5 0"
                                                />
                                            </svg>
                                        </div>

                                        <p class="mt-3 text-xs font-semibold text-slate-500">
                                            Belum ada notifikasi
                                        </p>
                                    </div>
                                @endforelse
                            </div>

                            {{-- FOOTER --}}
                            @if($notifikasiTerbaru->count() > 0)
                                <div
                                    class="
                                        border-t
                                        border-slate-100
                                        bg-slate-50/70
                                        px-4
                                        py-3
                                        text-center
                                    "
                                >
                                    <button
                                        type="button"
                                        @click="notificationOpen = false; showAllNotifications = true"
                                        class="
                                            text-xs
                                            font-bold
                                            text-[#123F7A]
                                            hover:text-[#F28C28]
                                            transition
                                        "
                                    >
                                        Lihat semua notifikasi
                                    </button>
                                </div>
                            @endif
                        </div>

                        {{-- MODAL SEMUA NOTIFIKASI --}}
                        <div
                            x-show="showAllNotifications"
                            x-cloak
                            x-transition.opacity
                            class="fixed inset-0 z-[9998] flex items-center justify-center bg-black/55 px-4 backdrop-blur-sm"
                            @click.self="showAllNotifications = false"
                        >
                            <div
                                x-show="showAllNotifications"
                                x-transition
                                class="w-full max-w-2xl overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-2xl dark-notification-modal"
                            >
                                {{-- HEADER --}}
                                <div class="flex items-start justify-between border-b border-slate-200 px-6 py-5">
                                    <div>
                                        <p class="text-xs font-semibold tracking-[0.18em] text-[#F28C28]">
                                            NOTIFIKASI
                                        </p>
                                        <h2 class="mt-1 text-2xl font-bold text-[#082F63]">
                                            Semua Notifikasi
                                        </h2>
                                        <p class="mt-1 text-xs text-slate-400">
                                            Seluruh pemberitahuan dari Sistem BA Rampung.
                                        </p>
                                    </div>

                                    <button
                                        type="button"
                                        @click="showAllNotifications = false"
                                        class="rounded-xl p-2 text-slate-400 transition hover:bg-slate-100 hover:text-slate-700"
                                        aria-label="Tutup"
                                    >
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 6l12 12M18 6 6 18"/>
                                        </svg>
                                    </button>
                                </div>

                                {{-- FILTER --}}
                                <div class="flex gap-2 border-b border-slate-200 px-6 py-3">
                                    <button
                                        type="button"
                                        @click="notificationFilter = 'all'"
                                        :class="notificationFilter === 'all'
                                            ? 'bg-[#123F7A] text-white'
                                            : 'text-slate-500 hover:bg-slate-100'"
                                        class="rounded-full px-4 py-2 text-xs font-bold transition"
                                    >
                                        Semua (<span id="ba-notification-total">{{ $semuaNotifikasi->count() }}</span>)
                                    </button>

                                    <button
                                        type="button"
                                        @click="notificationFilter = 'unread'"
                                        :class="notificationFilter === 'unread'
                                            ? 'bg-[#123F7A] text-white'
                                            : 'text-slate-500 hover:bg-slate-100'"
                                        class="rounded-full px-4 py-2 text-xs font-semibold transition"
                                    >
                                        Belum Dibaca (<span id="ba-notification-modal-unread">{{ $jumlahNotifikasi }}</span>)
                                    </button>
                                </div>

                                {{-- LIST --}}
                                <div id="ba-notification-all" class="max-h-[55vh] overflow-y-auto px-5 py-2">
                                    @forelse($semuaNotifikasi as $notification)
                                        <form
                                            x-show="notificationFilter === 'all' || {{ $notification->is_read ? 'false' : 'true' }}"
                                            method="POST"
                                            action="{{ route('notifications.read', $notification) }}"
                                            class="border-b border-slate-100 last:border-b-0"
                                        >
                                            @csrf
                                            @method('PATCH')

                                            <button
                                                type="submit"
                                                class="group flex w-full items-start gap-4 px-2 py-4 text-left transition hover:bg-slate-50"
                                            >
                                                <div
                                                    class="mt-0.5 flex h-11 w-11 shrink-0 items-center justify-center rounded-xl
                                                        {{ !$notification->is_read
                                                            ? 'bg-orange-100 text-[#F28C28]'
                                                            : 'bg-slate-100 text-slate-400' }}"
                                                >
                                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                            d="M9 12.75 11.25 15 15 9.75"/>
                                                    </svg>
                                                </div>

                                                <div class="min-w-0 flex-1">
                                                    <div class="flex items-start justify-between gap-3">
                                                        <p class="text-sm font-bold
                                                            {{ !$notification->is_read ? 'text-[#082F63]' : 'text-slate-600' }}">
                                                            {{ $notification->title }}
                                                        </p>

                                                        @if(!$notification->is_read)
                                                            <span class="mt-1.5 h-2 w-2 shrink-0 rounded-full bg-[#F28C28]"></span>
                                                        @endif
                                                    </div>

                                                    <p class="mt-1 text-xs leading-relaxed text-slate-500">
                                                        {{ $notification->message }}
                                                    </p>

                                                    <p class="mt-2 text-[10px] text-slate-400">
                                                        {{ $notification->created_at->diffForHumans() }}
                                                    </p>
                                                </div>
                                            </button>
                                        </form>
                                    @empty
                                        <div class="px-5 py-12 text-center">
                                            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-slate-100 text-slate-400">
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6"
                                                        d="M14.857 17.082a23.848 23.848 0 0 1-5.714 0A2.25 2.25 0 0 1 7.5 14.85V11a4.5 4.5 0 1 1 9 0v3.85a2.25 2.25 0 0 1-1.643 2.232ZM9.75 18.75a2.25 2.25 0 0 0 4.5 0"/>
                                                </svg>
                                            </div>
                                            <p class="mt-3 text-sm font-semibold text-slate-500">
                                                Belum ada notifikasi.
                                            </p>
                                        </div>
                                    @endforelse

                                    @if($jumlahNotifikasi === 0)
                                        <div
                                            x-show="notificationFilter === 'unread'"
                                            class="px-5 py-12 text-center"
                                        >
                                            <p class="text-sm font-semibold text-slate-500">
                                                Tidak ada notifikasi yang belum dibaca.
                                            </p>
                                        </div>
                                    @endif
                                </div>

                                {{-- FOOTER --}}
                                <div class="border-t border-slate-200 px-6 py-4">
                                    <button
                                        type="button"
                                        @click="showAllNotifications = false"
                                        class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-100"
                                    >
                                        Tutup
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div
                        class="
                            h-7
                            w-px
                            bg-white/30
                        "
                    ></div>



                    {{-- USER --}}

                    <div
                        class="
                            flex
                            items-center
                            gap-3
                        "
                    >

                        <div
                            class="
                                flex
                                h-10
                                w-10
                                items-center
                                justify-center
                                rounded-full
                                border
                                border-white/50
                                bg-white/80
                                text-[#082F63]
                                user-avatar-initial
                                font-bold
                            "
                        >
                            {{ strtoupper(substr(auth()->user()->name ?? 'O', 0, 1)) }}
                        </div>


                        <div>

                            <p
                                class="
                                    text-xs
                                    font-bold
                                    text-white
                                "
                            >
                                {{ auth()->user()->name }}
                            </p>

                            <p
                                class="
                                    text-[10px]
                                    text-white/65
                                "
                            >
                                {{ auth()->user()?->roleLabel() ?? 'Pengguna' }}
                            </p>

                        </div>


                        {{-- LOGOUT + KONFIRMASI --}}
                        <div
                            class="relative"
                            x-data="{ logoutOpen: false }"
                        >
                            <button
                                type="button"
                                @click="logoutOpen = true"
                                class="
                                    text-xs
                                    text-white/70
                                    hover:text-white
                                    transition
                                "
                                title="Keluar"
                            >
                                Keluar
                            </button>

                            {{-- MODAL KONFIRMASI LOGOUT --}}
                            <div
                                x-show="logoutOpen"
                                x-cloak
                                x-transition
                                class="
                                    fixed
                                    inset-0
                                    z-[9999]
                                    flex
                                    items-center
                                    justify-center
                                    bg-black/50
                                    px-4
                                "
                                @click.self="logoutOpen = false"
                            >
                                <div
                                    x-show="logoutOpen"
                                    x-transition
                                    class="
                                        w-full
                                        max-w-sm
                                        rounded-2xl
                                        bg-white
                                        p-6
                                        shadow-2xl
                                        logout-confirm-modal
                                    "
                                >
                                    <div class="flex items-start gap-4">
                                        <div
                                            class="
                                                flex
                                                h-11
                                                w-11
                                                flex-shrink-0
                                                items-center
                                                justify-center
                                                rounded-full
                                                bg-orange-100
                                                text-[#F28C28]
                                            "
                                        >
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke-width="1.8"
                                                stroke="currentColor"
                                                class="h-5 w-5"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M12 9v3.75m0 3h.008v.008H12V15.75ZM10.29 3.86 1.82 18a1.5 1.5 0 0 0 1.29 2.25h17.78A1.5 1.5 0 0 0 22.18 18L13.71 3.86a1.98 1.98 0 0 0-3.42 0Z"
                                                />
                                            </svg>
                                        </div>

                                        <div>
                                            <h3 class="text-base font-bold text-[#082F63]">
                                                Keluar dari sistem?
                                            </h3>

                                            <p class="mt-1 text-sm leading-relaxed text-slate-500">
                                                Apakah Anda yakin ingin keluar dari sistem?
                                            </p>
                                        </div>
                                    </div>

                                    <div class="mt-6 flex justify-end gap-2">
                                        <button
                                            type="button"
                                            @click="logoutOpen = false"
                                            class="
                                                rounded-xl
                                                border
                                                border-slate-200
                                                px-4
                                                py-2
                                                text-sm
                                                font-semibold
                                                text-slate-600
                                                hover:bg-slate-50
                                                transition
                                            "
                                        >
                                            Batal
                                        </button>

                                        <form
                                            method="POST"
                                            action="{{ route('logout') }}"
                                            data-logout-form
                                        >
                                            @csrf

                                            <button
                                                type="submit"
                                                class="
                                                    rounded-xl
                                                    bg-[#F28C28]
                                                    px-4
                                                    py-2
                                                    text-sm
                                                    font-semibold
                                                    text-white
                                                    hover:bg-[#df7918]
                                                    transition
                                                "
                                            >
                                                Ya, Keluar
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>



                {{-- MOBILE BUTTON --}}

                <button
                    type="button"
                    class="
                        lg:hidden
                        flex
                        h-10
                        w-10
                        items-center
                        justify-center
                        rounded-xl
                        border
                        border-white/30
                        bg-white/10
                        text-white
                    "
                    @click="sidebarOpen = !sidebarOpen"
                >

                    <svg
                        class="h-5 w-5"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >

                        <path
                            stroke-width="2"
                            stroke-linecap="round"
                            d="M4 6h16M4 12h16M4 18h16"
                        />

                    </svg>

                </button>

            </div>



            {{-- MOBILE NAV --}}

            <div
                x-show="sidebarOpen"
                x-cloak
                class="
                    lg:hidden
                    mt-4
                    rounded-2xl
                    border
                    border-white/20
                    bg-[#082F63]/95
                    p-4
                    backdrop-blur-xl
                "
            >

                <div class="mb-3 flex items-center justify-between rounded-2xl border border-white/15 bg-white/10 px-4 py-3 text-white">
                    <span class="text-sm font-semibold">Mode Tampilan</span>
                    <button
                        type="button"
                        id="themeToggleMobile"
                        class="theme-toggle"
                        aria-label="Ganti mode tampilan"
                        title="Ganti mode tampilan"
                    >
                        <span class="theme-icon-sun" aria-hidden="true">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <circle cx="12" cy="12" r="4"></circle>
                                <path d="M12 2v2M12 20v2M4.93 4.93l1.42 1.42M17.65 17.65l1.42 1.42M2 12h2M20 12h2M4.93 19.07l1.42-1.42M17.65 6.35l1.42-1.42"></path>
                            </svg>
                        </span>
                        <span class="theme-icon-moon" aria-hidden="true">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <path d="M21 12.8A8.5 8.5 0 1 1 11.2 3 6.7 6.7 0 0 0 21 12.8Z"></path>
                            </svg>
                        </span>
                    </button>
                </div>

                <div class="space-y-1">

                    <a
                        href="{{ route('dashboard') }}"
                        class="mobile-dashboard-link"
                    >
                        Home
                    </a>

                    <a
                        href="{{ route('ba-rampung.index') }}"
                        class="mobile-dashboard-link"
                    >
                        BA Rampung
                    </a>

                    <a
                        href="{{ route('gudang.index') }}"
                        class="mobile-dashboard-link"
                    >
                        Master Data
                    </a>
@if(auth()->user()?->isAdminKantor())

                        <a
                            href="{{ route('pengaturan.users.index') }}"
                            class="mobile-dashboard-link"
                        >
                            Pengaturan
                        </a>

                    @endif

                </div>

            </div>

        </header>



        {{-- =================================================
             MAIN DASHBOARD
        ================================================== --}}

        <main
            class="
                relative
                z-10
                flex-1
                mx-auto
                w-full
                max-w-[1500px]
                px-6
                pb-10
                lg:px-10
                {{ request()->routeIs('ba-rampung.*') || request()->routeIs('gudang.*') || request()->routeIs('mitra.*') || request()->routeIs('pimpinan.*') || request()->routeIs('pengaturan.*') ? 'pt-28' : '' }}
            "
        >



            @yield('content')


        </main>


        {{-- =================================================
             FOOTER
        ================================================== --}}

        <footer
            class="
                relative
                z-10
                border-t
                border-slate-200/80
                bg-white/80
                backdrop-blur-md
            "
        >

            <div
                class="
                    mx-auto
                    max-w-[1500px]
                    px-6
                    py-5
                    lg:px-10
                    flex
                    flex-col
                    gap-3
                    text-xs
                    text-slate-500
                    sm:flex-row
                    sm:items-center
                    sm:justify-between
                "
            >

                <p>
                    © {{ date('Y') }} Perum BULOG. All rights reserved.
                </p>

                <div class="flex gap-5">

                    <span>
                        Kebijakan Privasi
                    </span>

                    <span>
                        Syarat dan Ketentuan
                    </span>

                    <span>
                        Bantuan
                    </span>

                </div>

            </div>

        </footer>


    </div>


@else


{{-- =========================================================
     HALAMAN LAIN
     
     TETAP PAKAI LAYOUT LAMA
========================================================= --}}

<div class="flex min-h-screen">

    @include('components.sidebar')


    <div
        class="
            flex-1
            flex
            flex-col
            min-w-0
        "
    >

        <x-header
            :title="trim($__env->yieldContent('title', 'Dashboard'))"
            :breadcrumbs="$breadcrumbs ?? []"
        />


        <main
            class="
                flex-1
                p-4
                lg:p-8
                space-y-6
            "
        >

         


            @yield('content')

        </main>

    </div>

</div>


@endif


{{-- =========================================================
     AUDIO LOGOUT (satu-satunya definisi, aktif di SEMUA halaman)

     Diletakkan di luar blok if/else di atas, karena dashboard
     memakai header inline sedangkan halaman lain memakai <x-header>.
     Form logout mana pun cukup diberi atribut: data-logout-form
========================================================= --}}
<audio
    id="logoutAudio"
    src="{{ asset('audio/logout.mp3') }}"
    preload="auto"
></audio>

<script>
    (function () {
        // Cegah inisialisasi ganda (mis. layout ter-include dua kali).
        if (window.__logoutAudioInit) return;
        window.__logoutAudioInit = true;

        var START_TIMEOUT_MS = 4000;   // audio harus mulai berbunyi dalam 4 detik
        var END_EXTRA_MS     = 2000;   // toleransi di atas durasi audio
        var END_DEFAULT_MS   = 10000;  // batas jika durasi tidak diketahui
        var ERROR_DELAY_MS   = 1800;   // jeda agar pesan diagnostik terbaca
        var busy = false;

        var MEDIA_ERRORS = {
            1: 'pemutaran dibatalkan (MEDIA_ERR_ABORTED)',
            2: 'gagal mengunduh file (MEDIA_ERR_NETWORK)',
            3: 'file rusak atau tidak bisa didekode (MEDIA_ERR_DECODE)',
            4: 'file tidak ditemukan atau format tidak didukung (MEDIA_ERR_SRC_NOT_SUPPORTED) — cek URL ' +
               'dan pastikan public/audio/logout.mp3 ada'
        };

        function showDiagnostic(message) {
            console.error('[Logout Audio] ' + message);

            var old = document.getElementById('logoutAudioNotice');
            if (old) old.remove();

            var box = document.createElement('div');
            box.id = 'logoutAudioNotice';
            box.setAttribute('role', 'alert');
            box.textContent = 'Suara logout tidak dapat diputar: ' + message + '. Anda tetap akan keluar.';
            box.style.cssText =
                'position:fixed;left:50%;bottom:24px;transform:translateX(-50%);' +
                'z-index:99999;max-width:min(92vw,560px);padding:12px 18px;' +
                'border-radius:12px;background:#7f1d1d;color:#fff;font-size:13px;' +
                'line-height:1.4;box-shadow:0 10px 30px rgba(0,0,0,.35);';
            document.body.appendChild(box);
        }

        function setBusy(form, state) {
            busy = state;
            var buttons = form.querySelectorAll('button[type="submit"], button:not([type])');
            for (var i = 0; i < buttons.length; i++) {
                buttons[i].disabled = state;
            }
        }

        function handleLogoutSubmit(event) {
            var form = event.target;

            if (!(form instanceof HTMLFormElement) || !form.hasAttribute('data-logout-form')) {
                return; // bukan form logout: jangan diganggu
            }

            event.preventDefault();

            if (busy) return; // klik ganda diabaikan, form.submit() hanya sekali

            setBusy(form, true);

            var audio = document.getElementById('logoutAudio');
            var finished = false;
            var startTimer = null;
            var endTimer = null;

            // Satu-satunya tempat form dikirim. Selalu berjalan paling banyak SEKALI.
            // Memanggil prototype.submit() melewati event "submit" sehingga tidak
            // masuk ke handler ini lagi (tidak ada loop) dan tidak terganggu
            // elemen form yang bernama "submit".
            function finish(problem) {
                if (finished) return;
                finished = true;

                clearTimeout(startTimer);
                clearTimeout(endTimer);

                var go = function () {
                    try {
                        HTMLFormElement.prototype.submit.call(form);
                    } catch (e) {
                        console.error('[Logout Audio] submit gagal', e);
                        setBusy(form, false); // jangan biarkan tombol macet
                    }
                };

                if (problem) {
                    showDiagnostic(problem);
                    setTimeout(go, ERROR_DELAY_MS);
                } else {
                    go();
                }
            }

            if (!audio) {
                finish('elemen #logoutAudio tidak ada di halaman');
                return;
            }

            audio.addEventListener('ended', function () { finish(); }, { once: true });

            audio.addEventListener('error', function () {
                var code = audio.error ? audio.error.code : 0;
                finish(MEDIA_ERRORS[code] || 'kesalahan audio tidak dikenal');
            }, { once: true });

            audio.addEventListener('playing', function () {
                clearTimeout(startTimer);
                var ms = isFinite(audio.duration) && audio.duration > 0
                    ? audio.duration * 1000 + END_EXTRA_MS
                    : END_DEFAULT_MS;
                endTimer = setTimeout(function () {
                    finish(); // pengaman: 'ended' tidak datang, tetap logout
                }, ms);
            }, { once: true });

            // Pengaman: audio tidak pernah mulai (jaringan macet, dll).
            startTimer = setTimeout(function () {
                finish('audio tidak mulai diputar dalam ' + (START_TIMEOUT_MS / 1000) + ' detik');
            }, START_TIMEOUT_MS);

            try {
                audio.currentTime = 0;
                var result = audio.play();

                if (result && typeof result.catch === 'function') {
                    result.catch(function (err) {
                        var name = err && err.name ? err.name : 'Error';
                        var hint = name === 'NotAllowedError'
                            ? 'browser memblokir autoplay (NotAllowedError)'
                            : name === 'NotSupportedError'
                                ? 'file tidak ditemukan atau format tidak didukung (NotSupportedError)'
                                : name + (err && err.message ? ': ' + err.message : '');
                        finish(hint);
                    });
                }
            } catch (err) {
                finish('play() melempar error: ' + (err && err.message ? err.message : err));
            }
        }

        // Event delegation pada document: satu listener saja, tetap bekerja untuk
        // form yang dirender belakangan (mis. di dalam modal Alpine x-show).
        document.addEventListener('submit', handleLogoutSubmit);

        // Tombol "Back" Chrome bisa memulihkan halaman dari bfcache dengan tombol
        // masih disabled dan busy=true. Pulihkan agar logout tidak macet.
        window.addEventListener('pageshow', function (e) {
            if (!e.persisted) return;
            busy = false;
            var forms = document.querySelectorAll('form[data-logout-form]');
            for (var i = 0; i < forms.length; i++) setBusy(forms[i], false);
            try { document.getElementById('logoutAudio').pause(); } catch (x) {}
        });
    })();
</script>


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const root = document.documentElement;
            const toggles = [
                document.getElementById('themeToggle'),
                document.getElementById('themeToggleMobile')
            ].filter(Boolean);

            function setTheme(theme) {
                root.classList.toggle('dark-theme', theme === 'dark');

                try {
                    localStorage.setItem('bulog-theme', theme);
                } catch (e) {}
            }

            toggles.forEach(function (toggle) {
                toggle.addEventListener('click', function () {
                    const isDark = root.classList.contains('dark-theme');
                    setTheme(isDark ? 'light' : 'dark');
                });
            });
        });
    </script>


@if (session('login_success'))
    <audio id="welcomeAudio"
           src="{{ asset('audio/welcome.mp3') }}"
           preload="auto"></audio>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const audio = document.getElementById('welcomeAudio');

            if (!audio) return;

            audio.play().catch(function () {
                const button = document.createElement('button');

                button.textContent = '▶ Putar suara sambutan';
                button.style.cssText =
                    'position:fixed;bottom:24px;right:24px;' +
                    'z-index:9999;padding:12px 18px;' +
                    'border:0;border-radius:10px;' +
                    'background:#102a56;color:white;cursor:pointer;';

                button.onclick = function () {
                    audio.play().then(function () {
                        button.remove();
                    });
                };

                document.body.appendChild(button);
            });
        });
    </script>
@endif



    {{-- Auto-update notifikasi tanpa reload, setiap 15 detik. --}}
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const bell = document.getElementById('ba-notification-bell');
        if (!bell) return;

        let loading = false;
        const idList = [
            'ba-notification-bell',
            'ba-notification-unread',
            'ba-notification-latest',
            'ba-notification-total',
            'ba-notification-modal-unread',
            'ba-notification-all'
        ];

        async function cekNotifikasi() {
            if (document.hidden || loading) return;
            loading = true;
            try {
                const result = await fetch(window.location.href, {
                    credentials: 'same-origin',
                    cache: 'no-store',
                    headers: { 'Accept': 'text/html', 'X-Requested-With': 'XMLHttpRequest' }
                });
                if (!result.ok || result.redirected) return;
                const html = await result.text();
                const terbaru = new DOMParser().parseFromString(html, 'text/html');

                // Jangan mengganti parent x-data: state Alpine dropdown/modal tetap hidup.
                for (const id of idList) {
                    const current = document.getElementById(id);
                    const next = terbaru.getElementById(id);
                    if (!current || !next || current.innerHTML === next.innerHTML) continue;

                    // Jangan ubah isi modal saat dibuka oleh pengguna.
                    if (id === 'ba-notification-all') {
                        const modal = current.closest('[x-show="showAllNotifications"]');
                        if (modal && getComputedStyle(modal).display !== 'none') continue;
                    }

                    // Untuk kontainer Alpine, bersihkan sebelum mengganti elemen anak.
                    if (id === 'ba-notification-all' && window.Alpine?.destroyTree) {
                        [...current.children].forEach(el => window.Alpine.destroyTree(el));
                    }
                    current.innerHTML = next.innerHTML;
                    if (id === 'ba-notification-all' && window.Alpine?.initTree) {
                        [...current.children].forEach(el => window.Alpine.initTree(el));
                    }
                }
            } catch (err) {
                console.warn('Gagal memperbarui notifikasi:', err);
            } finally {
                loading = false;
            }
        }
        window.setInterval(cekNotifikasi, 15000);
        window.addEventListener('focus', cekNotifikasi);
    });
    </script>

</body>

</html>