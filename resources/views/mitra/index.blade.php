@extends('layouts.app')

@section('title', 'Data Mitra')

@section('content')

<div class="space-y-6 pb-12">

    {{-- =========================================================
         HERO / JUDUL
    ========================================================== --}}
    <section
        class="relative overflow-hidden rounded-[30px] border border-white/20"
        style="
            min-height: 210px;
            background:
                linear-gradient(
                    90deg,
                    rgba(7, 48, 91, .88) 0%,
                    rgba(15, 61, 110, .72) 52%,
                    rgba(15, 61, 110, .38) 100%
                );
            box-shadow: 0 18px 50px rgba(15, 61, 110, .15);
            backdrop-filter: blur(3px);
        "
    >

        {{-- efek kabut / glass --}}
        <div
            class="pointer-events-none absolute inset-0"
            style="
                background:
                    radial-gradient(
                        circle at 15% 40%,
                        rgba(255,255,255,.12),
                        transparent 34%
                    ),
                    radial-gradient(
                        circle at 85% 20%,
                        rgba(255,255,255,.07),
                        transparent 30%
                    ),
                    linear-gradient(
                        180deg,
                        rgba(255,255,255,.05),
                        rgba(0,25,55,.18)
                    );
            "
        ></div>

        {{-- garis cahaya --}}
        <div
            class="pointer-events-none absolute -right-20 -top-24 h-72 w-72 rounded-full"
            style="background:rgba(255,255,255,.06); filter:blur(45px);"
        ></div>

        <div class="relative z-10 flex min-h-[210px] items-center justify-between gap-8 px-8 py-8 sm:px-10 lg:px-11">

            {{-- kiri --}}
            <div class="min-w-0">

                <p class="mb-2 text-[10px] font-bold uppercase tracking-[0.30em] text-white/75">
                    MASTER DATA
                </p>

                <h1
                    class="dashboard-display text-5xl leading-none text-white sm:text-6xl"
                >
                    Data
                    <span class="text-[#F28C28]">
                        Mitra
                    </span>
                </h1>

                <p class="mt-4 max-w-2xl text-sm leading-6 text-white/85 sm:text-base">
                    Kelola data mitra pengolahan BA Rampung dengan mudah dan terstruktur.
                </p>

            </div>

            {{-- kanan --}}
            <div class="hidden shrink-0 flex-col items-end gap-3 sm:flex">

                <div
                    class="rounded-[18px] border border-white/15 px-5 py-3 text-white"
                    style="
                        background:rgba(8,35,68,.42);
                        backdrop-filter:blur(12px);
                    "
                >
                    <p class="text-[10px] font-bold uppercase tracking-[0.20em] text-white/60">
                        STATUS DATA
                    </p>

                    <div class="mt-1 flex items-center gap-2 text-sm font-semibold">
                        <span class="h-2.5 w-2.5 rounded-full bg-emerald-400"></span>
                        Data mitra aktif
                    </div>
                </div>

                @role('admin_kantor', 'admin_gudang', 'admin_sistem')
                    <a
                        href="{{ route('mitra.create') }}"
                        class="inline-flex items-center gap-2 rounded-full bg-[#123F7A] px-6 py-3 text-sm font-bold text-white shadow-lg transition duration-200 hover:-translate-y-0.5 hover:bg-[#0d3263]"
                    >
                        <span class="text-lg leading-none">＋</span>
                        Tambah Mitra
                    </a>
                @endrole

            </div>

        </div>

    </section>


    {{-- =========================================================
         KPI
    ========================================================== --}}
    <section class="grid grid-cols-1 gap-4 md:grid-cols-3">

        {{-- TOTAL MITRA --}}
        <div
            class="group relative overflow-hidden rounded-[24px] border border-white/80 bg-white px-6 py-5 shadow-[0_12px_35px_rgba(15,61,110,.08)] transition duration-200 hover:-translate-y-1"
        >

            <div class="absolute -right-8 -top-8 h-28 w-28 rounded-full bg-[#EAF2FC]"></div>

            <div class="relative flex items-center justify-between">

                <div>
                    <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-[#7086A2]">
                        Total Mitra
                    </p>

                    <p class="dashboard-display mt-2 text-4xl text-[#123F7A]">
                        {{ number_format($mitras->total()) }}
                    </p>

                    <p class="mt-1 text-xs text-[#91A4BC]">
                        Mitra pengolahan terdaftar
                    </p>
                </div>

                <div
                    class="flex h-14 w-14 items-center justify-center rounded-2xl bg-[#EDF5FF] text-2xl shadow-sm"
                >
                    🤝
                </div>

            </div>

        </div>


        {{-- DATA DITAMPILKAN --}}
        <div
            class="group relative overflow-hidden rounded-[24px] border border-white/80 bg-white px-6 py-5 shadow-[0_12px_35px_rgba(15,61,110,.08)] transition duration-200 hover:-translate-y-1"
        >

            <div class="absolute -right-8 -top-8 h-28 w-28 rounded-full bg-[#EEF9F3]"></div>

            <div class="relative flex items-center justify-between">

                <div>
                    <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-[#7086A2]">
                        Data Ditampilkan
                    </p>

                    <p class="dashboard-display mt-2 text-4xl text-[#123F7A]">
                        {{ number_format($mitras->count()) }}
                    </p>

                    <p class="mt-1 text-xs text-[#91A4BC]">
                        Data pada halaman ini
                    </p>
                </div>

                <div
                    class="flex h-14 w-14 items-center justify-center rounded-2xl bg-[#EEF9F3] text-xl text-emerald-600 shadow-sm"
                >
                    ✓
                </div>

            </div>

        </div>


        {{-- JENIS USAHA --}}
        <div
            class="group relative overflow-hidden rounded-[24px] border border-white/80 bg-white px-6 py-5 shadow-[0_12px_35px_rgba(15,61,110,.08)] transition duration-200 hover:-translate-y-1"
        >

            <div class="absolute -right-8 -top-8 h-28 w-28 rounded-full bg-[#FFF5E9]"></div>

            <div class="relative flex items-center justify-between">

                <div>
                    <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-[#7086A2]">
                        Jenis Usaha
                    </p>

                    <p class="dashboard-display mt-2 text-4xl text-[#F28C28]">
                        {{ number_format(count($jenisUsahaOptions)) }}
                    </p>

                    <p class="mt-1 text-xs text-[#91A4BC]">
                        Pilihan jenis usaha
                    </p>
                </div>

                <div
                    class="flex h-14 w-14 items-center justify-center rounded-2xl bg-[#FFF5E9] text-xl text-[#F28C28] shadow-sm"
                >
                    ▦
                </div>

            </div>

        </div>

    </section>


    {{-- =========================================================
         FILTER
    ========================================================== --}}
    <section
        class="overflow-hidden rounded-[26px] border border-white/80 bg-white shadow-[0_12px_35px_rgba(15,61,110,.08)]"
    >

        <form
            method="GET"
            action="{{ route('mitra.index') }}"
        >

            {{-- HEADER FILTER --}}
            <div
                class="flex flex-col gap-4 border-b border-[#EDF2F7] px-6 py-5 sm:flex-row sm:items-center sm:justify-between"
            >

                <div class="flex items-center gap-4">

                    <div
                        class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-[#123F7A] text-lg text-white shadow-sm"
                    >
                        ⌕
                    </div>

                    <div>

                        <p class="text-[10px] font-bold uppercase tracking-[0.25em] text-[#123F7A]">
                            FILTER DATA
                        </p>

                        <h2 class="mt-1 text-xl font-bold text-[#102F55]">
                            Cari Mitra
                        </h2>

                        <p class="mt-0.5 text-xs text-[#8CA0B8]">
                            Cari dan saring data mitra pengolahan dengan lebih cepat.
                        </p>

                    </div>

                </div>


                <div class="flex items-center gap-2">

                    @if(request('search') || request('jenis_usaha'))

                        <a
                            href="{{ route('mitra.index') }}"
                            class="inline-flex items-center justify-center rounded-xl border border-[#DDE6F0] bg-white px-4 py-2.5 text-sm font-semibold text-[#60758F] transition hover:bg-[#F7F9FC]"
                        >
                            ↺ Reset
                        </a>

                    @endif

                    <button
                        type="submit"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#123F7A] px-5 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-[#0d3263]"
                    >
                        ⌕
                        Cari
                    </button>

                </div>

            </div>


            {{-- FORM FILTER --}}
            <div class="grid grid-cols-1 gap-5 px-6 py-6 md:grid-cols-2">

                {{-- PENCARIAN --}}
                <div>

                    <label
                        class="mb-2 block text-[11px] font-bold uppercase tracking-[0.12em] text-[#60758F]"
                    >
                        Pencarian
                    </label>

                    <div class="relative">

                        <span
                            class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-[#9BAEC4]"
                        >
                            ⌕
                        </span>

                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Cari nama mitra atau kode mitra..."
                            class="w-full rounded-2xl border border-[#DDE6F0] bg-[#FBFCFE] py-3.5 pl-11 pr-4 text-sm text-[#243B5A] outline-none transition placeholder:text-[#A9B7C8] focus:border-[#123F7A] focus:bg-white focus:ring-4 focus:ring-blue-50"
                        >

                    </div>

                </div>


                {{-- JENIS USAHA --}}
                <div>

                    <label
                        class="mb-2 block text-[11px] font-bold uppercase tracking-[0.12em] text-[#60758F]"
                    >
                        Jenis Usaha
                    </label>

                    <select
                        name="jenis_usaha"
                        onchange="this.form.submit()"
                        class="w-full rounded-2xl border border-[#DDE6F0] bg-[#FBFCFE] px-4 py-3.5 text-sm text-[#243B5A] outline-none transition focus:border-[#123F7A] focus:bg-white focus:ring-4 focus:ring-blue-50"
                    >

                        <option value="">
                            Semua Jenis Usaha
                        </option>

                        @foreach($jenisUsahaOptions as $j)

                            <option
                                value="{{ $j }}"
                                @selected(request('jenis_usaha') === $j)
                            >
                                {{ $j }}
                            </option>

                        @endforeach

                    </select>

                </div>

            </div>

        </form>

    </section>


    {{-- =========================================================
         DATA MITRA
    ========================================================== --}}
    <section
        class="overflow-hidden rounded-[26px] border border-white/80 bg-white shadow-[0_12px_35px_rgba(15,61,110,.08)]"
    >

        {{-- HEADER DATA --}}
        <div
            class="flex flex-col gap-4 border-b border-[#EDF2F7] px-6 py-5 sm:flex-row sm:items-center sm:justify-between"
        >

            <div class="flex items-center gap-4">

                <div
                    class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-[#EDF5FF] text-lg"
                >
                    🤝
                </div>

                <div>

                    <p class="text-[10px] font-bold uppercase tracking-[0.25em] text-[#123F7A]">
                        MASTER DATA
                    </p>

                    <h2 class="mt-1 text-xl font-bold text-[#102F55]">
                        Data Mitra
                    </h2>

                    <p class="mt-0.5 text-xs text-[#8CA0B8]">
                        Menampilkan
                        {{ $mitras->firstItem() ?? 0 }}
                        –
                        {{ $mitras->lastItem() ?? 0 }}
                        dari
                        {{ $mitras->total() }}
                        data mitra.
                    </p>

                </div>

            </div>


            <div
                class="rounded-full bg-[#F5F8FC] px-4 py-2 text-xs font-semibold text-[#56708F]"
            >
                {{ number_format($mitras->total()) }} Mitra
            </div>

        </div>


        {{-- TABLE --}}
        <div class="overflow-x-auto">

            <table class="w-full min-w-[1100px] text-sm">

                <thead>

                    <tr
                        class="border-b border-[#E8EEF5] bg-[#F8FAFD] text-left"
                    >

                        <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-[0.14em] text-[#657A95]">
                            No.
                        </th>

                        <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-[0.14em] text-[#657A95]">
                            Kode Mitra
                        </th>

                        <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-[0.14em] text-[#657A95]">
                            Nama Mitra
                        </th>

                        <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-[0.14em] text-[#657A95]">
                            Jenis Usaha
                        </th>

                        <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-[0.14em] text-[#657A95]">
                            Alamat
                        </th>

                        <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-[0.14em] text-[#657A95]">
                            Kontak
                        </th>

                        <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-[0.14em] text-[#657A95]">
                            Status
                        </th>

                        <th class="px-6 py-4 text-right text-[10px] font-bold uppercase tracking-[0.14em] text-[#657A95]">
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($mitras as $i => $m)

                        <tr
                            class="border-b border-[#EEF2F6] transition duration-150 hover:bg-[#F7FAFE]"
                        >

                            {{-- NO --}}
                            <td class="px-6 py-4 text-[#8193A9]">
                                {{ $mitras->firstItem() + $i }}
                            </td>


                            {{-- KODE --}}
                            <td class="px-6 py-4">

                                <span
                                    class="inline-flex rounded-lg bg-[#EDF5FF] px-3 py-1.5 text-xs font-bold text-[#123F7A]"
                                >
                                    {{ $m->kode_mitra }}
                                </span>

                            </td>


                            {{-- NAMA --}}
                            <td class="px-6 py-4">

                                <div class="font-semibold text-[#183657]">
                                    {{ $m->nama_mitra }}
                                </div>

                            </td>


                            {{-- JENIS USAHA --}}
                            <td class="px-6 py-4 text-[#60758F]">
                                {{ $m->jenis_usaha ?? '-' }}
                            </td>


                            {{-- ALAMAT --}}
                            <td class="max-w-[320px] px-6 py-4 text-[#60758F]">
                                {{ $m->alamat ?? '-' }}
                            </td>


                            {{-- KONTAK --}}
                            <td class="px-6 py-4 text-[#60758F]">
                                {{ $m->nomor_telepon ?? '-' }}
                            </td>


                            {{-- STATUS --}}
                            <td class="px-6 py-4">

                                <x-status-badge
                                    :color="$m->status === 'aktif' ? 'green' : 'gray'"
                                    :label="ucfirst($m->status)"
                                />

                            </td>


                            {{-- AKSI --}}
                            <td class="px-6 py-4">

                                <div class="flex justify-end gap-2">

                                    {{-- DETAIL --}}
                                    <a
                                        href="{{ route('mitra.show', $m) }}"
                                        title="Detail"
                                        class="flex h-9 w-9 items-center justify-center rounded-xl bg-[#EDF5FF] text-[#123F7A] transition hover:bg-[#DDEBFC]"
                                    >
                                        👁
                                    </a>


                                    @role('admin_kantor', 'admin_gudang', 'admin_sistem')

                                        {{-- EDIT --}}
                                        <a
                                            href="{{ route('mitra.edit', $m) }}"
                                            title="Edit"
                                            class="flex h-9 w-9 items-center justify-center rounded-xl bg-[#FFF5E9] text-[#D97706] transition hover:bg-[#FFE9CC]"
                                        >
                                            ✎
                                        </a>


                                        {{-- TOGGLE STATUS --}}
                                        <form
                                            method="POST"
                                            action="{{ route('mitra.toggle-status', $m) }}"
                                            onsubmit="return confirm('{{ $m->status === 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }} mitra {{ $m->nama_mitra }}?');"
                                        >

                                            @csrf
                                            @method('PATCH')

                                            <button
                                                type="submit"
                                                title="{{ $m->status === 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }}"
                                                class="flex h-9 w-9 items-center justify-center rounded-xl bg-[#F4F6F8] text-[#60758F] transition hover:bg-[#E8EDF2]"
                                            >
                                                {{ $m->status === 'aktif' ? '⏸' : '▶' }}
                                            </button>

                                        </form>

                                    @endrole

                                </div>

                            </td>

                        </tr>


                    @empty

                        <tr>

                            <td
                                colspan="8"
                                class="px-6 py-20 text-center"
                            >

                                <div class="flex flex-col items-center">

                                    <div
                                        class="mb-4 flex h-16 w-16 items-center justify-center rounded-2xl bg-[#EDF5FF] text-3xl"
                                    >
                                        🤝
                                    </div>

                                    <p class="font-semibold text-[#183657]">
                                        Belum ada data Mitra Pengolahan.
                                    </p>

                                    <p class="mt-1 text-sm text-[#8CA0B8]">
                                        Data mitra akan tampil di sini.
                                    </p>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- PAGINATION --}}
        @if($mitras->hasPages())

            <div class="border-t border-[#EDF2F7] px-6 py-5">
                {{ $mitras->links() }}
            </div>

        @endif

    </section>

</div>

@endsection