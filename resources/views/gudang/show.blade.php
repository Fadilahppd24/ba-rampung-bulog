@extends('layouts.app')

@section('title', 'Detail Gudang')

@section('content')

<div class="space-y-6">

    {{-- =========================================================
         HERO / HEADER HALAMAN
    ========================================================== --}}
    <div class="flex flex-col gap-4 pt-2 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="dashboard-kicker text-white/75">
                Master Data
            </p>

            <h1 class="dashboard-display mt-2 text-4xl leading-tight text-white sm:text-5xl">
                {{ $gudang->nama_gudang }}
            </h1>

            <p class="mt-2 text-sm text-white/85" style="text-shadow: 0 1px 8px rgba(3, 28, 55, .2);">
                {{ $gudang->kode_gudang }}
            </p>
        </div>

        <div class="flex items-center gap-3">
            <x-status-badge
                :color="$gudang->status === 'aktif' ? 'green' : 'gray'"
                :label="ucfirst($gudang->status)"
                class="text-sm px-3 py-1.5"
            />

            @role('admin_gudang', 'admin_sistem')
                <a
                    href="{{ route('gudang.edit', $gudang) }}"
                    class="inline-flex items-center justify-center gap-2 rounded-full bg-white px-5 py-3 text-sm font-bold text-[#123F7A] shadow-lg transition hover:-translate-y-0.5 hover:bg-slate-50"
                >
                    ✏️ Edit
                </a>
            @endrole
        </div>
    </div>


    {{-- =========================================================
         INFORMASI GUDANG + PEGAWAI
    ========================================================== --}}
    <div class="grid grid-cols-1 gap-4 lg:grid-cols-3">

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm lg:col-span-1">
            <div class="mb-4 flex items-center gap-3">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-lg">
                    🏭
                </div>
                <h3 class="font-bold text-gray-900">
                    Informasi Gudang
                </h3>
            </div>

            <dl class="space-y-3 text-sm">
                <div>
                    <dt class="text-slate-500">Alamat</dt>
                    <dd class="font-medium text-gray-900">{{ $gudang->alamat ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-slate-500">Kecamatan / Desa</dt>
                    <dd class="font-medium text-gray-900">{{ $gudang->kecamatan ?? '-' }} / {{ $gudang->desa ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-slate-500">Telepon</dt>
                    <dd class="font-medium text-gray-900">{{ $gudang->nomor_telepon ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-slate-500">Email</dt>
                    <dd class="font-medium text-gray-900">{{ $gudang->email ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-slate-500">Kapasitas</dt>
                    <dd class="font-medium text-gray-900">{{ $gudang->kapasitas ? number_format($gudang->kapasitas, 2) . ' Ton' : '-' }}</dd>
                </div>
                <div>
                    <dt class="text-slate-500">Total BA Rampung</dt>
                    <dd class="font-medium text-gray-900">{{ $gudang->ba_rampungs_count }}</dd>
                </div>
            </dl>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm lg:col-span-2">
            <div class="mb-4 flex items-center gap-3">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-lg">
                    👤
                </div>
                <h3 class="font-bold text-gray-900">
                    Pegawai di Gudang Ini
                </h3>
            </div>

            @if ($gudang->pegawais->isEmpty())
                <p class="text-sm text-slate-500">
                    Belum ada pegawai terdaftar di gudang ini.
                </p>
            @else
                <div class="divide-y divide-slate-100">
                    @foreach ($gudang->pegawais as $p)
                        <div class="flex items-center justify-between py-3 text-sm">
                            <div>
                                <p class="font-medium text-gray-900">{{ $p->nama }}</p>
                                <p class="text-xs text-slate-500">{{ $p->jabatan }} · {{ $p->nip }}</p>
                            </div>
                            <span class="text-slate-500">{{ $p->nomor_telepon ?? '-' }}</span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>


    {{-- =========================================================
         BA RAMPUNG TERBARU
    ========================================================== --}}
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="mb-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-lg">
                    🧾
                </div>
                <h3 class="font-bold text-gray-900">
                    BA Rampung Terbaru dari Gudang Ini
                </h3>
            </div>

            <a
                href="{{ route('ba-rampung.index', ['gudang_id' => $gudang->id]) }}"
                class="text-sm font-semibold text-[#123F7A] hover:underline"
            >
                Lihat Semua →
            </a>
        </div>

        @if ($baTerbaru->isEmpty())
            <p class="py-6 text-center text-sm text-slate-500">
                Belum ada data BA Rampung.
            </p>
        @else
            <div class="divide-y divide-slate-100">
                @foreach ($baTerbaru as $ba)
                    <a
                        href="{{ route('ba-rampung.show', $ba) }}"
                        class="-mx-2 flex items-center justify-between rounded-lg px-2 py-3 transition hover:bg-slate-50"
                    >
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ $ba->nomor_ba }}</p>
                            <p class="text-xs text-slate-500">{{ $ba->mitraPengolahan->nama_mitra }}</p>
                        </div>
                        <x-status-badge :color="$ba->statusBadgeColor()" :label="$ba->statusLabel()" />
                    </a>
                @endforeach
            </div>
        @endif
    </div>

</div>

@endsection
