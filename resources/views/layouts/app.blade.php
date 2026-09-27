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
    /* =========================================================
       NAVBAR DROPDOWN — NATIVE HTML
       Tidak bergantung pada Alpine/JavaScript.
    ========================================================= */

    .dashboard-dropdown {
        position: relative;
        flex: 0 0 auto;
    }

    .dashboard-dropdown > summary {
        list-style: none;
        cursor: pointer;
        user-select: none;
    }

    .dashboard-dropdown > summary::-webkit-details-marker {
        display: none;
    }

    .dashboard-dropdown > summary {
        display: inline-flex !important;
        align-items: center;
        gap: 4px;
    }

    .dashboard-dropdown-chevron {
        width: 14px;
        height: 14px;
        flex: 0 0 14px;
        transition: transform .18s ease;
    }

    .dashboard-dropdown[open] .dashboard-dropdown-chevron {
        transform: rotate(180deg);
    }

    .dashboard-dropdown-menu {
        position: absolute;
        top: calc(100% + 10px);
        left: 0;
        z-index: 9999;

        width: 230px;
        padding: 8px;

        border: 1px solid rgba(15, 61, 115, .12);
        border-radius: 16px;

        background: rgba(255,255,255,.98);
        box-shadow:
            0 18px 45px rgba(8,47,99,.20),
            0 4px 12px rgba(8,47,99,.08);

        backdrop-filter: blur(16px);
    }

    .dashboard-dropdown-menu a {
        display: flex;
        align-items: center;

        min-height: 42px;
        padding: 10px 13px;

        border-radius: 11px;

        color: #173B67;
        background: transparent;

        font-size: 13px;
        font-weight: 600;
        text-decoration: none;

        transition: background .15s ease, color .15s ease;
    }

    .dashboard-dropdown-menu a:hover {
        color: #0D3F7A;
        background: #EEF5FC;
    }

    .dashboard-dropdown-right .dashboard-dropdown-menu {
        left: auto;
        right: 0;
    }

    @media (max-width: 1023px) {
        .dashboard-dropdown {
            width: 100%;
        }

        .dashboard-dropdown-menu {
            position: static;
            width: 100%;
            margin-top: 6px;
            box-shadow: none;
        }
    }
</style>

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

@if(request()->routeIs('dashboard'))


<div class="min-h-screen">


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
                            dashboard-nav-active
                        "
                    >
                        Home
                    </a>


                    {{-- BA RAMPUNG DROPDOWN --}}
                    <details class="dashboard-dropdown">
                        <summary class="dashboard-nav-link">
                            <span>BA Rampung</span>
                            <svg class="dashboard-dropdown-chevron" viewBox="0 0 24 24" fill="none">
                                <path d="m6 9 6 6 6-6" stroke="currentColor" stroke-width="2"
                                      stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </summary>

                        <div class="dashboard-dropdown-menu">
                            <a href="{{ route('ba-rampung.index') }}">
                                <span>Daftar BA Rampung</span>
                            </a>
                            <a href="{{ route('ba-rampung.create') }}">
                                <span>Buat BA Rampung</span>
                            </a>
                        </div>
                    </details>


                    {{-- MASTER DATA DROPDOWN --}}
                    @if(auth()->user()?->isAdminKantor())
                        <details class="dashboard-dropdown">
                            <summary class="dashboard-nav-link">
                                <span>Master Data</span>
                                <svg class="dashboard-dropdown-chevron" viewBox="0 0 24 24" fill="none">
                                    <path d="m6 9 6 6 6-6" stroke="currentColor" stroke-width="2"
                                          stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </summary>

                            <div class="dashboard-dropdown-menu">
                                <a href="{{ route('gudang.index') }}">
                                    <span>Data Gudang</span>
                                </a>
                                <a href="{{ route('mitra.index') }}">
                                    <span>Data Mitra Pengolahan</span>
                                </a>
                            </div>
                        </details>
                    @endif


                    {{-- LAPORAN --}}

                    <a
                        href="{{ route('laporan.index') }}"
                        class="dashboard-nav-link"
                    >
                        Laporan
                    </a>


                    {{-- ADMINISTRASI DROPDOWN --}}
                    @if(auth()->user()?->isAdminKantor())
                        <details class="dashboard-dropdown dashboard-dropdown-right">
                            <summary class="dashboard-nav-link">
                                <span>Administrasi</span>
                                <svg class="dashboard-dropdown-chevron" viewBox="0 0 24 24" fill="none">
                                    <path d="m6 9 6 6 6-6" stroke="currentColor" stroke-width="2"
                                          stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </summary>

                            <div class="dashboard-dropdown-menu">
                                <a href="{{ route('pengaturan.umum') }}">
                                    <span>Pengaturan Umum</span>
                                </a>
                            </div>
                        </details>
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


                    {{-- SEARCH --}}

                    <div
                        class="
                            flex
                            items-center
                            gap-2
                            rounded-full
                            border
                            border-white/40
                            bg-white/10
                            backdrop-blur-md
                            px-4
                            py-2
                            w-[215px]
                        "
                    >

                        <svg
                            class="h-4 w-4 text-white/80"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <circle
                                cx="11"
                                cy="11"
                                r="7"
                                stroke-width="2"
                            />

                            <path
                                d="m20 20-4-4"
                                stroke-width="2"
                                stroke-linecap="round"
                            />
                        </svg>

                        <input
                            type="text"
                            placeholder="Cari data, gudang, atau mitra..."
                            class="
                                w-full
                                bg-transparent
                                text-xs
                                text-white
                                placeholder:text-white/60
                                outline-none
                            "
                        >

                    </div>



                    {{-- NOTIFICATION --}}

                    <button
                        type="button"
                        class="
                            relative
                            text-white
                            hover:text-orange-300
                            transition
                        "
                    >

                        <svg
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


                        <span
                            class="
                                absolute
                                -right-0.5
                                top-0
                                h-2
                                w-2
                                rounded-full
                                bg-[#F28C28]
                                ring-2
                                ring-[#284F6A]
                            "
                        ></span>

                    </button>


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


                        <form
                            method="POST"
                            action="{{ route('logout') }}"
                        >

                            @csrf

                            <button
                                type="submit"
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

                        </form>

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

                    <a
                        href="{{ route('laporan.index') }}"
                        class="mobile-dashboard-link"
                    >
                        Laporan
                    </a>

                    @if(auth()->user()?->isAdminKantor())

                        <a
                            href="{{ route('pengaturan.umum') }}"
                            class="mobile-dashboard-link"
                        >
                            Administrasi
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
                mx-auto
                max-w-[1500px]
                px-6
                pb-10
                lg:px-10
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


</body>

</html>