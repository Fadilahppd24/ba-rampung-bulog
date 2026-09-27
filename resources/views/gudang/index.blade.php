@extends('layouts.app')

@section('title', 'Gudang')

@section('content')

<div class="space-y-6">

    {{-- =========================================================
         HEADER
         Mengikuti pola visual Daftar BA Rampung.
    ========================================================== --}}
    <div class="flex flex-col gap-4 pt-2 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="dashboard-kicker text-white/75">
                Master Data
            </p>

            <h1 class="dashboard-display mt-2 text-4xl leading-tight text-white sm:text-5xl">
                Data <span class="text-[#F28C28]">Gudang</span>
            </h1>

            <p class="mt-2 text-sm text-white/85" style="text-shadow: 0 1px 8px rgba(3, 28, 55, .2);">
                Kelola data gudang penyimpanan BA Rampung.
            </p>
        </div>

        {{-- ADMIN KANTOR BISA TAMBAH GUDANG --}}
        @role('admin_kantor')
            <a
                href="{{ route('gudang.create') }}"
                class="inline-flex items-center justify-center gap-2 rounded-full bg-[#123F7A] px-5 py-3 text-sm font-bold text-white shadow-lg transition hover:-translate-y-0.5 hover:bg-[#0d3263]"
            >
                <span class="text-lg leading-none">＋</span>
                Tambah Gudang
            </a>
        @endrole
    </div>


    {{-- =========================================================
         KPI
    ========================================================== --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">
                        Total Gudang
                    </p>
                    <p class="mt-2 text-3xl font-bold text-[#123F7A]">
                        {{ number_format($kpi['total']) }}
                    </p>
                </div>
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 text-xl">
                    🏭
                </div>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">
                        Gudang Aktif
                    </p>
                    <p class="mt-2 text-3xl font-bold text-emerald-600">
                        {{ number_format($kpi['aktif']) }}
                    </p>
                </div>
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-50 text-xl">
                    ✅
                </div>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">
                        Total Dokumen BA
                    </p>
                    <p class="mt-2 text-3xl font-bold text-[#123F7A]">
                        {{ number_format($kpi['total_dokumen']) }}
                    </p>
                </div>
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 text-xl">
                    📄
                </div>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">
                        Sedang Diproses
                    </p>
                    <p class="mt-2 text-3xl font-bold text-amber-600">
                        {{ number_format($kpi['dengan_proses']) }}
                    </p>
                </div>
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-amber-50 text-xl">
                    ⏳
                </div>
            </div>
        </div>

    </div>


    {{-- =========================================================
         FILTER & SEARCH
    ========================================================== --}}
    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

        <form method="GET" action="{{ route('gudang.index') }}" class="space-y-5">

            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-lg">
                        🔍
                    </div>
                    <div>
                        <h2 class="text-base font-bold text-gray-900">
                            Filter Data
                        </h2>
                        <p class="mt-0.5 text-xs text-gray-500">
                            Gunakan filter berikut untuk menemukan gudang dengan lebih cepat.
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-2">

                    {{-- RESET --}}
                    @if(request('gudang_utama_id') || request('search'))
                        <a
                            href="{{ route('gudang.index') }}"
                            class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50"
                        >
                            ↺ Reset
                        </a>
                    @endif

                    <button
                        type="submit"
                        class="inline-flex items-center justify-center rounded-xl bg-[#123F7A] px-4 py-2.5 text-sm font-bold text-white transition hover:bg-[#0d3263]"
                    >
                        🔍 Cari
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-3 md:grid-cols-2">

                <div>
                    <label class="mb-1.5 block text-xs font-semibold text-slate-500">
                        Pencarian
                    </label>

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari nama gudang atau kode gudang..."
                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm text-gray-700 outline-none transition placeholder:text-slate-400 focus:border-[#123F7A] focus:ring-2 focus:ring-blue-100"
                    >
                </div>

                <div>
                    <label class="mb-1.5 block text-xs font-semibold text-slate-500">
                        Gudang Utama
                    </label>

                    <select
                        name="gudang_utama_id"
                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm text-gray-700 outline-none focus:border-[#123F7A] focus:ring-2 focus:ring-blue-100"
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

    </div>


    {{-- =========================================================
         TABLE
    ========================================================== --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        <div class="flex flex-col gap-2 border-b border-slate-100 px-5 py-5 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-lg">
                    🏭
                </div>
                <div>
                    <h2 class="font-bold text-gray-900">
                        Data Gudang
                    </h2>
                    <p class="mt-1 text-xs text-gray-500">
                        Gudang utama dan gudang filial.
                    </p>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">

            <table class="w-full min-w-[900px] text-sm">

                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50 text-left text-xs uppercase tracking-wider text-slate-500">
                        <th class="px-5 py-3 font-semibold">No.</th>
                        <th class="px-5 py-3 font-semibold">Kode</th>
                        <th class="px-5 py-3 font-semibold">Nama Gudang</th>
                        <th class="px-5 py-3 font-semibold">Gudang Induk</th>
                        <th class="px-5 py-3 font-semibold">Kecamatan</th>
                        <th class="px-5 py-3 font-semibold">Desa</th>
                        <th class="px-5 py-3 font-semibold">Kapasitas</th>
                        <th class="px-5 py-3 font-semibold">Status</th>
                        <th class="px-5 py-3 text-right font-semibold">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">

                    @forelse($gudangs as $i => $gudang)

                        {{-- ========================= --}}
                        {{-- GUDANG UTAMA --}}
                        {{-- ========================= --}}

                        @if(is_null($gudang->gudang_induk_id))

                            <tr class="bg-slate-50/80">
                                <td colspan="9" class="px-5 py-4">
                                    <div class="flex items-center gap-3">
                                        <span class="text-lg">
                                            🏭
                                        </span>
                                        <div>
                                            <p class="font-bold text-gray-900">
                                                {{ $gudang->nama_gudang }}
                                            </p>
                                            <p class="text-xs text-slate-500">
                                                {{ $gudang->kode_gudang }}
                                                — Gudang Utama
                                            </p>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                        {{-- ========================= --}}
                        {{-- GUDANG FILIAL --}}
                        {{-- ========================= --}}

                        @else

                            <tr class="transition hover:bg-slate-50/80">

                                <td class="px-5 py-4 text-slate-400">
                                    {{ $i + 1 }}
                                </td>

                                <td class="px-5 py-4 font-bold text-[#123F7A]">
                                    {{ $gudang->kode_gudang }}
                                </td>

                                <td class="px-5 py-4">
                                    <div class="pl-4">
                                        <p class="font-medium text-gray-900">
                                            ↳ {{ $gudang->nama_gudang }}
                                        </p>
                                        @if($gudang->alamat)
                                            <p class="mt-1 text-xs text-slate-500">
                                                {{ $gudang->alamat }}
                                            </p>
                                        @endif
                                    </div>
                                </td>

                                <td class="px-5 py-4 text-slate-600">
                                    {{ $gudang->gudangInduk->nama_gudang ?? '-' }}
                                </td>

                                <td class="px-5 py-4 text-slate-600">
                                    {{ $gudang->kecamatan ?? '-' }}
                                </td>

                                <td class="px-5 py-4 text-slate-600">
                                    {{ $gudang->desa ?? '-' }}
                                </td>

                                <td class="px-5 py-4 text-slate-600">
                                    @if($gudang->kapasitas !== null)
                                        {{ number_format($gudang->kapasitas, 2, ',', '.') }} Ton
                                    @else
                                        -
                                    @endif
                                </td>

                                <td class="px-5 py-4">
                                    <x-status-badge
                                        :color="$gudang->status === 'aktif' ? 'green' : 'gray'"
                                        :label="ucfirst($gudang->status)"
                                    />
                                </td>

                                <td class="px-5 py-4">
                                    <div class="flex justify-end items-center gap-3 text-xs font-semibold">

                                        <a
                                            href="{{ route('gudang.show', $gudang) }}"
                                            class="text-[#123F7A] transition hover:text-orange-500 hover:underline"
                                        >
                                            Lihat
                                        </a>

                                        @role('admin_kantor')

                                            <a
                                                href="{{ route('gudang.edit', $gudang) }}"
                                                class="text-[#123F7A] transition hover:text-orange-500 hover:underline"
                                            >
                                                Edit
                                            </a>

                                            <form
                                                method="POST"
                                                action="{{ route('gudang.toggle-status', $gudang) }}"
                                                class="inline"
                                            >
                                                @csrf
                                                @method('PATCH')

                                                <button
                                                    type="submit"
                                                    class="text-[#123F7A] transition hover:text-orange-500 hover:underline"
                                                    onclick="return confirm('Apakah Anda yakin ingin mengubah status gudang ini?')"
                                                >
                                                    {{ $gudang->status === 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }}
                                                </button>
                                            </form>

                                        @endrole

                                    </div>
                                </td>

                            </tr>

                        @endif

                    @empty

                        <tr>
                            <td colspan="9" class="px-5 py-16 text-center text-slate-500">
                                <p class="mb-2 text-3xl">🏭</p>
                                <p class="font-medium">
                                    Belum ada data gudang.
                                </p>

                                @role('admin_kantor')
                                    <a
                                        href="{{ route('gudang.create') }}"
                                        class="mt-3 inline-block text-sm font-semibold text-[#123F7A] hover:underline"
                                    >
                                        ＋ Tambah Gudang
                                    </a>
                                @endrole
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection
