@php
    $user = auth()->user();
@endphp


{{-- =========================================================
     SIDEBAR
========================================================= --}}
<aside
    x-cloak
    :class="sidebarOpen
        ? 'translate-x-0'
        : '-translate-x-full lg:translate-x-0'"
    class="
        fixed
        inset-y-0
        left-0
        z-40
        w-64
        transform
        bg-[#082F63]
        transition-transform
        duration-300
        ease-in-out
        lg:static
        lg:translate-x-0
        flex
        flex-col
        shadow-[8px_0_30px_rgba(8,47,99,0.08)]
    "
>


    {{-- =====================================================
         LOGO BULOG
    ====================================================== --}}
    <div class="relative px-5 pt-7 pb-6">

        {{-- Decorative orange line --}}
        <div
            class="
                absolute
                top-0
                left-0
                w-full
                h-1
                bg-gradient-to-r
                from-[#F28C28]
                via-[#F5A13A]
                to-transparent
            "
        ></div>


        <div class="flex items-center justify-center">

            <div
                class="
                    w-full
                    rounded-2xl
                    bg-white/[0.06]
                    border
                    border-white/[0.08]
                    px-4
                    py-4
                    flex
                    items-center
                    justify-center
                    transition
                    duration-300
                    hover:bg-white/[0.09]
                "
            >

                <img
                    src="{{ asset('assets/images/bulog-logo.png') }}"
                    alt="BULOG"
                    class="w-[145px] h-auto object-contain"
                >

            </div>

        </div>

    </div>


    {{-- =====================================================
         USER / SYSTEM INFO
    ====================================================== --}}
    <div class="px-4 mb-3">

        <div
            class="
                rounded-xl
                bg-white/[0.05]
                border
                border-white/[0.07]
                px-3
                py-3
            "
        >

            <div class="flex items-center gap-3">

                <div
                    class="
                        h-9
                        w-9
                        shrink-0
                        rounded-full
                        bg-[#F28C28]
                        text-white
                        flex
                        items-center
                        justify-center
                        text-sm
                        font-extrabold
                        shadow-sm
                    "
                >
                    {{ strtoupper(substr($user?->name ?? 'U', 0, 1)) }}
                </div>


                <div class="min-w-0">

                    <p
                        class="
                            text-xs
                            font-bold
                            text-white
                            truncate
                        "
                    >
                        {{ $user?->name ?? 'User' }}
                    </p>

                    <p
                        class="
                            mt-0.5
                            text-[10px]
                            text-white/45
                            truncate
                        "
                    >
                        {{ $user?->roleLabel() ?? 'Pengguna' }}
                    </p>

                </div>

            </div>

        </div>

    </div>


    {{-- =====================================================
         NAVIGATION
    ====================================================== --}}
    <nav
        class="
            flex-1
            overflow-y-auto
            px-3
            pb-6
            custom-scrollbar
        "
    >


        {{-- =================================================
             DASHBOARD
        ================================================== --}}
        <a
            href="{{ route('dashboard') }}"
            class="
                sidebar-link
                group
                {{ request()->routeIs('dashboard') ? 'active' : '' }}
            "
        >

            {{-- Icon Dashboard --}}
            <svg
                class="w-5 h-5 shrink-0 transition-transform duration-200 group-hover:scale-105"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >
                <rect
                    x="4"
                    y="4"
                    width="6"
                    height="6"
                    rx="1"
                    stroke-width="2"
                />

                <rect
                    x="14"
                    y="4"
                    width="6"
                    height="6"
                    rx="1"
                    stroke-width="2"
                />

                <rect
                    x="4"
                    y="14"
                    width="6"
                    height="6"
                    rx="1"
                    stroke-width="2"
                />

                <rect
                    x="14"
                    y="14"
                    width="6"
                    height="6"
                    rx="1"
                    stroke-width="2"
                />
            </svg>

            <span>
                Dashboard
            </span>

        </a>


        {{-- =================================================
             ADMIN GUDANG
        ================================================== --}}
        @if ($user?->isAdminGudang())

            <div class="sidebar-title">
                BA Rampung
            </div>


            {{-- Daftar BA --}}
            <a
                href="{{ route('ba-rampung.index') }}"
                class="
                    sidebar-link
                    group
                    {{
                        request()->routeIs('ba-rampung.index')
                        || request()->routeIs('ba-rampung.show')
                        ? 'active'
                        : ''
                    }}
                "
            >

                <svg
                    class="w-5 h-5 shrink-0 transition-transform duration-200 group-hover:scale-105"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M6 3h9l3 3v15H6V3z"
                    />

                    <path
                        stroke-width="2"
                        stroke-linecap="round"
                        d="M9 8h6M9 12h6M9 16h4"
                    />
                </svg>

                <span>
                    Daftar BA Rampung
                </span>

            </a>


            {{-- Buat BA --}}
            @can('create', \App\Models\BaRampung::class)

                <a
                    href="{{ route('ba-rampung.create') }}"
                    class="
                        sidebar-link
                        group
                        {{
                            request()->routeIs('ba-rampung.create')
                            || request()->routeIs('ba-rampung.edit')
                            ? 'active'
                            : ''
                        }}
                    "
                >

                    <svg
                        class="w-5 h-5 shrink-0 transition-transform duration-200 group-hover:scale-105"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-width="2"
                            stroke-linecap="round"
                            d="M12 5v14M5 12h14"
                        />
                    </svg>

                    <span>
                        Buat BA Rampung
                    </span>

                </a>

            @endcan


        @endif


        {{-- =================================================
             ADMIN KANTOR
        ================================================== --}}
        @if ($user?->isAdminKantor())

            <div class="sidebar-title">
                BA Rampung
            </div>


            {{-- Semua BA --}}
            <a
                href="{{ route('ba-rampung.index') }}"
                class="
                    sidebar-link
                    group
                    {{
                        request()->routeIs('ba-rampung.index')
                        || request()->routeIs('ba-rampung.show')
                        ? 'active'
                        : ''
                    }}
                "
            >

                <svg
                    class="w-5 h-5 shrink-0 transition-transform duration-200 group-hover:scale-105"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M6 3h9l3 3v15H6V3z"
                    />

                    <path
                        stroke-width="2"
                        stroke-linecap="round"
                        d="M9 8h6M9 12h6M9 16h4"
                    />
                </svg>

                <span>
                    Semua BA Rampung
                </span>

            </a>


           


            {{-- =================================================
                 MASTER DATA
            ================================================== --}}
            <div class="sidebar-title">
                Master Data
            </div>


            {{-- Gudang --}}
            <a
                href="{{ route('gudang.index') }}"
                class="
                    sidebar-link
                    group
                    {{ request()->routeIs('gudang.*') ? 'active' : '' }}
                "
            >

                <svg
                    class="w-5 h-5 shrink-0 transition-transform duration-200 group-hover:scale-105"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M3 10l9-6 9 6"
                    />

                    <path
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M5 10v9h14v-9"
                    />

                    <path
                        stroke-width="2"
                        stroke-linecap="round"
                        d="M9 19v-5h6v5"
                    />
                </svg>

                <span>
                    Gudang
                </span>

            </a>


            {{-- Mitra --}}
            <a
                href="{{ route('mitra.index') }}"
                class="
                    sidebar-link
                    group
                    {{ request()->routeIs('mitra.*') ? 'active' : '' }}
                "
            >

                <svg
                    class="w-5 h-5 shrink-0 transition-transform duration-200 group-hover:scale-105"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2"
                    />

                    <circle
                        cx="9"
                        cy="7"
                        r="4"
                        stroke-width="2"
                    />

                    <path
                        stroke-width="2"
                        stroke-linecap="round"
                        d="M17 8l2 2 4-4"
                    />
                </svg>

                <span>
                    Mitra Pengolahan
                </span>

            </a>


            {{-- =================================================
                 PEGAWAI DIHAPUS DARI SIDEBAR
            ================================================== --}}
            {{--
                Menu Pegawai sengaja dihapus.
                Tidak ada:
                route('pegawai.index')
                Pegawai & User
            --}}


            {{-- Pimpinan --}}
            <a
                href="{{ route('pimpinan.index') }}"
                class="
                    sidebar-link
                    group
                    {{ request()->routeIs('pimpinan.*') ? 'active' : '' }}
                "
            >

                <svg
                    class="w-5 h-5 shrink-0 transition-transform duration-200 group-hover:scale-105"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2"
                    />

                    <circle
                        cx="9"
                        cy="7"
                        r="4"
                        stroke-width="2"
                    />

                    <path
                        stroke-width="2"
                        stroke-linecap="round"
                        d="M16 3.5a4 4 0 010 7.9"
                    />
                </svg>

                <span>
                    Pimpinan Cabang
                </span>

            </a>


            {{-- =================================================
                 ADMINISTRASI
            ================================================== --}}
            <div class="sidebar-title">
                Administrasi
            </div>


            <a
                href="{{ route('pengaturan.index') }}"
                class="
                    sidebar-link
                    group
                    {{ request()->routeIs('pengaturan.*') ? 'active' : '' }}
                "
            >

                <svg
                    class="w-5 h-5 shrink-0 transition-transform duration-200 group-hover:scale-105"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >

                    <circle
                        cx="12"
                        cy="12"
                        r="3"
                        stroke-width="2"
                    />

                    <path
                        stroke-width="2"
                        stroke-linecap="round"
                        d="M19.4 15a1.7 1.7 0 00.3 1.9l.1.1-1.8 1.8-.1-.1a1.7 1.7 0 00-1.9-.3 1.7 1.7 0 00-1 1.6v.1h-2.6V20a1.7 1.7 0 00-1-1.6 1.7 1.7 0 00-1.9.3l-.1.1-1.8-1.8.1-.1A1.7 1.7 0 008 15a1.7 1.7 0 00-1.6-1H6v-2.6h.1A1.7 1.7 0 008 10a1.7 1.7 0 00-.3-1.9l-.1-.1 1.8-1.8.1.1a1.7 1.7 0 001.9.3 1.7 1.7 0 001-1.6v-.1H15V5a1.7 1.7 0 001 1.6 1.7 1.7 0 001.9-.3l.1-.1 1.8 1.8-.1.1A1.7 1.7 0 0019.4 10a1.7 1.7 0 001.6 1h.1v2.6H21a1.7 1.7 0 00-1.6 1.4z"
                    />

                </svg>

                <span>
                    Pengaturan
                </span>

            </a>

        @endif


        {{-- =================================================
             PIMPINAN CABANG
        ================================================== --}}
        @if ($user?->isPimpinanCabang())

            <div class="sidebar-title">
                BA Rampung
            </div>


            <a
                href="{{ route('ba-rampung.index') }}"
                class="
                    sidebar-link
                    group
                    {{
                        request()->routeIs('ba-rampung.index')
                        || request()->routeIs('ba-rampung.show')
                        ? 'active'
                        : ''
                    }}
                "
            >

                <svg
                    class="w-5 h-5 shrink-0 transition-transform duration-200 group-hover:scale-105"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M6 3h9l3 3v15H6V3z"
                    />

                    <path
                        stroke-width="2"
                        stroke-linecap="round"
                        d="M9 8h6M9 12h6M9 16h4"
                    />
                </svg>

                <span>
                    Daftar BA Rampung
                </span>

            </a>


        @endif


    </nav>


    {{-- =====================================================
         SIDEBAR FOOTER
    ====================================================== --}}
    <div class="px-3 pb-4">

        <div
            class="
                rounded-xl
                border
                border-white/[0.07]
                bg-white/[0.04]
                px-4
                py-3
            "
        >

            <div class="flex items-center gap-2">

                <div
                    class="
                        w-2
                        h-2
                        rounded-full
                        bg-emerald-400
                        shadow-[0_0_0_4px_rgba(52,211,153,0.10)]
                    "
                ></div>

                <span class="text-[10px] font-semibold text-white/55">
                    Sistem Aktif
                </span>

            </div>

            <p class="mt-1 text-[9px] text-white/30">
                BA Rampung BULOG Indramayu
            </p>

        </div>

    </div>


</aside>


{{-- =========================================================
     MOBILE OVERLAY
========================================================= --}}
<div
    x-show="sidebarOpen"
    x-cloak
    @click="sidebarOpen = false"
    class="
        fixed
        inset-0
        z-30
        bg-slate-950/50
        backdrop-blur-[2px]
        lg:hidden
    "
></div>