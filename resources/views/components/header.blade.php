@props(['title' => 'Dashboard', 'breadcrumbs' => []])

<header
    class="sticky top-0 z-40 bg-white/95 backdrop-blur-xl border-b border-slate-200/80"
>
    <div class="w-full px-4 sm:px-6 lg:px-8">

        <div class="min-h-[76px] flex items-center justify-between gap-4">

            {{-- =====================================================
                 BAGIAN KIRI
            ====================================================== --}}
            <div class="flex items-center gap-3 min-w-0">

                {{-- Tombol menu mobile --}}
                <button
                    type="button"
                    @click="sidebarOpen = !sidebarOpen"
                    class="lg:hidden flex-shrink-0 h-10 w-10 rounded-xl
                           bg-slate-100 text-slate-600
                           hover:bg-blue-50 hover:text-[#082f63]
                           transition duration-200"
                    aria-label="Buka menu"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="2"
                        stroke="currentColor"
                        class="w-5 h-5 mx-auto"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M4 6h16M4 12h16M4 18h16"
                        />
                    </svg>
                </button>


                {{-- =================================================
                     JUDUL HALAMAN
                ================================================== --}}
                <div class="min-w-0">

                    <div class="flex items-center gap-2">

                        <h1
                            class="text-xl sm:text-2xl font-extrabold
                                   tracking-tight text-[#082f63]
                                   truncate"
                        >
                            {{ $title }}
                        </h1>

                        {{-- Aksen orange --}}
                        <span
                            class="hidden sm:block w-1.5 h-1.5 rounded-full bg-[#f28c28]"
                        ></span>

                    </div>


                    {{-- Breadcrumb --}}
                    @if (count($breadcrumbs))

                        <div
                            class="mt-1 flex items-center gap-1
                                   text-xs sm:text-sm text-slate-400
                                   overflow-hidden"
                        >

                            @foreach ($breadcrumbs as $crumb)

                                <span
                                    class="
                                        truncate
                                        {{ $loop->last
                                            ? 'text-slate-500 font-medium'
                                            : 'text-slate-400'
                                        }}
                                    "
                                >
                                    {{ $crumb }}
                                </span>

                                @if (! $loop->last)

                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="2"
                                        stroke="currentColor"
                                        class="w-3 h-3 flex-shrink-0 text-slate-300"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="m9 5 7 7-7 7"
                                        />
                                    </svg>

                                @endif

                            @endforeach

                        </div>

                    @else

                        <p class="mt-1 text-xs text-slate-400">
                            Sistem BA Rampung BULOG Indramayu
                        </p>

                    @endif

                </div>

            </div>


            {{-- =====================================================
                 BAGIAN KANAN
            ====================================================== --}}
            <div class="flex items-center gap-2 sm:gap-3 flex-shrink-0">


                {{-- =================================================
                     SEARCH
                ================================================== --}}
                <button
                    type="button"
                    class="
                        hidden sm:flex
                        h-10 w-10
                        items-center justify-center
                        rounded-xl
                        text-slate-500
                        hover:bg-slate-100
                        hover:text-[#082f63]
                        transition duration-200
                    "
                    title="Pencarian"
                    aria-label="Pencarian"
                >

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.8"
                        stroke="currentColor"
                        class="w-5 h-5"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="m21 21-4.35-4.35m1.35-5.4a6.75 6.75 0 1 1-13.5 0 6.75 6.75 0 0 1 13.5 0Z"
                        />
                    </svg>

                </button>


                {{-- =================================================
                     NOTIFIKASI
                ================================================== --}}
                <button
                    type="button"
                    class="
                        relative
                        flex
                        h-10 w-10
                        items-center justify-center
                        rounded-xl
                        text-slate-500
                        hover:bg-slate-100
                        hover:text-[#082f63]
                        transition duration-200
                    "
                    title="Notifikasi"
                    aria-label="Notifikasi"
                >

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.8"
                        stroke="currentColor"
                        class="w-5 h-5"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M14.857 17.082a23.848 23.848 0 0 1-5.714 0A2.25 2.25 0 0 1 7.5 14.85V11a4.5 4.5 0 1 1 9 0v3.85a2.25 2.25 0 0 1-1.643 2.232ZM9.75 18.75a2.25 2.25 0 0 0 4.5 0"
                        />
                    </svg>


                    {{-- Notification dot --}}
                    <span
                        class="
                            absolute
                            top-2 right-2
                            w-2 h-2
                            rounded-full
                            bg-[#f28c28]
                            ring-2 ring-white
                        "
                    ></span>

                </button>


                {{-- =================================================
                     PEMBATAS
                ================================================== --}}
                <div class="hidden sm:block h-8 w-px bg-slate-200"></div>


                {{-- =================================================
                     USER PROFILE
                ================================================== --}}
                <div class="flex items-center gap-2 sm:gap-3">


                    {{-- Avatar --}}
                    <div
                        class="
                            h-10 w-10
                            sm:h-11 sm:w-11
                            rounded-full
                            flex items-center justify-center
                            bg-gradient-to-br
                            from-[#082f63]
                            to-[#0b4f9c]
                            text-white
                            font-extrabold
                            text-sm
                            shadow-sm
                            ring-4 ring-blue-50
                        "
                    >
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>


                    {{-- Informasi user --}}
                    <div class="hidden md:block min-w-0">

                        <p
                            class="
                                text-sm
                                font-bold
                                text-slate-800
                                leading-tight
                                max-w-[150px]
                                truncate
                            "
                        >
                            {{ auth()->user()->name }}
                        </p>

                        <p
                            class="
                                mt-1
                                text-[11px]
                                font-medium
                                text-slate-400
                                leading-tight
                            "
                        >
                            {{ auth()->user()->roleLabel() }}
                        </p>

                    </div>


                    {{-- =================================================
                         LOGOUT
                    ================================================== --}}
                    <form
                        method="POST"
                        action="{{ route('logout') }}"
                    >
                        @csrf

                        <button
                            type="submit"
                            class="
                                group
                                flex items-center justify-center
                                h-9
                                px-2 sm:px-3
                                rounded-lg
                                text-slate-400
                                hover:bg-red-50
                                hover:text-red-500
                                transition duration-200
                            "
                            title="Keluar"
                        >

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.8"
                                stroke="currentColor"
                                class="w-4 h-4 sm:mr-1.5"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6A2.25 2.25 0 0 0 5.25 5.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15"
                                />

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12 12h7.5m0 0-3-3m3 3-3 3"
                                />
                            </svg>

                            <span
                                class="
                                    hidden sm:inline
                                    text-xs
                                    font-bold
                                "
                            >
                                Keluar
                            </span>

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</header>