@extends('layouts.app')

@section('title', 'Daftar BA Rampung')

@section('content')

<div class="space-y-6">

    {{-- =========================================================
         FONT & STYLE HERO
         Sama persis dengan Dashboard (dashboard-kicker / dashboard-display)
         agar design system konsisten. Tidak mengubah logic apapun.
    ========================================================== --}}
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Manrope:wght@400;500;600;700&display=swap');

        .dashboard-display {
            font-family: 'Cormorant Garamond', Georgia, serif;
            font-weight: 400;
            letter-spacing: -0.025em;
            text-shadow: 0 2px 18px rgba(3, 28, 55, .16);
        }

        .dashboard-kicker {
            letter-spacing: .32em;
            text-transform: uppercase;
            font-size: 10px;
            font-weight: 700;
        }
    </style>

    {{-- =========================================================
         HEADER
    ========================================================== --}}
    <div class="flex flex-col gap-4 pt-2 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="dashboard-kicker text-white/75">
                Sistem BA Rampung
            </p>

            <h1 class="dashboard-display mt-2 text-4xl leading-tight text-white sm:text-5xl">
                Daftar <span class="text-[#F28C28]">BA Rampung</span>
            </h1>

            <p class="mt-2 text-sm text-white/85" style="text-shadow: 0 1px 8px rgba(3, 28, 55, .2);">
                Kelola, cari, dan pantau seluruh data BA Rampung.
            </p>
        </div>

        @can('create', \App\Models\BaRampung::class)
            <a
                href="{{ route('ba-rampung.create') }}"
                class="inline-flex items-center justify-center gap-2 rounded-full bg-[#123F7A] px-5 py-3 text-sm font-bold text-white shadow-lg transition hover:-translate-y-0.5 hover:bg-[#0d3263]"
            >
                <span class="text-lg leading-none">＋</span>
                Buat BA Rampung
            </a>
        @endcan
    </div>


    {{-- =========================================================
         KPI
    ========================================================== --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">
                        Total BA Rampung
                    </p>
                    <p class="mt-2 text-3xl font-bold text-[#123F7A]">
                        {{ number_format($kpi['total']) }}
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
                        Terverifikasi
                    </p>
                    <p class="mt-2 text-3xl font-bold text-emerald-600">
                        {{ number_format($kpi['terverifikasi']) }}
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
                        Belum Diserah
                    </p>
                    <p class="mt-2 text-3xl font-bold text-amber-600">
                        {{ number_format($kpi['belum_serah']) }}
                    </p>
                </div>
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-amber-50 text-xl">
                    ⏳
                </div>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">
                        Mitra Pengolahan
                    </p>
                    <p class="mt-2 text-3xl font-bold text-[#123F7A]">
                        {{ number_format($kpi['mitra']) }}
                    </p>
                </div>
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 text-xl">
                    🤝
                </div>
            </div>
        </div>

    </div>


    {{-- =========================================================
         FILTER
    ========================================================== --}}
    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

        <form method="GET" action="{{ route('ba-rampung.index') }}" class="space-y-5">

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
                            Gunakan filter berikut untuk menemukan BA Rampung dengan lebih cepat.
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <a
                        href="{{ route('ba-rampung.index') }}"
                        class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50"
                    >
                        ↺ Reset
                    </a>

                    <a
                        href="{{ route('ba-rampung.export', request()->query()) }}"
                        class="inline-flex items-center justify-center rounded-xl border border-[#123F7A] bg-white px-4 py-2.5 text-sm font-semibold text-[#123F7A] transition hover:bg-blue-50"
                    >
                        ⬇ Export
                    </a>

                    <button
                        type="submit"
                        class="inline-flex items-center justify-center rounded-xl bg-[#123F7A] px-4 py-2.5 text-sm font-bold text-white transition hover:bg-[#0d3263]"
                    >
                        Terapkan
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-3 md:grid-cols-2 lg:grid-cols-5">

                <div class="lg:col-span-2">
                    <label class="mb-1.5 block text-xs font-semibold text-slate-500">
                        Pencarian
                    </label>

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Nomor BA, Gudang, atau Mitra..."
                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm text-gray-700 outline-none transition placeholder:text-slate-400 focus:border-[#123F7A] focus:ring-2 focus:ring-blue-100"
                    >
                </div>

                <div>
                    <label class="mb-1.5 block text-xs font-semibold text-slate-500">
                        Status
                    </label>

                    <select
                        name="status"
                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm text-gray-700 outline-none focus:border-[#123F7A] focus:ring-2 focus:ring-blue-100"
                    >
                        <option value="">Semua Status</option>

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

                <div>
                    <label class="mb-1.5 block text-xs font-semibold text-slate-500">
                        Gudang
                    </label>

                    <select
                        name="gudang_id"
                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm text-gray-700 outline-none focus:border-[#123F7A] focus:ring-2 focus:ring-blue-100"
                    >
                        <option value="">Semua Gudang</option>

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

                <div>
                    <label class="mb-1.5 block text-xs font-semibold text-slate-500">
                        Mitra Pengolahan
                    </label>

                    <select
                        name="mitra_pengolahan_id"
                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm text-gray-700 outline-none focus:border-[#123F7A] focus:ring-2 focus:ring-blue-100"
                    >
                        <option value="">Semua Mitra</option>

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

            </div>


            <div class="grid grid-cols-1 gap-3 md:grid-cols-3">

                <div>
                    <label class="mb-1.5 block text-xs font-semibold text-slate-500">
                        Bulan
                    </label>

                    <select
                        name="bulan"
                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm text-gray-700 outline-none focus:border-[#123F7A] focus:ring-2 focus:ring-blue-100"
                    >
                        <option value="">Semua Bulan</option>

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

                <div>
                    <label class="mb-1.5 block text-xs font-semibold text-slate-500">
                        Tahun
                    </label>

                    <select
                        name="tahun"
                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm text-gray-700 outline-none focus:border-[#123F7A] focus:ring-2 focus:ring-blue-100"
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
                    📋
                </div>
                <div>
                    <h2 class="font-bold text-gray-900">
                        Data BA Rampung
                    </h2>
                    <p class="mt-1 text-xs text-gray-500">
                        Menampilkan {{ $baList->firstItem() ?? 0 }}–{{ $baList->lastItem() ?? 0 }}
                        dari {{ $baList->total() }} data
                    </p>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">

            <table class="w-full min-w-[900px] text-sm">

                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50 text-left text-xs uppercase tracking-wider text-slate-500">
                        <th class="px-5 py-3 font-semibold">No.</th>
                        <th class="px-5 py-3 font-semibold">Nomor BA</th>
                        <th class="px-5 py-3 font-semibold">Tanggal BA</th>
                        <th class="px-5 py-3 font-semibold">Gudang</th>
                        <th class="px-5 py-3 font-semibold">Mitra Pengolahan</th>
                        <th class="px-5 py-3 font-semibold">Status Verifikasi</th>
                        <th class="px-5 py-3 text-right font-semibold">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">

                    @forelse ($baList as $i => $ba)

                        <tr class="transition hover:bg-slate-50/80">

                            <td class="px-5 py-4 text-slate-400">
                                {{ $baList->firstItem() + $i }}
                            </td>

                            <td class="px-5 py-4 font-bold text-[#123F7A]">
                                {{ $ba->nomor_ba }}
                            </td>

                            <td class="px-5 py-4 text-slate-600">
                                {{ $ba->tanggal_ba->format('d/m/Y') }}
                            </td>

                            <td class="px-5 py-4 text-slate-600">
                                {{ $ba->gudang->nama_gudang }}
                            </td>

                            <td class="px-5 py-4 text-slate-600">
                                {{ $ba->mitraPengolahan->nama_mitra }}
                            </td>

                            <td class="px-5 py-4">
                                <x-status-badge
                                    :color="$ba->statusBadgeColor()"
                                    :label="$ba->statusLabel()"
                                />
                            </td>

                            <td class="px-5 py-4">
                                <div class="flex justify-end gap-3 text-xs font-semibold">

                                    <a
                                        href="{{ route('ba-rampung.show', $ba) }}"
                                        class="text-[#123F7A] transition hover:text-orange-500 hover:underline"
                                    >
                                        Lihat
                                    </a>

                                    @can('update', $ba)
                                        <a
                                            href="{{ route('ba-rampung.edit', $ba) }}"
                                            class="text-[#123F7A] transition hover:text-orange-500 hover:underline"
                                        >
                                            Edit
                                        </a>
                                    @endcan

                                    <a
                                        href="{{ route('ba-rampung.pdf', $ba) }}"
                                        target="_blank"
                                        class="text-[#123F7A] transition hover:text-orange-500 hover:underline"
                                    >
                                        PDF
                                    </a>

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
                                                class="text-red-600 transition hover:underline"
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
                            <td colspan="7" class="px-5 py-16 text-center text-slate-500">
                                <p class="mb-2 text-3xl">🗂️</p>
                                <p class="font-medium">
                                    Belum ada data BA Rampung.
                                </p>
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        @if ($baList->hasPages())
            <div class="border-t border-slate-100 p-5">
                {{ $baList->links() }}
            </div>
        @endif

    </div>

</div>

@endsection