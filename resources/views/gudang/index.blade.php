@extends('layouts.app')

@section('title', 'Gudang')

@section('content')

<div class="space-y-4">

    {{-- HEADER --}}
    <div class="flex items-center justify-between">

        <div>
            <h2 class="text-lg font-semibold text-gray-900">
                Gudang
            </h2>

            <p class="text-sm text-gray-500">
                Daftar gudang BULOG
            </p>
        </div>

        {{-- ADMIN KANTOR BISA TAMBAH GUDANG --}}
        @role('admin_kantor')
            <a
                href="{{ route('gudang.create') }}"
                class="btn-primary"
            >
                ➕ Tambah Gudang
            </a>
        @endrole

    </div>


    {{-- DAFTAR GUDANG --}}
    <div class="card">

        <div class="p-6 border-b border-gray-100">

            <div class="flex flex-col gap-4">

                <div>
                    <h3 class="font-semibold text-gray-900">
                        Daftar Gudang
                    </h3>

                    <p class="text-sm text-gray-500 mt-1">
                        Gudang utama dan gudang filial.
                    </p>
                </div>


                {{-- FILTER & SEARCH --}}
                <form
                    method="GET"
                    action="{{ route('gudang.index') }}"
                    class="flex flex-wrap items-center gap-2"
                >

                    {{-- FILTER GUDANG UTAMA --}}
                    <select
                        name="gudang_utama_id"
                        class="border border-gray-200 rounded-lg px-3 py-2 text-sm
                               focus:outline-none focus:ring-2 focus:ring-bulog-500
                               w-56"
                    >

                        <option value="">
                            Semua Gudang Utama
                        </option>

                        @foreach($gudangsUtama as $gudangUtama)

                            <option
                                value="{{ $gudangUtama->id }}"
                                @selected(
                                    request('gudang_utama_id') == $gudangUtama->id
                                )
                            >
                                {{ $gudangUtama->nama_gudang }}
                            </option>

                        @endforeach

                    </select>


                    {{-- SEARCH --}}
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari nama gudang atau kode gudang..."
                        class="border border-gray-200 rounded-lg px-3 py-2 text-sm
                               focus:outline-none focus:ring-2 focus:ring-bulog-500
                               w-72"
                    >


                    {{-- CARI --}}
                    <button
                        type="submit"
                        class="btn-secondary"
                    >
                        🔍 Cari
                    </button>


                    {{-- RESET --}}
                    @if(request('gudang_utama_id') || request('search'))

                        <a
                            href="{{ route('gudang.index') }}"
                            class="btn-secondary"
                        >
                            Reset
                        </a>

                    @endif

                </form>

            </div>

        </div>


        {{-- TABLE --}}
        <div class="overflow-x-auto">

            <table class="w-full text-sm">

                <thead>

                    <tr class="border-b border-gray-100 text-left text-gray-500">

                        <th class="px-6 py-3 font-medium">
                            No.
                        </th>

                        <th class="px-6 py-3 font-medium">
                            Kode
                        </th>

                        <th class="px-6 py-3 font-medium">
                            Nama Gudang
                        </th>

                        <th class="px-6 py-3 font-medium">
                            Gudang Induk
                        </th>

                        <th class="px-6 py-3 font-medium">
                            Kecamatan
                        </th>

                        <th class="px-6 py-3 font-medium">
                            Desa
                        </th>

                        <th class="px-6 py-3 font-medium">
                            Kapasitas
                        </th>

                        <th class="px-6 py-3 font-medium">
                            Status
                        </th>

                        <th class="px-6 py-3 font-medium text-right">
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-gray-50">

                    @forelse($gudangs as $i => $gudang)

                        {{-- ========================= --}}
                        {{-- GUDANG UTAMA --}}
                        {{-- ========================= --}}

                        @if(is_null($gudang->gudang_induk_id))

                            <tr class="bg-gray-100 border-t-2 border-gray-200">

                                <td
                                    colspan="9"
                                    class="px-6 py-4"
                                >

                                    <div class="flex items-center gap-3">

                                        <span class="text-lg">
                                            🏭
                                        </span>

                                        <div>

                                            <p class="font-bold text-gray-900">
                                                {{ $gudang->nama_gudang }}
                                            </p>

                                            <p class="text-xs text-gray-500">
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

                            <tr class="hover:bg-gray-50">

                                {{-- NOMOR --}}
                                <td class="px-6 py-4 text-gray-500">
                                    {{ $i + 1 }}
                                </td>


                                {{-- KODE --}}
                                <td class="px-6 py-4">

                                    <span class="font-medium text-gray-900">
                                        {{ $gudang->kode_gudang }}
                                    </span>

                                </td>


                                {{-- NAMA GUDANG --}}
                                <td class="px-6 py-4">

                                    <div class="pl-4">

                                        <p class="font-medium text-gray-900">
                                            ↳ {{ $gudang->nama_gudang }}
                                        </p>

                                        @if($gudang->alamat)

                                            <p class="text-xs text-gray-500 mt-1">
                                                {{ $gudang->alamat }}
                                            </p>

                                        @endif

                                    </div>

                                </td>


                                {{-- GUDANG INDUK --}}
                                <td class="px-6 py-4">

                                    <span class="text-xs text-gray-600">
                                        {{ $gudang->gudangInduk->nama_gudang ?? '-' }}
                                    </span>

                                </td>


                                {{-- KECAMATAN --}}
                                <td class="px-6 py-4 text-gray-600">
                                    {{ $gudang->kecamatan ?? '-' }}
                                </td>


                                {{-- DESA --}}
                                <td class="px-6 py-4 text-gray-600">
                                    {{ $gudang->desa ?? '-' }}
                                </td>


                                {{-- KAPASITAS --}}
                                <td class="px-6 py-4 text-gray-600">

                                    @if($gudang->kapasitas !== null)

                                        {{ number_format(
                                            $gudang->kapasitas,
                                            2,
                                            ',',
                                            '.'
                                        ) }}
                                        Ton

                                    @else

                                        -

                                    @endif

                                </td>


                                {{-- STATUS --}}
                                <td class="px-6 py-4">

                                    <x-status-badge
                                        :color="$gudang->status === 'aktif'
                                            ? 'green'
                                            : 'gray'"
                                        :label="ucfirst($gudang->status)"
                                    />

                                </td>


                                {{-- AKSI --}}
                                <td class="px-6 py-4">

                                    <div class="flex justify-end items-center gap-3 text-xs">

                                        {{-- LIHAT --}}
                                        <a
                                            href="{{ route(
                                                'gudang.show',
                                                $gudang
                                            ) }}"
                                            class="text-bulog-700 hover:underline"
                                        >
                                            Lihat
                                        </a>


                                        {{-- ADMIN KANTOR --}}
                                        @role('admin_kantor')

                                            <a
                                                href="{{ route(
                                                    'gudang.edit',
                                                    $gudang
                                                ) }}"
                                                class="text-bulog-700 hover:underline"
                                            >
                                                Edit
                                            </a>


                                            {{-- UBAH STATUS --}}
                                            <form
                                                method="POST"
                                                action="{{ route(
                                                    'gudang.toggle-status',
                                                    $gudang
                                                ) }}"
                                                class="inline"
                                            >

                                                @csrf

                                                @method('PATCH')

                                                <button
                                                    type="submit"
                                                    class="text-bulog-700 hover:underline"
                                                    onclick="return confirm(
                                                        'Apakah Anda yakin ingin mengubah status gudang ini?'
                                                    )"
                                                >
                                                    {{ $gudang->status === 'aktif'
                                                        ? 'Nonaktifkan'
                                                        : 'Aktifkan' }}
                                                </button>

                                            </form>

                                        @endrole

                                    </div>

                                </td>

                            </tr>

                        @endif

                    @empty

                        <tr>

                            <td
                                colspan="9"
                                class="px-6 py-16 text-center text-gray-500"
                            >

                                <div class="text-3xl mb-2">
                                    🏭
                                </div>

                                <p>
                                    Belum ada data gudang.
                                </p>


                                {{-- ADMIN KANTOR BISA TAMBAH --}}
                                @role('admin_kantor')

                                    <a
                                        href="{{ route('gudang.create') }}"
                                        class="inline-block mt-3 text-sm text-bulog-700 hover:underline"
                                    >
                                        ➕ Tambah Gudang
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