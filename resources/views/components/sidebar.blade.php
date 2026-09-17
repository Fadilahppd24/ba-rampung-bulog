@php
    $menuBuilt = [
        ['route' => 'dashboard', 'icon' => 'home', 'label' => 'Dashboard'],
    ];
@endphp


<aside
    x-cloak
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
    class="fixed inset-y-0 left-0 z-40 w-64 transform bg-[#0D2B6B] transition-transform duration-200 lg:static lg:translate-x-0 flex flex-col"
>


    {{-- LOGO BULOG --}}
    <div class="flex items-center justify-center px-4 pt-5 pb-4">

        <img
            src="{{ asset('assets/images/bulog-logo.png') }}"
            alt="BULOG"
            class="w-[180px] h-auto object-contain"
        >

    </div>


    {{-- MENU --}}
    <nav class="flex-1 overflow-y-auto px-3 pb-5 space-y-1">


        {{-- DASHBOARD --}}
        <a
            href="{{ route('dashboard') }}"
            class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
        >

            <span class="w-6 text-center">
                📊
            </span>

            <span>
                Dashboard
            </span>

        </a>



        {{-- ADMIN GUDANG --}}
        @role('admin_gudang')


            <div class="sidebar-title">
                BA Rampung
            </div>


            <a
                href="{{ route('ba-rampung.index') }}"
                class="sidebar-link {{ request()->routeIs('ba-rampung.index') || request()->routeIs('ba-rampung.show') ? 'active' : '' }}"
            >

                <span class="w-6 text-center">
                    📋
                </span>

                Daftar BA Rampung

            </a>



            @can('create', \App\Models\BaRampung::class)

                <a
                    href="{{ route('ba-rampung.create') }}"
                    class="sidebar-link {{ request()->routeIs('ba-rampung.create') || request()->routeIs('ba-rampung.edit') ? 'active' : '' }}"
                >

                    <span class="w-6 text-center">
                        ➕
                    </span>

                    Buat BA Rampung

                </a>

            @endcan



            <a
                href="{{ route('laporan.index') }}"
                class="sidebar-link {{ request()->routeIs('laporan.*') ? 'active' : '' }}"
            >

                <span class="w-6 text-center">
                    📄
                </span>

                Laporan

            </a>


        @endrole




        {{-- ADMIN KANTOR --}}
        @role('admin_kantor')


            <div class="sidebar-title">
                BA Rampung
            </div>



            <a
                href="{{ route('ba-rampung.index') }}"
                class="sidebar-link {{ request()->routeIs('ba-rampung.index') || request()->routeIs('ba-rampung.show') ? 'active' : '' }}"
            >

                <span class="w-6 text-center">
                    📋
                </span>

                Daftar BA Rampung

            </a>




            @can('create', \App\Models\BaRampung::class)

            <a
                href="{{ route('ba-rampung.create') }}"
                class="sidebar-link {{ request()->routeIs('ba-rampung.create') || request()->routeIs('ba-rampung.edit') ? 'active' : '' }}"
            >

                <span class="w-6 text-center">
                    ➕

                </span>

                Buat BA Rampung

            </a>

            @endcan





            {{-- MASTER DATA --}}

            <div class="sidebar-title">
                Master Data
            </div>



            <a
                href="{{ route('gudang.index') }}"
                class="sidebar-link {{ request()->routeIs('gudang.*') ? 'active' : '' }}"
            >

                <span class="w-6 text-center">
                    🏠
                </span>

                Gudang

            </a>



            <a
                href="{{ route('mitra.index') }}"
                class="sidebar-link {{ request()->routeIs('mitra.*') ? 'active' : '' }}"
            >

                <span class="w-6 text-center">
                    🤝
                </span>

                Mitra Pengolahan

            </a>
            
            <a
                href="{{ route('pimpinan.index') }}"
                class="sidebar-link {{ request()->routeIs('pimpinan.*') ? 'active' : '' }}"
            >

                <span class="w-6 text-center">
                    👔
                </span>

                Pimpinan Cabang

            </a>





            {{-- LAPORAN --}}

            <div class="sidebar-title">
                Laporan
            </div>



            <a
                href="{{ route('laporan.index') }}"
                class="sidebar-link {{ request()->routeIs('laporan.*') ? 'active' : '' }}"
            >

                <span class="w-6 text-center">
                    📄
                </span>

                Laporan

            </a>





            {{-- ADMINISTRASI --}}

            <div class="sidebar-title">
                Administrasi
            </div>



            <a
                href="{{ route('pengaturan.umum') }}"
                class="sidebar-link {{ request()->routeIs('pengaturan.*') ? 'active' : '' }}"
            >

                <span class="w-6 text-center">
                    ⚙️
                </span>

                Pengaturan

            </a>


        @endrole


    </nav>


</aside>



{{-- OVERLAY MOBILE --}}
<div
    x-show="sidebarOpen"
    x-cloak
    @click="sidebarOpen=false"
    class="fixed inset-0 z-30 bg-black/40 lg:hidden"
></div>