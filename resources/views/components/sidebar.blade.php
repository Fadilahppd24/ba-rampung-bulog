@php
    $user = auth()->user();
@endphp
{{-- =================================================
                 ADMINISTRASI
            ================================================== --}}
            <div class="sidebar-title">
                Administrasi
            </div>


            <a
                href="{{ route('pengaturan.umum') }}"
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