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
                    @endphp

                    <div
                        class="relative"
                        x-data="{ notificationOpen: false }"
                        @click.outside="notificationOpen = false"
                    >
                        {{-- TOMBOL BELL --}}
                        <button
                            type="button"
                            @click="notificationOpen = !notificationOpen"
                            class="relative text-white hover:text-orange-300 transition"
                            title="Notifikasi"
                            aria-label="Notifikasi"
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
                                        {{ $jumlahNotifikasi }} belum dibaca
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
                            <div class="max-h-[380px] overflow-y-auto">
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
                                    <a
                                        href="{{ route('notifications.index') }}"
                                        @click="notificationOpen = false"
                                        class="
                                            text-xs
                                            font-bold
                                            text-[#123F7A]
                                            hover:text-[#F28C28]
                                            transition
                                        "
                                    >
                                        Lihat semua notifikasi
                                    </a>
                                </div>
                            @endif
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


            {{-- ALERT SUCCESS --}}

            @if (session('success'))

                <div
                    class="
                        mb-5
                        rounded-2xl
                        border
                        border-emerald-200
                        bg-emerald-50
                        px-5
                        py-4
                        text-sm
                        font-medium
                        text-emerald-700
                    "
                >
                    {{ session('success') }}
                </div>

            @endif


            {{-- ALERT ERROR --}}

            @if ($errors->any())

                <div
                    class="
                        mb-5
                        rounded-2xl
                        border
                        border-red-200
                        bg-red-50
                        px-5
                        py-4
                        text-sm
                        text-red-700
                    "
                >

                    <p class="font-semibold mb-1">
                        Terdapat kesalahan pada form:
                    </p>

                    <ul class="list-disc list-inside">

                        @foreach ($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            @endif


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

            @if (session('success'))

                <div
                    class="
                        rounded-xl
                        bg-success-bg
                        text-success-text
                        px-4
                        py-3
                        text-sm
                        font-medium
                    "
                >
                    {{ session('success') }}
                </div>

            @endif


            @if ($errors->any())

                <div
                    class="
                        rounded-xl
                        bg-danger-bg
                        text-danger-text
                        px-4
                        py-3
                        text-sm
                    "
                >

                    <p class="font-medium mb-1">
                        Terdapat kesalahan pada form:
                    </p>

                    <ul
                        class="
                            list-disc
                            list-inside
                            space-y-0.5
                        "
                    >

                        @foreach ($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            @endif


            @yield('content')

        </main>

    </div>

</div>


@endif


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

</body>

</html>