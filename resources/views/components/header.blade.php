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
        class="
            relative
            flex
            h-10
            w-10
            items-center
            justify-center
            rounded-xl
            text-slate-500
            hover:bg-slate-100
            hover:text-[#082f63]
            transition
            duration-200
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

        {{-- JUMLAH NOTIFIKASI BELUM DIBACA --}}
        @if($jumlahNotifikasi > 0)

            <span
                class="
                    absolute
                    -top-0.5
                    -right-0.5
                    min-w-[18px]
                    h-[18px]
                    px-1
                    rounded-full
                    bg-[#f28c28]
                    text-white
                    text-[10px]
                    font-bold
                    flex
                    items-center
                    justify-center
                    ring-2
                    ring-white
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
            top-[calc(100%+10px)]
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

        {{-- HEADER DROPDOWN --}}
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


        {{-- DAFTAR NOTIFIKASI --}}
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
                            {{ !$notification->is_read ? 'bg-orange-50/50' : 'bg-white' }}
                        "
                    >

                        {{-- ICON --}}
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
                                    : 'bg-slate-100 text-slate-400'
                                }}
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


                        {{-- ISI --}}
                        <div class="min-w-0 flex-1">

                            <div class="flex items-start justify-between gap-2">

                                <p
                                    class="
                                        text-xs
                                        font-bold
                                        {{ !$notification->is_read
                                            ? 'text-[#082f63]'
                                            : 'text-slate-600'
                                        }}
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