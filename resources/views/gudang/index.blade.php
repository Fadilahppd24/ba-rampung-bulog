@extends('layouts.app')

@section('title', 'Gudang')

@section('content')

<div class="space-y-6">

    {{-- =========================================================
         HERO / HEADER
    ========================================================== --}}
    <section class="relative overflow-hidden rounded-[2rem] border border-white/20 bg-[#0B315F]/20 shadow-xl">

        {{-- Overlay supaya tulisan tetap terbaca --}}
        <div class="absolute inset-0 bg-gradient-to-r from-[#06254A]/75 via-[#0B3D73]/45 to-transparent"></div>

        <div class="relative px-6 py-8 sm:px-8 sm:py-10 lg:px-10">

            <div class="flex flex-col gap-7 lg:flex-row lg:items-end lg:justify-between">

                <div class="max-w-3xl">

                    <p class="dashboard-kicker text-white/75">
                        MASTER DATA
                    </p>

                    <h1 class="dashboard-display mt-2 text-4xl leading-tight text-white sm:text-5xl lg:text-6xl">
                        Data <span class="text-[#F28C28]">Gudang</span>
                    </h1>

                    <p
                        class="mt-3 max-w-xl text-sm leading-6 text-white/85 sm:text-base"
                        style="text-shadow: 0 1px 8px rgba(3, 28, 55, .25);"
                    >
                        Kelola data gudang penyimpanan BA Rampung dengan mudah dan terstruktur.
                    </p>

                </div>


                <div class="flex flex-col items-start gap-3 sm:flex-row sm:items-center lg:flex-col lg:items-end">

                    <div class="rounded-2xl border border-white/20 bg-[#082F63]/60 px-5 py-3 text-white backdrop-blur-md">

                        <p class="text-[10px] font-bold uppercase tracking-[.2em] text-white/55">
                            STATUS DATA
                        </p>

                        <div class="mt-1.5 flex items-center gap-2">

                            <span class="h-2.5 w-2.5 rounded-full bg-emerald-400 shadow-[0_0_0_4px_rgba(52,211,153,.15)]"></span>

                            <span class="text-sm font-semibold">
                                Data gudang aktif
                            </span>

                        </div>

                    </div>


                    @role('admin_kantor')

                        <a
                            href="{{ route('gudang.create') }}"
                            class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#123F7A] px-5 py-3 text-sm font-bold text-white shadow-lg transition duration-200 hover:-translate-y-0.5 hover:bg-[#0d3263]"
                        >
                            <span class="text-lg leading-none">＋</span>
                            Tambah Gudang
                        </a>

                    @endrole

                </div>

            </div>

        </div>

    </section>



    {{-- =========================================================
         KPI
    ========================================================== --}}
    <section class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

        {{-- TOTAL --}}
        <div class="group rounded-[1.35rem] border border-slate-200/80 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:shadow-lg">

            <div class="flex items-start justify-between">

                <div>

                    <p class="text-[10px] font-bold uppercase tracking-[.15em] text-slate-400">
                        Total Gudang
                    </p>

                    <p class="mt-2 text-3xl font-bold tracking-tight text-[#123F7A]">
                        {{ number_format($kpi['total']) }}
                    </p>

                    <p class="mt-1 text-xs text-slate-400">
                        Seluruh gudang dalam sistem
                    </p>

                </div>

                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-blue-50 text-lg transition group-hover:scale-105">
                    🏭
                </div>

            </div>

        </div>


        {{-- AKTIF --}}
        <div class="group rounded-[1.35rem] border border-slate-200/80 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:shadow-lg">

            <div class="flex items-start justify-between">

                <div>

                    <p class="text-[10px] font-bold uppercase tracking-[.15em] text-slate-400">
                        Gudang Aktif
                    </p>

                    <p class="mt-2 text-3xl font-bold tracking-tight text-emerald-600">
                        {{ number_format($kpi['aktif']) }}
                    </p>

                    <div class="mt-1 flex items-center gap-1.5 text-xs text-emerald-600">

                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>

                        Aktif

                    </div>

                </div>

                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-emerald-50 text-lg">
                    ✓
                </div>

            </div>

        </div>


        {{-- DOKUMEN --}}
        <div class="group rounded-[1.35rem] border border-slate-200/80 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:shadow-lg">

            <div class="flex items-start justify-between">

                <div>

                    <p class="text-[10px] font-bold uppercase tracking-[.15em] text-slate-400">
                        Total Dokumen BA
                    </p>

                    <p class="mt-2 text-3xl font-bold tracking-tight text-[#123F7A]">
                        {{ number_format($kpi['total_dokumen']) }}
                    </p>

                    <p class="mt-1 text-xs text-slate-400">
                        Terkait data gudang
                    </p>

                </div>

                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-indigo-50 text-lg">
                    📄
                </div>

            </div>

        </div>


        {{-- PROSES --}}
        <div class="group rounded-[1.35rem] border border-slate-200/80 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:shadow-lg">

            <div class="flex items-start justify-between">

                <div>

                    <p class="text-[10px] font-bold uppercase tracking-[.15em] text-slate-400">
                        Sedang Diproses
                    </p>

                    <p class="mt-2 text-3xl font-bold tracking-tight text-amber-600">
                        {{ number_format($kpi['dengan_proses']) }}
                    </p>

                    <p class="mt-1 text-xs text-slate-400">
                        Dokumen masih diproses
                    </p>

                </div>

                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-amber-50 text-lg">
                    ⏳
                </div>

            </div>

        </div>

    </section>



    {{-- =========================================================
         FILTER
    ========================================================== --}}
    <section class="overflow-hidden rounded-[1.5rem] border border-slate-200/80 bg-white shadow-lg">

        <form
            method="GET"
            action="{{ route('gudang.index') }}"
            class="p-5 sm:p-6"
        >

            <div class="flex flex-col gap-4 border-b border-slate-100 pb-5 sm:flex-row sm:items-center sm:justify-between">

                <div class="flex items-center gap-3">

                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-lg">
                        🔍
                    </div>

                    <div>

                        <p class="dashboard-kicker text-[#123F7A]">
                            Filter Data
                        </p>

                        <h2 class="mt-0.5 text-lg font-bold text-[#0B2545]">
                            Cari Gudang
                        </h2>

                        <p class="mt-0.5 text-xs text-slate-400">
                            Gunakan filter untuk menemukan gudang dengan lebih cepat.
                        </p>

                    </div>

                </div>


                <div class="flex flex-wrap gap-2">

                    @if(request('gudang_utama_id') || request('search'))

                        <a
                            href="{{ route('gudang.index') }}"
                            class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50"
                        >
                            ↺
                            Reset
                        </a>

                    @endif


                    <button
                        type="submit"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#123F7A] px-5 py-2.5 text-sm font-bold text-white shadow-sm transition hover:-translate-y-0.5 hover:bg-[#0d3263]"
                    >
                        🔍
                        Cari
                    </button>

                </div>

            </div>



            <div class="mt-5 grid grid-cols-1 gap-4 lg:grid-cols-2">

                {{-- SEARCH --}}
                <div>

                    <label class="mb-2 block text-xs font-bold uppercase tracking-wide text-slate-500">
                        Pencarian
                    </label>

                    <div class="relative">

                        <span class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                            ⌕
                        </span>

                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Cari nama gudang atau kode gudang..."
                            class="w-full rounded-xl border border-slate-200 bg-slate-50/60 py-3 pl-11 pr-4 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-[#123F7A] focus:bg-white focus:ring-4 focus:ring-blue-50"
                        >

                    </div>

                </div>


                {{-- GUDANG UTAMA --}}
                <div>

                    <label class="mb-2 block text-xs font-bold uppercase tracking-wide text-slate-500">
                        Gudang Utama
                    </label>

                    <select
                        name="gudang_utama_id"
                        class="w-full rounded-xl border border-slate-200 bg-slate-50/60 px-4 py-3 text-sm text-slate-700 outline-none transition focus:border-[#123F7A] focus:bg-white focus:ring-4 focus:ring-blue-50"
                    >

                        <option value="">
                            Semua Gudang Utama
                        </option>

                        @foreach($gudangsUtama as $gudangUtama)

                            <option
                                value="{{ $gudangUtama->id }}"
                                @selected(request('gudang_utama_id') == $gudangUtama->id)
                            >
                                {{ $gudangUtama->nama_gudang }}
                            </option>

                        @endforeach

                    </select>

                </div>

            </div>

        </form>

    </section>



    {{-- =========================================================
         DATA GUDANG
    ========================================================== --}}
    <section class="overflow-hidden rounded-[1.5rem] border border-slate-200/80 bg-white shadow-lg">

        {{-- HEADER TABLE --}}
        <div class="flex flex-col gap-4 border-b border-slate-100 px-5 py-5 sm:px-6 lg:flex-row lg:items-center lg:justify-between">

            <div class="flex items-center gap-3">

                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-lg">
                    🏭
                </div>

                <div>

                    <p class="dashboard-kicker text-[#123F7A]">
                        Master Data
                    </p>

                    <h2 class="dashboard-display mt-0.5 text-2xl font-normal text-[#0B2545] sm:text-3xl">
                        Data Gudang
                    </h2>

                    <p class="mt-1 text-xs text-slate-400">
                        Gudang utama dan gudang filial yang terdaftar dalam sistem.
                    </p>

                </div>

            </div>


            @role('admin_kantor')

                <a
                    href="{{ route('gudang.create') }}"
                    class="inline-flex items-center justify-center gap-2 self-start rounded-xl bg-[#123F7A] px-4 py-2.5 text-sm font-bold text-white shadow-sm transition hover:-translate-y-0.5 hover:bg-[#0d3263] lg:self-center"
                >
                    <span class="text-lg leading-none">＋</span>
                    Tambah Gudang
                </a>

            @endrole

        </div>



        {{-- TABLE --}}
        <div class="overflow-x-auto">

            <table class="w-full min-w-[1050px] text-sm">

                <thead>

                    <tr class="border-b border-slate-100 bg-[#F5F8FD] text-left text-[10px] uppercase tracking-[.12em] text-slate-500">

                        <th class="px-5 py-4 font-bold">
                            No.
                        </th>

                        <th class="px-5 py-4 font-bold">
                            Kode
                        </th>

                        <th class="px-5 py-4 font-bold">
                            Nama Gudang
                        </th>

                        <th class="px-5 py-4 font-bold">
                            Gudang Induk
                        </th>

                        <th class="px-5 py-4 font-bold">
                            Kecamatan
                        </th>

                        <th class="px-5 py-4 font-bold">
                            Desa
                        </th>

                        <th class="px-5 py-4 font-bold">
                            Kapasitas
                        </th>

                        <th class="px-5 py-4 font-bold">
                            Status
                        </th>

                        <th class="px-5 py-4 text-right font-bold">
                            Aksi
                        </th>

                    </tr>

                </thead>



                <tbody class="divide-y divide-slate-100">

                    @forelse($gudangs as $i => $gudang)


                        {{-- =================================================
                             GUDANG UTAMA
                        ================================================== --}}
                        @if(is_null($gudang->gudang_induk_id))

                            <tr class="bg-[#F8FAFD]">

                                <td colspan="9" class="px-5 py-4">

                                    <div class="flex items-center gap-3">

                                        <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-blue-100 text-base">
                                            🏭
                                        </div>

                                        <div>

                                            <div class="flex items-center gap-2">

                                                <p class="font-bold text-[#0B2545]">
                                                    {{ $gudang->nama_gudang }}
                                                </p>

                                                <span class="rounded-full bg-blue-50 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide text-[#123F7A]">
                                                    Gudang Utama
                                                </span>

                                            </div>

                                            <p class="mt-0.5 text-xs text-slate-400">
                                                {{ $gudang->kode_gudang }}
                                            </p>

                                        </div>

                                    </div>

                                </td>

                            </tr>


                        {{-- =================================================
                             GUDANG FILIAL
                        ================================================== --}}
                        @else

                            <tr class="group transition hover:bg-[#F8FAFD]">

                                {{-- NO --}}
                                <td class="px-5 py-5 text-slate-400">
                                    {{ $i + 1 }}
                                </td>


                                {{-- KODE --}}
                                <td class="px-5 py-5">

                                    <span class="font-bold text-[#123F7A]">
                                        {{ $gudang->kode_gudang }}
                                    </span>

                                </td>


                                {{-- NAMA --}}
                                <td class="px-5 py-5">

                                    <div class="pl-2">

                                        <div class="flex items-center gap-2">

                                            <span class="text-slate-300">
                                                ↳
                                            </span>

                                            <p class="font-semibold text-[#0B2545]">
                                                {{ $gudang->nama_gudang }}
                                            </p>

                                        </div>


                                        @if($gudang->alamat)

                                            <p class="mt-1 max-w-[230px] truncate pl-5 text-xs text-slate-400">
                                                {{ $gudang->alamat }}
                                            </p>

                                        @endif

                                    </div>

                                </td>


                                {{-- GUDANG INDUK --}}
                                <td class="px-5 py-5">

                                    <span class="text-slate-600">
                                        {{ $gudang->gudangInduk->nama_gudang ?? '-' }}
                                    </span>

                                </td>


                                {{-- KECAMATAN --}}
                                <td class="px-5 py-5 text-slate-600">
                                    {{ $gudang->kecamatan ?? '-' }}
                                </td>


                                {{-- DESA --}}
                                <td class="px-5 py-5 text-slate-600">
                                    {{ $gudang->desa ?? '-' }}
                                </td>


                                {{-- KAPASITAS --}}
                                <td class="px-5 py-5">

                                    @if($gudang->kapasitas !== null)

                                        <span class="font-medium text-slate-700">
                                            {{ number_format($gudang->kapasitas, 2, ',', '.') }}
                                        </span>

                                        <span class="text-xs text-slate-400">
                                            Ton
                                        </span>

                                    @else

                                        <span class="text-slate-400">
                                            -
                                        </span>

                                    @endif

                                </td>


                                {{-- STATUS --}}
                                <td class="px-5 py-5">

                                    <x-status-badge
                                        :color="$gudang->status === 'aktif' ? 'green' : 'gray'"
                                        :label="ucfirst($gudang->status)"
                                    />

                                </td>


                                {{-- AKSI --}}
                                <td class="px-5 py-5">

                                    <div class="flex items-center justify-end gap-2">


                                        {{-- LIHAT --}}
                                        <a
                                            href="{{ route('gudang.show', $gudang) }}"
                                            title="Lihat Gudang"
                                            class="flex h-9 w-9 items-center justify-center rounded-xl bg-blue-50 text-[#123F7A] transition hover:bg-[#123F7A] hover:text-white"
                                        >
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                class="h-4 w-4"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor"
                                                stroke-width="1.8"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7Z"
                                                />
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"
                                                />
                                            </svg>
                                        </a>



                                        @role('admin_kantor')


                                            {{-- EDIT --}}
                                            <a
                                                href="{{ route('gudang.edit', $gudang) }}"
                                                title="Edit Gudang"
                                                class="flex h-9 w-9 items-center justify-center rounded-xl bg-orange-50 text-orange-600 transition hover:bg-orange-500 hover:text-white"
                                            >
                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    class="h-4 w-4"
                                                    fill="none"
                                                    viewBox="0 0 24 24"
                                                    stroke="currentColor"
                                                    stroke-width="1.8"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 15.07a4.5 4.5 0 0 1-1.897 1.13L6 17l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-7.931Z"
                                                    />
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        d="M19.5 7.5 16.5 4.5"
                                                    />
                                                </svg>
                                            </a>



                                            {{-- TOGGLE STATUS --}}
                                            <form
                                                method="POST"
                                                action="{{ route('gudang.toggle-status', $gudang) }}"
                                                class="inline"
                                            >

                                                @csrf

                                                @method('PATCH')

                                                <button
                                                    type="submit"
                                                    title="{{ $gudang->status === 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }}"
                                                    class="flex h-9 w-9 items-center justify-center rounded-xl transition
                                                    {{ $gudang->status === 'aktif'
                                                        ? 'bg-red-50 text-red-500 hover:bg-red-500 hover:text-white'
                                                        : 'bg-emerald-50 text-emerald-600 hover:bg-emerald-500 hover:text-white'
                                                    }}"
                                                    onclick="return confirm('Apakah Anda yakin ingin mengubah status gudang ini?')"
                                                >

                                                    @if($gudang->status === 'aktif')

                                                        <svg
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            class="h-4 w-4"
                                                            fill="none"
                                                            viewBox="0 0 24 24"
                                                            stroke="currentColor"
                                                            stroke-width="1.8"
                                                        >
                                                            <path
                                                                stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                d="M18.364 18.364A9 9 0 1 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636"
                                                            />
                                                        </svg>

                                                    @else

                                                        <svg
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            class="h-4 w-4"
                                                            fill="none"
                                                            viewBox="0 0 24 24"
                                                            stroke="currentColor"
                                                            stroke-width="1.8"
                                                        >
                                                            <path
                                                                stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                d="m4.5 12.75 6 6 9-13.5"
                                                            />
                                                        </svg>

                                                    @endif

                                                </button>

                                            </form>


                                        @endrole

                                    </div>

                                </td>

                            </tr>

                        @endif


                    @empty

                        {{-- EMPTY STATE --}}
                        <tr>

                            <td colspan="9" class="px-5 py-16 text-center">

                                <div class="mx-auto flex max-w-sm flex-col items-center">

                                    <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-blue-50 text-3xl">
                                        🏭
                                    </div>

                                    <p class="mt-4 font-bold text-[#0B2545]">
                                        Belum ada data gudang
                                    </p>

                                    <p class="mt-1 text-sm text-slate-400">
                                        Belum terdapat data gudang yang dapat ditampilkan.
                                    </p>


                                    @role('admin_kantor')

                                        <a
                                            href="{{ route('gudang.create') }}"
                                            class="mt-5 inline-flex items-center gap-2 rounded-xl bg-[#123F7A] px-5 py-2.5 text-sm font-bold text-white transition hover:bg-[#0d3263]"
                                        >
                                            ＋
                                            Tambah Gudang
                                        </a>

                                    @endrole

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>



        {{-- FOOTER TABLE --}}
        @if($gudangs->count() > 0)

            <div class="flex flex-col gap-3 border-t border-slate-100 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">

                <p class="text-xs text-slate-400">
                    Menampilkan data gudang yang tersedia dalam sistem.
                </p>

                @if(method_exists($gudangs, 'links'))

                    <div>
                        {{ $gudangs->withQueryString()->links() }}
                    </div>

                @endif

            </div>

        @endif

    </section>

</div>

@endsection