@php
    $menuBuilt = [
        ['route' => 'dashboard', 'icon' => 'home', 'label' => 'Dashboard'],
    ];
@endphp

<aside
    x-cloak
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
    class="fixed inset-y-0 left-0 z-40 w-72 transform bg-bulog-900 transition-transform duration-200 lg:static lg:translate-x-0 flex flex-col"
>
    {{-- Logo --}}
    <div class="flex items-center gap-3 px-6 py-6">
        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-bulog-cream text-bulog-900 font-bold">
            B
        </div>

        <div>
            <p class="text-lg font-semibold text-white leading-tight">bulog</p>
            <p class="text-xs text-white/60">Cabang Indramayu</p>
        </div>
    </div>

    {{-- Menu --}}
    <nav class="flex-1 overflow-y-auto px-4 pb-6 space-y-1">

        {{-- DASHBOARD --}}
        <a
            href="{{ route('dashboard') }}"
            class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
        >
            <span>📊</span>
            Dashboard
        </a>


        {{-- ========================================= --}}
        {{-- ADMIN GUDANG --}}
        {{-- ========================================= --}}
        @role('admin_gudang')

            <div class="pt-4 pb-1 px-3 text-[11px] font-semibold uppercase tracking-wider text-white/40">
                BA Rampung
            </div>

            {{-- Daftar BA --}}
            <a
                href="{{ route('ba-rampung.index') }}"
                class="sidebar-link {{ request()->routeIs('ba-rampung.index') || request()->routeIs('ba-rampung.show') ? 'active' : '' }}"
            >
                <span>📋</span>
                Daftar BA Rampung
            </a>

            {{-- Buat BA --}}
            @can('create', \App\Models\BaRampung::class)
                <a
                    href="{{ route('ba-rampung.create') }}"
                    class="sidebar-link {{ request()->routeIs('ba-rampung.create') || request()->routeIs('ba-rampung.edit') ? 'active' : '' }}"
                >
                    <span>➕</span>
                    Buat BA Rampung
                </a>
            @endcan

            {{-- Laporan --}}
            <a
                href="{{ route('laporan.index') }}"
                class="sidebar-link {{ request()->routeIs('laporan.*') ? 'active' : '' }}"
            >
                <span>📄</span>
                Laporan
            </a>

        @endrole


        {{-- ========================================= --}}
        {{-- ADMIN KANTOR / ADMIN SISTEM --}}
        {{-- ========================================= --}}
        @role('admin_kantor')

            <div class="pt-4 pb-1 px-3 text-[11px] font-semibold uppercase tracking-wider text-white/40">
                BA Rampung
            </div>

            {{-- Daftar BA --}}
            <a
                href="{{ route('ba-rampung.index') }}"
                class="sidebar-link {{ request()->routeIs('ba-rampung.index') || request()->routeIs('ba-rampung.show') ? 'active' : '' }}"
            >
                <span>📋</span>
                Daftar BA Rampung
            </a>

            {{-- Buat BA --}}
            @can('create', \App\Models\BaRampung::class)
                <a
                    href="{{ route('ba-rampung.create') }}"
                    class="sidebar-link {{ request()->routeIs('ba-rampung.create') || request()->routeIs('ba-rampung.edit') ? 'active' : '' }}"
                >
                    <span>➕</span>
                    Buat BA Rampung
                </a>
            @endcan


            {{-- MASTER DATA --}}
            <div class="pt-4 pb-1 px-3 text-[11px] font-semibold uppercase tracking-wider text-white/40">
                Master Data
            </div>

            <a
                href="{{ route('gudang.index') }}"
                class="sidebar-link {{ request()->routeIs('gudang.*') ? 'active' : '' }}"
            >
                <span>🏠</span>
                Gudang
            </a>

            <a
                href="{{ route('mitra.index') }}"
                class="sidebar-link {{ request()->routeIs('mitra.*') ? 'active' : '' }}"
            >
                <span>🤝</span>
                Mitra Pengolahan
            </a>

            <a
                href="{{ route('pegawai.index') }}"
                class="sidebar-link {{ request()->routeIs('pegawai.*') ? 'active' : '' }}"
            >
                <span>👤</span>
                Pegawai
            </a>

            <a
                href="{{ route('pimpinan.index') }}"
                class="sidebar-link {{ request()->routeIs('pimpinan.*') ? 'active' : '' }}"
            >
                <span>👔</span>
                Pimpinan Cabang
            </a>


            {{-- LAPORAN --}}
            <div class="pt-4 pb-1 px-3 text-[11px] font-semibold uppercase tracking-wider text-white/40">
                Laporan
            </div>

            <a
                href="{{ route('laporan.index') }}"
                class="sidebar-link {{ request()->routeIs('laporan.*') ? 'active' : '' }}"
            >
                <span>📄</span>
                Laporan
            </a>


            {{-- ADMINISTRASI --}}
            <div class="pt-4 pb-1 px-3 text-[11px] font-semibold uppercase tracking-wider text-white/40">
                Administrasi
            </div>

            <a
                href="{{ route('pengaturan.umum') }}"
                class="sidebar-link {{ request()->routeIs('pengaturan.*') ? 'active' : '' }}"
            >
                <span>⚙️</span>
                Pengaturan
            </a>

        @endrole

    </nav>
</aside>


{{-- Overlay mobile --}}
<div
    x-show="sidebarOpen"
    x-cloak
    @click="sidebarOpen = false"
    class="fixed inset-0 z-30 bg-black/40 lg:hidden"
></div>