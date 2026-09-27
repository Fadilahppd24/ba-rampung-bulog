@extends('layouts.ba-rampung')

@section('title', 'Daftar BA Rampung')

@section('content')

{{-- =========================================================
     PAGE HEADER
========================================================= --}}
<div class="mb-7">

    <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-4">

        <div>

            <div class="flex items-center gap-2 mb-2">

                <span class="w-2 h-2 rounded-full bg-orange-500"></span>

                <span class="text-[10px] font-bold uppercase tracking-[0.2em] text-slate-400">
                    ADMINISTRASI BA
                </span>

            </div>


            <h1 class="text-2xl lg:text-3xl font-bold tracking-tight text-slate-900">
                Daftar BA Rampung
            </h1>


            <p class="mt-1.5 text-sm text-slate-500">
                Kelola dan pantau seluruh Berita Acara Rampung.
            </p>

        </div>


        <div class="inline-flex items-center gap-2 self-start lg:self-auto px-3.5 py-2 rounded-full bg-white border border-slate-200 shadow-sm">

            <span class="relative flex h-2 w-2">

                <span
                    class="absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-60 animate-ping"
                ></span>

                <span
                    class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"
                ></span>

            </span>

            <span class="text-xs font-medium text-slate-600">
                Sistem aktif
            </span>

        </div>

    </div>

</div>


{{-- =========================================================
     KPI CARDS
========================================================= --}}
<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-5 gap-4 mb-7">


    {{-- TOTAL --}}
    <div class="relative overflow-hidden bg-white rounded-2xl border border-slate-200 p-5 shadow-sm hover:shadow-md transition">

        <div class="absolute -right-6 -top-6 w-20 h-20 rounded-full bg-blue-50"></div>

        <div class="relative flex items-start justify-between">

            <div>

                <p class="text-xs font-semibold text-slate-500">
                    Total BA Rampung
                </p>

                <p class="mt-2 text-2xl font-bold text-slate-900">
                    {{ number_format($kpi['total']) }}
                </p>

                <p class="mt-1 text-[10px] text-slate-400">
                    Seluruh dokumen
                </p>

            </div>

            <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center">
                📄
            </div>

        </div>

    </div>


    {{-- TERVERIFIKASI --}}
    <div class="relative overflow-hidden bg-white rounded-2xl border border-slate-200 p-5 shadow-sm hover:shadow-md transition">

        <div class="absolute -right-6 -top-6 w-20 h-20 rounded-full bg-emerald-50"></div>

        <div class="relative flex items-start justify-between">

            <div>

                <p class="text-xs font-semibold text-slate-500">
                    Terverifikasi
                </p>

                <p class="mt-2 text-2xl font-bold text-slate-900">
                    {{ number_format($kpi['terverifikasi']) }}
                </p>

                <p class="mt-1 text-[10px] text-emerald-600">
                    Sudah diverifikasi
                </p>

            </div>

            <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center">
                ✓
            </div>

        </div>

    </div>


    {{-- BELUM DISERAH --}}
    <div class="relative overflow-hidden bg-white rounded-2xl border border-slate-200 p-5 shadow-sm hover:shadow-md transition">

        <div class="absolute -right-6 -top-6 w-20 h-20 rounded-full bg-amber-50"></div>

        <div class="relative flex items-start justify-between">

            <div>

                <p class="text-xs font-semibold text-slate-500">
                    Belum Diserah
                </p>

                <p class="mt-2 text-2xl font-bold text-slate-900">
                    {{ number_format($kpi['belum_serah']) }}
                </p>

                <p class="mt-1 text-[10px] text-amber-600">
                    Menunggu proses
                </p>

            </div>

            <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center">
                ⏳
            </div>

        </div>

    </div>


    {{-- DITOLAK --}}
    <div class="relative overflow-hidden bg-white rounded-2xl border border-slate-200 p-5 shadow-sm hover:shadow-md transition">

        <div class="absolute -right-6 -top-6 w-20 h-20 rounded-full bg-red-50"></div>

        <div class="relative flex items-start justify-between">

            <div>

                <p class="text-xs font-semibold text-slate-500">
                    Ditolak / Catatan
                </p>

                <p class="mt-2 text-2xl font-bold text-slate-900">
                    {{ number_format($kpi['ditolak']) }}
                </p>

                <p class="mt-1 text-[10px] text-red-500">
                    Perlu diperiksa
                </p>

            </div>

            <div class="w-10 h-10 rounded-xl bg-red-50 flex items-center justify-center">
                !
            </div>

        </div>

    </div>


    {{-- MITRA --}}
    <div class="relative overflow-hidden bg-white rounded-2xl border border-slate-200 p-5 shadow-sm hover:shadow-md transition">

        <div class="absolute -right-6 -top-6 w-20 h-20 rounded-full bg-orange-50"></div>

        <div class="relative flex items-start justify-between">

            <div>

                <p class="text-xs font-semibold text-slate-500">
                    Mitra Pengolahan
                </p>

                <p class="mt-2 text-2xl font-bold text-slate-900">
                    {{ number_format($kpi['mitra']) }}
                </p>

                <p class="mt-1 text-[10px] text-slate-400">
                    Mitra terdaftar
                </p>

            </div>

            <div class="w-10 h-10 rounded-xl bg-orange-50 flex items-center justify-center">
                🤝
            </div>

        </div>

    </div>

