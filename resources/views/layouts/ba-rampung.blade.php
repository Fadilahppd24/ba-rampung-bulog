@php
    $user = auth()->user();
@endphp

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <title>
        @yield('title', 'BA Rampung') — Sistem BA Rampung BULOG
    </title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])
</head>


<body class="min-h-screen bg-[#f5f3ee] text-slate-800 antialiased">


    {{-- =========================================================
         TOP NAVBAR
    ========================================================== --}}
    <header class="sticky top-0 z-50 bg-white border-b border-slate-200">

        <div class="max-w-[1600px] mx-auto px-5 lg:px-8">

            <div class="h-[76px] flex items-center justify-between gap-6">


                {{-- =================================================
                     LOGO / BRAND
                ================================================== --}}
                <a
                    href="{{ route('dashboard') }}"
                    class="flex items-center gap-3 shrink-0"
                >

                    <div
                        class="w-11 h-11 rounded-xl bg-[#082F63] flex items-center justify-center overflow-hidden"
                    >

                        <img
                            src="{{ asset('images/logobulog.png') }}"
                            alt="BULOG"
                            class="w-9 h-9 object-contain"
                        >

                    </div>


                    <div class="hidden xl:block">

                        <div class="flex items-center gap-1.5">

                            <span class="text-[15px] font-bold text-[#082F63]">
                                Sistem BA Rampung
                            </span>

                            <span class="w-1.5 h-1.5 rounded-full bg-[#F28C28]"></span>

                        </div>

                        <p class="text-[10px] text-slate-400 mt-0.5">
                            BULOG Indramayu
                        </p>

                    </div>

                </a>



                {{-- =================================================
                     DESKTOP NAVIGATION
                ================================================== --}}
                <nav class="hidden lg:flex items-center gap-1 flex-1">


                    {{-- DASHBOARD --}}
                    <a
                        href="{{ route('dashboard') }}"
                        class="
                            px-3.5 py-2.5
                            rounded-xl
                            text-xs font-semibold
                            transition
                            whitespace-nowrap
                            {{ request()->routeIs('dashboard')
                                ? 'bg-[#082F63] text-white shadow-sm'
                                : 'text-slate-500 hover:text-[#082F63] hover:bg-blue-50'
                            }}
                        "
                    >
                        Dashboard
                    </a>



                    {{-- =================================================
                         BA RAMPUNG
                    ================================================== --}}
                    @if (
                        $user?->isAdminGudang()
                        || $user?->isAdminKantor()
                        || $user?->isPimpinanCabang()
                    )

                        <div class="relative group">

                            <button
                                type="button"
                                class="
                                    flex items-center gap-1.5
                                    px-3.5 py-2.5
                                    rounded-xl
                                    text-xs font-semibold
                                    transition
                                    whitespace-nowrap
                                    {{
                                        request()->routeIs('ba-rampung.*')
                                            ? 'bg-[#082F63] text-white'
                                            : 'text-slate-500 hover:text-[#082F63] hover:bg-blue-50'
                                    }}
                                "
                            >

                                BA Rampung

                                <svg
                                    class="w-3.5 h-3.5 transition-transform group-hover:rotate-180"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-width="2"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M6 9l6 6 6-6"
                                    />
                                </svg>

                            </button>


                            {{-- DROPDOWN BA RAMPUNG --}}
                            <div
                                class="
                                    absolute
                                    left-0
                                    top-full
                                    pt-2
                                    hidden
                                    group-hover:block
                                    z-50
                                "
                            >

                                <div
                                    class="
                                        w-56
                                        bg-white
                                        rounded-2xl
                                        border border-slate-200
                                        shadow-xl
                                        p-2
                                    "
                                >


                                    {{-- SEMUA BA --}}
                                    <a
                                        href="{{ route('ba-rampung.index') }}"
                                        class="
                                            flex items-center gap-3
                                            px-3 py-2.5
                                            rounded-xl
                                            text-xs
                                            transition
                                            {{
                                                request()->routeIs('ba-rampung.index')
                                                || request()->routeIs('ba-rampung.show')
                                                    ? 'bg-blue-50 text-[#082F63] font-semibold'
                                                    : 'text-slate-600 hover:bg-slate-50'
                                            }}
                                        "
                                    >

                                        <span
                                            class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center text-xs"
                                        >
                                            📄
                                        </span>

                                        <span>

                                            <span class="block">
                                                {{ $user?->isAdminGudang()
                                                    ? 'Daftar BA Rampung'
                                                    : 'Semua BA Rampung'
                                                }}
                                            </span>

                                            <span class="block text-[9px] text-slate-400 mt-0.5">
                                                Lihat data BA
                                            </span>

                                        </span>

                                    </a>



                                    {{-- BUAT BA --}}
                                    @can('create', \App\Models\BaRampung::class)

                                        <a
                                            href="{{ route('ba-rampung.create') }}"
                                            class="
                                                flex items-center gap-3
                                                px-3 py-2.5
                                                rounded-xl
                                                text-xs
                                                transition
                                                {{
                                                    request()->routeIs('ba-rampung.create')
                                                    || request()->routeIs('ba-rampung.edit')
                                                        ? 'bg-orange-50 text-orange-700 font-semibold'
                                                        : 'text-slate-600 hover:bg-slate-50'
                                                }}
                                            "
                                        >

                                            <span
                                                class="w-8 h-8 rounded-lg bg-orange-50 flex items-center justify-center text-orange-600"
                                            >
                                                +
                                            </span>

                                            <span>

                                                <span class="block">
                                                    Buat BA Rampung
                                                </span>

                                                <span class="block text-[9px] text-slate-400 mt-0.5">
                                                    Tambah berita acara
                                                </span>

                                            </span>

                                        </a>

                                    @endcan

                                </div>

                            </div>

                        </div>

                    @endif



                    {{-- =================================================
                         MASTER DATA
                    ================================================== --}}
                    @if ($user?->isAdminKantor())

                        <div class="relative group">

                            <button
                                type="button"
                                class="
                                    flex items-center gap-1.5
                                    px-3.5 py-2.5
                                    rounded-xl
                                    text-xs font-semibold
                                    transition
                                    whitespace-nowrap
                                    {{
                                        request()->routeIs('gudang.*')
                                        || request()->routeIs('mitra.*')
                                        || request()->routeIs('pimpinan.*')
                                            ? 'bg-[#082F63] text-white'
                                            : 'text-slate-500 hover:text-[#082F63] hover:bg-blue-50'
                                    }}
                                "
                            >

                                Master Data

                                <svg
                                    class="w-3.5 h-3.5 transition-transform group-hover:rotate-180"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-width="2"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M6 9l6 6 6-6"
                                    />
                                </svg>

                            </button>


                            {{-- DROPDOWN MASTER DATA --}}
                            <div
                                class="
                                    absolute
                                    left-0
                                    top-full
                                    pt-2
                                    hidden
                                    group-hover:block
                                    z-50
                                "
                            >

                                <div
                                    class="
                                        w-60
                                        bg-white
                                        rounded-2xl
                                        border border-slate-200
                                        shadow-xl
                                        p-2
                                    "
                                >


                                    {{-- GUDANG --}}
                                    <a
                                        href="{{ route('gudang.index') }}"
                                        class="
                                            flex items-center gap-3
                                            px-3 py-2.5
                                            rounded-xl
                                            text-xs
                                            transition
                                            {{
                                                request()->routeIs('gudang.*')
                                                    ? 'bg-blue-50 text-[#082F63] font-semibold'
                                                    : 'text-slate-600 hover:bg-slate-50'
                                            }}
                                        "
                                    >

                                        <span
                                            class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center"
                                        >
                                            🏠
                                        </span>

                                        <span>

                                            <span class="block">
                                                Gudang
                                            </span>

                                            <span class="block text-[9px] text-slate-400 mt-0.5">
                                                Data gudang
                                            </span>

                                        </span>

                                    </a>



                                    {{-- MITRA --}}
                                    <a
                                        href="{{ route('mitra.index') }}"
                                        class="
                                            flex items-center gap-3
                                            px-3 py-2.5
                                            rounded-xl
                                            text-xs
                                            transition
                                            {{
                                                request()->routeIs('mitra.*')
                                                    ? 'bg-blue-50 text-[#082F63] font-semibold'
                                                    : 'text-slate-600 hover:bg-slate-50'
                                            }}
                                        "
                                    >

                                        <span
                                            class="w-8 h-8 rounded-lg bg-orange-50 flex items-center justify-center"
                                        >
                                            🤝
                                        </span>

                                        <span>

                                            <span class="block">
                                                Mitra Pengolahan
                                            </span>

                                            <span class="block text-[9px] text-slate-400 mt-0.5">
                                                Data mitra
                                            </span>

                                        </span>

                                    </a>



                                    {{-- PIMPINAN --}}
                                    <a
                                        href="{{ route('pimpinan.index') }}"
                                        class="
                                            flex items-center gap-3
                                            px-3 py-2.5
                                            rounded-xl
                                            text-xs
                                            transition
                                            {{
                                                request()->routeIs('pimpinan.*')
                                                    ? 'bg-blue-50 text-[#082F63] font-semibold'
                                                    : 'text-slate-600 hover:bg-slate-50'
                                            }}
                                        "
                                    >

                                        <span
                                            class="w-8 h-8 rounded-lg bg-purple-50 flex items-center justify-center"
                                        >
                                            👤
                                        </span>

                                        <span>

                                            <span class="block">
                                                Pimpinan Cabang
                                            </span>

                                            <span class="block text-[9px] text-slate-400 mt-0.5">
                                                Data pimpinan
                                            </span>

                                        </span>

                                    </a>

                                </div>

                            </div>

                        </div>

                    @endif



                    {{-- =================================================
                         LAPORAN
                    ================================================== --}}
                    @if (
                        $user?->isAdminGudang()
                        || $user?->isAdminKantor()
                        || $user?->isPimpinanCabang()
                    )

                        <a
                            href="{{ route('laporan.index') }}"
                            class="
                                px-3.5 py-2.5
                                rounded-xl
                                text-xs font-semibold
                                transition
                                whitespace-nowrap
                                {{
                                    request()->routeIs('laporan.*')
                                        ? 'bg-[#082F63] text-white shadow-sm'
                                        : 'text-slate-500 hover:text-[#082F63] hover:bg-blue-50'
                                }}
                            "
                        >
                            Laporan
                        </a>

                    @endif



                    {{-- =================================================
                         PENGATURAN
                    ================================================== --}}
                    @if ($user?->isAdminKantor())

                        <a
                            href="{{ route('pengaturan.umum') }}"
                            class="
                                px-3.5 py-2.5
                                rounded-xl
                                text-xs font-semibold
                                transition
                                whitespace-nowrap
                                {{
                                    request()->routeIs('pengaturan.*')
                                        ? 'bg-[#082F63] text-white shadow-sm'
                                        : 'text-slate-500 hover:text-[#082F63] hover:bg-blue-50'
                                }}
                            "
                        >
                            Pengaturan
                        </a>

                    @endif

                </nav>



                {{-- =================================================
                     USER AREA
                ================================================== --}}
                <div class="flex items-center gap-3 shrink-0">


                    {{-- STATUS --}}
                    <div
                        class="
                            hidden xl:flex
                            items-center gap-2
                            px-3 py-2
                            rounded-full
                            bg-slate-50
                            border border-slate-200
                        "
                    >

                        <span class="relative flex w-2 h-2">

                            <span
                                class="
                                    absolute
                                    inline-flex
                                    w-full h-full
                                    rounded-full
                                    bg-emerald-400
                                    opacity-60
                                    animate-ping
                                "
                            ></span>

                            <span
                                class="
                                    relative
                                    inline-flex
                                    w-2 h-2
                                    rounded-full
                                    bg-emerald-500
                                "
                            ></span>

                        </span>

                        <span class="text-[10px] font-medium text-slate-500">
                            Sistem aktif
                        </span>

                    </div>



                    {{-- USER --}}
                    <div class="flex items-center gap-2">

                        <div
                            class="
                                w-9 h-9
                                rounded-full
                                bg-[#082F63]
                                text-white
                                flex items-center justify-center
                                text-xs font-bold
                            "
                        >
                            {{ strtoupper(substr($user?->name ?? 'U', 0, 1)) }}
                        </div>


                        <div class="hidden xl:block">

                            <p class="text-[11px] font-bold text-slate-700 leading-tight">
                                {{ $user?->name ?? 'User' }}
                            </p>

                            <p class="text-[9px] text-slate-400 mt-0.5">
                                {{ $user?->roleLabel() ?? 'Pengguna' }}
                            </p>

                        </div>

                    </div>



                    {{-- LOGOUT --}}
                    <form
                        method="POST"
                        action="{{ route('logout') }}"
                    >

                        @csrf

                        <button
                            type="submit"
                            class="
                                hidden md:inline-flex
                                h-9 px-3
                                rounded-lg
                                text-[11px]
                                font-semibold
                                text-slate-500
                                hover:text-red-600
                                hover:bg-red-50
                                transition
                            "
                        >
                            Keluar
                        </button>

                    </form>



                    {{-- MOBILE BUTTON --}}
                    <button
                        type="button"
                        id="baRampungMenuButton"
                        class="
                            lg:hidden
                            w-9 h-9
                            rounded-lg
                            border border-slate-200
                            text-slate-600
                            hover:bg-slate-50
                        "
                    >
                        ☰
                    </button>

                </div>

            </div>



            {{-- =====================================================
                 MOBILE NAVIGATION
            ====================================================== --}}
            <div
                id="baRampungMobileMenu"
                class="hidden lg:hidden border-t border-slate-100 py-4"
            >

                <div class="flex flex-col gap-1">


                    {{-- DASHBOARD --}}
                    <a
                        href="{{ route('dashboard') }}"
                        class="
                            px-4 py-3
                            rounded-xl
                            text-xs font-semibold
                            text-slate-600
                            hover:bg-blue-50
                        "
                    >
                        Dashboard
                    </a>



                    {{-- BA RAMPUNG --}}
                    @if (
                        $user?->isAdminGudang()
                        || $user?->isAdminKantor()
                        || $user?->isPimpinanCabang()
                    )

                        <div
                            class="
                                px-4 pt-3 pb-1
                                text-[9px]
                                uppercase
                                tracking-widest
                                text-slate-400
                            "
                        >
                            BA Rampung
                        </div>


                        <a
                            href="{{ route('ba-rampung.index') }}"
                            class="
                                px-4 py-3
                                rounded-xl
                                text-xs font-semibold
                                text-slate-600
                                hover:bg-blue-50
                            "
                        >
                            Semua BA Rampung
                        </a>


                        @can('create', \App\Models\BaRampung::class)

                            <a
                                href="{{ route('ba-rampung.create') }}"
                                class="
                                    px-4 py-3
                                    rounded-xl
                                    text-xs font-semibold
                                    text-slate-600
                                    hover:bg-orange-50
                                "
                            >
                                + Buat BA Rampung
                            </a>

                        @endcan

                    @endif



                    {{-- MASTER DATA --}}
                    @if ($user?->isAdminKantor())

                        <div
                            class="
                                px-4 pt-3 pb-1
                                text-[9px]
                                uppercase
                                tracking-widest
                                text-slate-400
                            "
                        >
                            Master Data
                        </div>


                        <a
                            href="{{ route('gudang.index') }}"
                            class="
                                px-4 py-3
                                rounded-xl
                                text-xs font-semibold
                                text-slate-600
                                hover:bg-blue-50
                            "
                        >
                            Gudang
                        </a>


                        <a
                            href="{{ route('mitra.index') }}"
                            class="
                                px-4 py-3
                                rounded-xl
                                text-xs font-semibold
                                text-slate-600
                                hover:bg-blue-50
                            "
                        >
                            Mitra Pengolahan
                        </a>


                        <a
                            href="{{ route('pimpinan.index') }}"
                            class="
                                px-4 py-3
                                rounded-xl
                                text-xs font-semibold
                                text-slate-600
                                hover:bg-blue-50
                            "
                        >
                            Pimpinan Cabang
                        </a>

                    @endif



                    {{-- LAPORAN --}}
                    @if (
                        $user?->isAdminGudang()
                        || $user?->isAdminKantor()
                        || $user?->isPimpinanCabang()
                    )

                        <div
                            class="
                                px-4 pt-3 pb-1
                                text-[9px]
                                uppercase
                                tracking-widest
                                text-slate-400
                            "
                        >
                            Laporan
                        </div>


                        <a
                            href="{{ route('laporan.index') }}"
                            class="
                                px-4 py-3
                                rounded-xl
                                text-xs font-semibold
                                text-slate-600
                                hover:bg-blue-50
                            "
                        >
                            Laporan
                        </a>

                    @endif



                    {{-- ADMINISTRASI --}}
                    @if ($user?->isAdminKantor())

                        <div
                            class="
                                px-4 pt-3 pb-1
                                text-[9px]
                                uppercase
                                tracking-widest
                                text-slate-400
                            "
                        >
                            Administrasi
                        </div>


                        <a
                            href="{{ route('pengaturan.umum') }}"
                            class="
                                px-4 py-3
                                rounded-xl
                                text-xs font-semibold
                                text-slate-600
                                hover:bg-blue-50
                            "
                        >
                            Pengaturan
                        </a>

                    @endif

                </div>

            </div>

        </div>

    </header>



    {{-- =========================================================
         MAIN CONTENT
    ========================================================== --}}
    <main class="max-w-[1600px] mx-auto px-5 lg:px-8 py-7 lg:py-8">


        {{-- SUCCESS MESSAGE --}}
        @if (session('success'))

            <div
                class="
                    mb-5
                    rounded-xl
                    border border-emerald-200
                    bg-emerald-50
                    px-4 py-3
                    text-sm
                    text-emerald-700
                "
            >
                {{ session('success') }}
            </div>

        @endif



        {{-- ERROR MESSAGE --}}
        @if (session('error'))

            <div
                class="
                    mb-5
                    rounded-xl
                    border border-red-200
                    bg-red-50
                    px-4 py-3
                    text-sm
                    text-red-700
                "
            >
                {{ session('error') }}
            </div>

        @endif



        {{-- PAGE CONTENT --}}
        @yield('content')

    </main>



    {{-- =========================================================
         MOBILE MENU SCRIPT
    ========================================================== --}}
    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const button = document.getElementById('baRampungMenuButton');

            const menu = document.getElementById('baRampungMobileMenu');


            if (button && menu) {

                button.addEventListener('click', function () {

                    menu.classList.toggle('hidden');

                });

            }

        });

    </script>


</body>

</html>