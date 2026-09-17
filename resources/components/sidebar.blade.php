@php
    $user = auth()->user();
@endphp

<aside
    x-cloak
    :class="sidebarOpen
        ? 'translate-x-0'
        : '-translate-x-full lg:translate-x-0'"
    class="fixed inset-y-0 left-0 z-40 w-64 transform
           bg-[#0D2B6B]
           transition-transform duration-200
           lg:static lg:translate-x-0
           flex flex-col"
>

    {{-- =====================================================
         LOGO BULOG
    ====================================================== --}}
    <div class="flex items-center justify-center px-5 py-6">

        <img
            src="{{ asset('assets/images/bulog-logo.png') }}"
            alt="BULOG"
            class="w-[170px] h-auto object-contain"
        >

    </div>


    {{-- =====================================================
         NAVIGATION
    ====================================================== --}}
    <nav class="flex-1 overflow-y-auto px-3 pb-6">


        {{-- =================================================
             DASHBOARD
        ================================================== --}}
        <a
            href="{{ route('dashboard') }}"
            class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
        >

            {{-- Icon Dashboard --}}
            <svg
                class="w-5 h-5 shrink-0"
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
                class="sidebar-link
                    {{
                        request()->routeIs('ba-rampung.index')
                        || request()->routeIs('ba-rampung.show')
                        ? 'active'
                        : ''
                    }}"
            >

                <svg
                    class="w-5 h-5 shrink-0"
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
                    class="sidebar-link
                        {{
                            request()->routeIs('ba-rampung.create')
                            || request()->routeIs('ba-rampung.edit')
                            ? 'active'
                            : ''
                        }}"
                >

                    <svg
                        class="w-5 h-5 shrink-0"
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


            {{-- Laporan --}}
            <div class="sidebar-title">
                Laporan
            </div>


            <a
                href="{{ route('laporan.index') }}"
                class="sidebar-link
                    {{ request()->routeIs('laporan.*') ? 'active' : '' }}"
            >

                <svg
                    class="w-5 h-5 shrink-0"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M4 19V5"
                    />

                    <path
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M4 17l5-5 4 3 6-7"
                    />
                </svg>

                <span>
                    Laporan
                </span>

            </a>

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
                class="sidebar-link
                    {{
                        request()->routeIs('ba-rampung.index')
                        || request()->routeIs('ba-rampung.show')
                        ? 'active'
                        : ''
                    }}"
            >

                <svg
                    class="w-5 h-5 shrink-0"
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


            {{-- Buat BA --}}
            @can('create', \App\Models\BaRampung::class)

                <a
                    href="{{ route('ba-rampung.create') }}"
                    class="sidebar-link
                        {{
                            request()->routeIs('ba-rampung.create')
                            || request()->routeIs('ba-rampung.edit')
                            ? 'active'
                            : ''
                        }}"
                >

                    <svg
                        class="w-5 h-5 shrink-0"
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


            {{-- =================================================
                 MASTER DATA
            ================================================== --}}
            <div class="sidebar-title">
                Master Data
            </div>


            {{-- Gudang --}}
            <a
                href="{{ route('gudang.index') }}"
                class="sidebar-link
                    {{ request()->routeIs('gudang.*') ? 'active' : '' }}"
            >

                <svg
                    class="w-5 h-5 shrink-0"
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
                class="sidebar-link
                    {{ request()->routeIs('mitra.*') ? 'active' : '' }}"
            >

                <svg
                    class="w-5 h-5 shrink-0"
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
                class="sidebar-link
                    {{ request()->routeIs('pimpinan.*') ? 'active' : '' }}"
            >

                <svg
                    class="w-5 h-5 shrink-0"
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
                 LAPORAN
            ================================================== --}}
            <div class="sidebar-title">
                Laporan
            </div>


            <a
                href="{{ route('laporan.index') }}"
                class="sidebar-link
                    {{ request()->routeIs('laporan.*') ? 'active' : '' }}"
            >

                <svg
                    class="w-5 h-5 shrink-0"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M4 19V5"
                    />

                    <path
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M4 17l5-5 4 3 6-7"
                    />
                </svg>

                <span>
                    Laporan
                </span>

            </a>


            {{-- =================================================
                 ADMINISTRASI
            ================================================== --}}
            <div class="sidebar-title">
                Administrasi
            </div>


            <a
                href="{{ route('pengaturan.umum') }}"
                class="sidebar-link
                    {{ request()->routeIs('pengaturan.*') ? 'active' : '' }}"
            >

                <svg
                    class="w-5 h-5 shrink-0"
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
                class="sidebar-link
                    {{
                        request()->routeIs('ba-rampung.index')
                        || request()->routeIs('ba-rampung.show')
                        ? 'active'
                        : ''
                    }}"
            >

                <svg
                    class="w-5 h-5 shrink-0"
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


            <div class="sidebar-title">
                Laporan
            </div>


            <a
                href="{{ route('laporan.index') }}"
                class="sidebar-link
                    {{ request()->routeIs('laporan.*') ? 'active' : '' }}"
            >

                <svg
                    class="w-5 h-5 shrink-0"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M4 19V5"
                    />

                    <path
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M4 17l5-5 4 3 6-7"
                    />
                </svg>

                <span>
                    Laporan
                </span>

            </a>

        @endif


    </nav>

</aside>


{{-- MOBILE OVERLAY --}}
<div
    x-show="sidebarOpen"
    x-cloak
    @click="sidebarOpen = false"
    class="fixed inset-0 z-30 bg-black/40 lg:hidden"
></div>