</div>


{{-- =========================================================
     FILTER
========================================================= --}}
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm mb-7 overflow-hidden">

    <div class="px-5 py-4 border-b border-slate-100">

        <div class="flex items-center gap-3">

            <div class="w-9 h-9 rounded-xl bg-blue-50 flex items-center justify-center">
                ⚙️
            </div>

            <div>

                <h2 class="text-sm font-bold text-slate-900">
                    Filter Data
                </h2>

                <p class="text-[11px] text-slate-400">
                    Gunakan filter untuk mencari data BA Rampung.
                </p>

            </div>

        </div>

    </div>


    <form
        method="GET"
        action="{{ route('ba-rampung.index') }}"
        class="p-5"
    >

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-6 gap-3">


            {{-- SEARCH --}}
            <div class="xl:col-span-2">

                <label class="block text-[11px] font-semibold text-slate-500 mb-1.5">
                    Pencarian
                </label>

                <div class="relative">

                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
                        ⌕
                    </span>

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari Nomor BA, Gudang, atau Mitra..."
                        class="w-full h-10 pl-9 pr-3 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-700 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition"
                    >

                </div>

            </div>


            {{-- STATUS --}}
            <div>

                <label class="block text-[11px] font-semibold text-slate-500 mb-1.5">
                    Status
                </label>

                <select
                    name="status"
                    class="w-full h-10 px-3 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition"
                >

                    <option value="">
                        Semua Status
                    </option>

                    @foreach (\App\Models\BaRampung::STATUSES as $val => $label)

                        <option
                            value="{{ $val }}"
                            @selected(request('status') === $val)
                        >
                            {{ $label }}
                        </option>

                    @endforeach

                </select>

            </div>


            {{-- GUDANG --}}
            <div>

                <label class="block text-[11px] font-semibold text-slate-500 mb-1.5">
                    Gudang
                </label>

                <select
                    name="gudang_id"
                    class="w-full h-10 px-3 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition"
                >

                    <option value="">
                        Semua Gudang
                    </option>

                    @foreach ($gudangs as $g)

                        <option
                            value="{{ $g->id }}"
                            @selected((string) request('gudang_id') === (string) $g->id)
                        >
                            {{ $g->nama_gudang }}
                        </option>

                    @endforeach

                </select>

            </div>


            {{-- MITRA --}}
            <div>

                <label class="block text-[11px] font-semibold text-slate-500 mb-1.5">
                    Mitra Pengolahan
                </label>

                <select
                    name="mitra_pengolahan_id"
                    class="w-full h-10 px-3 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition"
                >

                    <option value="">
                        Semua Mitra
                    </option>

                    @foreach ($mitras as $m)

                        <option
                            value="{{ $m->id }}"
                            @selected((string) request('mitra_pengolahan_id') === (string) $m->id)
                        >
                            {{ $m->nama_mitra }}
                        </option>

                    @endforeach

                </select>

            </div>


            {{-- BULAN --}}
            <div>

                <label class="block text-[11px] font-semibold text-slate-500 mb-1.5">
                    Bulan
                </label>

                <select
                    name="bulan"
                    class="w-full h-10 px-3 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition"
                >

                    <option value="">
                        Semua Bulan
                    </option>

                    @foreach (range(1, 12) as $m)

                        <option
                            value="{{ $m }}"
                            @selected((string) request('bulan') === (string) $m)
                        >
                            {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                        </option>

                    @endforeach

                </select>

            </div>

        </div>


        {{-- TAHUN + BUTTON --}}
        <div class="mt-4 flex flex-col lg:flex-row lg:items-end lg:justify-between gap-4">

            <div>

                <label class="block text-[11px] font-semibold text-slate-500 mb-1.5">
                    Tahun
                </label>

                <select
                    name="tahun"
                    class="w-full sm:w-32 h-10 px-3 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition"
                >

                    @foreach (range(now()->year, now()->year - 3) as $y)

                        <option
                            value="{{ $y }}"
                            @selected((string) request('tahun', now()->year) === (string) $y)
                        >
                            {{ $y }}
                        </option>

                    @endforeach

                </select>

            </div>


            <div class="flex flex-wrap gap-2">

                <a
                    href="{{ route('ba-rampung.index') }}"
                    class="inline-flex items-center justify-center h-10 px-4 rounded-xl border border-slate-200 bg-white text-xs font-semibold text-slate-600 hover:bg-slate-50 transition"
                >
                    ↻&nbsp; Reset
                </a>


                <a
                    href="{{ route('ba-rampung.export', request()->query()) }}"
                    class="inline-flex items-center justify-center h-10 px-4 rounded-xl bg-orange-50 border border-orange-100 text-xs font-semibold text-orange-700 hover:bg-orange-100 transition"
                >
                    ↓&nbsp; Export Excel
                </a>


                <button
                    type="submit"
                    class="inline-flex items-center justify-center h-10 px-5 rounded-xl bg-[#123D73] text-xs font-semibold text-white hover:bg-[#0d315d] transition shadow-sm"
                >
                    Terapkan Filter
                </button>

            </div>

        </div>

    </form>

</div>


{{-- =========================================================
     TABLE
========================================================= --}}
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">


    {{-- TABLE HEADER --}}
    <div class="px-5 py-5 border-b border-slate-100">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">

            <div>

                <div class="flex items-center gap-2">

                    <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center">
                        📋
                    </div>

                    <h2 class="text-base font-bold text-slate-900">
                        Daftar BA Rampung
                    </h2>

                </div>

                <p class="text-xs text-slate-400 mt-1.5 ml-10">
                    Daftar berita acara rampung yang tersimpan dalam sistem.
                </p>

            </div>


            <div class="inline-flex items-center gap-2 self-start md:self-auto px-3 py-1.5 rounded-full bg-slate-50 border border-slate-100">

                <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>

                <span class="text-[11px] text-slate-500">
                    Menampilkan
                </span>

                <strong class="text-[11px] text-slate-700">
                    {{ $baList->firstItem() ?? 0 }}–{{ $baList->lastItem() ?? 0 }}
                </strong>

                <span class="text-[11px] text-slate-400">
                    dari
                </span>

                <strong class="text-[11px] text-slate-700">
                    {{ $baList->total() }}
                </strong>

            </div>

        </div>

    </div>


    {{-- TABLE --}}
    <div class="overflow-x-auto">

        <table class="w-full min-w-[1100px] text-sm">

            <thead>

                <tr class="bg-slate-50/80 border-b border-slate-100">

                    <th class="px-5 py-3.5 text-left text-[10px] font-bold uppercase tracking-wider text-slate-400">
                        No.
                    </th>

                    <th class="px-5 py-3.5 text-left text-[10px] font-bold uppercase tracking-wider text-slate-400">
                        Nomor BA
                    </th>

                    <th class="px-5 py-3.5 text-left text-[10px] font-bold uppercase tracking-wider text-slate-400">
                        Tanggal BA
                    </th>

                    <th class="px-5 py-3.5 text-left text-[10px] font-bold uppercase tracking-wider text-slate-400">
                        Gudang
                    </th>

                    <th class="px-5 py-3.5 text-left text-[10px] font-bold uppercase tracking-wider text-slate-400">
                        Mitra Pengolahan
                    </th>

                    <th class="px-5 py-3.5 text-left text-[10px] font-bold uppercase tracking-wider text-slate-400">
                        Status Verifikasi
                    </th>

                    <th class="px-5 py-3.5 text-right text-[10px] font-bold uppercase tracking-wider text-slate-400">
                        Aksi
                    </th>

                </tr>

            </thead>


            <tbody class="divide-y divide-slate-100">

                @forelse ($baList as $i => $ba)

                    <tr class="group hover:bg-blue-50/30 transition-colors duration-150">


                        {{-- NO --}}
                        <td class="px-5 py-4">

                            <span class="text-xs font-medium text-slate-400">
                                {{ $baList->firstItem() + $i }}
                            </span>

                        </td>


                        {{-- NOMOR BA --}}
                        <td class="px-5 py-4">

                            <div class="flex items-center gap-3">

                                <div class="flex-shrink-0 w-9 h-9 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center text-[10px] font-bold">
                                    BA
                                </div>

                                <div class="min-w-0">

                                    <p class="text-xs font-bold text-slate-800">
                                        {{ $ba->nomor_ba }}
                                    </p>

                                    <p class="text-[10px] text-slate-400 mt-0.5">
                                        Berita Acara Rampung
                                    </p>

                                </div>

                            </div>

                        </td>


                        {{-- TANGGAL --}}
                        <td class="px-5 py-4">

                            <div class="flex items-center gap-2">

                                <span class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center">
                                    📅
                                </span>

                                <span class="text-xs font-medium text-slate-600">
                                    {{ $ba->tanggal_ba->format('d/m/Y') }}
                                </span>

                            </div>

                        </td>


                        {{-- GUDANG --}}
                        <td class="px-5 py-4">

                            <div class="max-w-[180px]">

                                <p class="text-xs font-semibold text-slate-700 truncate">
                                    {{ $ba->gudang->nama_gudang }}
                                </p>

                                <p class="text-[10px] text-slate-400 mt-0.5">
                                    Gudang penyimpanan
                                </p>

                            </div>

                        </td>


                        {{-- MITRA --}}
                        <td class="px-5 py-4">

                            <div class="max-w-[220px]">

                                <p class="text-xs font-semibold text-slate-700 truncate">
                                    {{ $ba->mitraPengolahan->nama_mitra }}
                                </p>

                                <p class="text-[10px] text-slate-400 mt-0.5">
                                    Mitra pengolahan
                                </p>

                            </div>

                        </td>


                        {{-- STATUS --}}
                        <td class="px-5 py-4">

                            <x-status-badge
                                :color="$ba->statusBadgeColor()"
                                :label="$ba->statusLabel()"
                            />

                        </td>


                        {{-- AKSI --}}
                        <td class="px-5 py-4">

                            <div class="flex items-center justify-end gap-1.5">


                                {{-- LIHAT --}}
                                <a
                                    href="{{ route('ba-rampung.show', $ba) }}"
                                    title="Lihat"
                                    class="inline-flex items-center justify-center h-8 px-3 rounded-lg border border-slate-200 bg-white text-[11px] font-semibold text-slate-600 hover:text-blue-700 hover:border-blue-200 hover:bg-blue-50 transition"
                                >
                                    Lihat
                                </a>


                                {{-- EDIT --}}
                                @can('update', $ba)

                                    <a
                                        href="{{ route('ba-rampung.edit', $ba) }}"
                                        title="Edit"
                                        class="inline-flex items-center justify-center h-8 px-3 rounded-lg border border-slate-200 bg-white text-[11px] font-semibold text-slate-600 hover:text-blue-700 hover:border-blue-200 hover:bg-blue-50 transition"
                                    >
                                        Edit
                                    </a>

                                @endcan


                                {{-- PDF --}}
                                <a
                                    href="{{ route('ba-rampung.pdf', $ba) }}"
                                    target="_blank"
                                    title="PDF"
                                    class="inline-flex items-center justify-center h-8 px-3 rounded-lg border border-orange-100 bg-orange-50 text-[11px] font-semibold text-orange-700 hover:bg-orange-100 transition"
                                >
                                    PDF
                                </a>


                                {{-- HAPUS --}}
                                @can('delete', $ba)

                                    <form
                                        method="POST"
                                        action="{{ route('ba-rampung.destroy', $ba) }}"
                                        onsubmit="return confirm('Hapus BA Rampung {{ $ba->nomor_ba }}? Tindakan ini tidak dapat dibatalkan.');"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            title="Hapus"
                                            class="inline-flex items-center justify-center h-8 px-3 rounded-lg border border-red-100 bg-red-50 text-[11px] font-semibold text-red-600 hover:bg-red-100 transition"
                                        >
                                            Hapus
                                        </button>

                                    </form>

                                @endcan

                            </div>

                        </td>

                    </tr>


                @empty

                    <tr>

                        <td
                            colspan="7"
                            class="px-5 py-20 text-center"
                        >

                            <div class="flex flex-col items-center">

                                <div class="w-16 h-16 rounded-2xl bg-slate-50 flex items-center justify-center text-3xl mb-4">
                                    🗂️
                                </div>

                                <h3 class="text-sm font-bold text-slate-700">
                                    Belum ada data BA Rampung
                                </h3>

                                <p class="text-xs text-slate-400 mt-1">
                                    Data BA Rampung akan muncul di sini.
                                </p>

                            </div>

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>


    {{-- PAGINATION --}}
    @if ($baList->hasPages())

        <div class="px-5 py-4 border-t border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">

            <p class="text-xs text-slate-400">

                Halaman

                <span class="font-semibold text-slate-600">
                    {{ $baList->currentPage() }}
                </span>

                dari

                <span class="font-semibold text-slate-600">
                    {{ $baList->lastPage() }}
                </span>

            </p>


            <div>
                {{ $baList->links() }}
            </div>

        </div>

    @endif

</div>

@endsection