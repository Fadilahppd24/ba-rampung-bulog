@extends('layouts.app')

@section('title', 'Pimpinan Cabang')

@section('content')

<div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

    {{-- INFORMASI PIMPINAN AKTIF --}}
    <div class="card p-6 lg:col-span-1">

        <div class="flex items-center justify-between mb-4">
            <h3 class="font-semibold text-gray-900">
                Informasi Pimpinan Cabang
            </h3>

            {{-- ADMIN KANTOR --}}
            @if(auth()->check() && auth()->user()->role === 'admin_kantor')
                <a
                    href="{{ route('pimpinan.create') }}"
                    class="text-xs text-bulog-700 hover:underline"
                >
                    ➕ Tambah Riwayat
                </a>
            @endif
        </div>

        @if ($pimpinanAktif)

            <div class="flex items-center gap-4 mb-4">

                <div class="h-16 w-16 rounded-full bg-bulog-cream flex items-center justify-center text-2xl font-bold text-bulog-900">
                    {{ strtoupper(substr($pimpinanAktif->nama, 0, 1)) }}
                </div>

                <div>
                    <p class="font-semibold text-gray-900">
                        {{ $pimpinanAktif->nama }}
                    </p>

                    <p class="text-xs text-gray-500">
                        {{ $pimpinanAktif->jabatan }}
                    </p>
                </div>

            </div>

            <dl class="space-y-2.5 text-sm">

                <div>
                    <dt class="text-gray-500">Email</dt>
                    <dd class="font-medium">
                        {{ $pimpinanAktif->email ?? '-' }}
                    </dd>
                </div>

                <div>
                    <dt class="text-gray-500">Telepon</dt>
                    <dd class="font-medium">
                        {{ $pimpinanAktif->nomor_telepon ?? '-' }}
                    </dd>
                </div>

                <div>
                    <dt class="text-gray-500">Alamat Kantor</dt>
                    <dd class="font-medium">
                        {{ $pimpinanAktif->alamat ?? '-' }}
                    </dd>
                </div>

                <div>
                    <dt class="text-gray-500">Menjabat sejak</dt>
                    <dd class="font-medium">
                        {{ $pimpinanAktif->periode_mulai?->format('d/m/Y') ?? '-' }}
                    </dd>
                </div>

            </dl>

            {{-- EDIT PROFIL ADMIN KANTOR --}}
            @if(auth()->check() && auth()->user()->role === 'admin_kantor')
                <a
                    href="{{ route('pimpinan.edit', $pimpinanAktif) }}"
                    class="btn-secondary w-full justify-center mt-5"
                >
                    ✏️ Edit Profil
                </a>
            @endif

        @else

            <p class="text-sm text-gray-500 py-6 text-center">
                Belum ada Pimpinan Cabang aktif.
            </p>

        @endif

    </div>


    {{-- RIWAYAT PIMPINAN --}}
    <div class="card p-6 lg:col-span-2">

        <div class="flex items-center justify-between mb-4">

            <h3 class="font-semibold text-gray-900">
                Riwayat Pimpinan Cabang
            </h3>

            {{-- ADMIN KANTOR BISA TAMBAH --}}
            @if(auth()->check() && auth()->user()->role === 'admin_kantor')
                <a
                    href="{{ route('pimpinan.create') }}"
                    class="btn-primary"
                >
                    ➕ Tambah Pimpinan
                </a>
            @endif

        </div>

        <div class="overflow-x-auto">

            <table class="w-full text-sm">

                <thead>
                    <tr class="border-y border-gray-100 text-left text-gray-500">

                        <th class="px-4 py-3 font-medium">
                            No.
                        </th>

                        <th class="px-4 py-3 font-medium">
                            Nama
                        </th>

                        <th class="px-4 py-3 font-medium">
                            Periode
                        </th>

                        <th class="px-4 py-3 font-medium">
                            Status
                        </th>

                        <th class="px-4 py-3 font-medium text-right">
                            Aksi
                        </th>

                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-50">

                    @forelse ($riwayat as $i => $p)

                        <tr class="hover:bg-gray-50">

                            <td class="px-4 py-3 text-gray-500">
                                {{ $riwayat->firstItem() + $i }}
                            </td>

                            <td class="px-4 py-3 font-medium text-gray-900">
                                {{ $p->nama }}
                            </td>

                            <td class="px-4 py-3 text-gray-600">

                                {{ $p->periode_mulai?->format('Y') ?? '-' }}

                                –

                                {{ $p->periode_selesai?->format('Y') ?? 'Sekarang' }}

                            </td>

                            <td class="px-4 py-3">

                                <x-status-badge
                                    :color="$p->status === 'aktif' ? 'green' : 'gray'"
                                    :label="ucfirst($p->status)"
                                />

                            </td>

                            <td class="px-4 py-3">

                                <div class="flex justify-end gap-3 text-xs">

                                    {{-- SEMUA ROLE BISA LIHAT --}}
                                    <a
                                        href="{{ route('pimpinan.show', $p) }}"
                                        class="text-bulog-700 hover:underline"
                                    >
                                        Lihat
                                    </a>

                                    {{-- ADMIN KANTOR BISA EDIT --}}
                                    @if(auth()->check() && auth()->user()->role === 'admin_kantor')
                                        <a
                                            href="{{ route('pimpinan.edit', $p) }}"
                                            class="text-bulog-700 hover:underline"
                                        >
                                            Edit
                                        </a>
                                    @endif

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="5"
                                class="px-4 py-16 text-center text-gray-500"
                            >

                                <p class="text-3xl mb-2">
                                    👔
                                </p>

                                Belum ada riwayat Pimpinan Cabang.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        @if ($riwayat->hasPages())
            <div class="pt-4">
                {{ $riwayat->links() }}
            </div>
        @endif

    </div>

</div>

@endsection