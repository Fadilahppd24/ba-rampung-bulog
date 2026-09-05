@extends('layouts.app')

@section('title', 'Mitra Pengolahan')

@section('content')

<div class="space-y-5">

    {{-- Judul --}}
    <div>
        <h1 class="text-xl font-semibold text-gray-900">
            Mitra Pengolahan
        </h1>

        <p class="text-sm text-gray-500">
            Daftar mitra pengolahan BULOG
        </p>
    </div>

    {{-- Pencarian dan Filter --}}
    <div class="card p-5">

        <form
            method="GET"
            action="{{ route('mitra.index') }}"
            class="flex flex-col sm:flex-row gap-3 sm:items-center sm:justify-between"
        >

            <div class="flex flex-col sm:flex-row gap-3 flex-1">

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari nama mitra atau kode mitra..."
                    class="input sm:max-w-sm"
                >

                <select
                    name="jenis_usaha"
                    class="input sm:max-w-xs"
                    onchange="this.form.submit()"
                >
                    <option value="">Pilih Jenis Usaha</option>

                    @foreach ($jenisUsahaOptions as $j)
                        <option
                            value="{{ $j }}"
                            @selected(request('jenis_usaha') === $j)
                        >
                            {{ $j }}
                        </option>
                    @endforeach
                </select>

            </div>

            <div class="flex gap-2">

                <button
                    type="submit"
                    class="btn-secondary"
                >
                    Cari
                </button>

                @role('admin_kantor', 'admin_gudang', 'admin_sistem')
                    <a
                        href="{{ route('mitra.create') }}"
                        class="btn-primary"
                    >
                        ➕ Tambah Mitra
                    </a>
                @endrole

            </div>

        </form>

    </div>

    {{-- Tabel Mitra --}}
    <div class="card overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full text-sm">

                <thead>
                    <tr class="border-y border-gray-100 text-left text-gray-500">

                        <th class="px-5 py-3 font-medium">
                            No.
                        </th>

                        <th class="px-5 py-3 font-medium">
                            Kode Mitra
                        </th>

                        <th class="px-5 py-3 font-medium">
                            Nama Mitra
                        </th>

                        <th class="px-5 py-3 font-medium">
                            Jenis Usaha
                        </th>

                        <th class="px-5 py-3 font-medium">
                            Alamat
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

                    @forelse ($mitras as $i => $m)

                        <tr class="hover:bg-gray-50">

                            {{-- No --}}
                            <td class="px-5 py-3 text-gray-500">
                                {{ $mitras->firstItem() + $i }}
                            </td>

                            {{-- Kode --}}
                            <td class="px-5 py-3 font-medium text-gray-900">
                                {{ $m->kode_mitra }}
                            </td>

                            {{-- Nama --}}
                            <td class="px-5 py-3 text-gray-700">
                                {{ $m->nama_mitra }}
                            </td>

                            {{-- Jenis Usaha --}}
                            <td class="px-5 py-3 text-gray-600">
                                {{ $m->jenis_usaha ?? '-' }}
                            </td>

                            {{-- Alamat --}}
                            <td class="px-5 py-3 text-gray-600">
                                {{ $m->alamat ?? '-' }}
                            </td>

                            {{-- Kontak --}}
                            <td class="px-5 py-3 text-gray-600">
                                {{ $m->nomor_telepon ?? '-' }}
                            </td>

                            {{-- Status --}}
                            <td class="px-5 py-3">

                                <x-status-badge
                                    :color="$m->status === 'aktif' ? 'green' : 'gray'"
                                    :label="ucfirst($m->status)"
                                />

                            </td>

                            {{-- Aksi --}}
                            <td class="px-5 py-3">

                                <div class="flex justify-end gap-3 text-xs">

                                    {{-- Detail --}}
                                    <a
                                        href="{{ route('mitra.show', $m) }}"
                                        class="text-bulog-700 hover:underline"
                                    >
                                        Detail
                                    </a>

                                    {{-- Edit + Status --}}
                                    @role('admin_kantor', 'admin_gudang', 'admin_sistem')

                                        <a
                                            href="{{ route('mitra.edit', $m) }}"
                                            class="text-bulog-700 hover:underline"
                                        >
                                            Edit
                                        </a>

                                        <form
                                            method="POST"
                                            action="{{ route('mitra.toggle-status', $m) }}"
                                            onsubmit="return confirm('{{ $m->status === 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }} mitra {{ $m->nama_mitra }}?');"
                                        >
                                            @csrf
                                            @method('PATCH')

                                            <button
                                                type="submit"
                                                class="text-gray-500 hover:underline"
                                            >
                                                {{ $m->status === 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }}
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
                                class="px-5 py-16 text-center text-gray-500"
                            >
                                <p class="text-3xl mb-2">
                                    🤝
                                </p>

                                Belum ada data Mitra Pengolahan.
                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        {{-- Pagination --}}
        @if ($mitras->hasPages())

            <div class="p-5">
                {{ $mitras->links() }}
            </div>

        @endif

    </div>

</div>

@endsection