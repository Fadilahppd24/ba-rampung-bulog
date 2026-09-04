@extends('layouts.app')

@section('title', 'Laporan')

@section('content')

<div class="space-y-5">

    {{-- HEADER --}}
    <div>
        <h1 class="text-2xl font-bold text-gray-900">
            Laporan
        </h1>

        <p class="mt-1 text-sm text-gray-500">
            Pilih jenis laporan dan tentukan periode untuk menampilkan data.
        </p>
    </div>


    {{-- INFO ROLE --}}
    <div class="rounded-xl border border-bulog-200 bg-bulog-cream/40 p-4">

        <div class="flex items-start gap-3">

            <div class="mt-0.5 text-xl">
                📊
            </div>

            <div>
                <p class="font-semibold text-gray-800">
                    {{ $isAdminGudang ? 'Laporan Gudang' : 'Laporan Seluruh Gudang' }}
                </p>

                <p class="mt-1 text-sm text-gray-600">

                    @if ($isAdminGudang)

                        Laporan hanya menampilkan data dari
                        <span class="font-semibold text-bulog-800">
                            {{ $gudangUser?->nama_gudang ?? 'gudang Anda' }}
                        </span>.

                    @else

                        Laporan dapat menampilkan data dari seluruh gudang.
                        Gunakan filter gudang untuk melihat data tertentu.

                    @endif

                </p>
            </div>

        </div>

    </div>


    {{-- FILTER LAPORAN --}}
    <div class="card p-5">

        <div class="mb-5">

            <h3 class="font-semibold text-gray-900">
                Pilih Jenis Laporan
            </h3>

            <p class="mt-1 text-sm text-gray-500">
                Tentukan data yang ingin kamu lihat.
            </p>

        </div>


        {{-- JENIS LAPORAN --}}
        <form
            method="GET"
            action="{{ route('laporan.index') }}"
            class="space-y-5"
        >

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">

                @foreach ($jenisList as $val => $label)

                    @php
                        $icon = match ($val) {
                            'ba_rampung' => '📄',
                            'per_mitra' => '🤝',
                            'per_gudang' => '🏭',
                            'catatan' => '📝',
                            default => '📊',
                        };
                    @endphp

                    <label class="cursor-pointer">

                        <input
                            type="radio"
                            name="jenis"
                            value="{{ $val }}"
                            class="hidden peer"
                            @checked($jenis === $val)
                        >

                        <div class="
                            h-full
                            rounded-xl
                            border-2
                            border-gray-200
                            bg-white
                            p-4
                            transition-all
                            peer-checked:border-bulog-700
                            peer-checked:bg-bulog-cream/40
                            hover:border-gray-300
                        ">

                            <div class="flex items-start gap-3">

                                <div class="text-2xl">
                                    {{ $icon }}
                                </div>

                                <div>
                                    <p class="
                                        text-sm
                                        font-semibold
                                        text-gray-700
                                        peer-checked:text-bulog-800
                                    ">
                                        {{ $label }}
                                    </p>

                                    <p class="mt-1 text-xs text-gray-400">

                                        @switch($val)

                                            @case('ba_rampung')
                                                Rekap seluruh BA Rampung
                                                @break

                                            @case('per_mitra')
                                                Rekap berdasarkan mitra
                                                @break

                                            @case('per_gudang')
                                                Rekap berdasarkan gudang
                                                @break

                                            @case('catatan')
                                                Daftar BA yang memiliki catatan
                                                @break

                                        @endswitch

                                    </p>
                                </div>

                            </div>

                        </div>

                    </label>

                @endforeach

            </div>


            {{-- FILTER --}}
            <div>

                <h4 class="mb-3 text-sm font-semibold text-gray-700">
                    Filter Data
                </h4>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-3">

                    {{-- GUDANG --}}
                    <div>

                        <label class="mb-1.5 block text-xs font-medium text-gray-600">
                            Gudang
                        </label>

                        @if ($isAdminGudang)

                            <input
                                type="text"
                                class="input bg-gray-100"
                                value="{{ $gudangUser?->nama_gudang ?? '-' }}"
                                readonly
                            >

                            <input
                                type="hidden"
                                name="gudang_id"
                                value="{{ $gudangUser?->id }}"
                            >

                        @else

                            <select
                                name="gudang_id"
                                class="input"
                            >

                                <option value="">
                                    Semua Gudang
                                </option>

                                @foreach ($gudangs as $g)

                                    <option
                                        value="{{ $g->id }}"
                                        @selected(request('gudang_id') == $g->id)
                                    >
                                        {{ $g->nama_gudang }}
                                    </option>

                                @endforeach

                            </select>

                        @endif

                    </div>


                    {{-- MITRA --}}
                    <div>

                        <label class="mb-1.5 block text-xs font-medium text-gray-600">
                            Mitra Pengolahan
                        </label>

                        <select
                            name="mitra_pengolahan_id"
                            class="input"
                        >

                            <option value="">
                                Semua Mitra
                            </option>

                            @foreach ($mitras as $m)

                                <option
                                    value="{{ $m->id }}"
                                    @selected(request('mitra_pengolahan_id') == $m->id)
                                >
                                    {{ $m->nama_mitra }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- BULAN --}}
                    <div>

                        <label class="mb-1.5 block text-xs font-medium text-gray-600">
                            Bulan
                        </label>

                        <select
                            name="bulan"
                            class="input"
                        >

                            <option value="">
                                Semua Bulan
                            </option>

                            @foreach (range(1, 12) as $bln)

                                <option
                                    value="{{ $bln }}"
                                    @selected((string) request('bulan') === (string) $bln)
                                >
                                    {{ \Carbon\Carbon::create()->month($bln)->translatedFormat('F') }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- TAHUN --}}
                    <div>

                        <label class="mb-1.5 block text-xs font-medium text-gray-600">
                            Tahun
                        </label>

                        <select
                            name="tahun"
                            class="input"
                        >

                            <option value="">
                                Semua Tahun
                            </option>

                            @foreach (range(now()->year, now()->year - 3) as $y)

                                <option
                                    value="{{ $y }}"
                                    @selected((string) request('tahun') === (string) $y)
                                >
                                    {{ $y }}
                                </option>

                            @endforeach

                        </select>

                    </div>

                </div>

            </div>


            {{-- BUTTON --}}
            <div class="
                flex
                flex-col
                sm:flex-row
                sm:items-center
                sm:justify-between
                gap-3
                pt-2
                border-t
                border-gray-100
            ">

                <a
                    href="{{ route('laporan.index') }}"
                    class="btn-secondary text-center"
                >
                    ↺ Reset Filter
                </a>

                <button
                    type="submit"
                    name="tampilkan"
                    value="1"
                    class="btn-primary"
                >
                    📊 Tampilkan Laporan
                </button>

            </div>

        </form>

    </div>


    {{-- HASIL LAPORAN --}}
    @if ($sudahFilter)

        <div class="card overflow-hidden">

            {{-- HEADER HASIL --}}
            <div class="
                flex
                flex-col
                lg:flex-row
                lg:items-center
                lg:justify-between
                gap-4
                p-5
                border-b
                border-gray-100
            ">

                <div>

                    <h3 class="font-semibold text-gray-900">
                        Hasil Laporan
                    </h3>

                    <p class="mt-1 text-sm text-gray-500">
                        {{ $jenisList[$jenis] }}
                    </p>

                </div>


                {{-- TOTAL DATA --}}
                <div class="
                    inline-flex
                    items-center
                    gap-2
                    self-start
                    rounded-lg
                    bg-gray-50
                    px-3
                    py-2
                ">

                    <span class="text-xs text-gray-500">
                        Total Data
                    </span>

                    <span class="font-semibold text-gray-800">
                        {{ $rows->count() }}
                    </span>

                </div>

            </div>


            {{-- FILTER YANG AKTIF --}}
            <div class="px-5 pt-4">

                <div class="flex flex-wrap gap-2 text-xs">

                    @if ($isAdminGudang && $gudangUser)

                        <span class="rounded-full bg-bulog-cream px-3 py-1 text-bulog-800">
                            Gudang: {{ $gudangUser->nama_gudang }}
                        </span>

                    @elseif (request('gudang_id'))

                        @php
                            $gudangAktif = $gudangs->firstWhere('id', request('gudang_id'));
                        @endphp

                        @if ($gudangAktif)

                            <span class="rounded-full bg-gray-100 px-3 py-1 text-gray-600">
                                Gudang: {{ $gudangAktif->nama_gudang }}
                            </span>

                        @endif

                    @else

                        <span class="rounded-full bg-gray-100 px-3 py-1 text-gray-600">
                            Gudang: Semua
                        </span>

                    @endif


                    @if (request('mitra_pengolahan_id'))

                        @php
                            $mitraAktif = $mitras->firstWhere('id', request('mitra_pengolahan_id'));
                        @endphp

                        @if ($mitraAktif)

                            <span class="rounded-full bg-gray-100 px-3 py-1 text-gray-600">
                                Mitra: {{ $mitraAktif->nama_mitra }}
                            </span>

                        @endif

                    @else

                        <span class="rounded-full bg-gray-100 px-3 py-1 text-gray-600">
                            Mitra: Semua
                        </span>

                    @endif


                    @if (request('bulan'))

                        <span class="rounded-full bg-gray-100 px-3 py-1 text-gray-600">
                            Bulan:
                            {{ \Carbon\Carbon::create()->month((int) request('bulan'))->translatedFormat('F') }}
                        </span>

                    @else

                        <span class="rounded-full bg-gray-100 px-3 py-1 text-gray-600">
                            Bulan: Semua
                        </span>

                    @endif


                    @if (request('tahun'))

                        <span class="rounded-full bg-gray-100 px-3 py-1 text-gray-600">
                            Tahun: {{ request('tahun') }}
                        </span>

                    @else

                        <span class="rounded-full bg-gray-100 px-3 py-1 text-gray-600">
                            Tahun: Semua
                        </span>

                    @endif

                </div>

            </div>


            {{-- ACTION --}}
            <div class="
                flex
                flex-wrap
                gap-2
                px-5
                pt-4
            ">

                <a
                    href="{{ route('laporan.export-excel', request()->query()) }}"
                    class="btn-secondary"
                >
                    ⬇️ Export Excel
                </a>

                <a
                    href="{{ route('laporan.export-pdf', request()->query()) }}"
                    target="_blank"
                    class="btn-secondary"
                >
                    📄 Export PDF
                </a>

                <button
                    type="button"
                    onclick="window.print()"
                    class="btn-primary"
                >
                    🖨️ Print
                </button>

            </div>


            {{-- TABLE --}}
            <div class="overflow-x-auto mt-4">

                <table class="w-full text-sm">

                    <thead>

                        <tr class="
                            border-y
                            border-gray-100
                            bg-gray-50
                            text-left
                            text-gray-500
                        ">

                            @foreach ($headings as $h)

                                <th class="
                                    px-5
                                    py-3
                                    font-medium
                                    whitespace-nowrap
                                ">
                                    {{ $h }}
                                </th>

                            @endforeach

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-gray-50">

                        @forelse ($rows as $row)

                            <tr class="hover:bg-gray-50">

                                @foreach ($row as $cell)

                                    <td class="
                                        px-5
                                        py-3
                                        text-gray-700
                                        whitespace-nowrap
                                    ">
                                        {{ $cell }}
                                    </td>

                                @endforeach

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="{{ count($headings) }}"
                                    class="px-5 py-16 text-center text-gray-500"
                                >

                                    <div class="text-3xl mb-2">
                                        📄
                                    </div>

                                    <p class="font-medium text-gray-600">
                                        Tidak ada data
                                    </p>

                                    <p class="mt-1 text-sm text-gray-400">
                                        Tidak ditemukan data untuk filter yang dipilih.
                                    </p>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            <div class="h-5"></div>

        </div>

    @endif


    {{-- PANDUAN --}}
    @unless ($sudahFilter)

        <div class="card p-5">

            <h3 class="font-semibold text-gray-900">
                Panduan Singkat
            </h3>

            <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4">

                <div class="rounded-xl bg-gray-50 p-4">

                    <div class="text-xl">
                        1️⃣
                    </div>

                    <p class="mt-2 text-sm font-semibold text-gray-700">
                        Pilih jenis laporan
                    </p>

                    <p class="mt-1 text-xs leading-5 text-gray-500">
                        Pilih laporan BA Rampung, per Mitra,
                        per Gudang, atau Catatan.
                    </p>

                </div>


                <div class="rounded-xl bg-gray-50 p-4">

                    <div class="text-xl">
                        2️⃣
                    </div>

                    <p class="mt-2 text-sm font-semibold text-gray-700">
                        Tentukan filter
                    </p>

                    <p class="mt-1 text-xs leading-5 text-gray-500">
                        Gunakan filter gudang, mitra, bulan,
                        dan tahun sesuai kebutuhan.
                    </p>

                </div>


                <div class="rounded-xl bg-gray-50 p-4">

                    <div class="text-xl">
                        3️⃣
                    </div>

                    <p class="mt-2 text-sm font-semibold text-gray-700">
                        Tampilkan atau export
                    </p>

                    <p class="mt-1 text-xs leading-5 text-gray-500">
                        Lihat hasil langsung atau export
                        menjadi Excel dan PDF.
                    </p>

                </div>

            </div>

        </div>

    @endunless

</div>


{{-- PRINT --}}
<style>
    @media print {

        body {
            background: white !important;
        }

        nav,
        aside,
        header,
        .no-print {
            display: none !important;
        }

        .card {
            box-shadow: none !important;
            border: 1px solid #ddd !important;
        }

        button,
        a {
            display: none !important;
        }

    }
</style>

@endsection