@extends('layouts.app')

@section('title', 'Pegawai')

@section('content')

<div class="space-y-5">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h1 class="text-xl font-semibold text-gray-900">Pegawai</h1>
            <p class="text-sm text-gray-500">Daftar pegawai BULOG</p>
        </div>

        @if(in_array(auth()->user()->role, ['admin_gudang', 'admin_kantor'], true))
            <a href="{{ route('pegawai.create') }}" class="btn-primary">
                ➕ Tambah Pegawai
            </a>
        @endif
    </div>

    {{-- Filter & Pencarian --}}
    <div class="card p-5">
        <form
            method="GET"
            action="{{ route('pegawai.index') }}"
            class="flex flex-col sm:flex-row gap-3 sm:items-center sm:justify-between"
        >
            <div class="flex flex-col sm:flex-row gap-3 flex-1">

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari nama pegawai atau NIP..."
                    class="input sm:max-w-sm"
                >

                <select
                    name="jabatan"
                    class="input sm:max-w-xs"
                    onchange="this.form.submit()"
                >
                    <option value="">Pilih Jabatan</option>

                    @foreach ($jabatanOptions as $j)
                        <option
                            value="{{ $j }}"
                            @selected(request('jabatan') === $j)
                        >
                            {{ $j }}
                        </option>
                    @endforeach
                </select>

            </div>

            <div class="flex gap-2">

                <button type="submit" class="btn-secondary">
                    Cari
                </button>

                @if(request('search') || request('jabatan'))
                    <a
                        href="{{ route('pegawai.index') }}"
                        class="btn-secondary"
                    >
                        Reset
                    </a>
                @endif

            </div>
        </form>
    </div>

    {{-- Tabel Pegawai --}}
    <div class="card overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full text-sm">

                <thead>
                    <tr class="border-y border-gray-100 text-left text-gray-500">

                        <th class="px-5 py-3 font-medium">
                            No.
                        </th>

                        <th class="px-5 py-3 font-medium">
                            NIP
                        </th>

                        <th class="px-5 py-3 font-medium">
                            Nama
                        </th>

                        <th class="px-5 py-3 font-medium">
                            Jabatan
                        </th>

                        <th class="px-5 py-3 font-medium">
                            Gudang
                        </th>

                        <th class="px-5 py-3 font-medium">
                            Kontak
                        </th>

                        <th class="px-5 py-3 font-medium">
                            Status
                        </th>

                        <th class="px-5 py-3 font-medium text-right">
                            Aksi
                        </th>

                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-50">

                    @forelse ($pegawais as $i => $p)

                        <tr class="hover:bg-gray-50">

                            {{-- No --}}
                            <td class="px-5 py-3 text-gray-500">
                                {{ $pegawais->firstItem() + $i }}
                            </td>

                            {{-- NIP --}}
                            <td class="px-5 py-3 font-medium text-gray-900">
                                {{ $p->nip }}
                            </td>

                            {{-- Nama --}}
                            <td class="px-5 py-3 text-gray-700">
                                {{ $p->nama }}
                            </td>

                            {{-- Jabatan --}}
                            <td class="px-5 py-3 text-gray-600">
                                {{ $p->jabatan ?? '-' }}
                            </td>

                            {{-- Gudang --}}
                            <td class="px-5 py-3 text-gray-600">
                                {{ $p->gudang->nama_gudang ?? '-' }}
                            </td>

                            {{-- Kontak --}}
                            <td class="px-5 py-3 text-gray-600">
                                {{ $p->nomor_telepon ?? '-' }}
                            </td>

                            {{-- Status --}}
                            <td class="px-5 py-3">

                                <x-status-badge
                                    :color="$p->status === 'aktif' ? 'green' : 'gray'"
                                    :label="ucfirst($p->status)"
                                />

                            </td>

                            {{-- Aksi --}}
                            <td class="px-5 py-3">

                                <div class="flex justify-end gap-3 text-xs">

                                    {{-- Detail --}}
                                    <a
                                        href="{{ route('pegawai.show', $p) }}"
                                        class="text-bulog-700 hover:underline"
                                    >
                                        Detail
                                    </a>

                                    {{-- Admin Gudang / Admin Kantor --}}
                                    @if(in_array(auth()->user()->role, ['admin_gudang', 'admin_kantor'], true))

                                        {{-- Edit --}}
                                        <a
                                            href="{{ route('pegawai.edit', $p) }}"
                                            class="text-bulog-700 hover:underline"
                                        >
                                            Edit
                                        </a>

                                        {{-- Toggle Status --}}
                                        <form
                                            method="POST"
                                            action="{{ route('pegawai.toggle-status', $p) }}"
                                            onsubmit="return confirm('{{ $p->status === 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }} pegawai {{ $p->nama }}?');"
                                        >

                                            @csrf
                                            @method('PATCH')

                                            <button
                                                type="submit"
                                                class="text-gray-500 hover:underline"
                                            >
                                                {{ $p->status === 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }}
                                            </button>

                                        </form>

                                    @endif

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="8"
                                class="px-5 py-16 text-center text-gray-500"
                            >

                                <p class="text-3xl mb-2">👤</p>

                                <p>Belum ada data Pegawai.</p>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        {{-- Pagination --}}
        @if ($pegawais->hasPages())

            <div class="p-5">
                {{ $pegawais->links() }}
            </div>

        @endif

    </div>

</div>

@endsection