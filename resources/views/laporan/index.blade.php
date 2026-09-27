@extends('layouts.app')

@section('title', 'Laporan')

@section('content')

<div class="space-y-6 pb-8">

    {{-- HERO --}}
    <section class="relative overflow-hidden rounded-[2rem] min-h-[250px] shadow-xl">
        <img src="{{ asset('images/dashboard-bulog.jpg') }}" alt="Gudang BULOG" class="absolute inset-0 h-full w-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-r from-[#082F63]/85 via-[#123F7A]/55 to-[#082F63]/15"></div>
        <div class="relative z-10 flex min-h-[250px] items-end px-7 py-8 sm:px-10 lg:px-12">
            <div>
                <div class="dashboard-kicker text-white/80 mb-3">Laporan</div>
                <h1 class="dashboard-display text-white text-5xl sm:text-6xl lg:text-[4.5rem] leading-[.9] font-normal">
                    Laporan <span class="orange-text">BA Rampung.</span>
                </h1>
                <p class="mt-4 max-w-2xl text-sm sm:text-base leading-7 text-white/80">
                    Pantau dan analisis data BA Rampung berdasarkan gudang, mitra, periode, dan jenis laporan.
                </p>
            </div>
        </div>
        <div class="absolute right-6 bottom-6 hidden lg:block rounded-2xl border border-white/20 bg-[#082F63]/65 px-5 py-4 text-white backdrop-blur-md">
            <p class="text-[10px] uppercase tracking-[.2em] text-white/60">Status Laporan</p>
            <p class="mt-1 text-sm font-semibold">{{ $sudahFilter ? 'Data sudah ditampilkan' : 'Siap digunakan' }}</p>
        </div>
    </section>

    {{-- INFO ROLE --}}
    <section class="rounded-[1.5rem] border border-white/70 bg-white/90 p-5 shadow-lg backdrop-blur-md">
        <div class="flex items-start gap-4">
            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-blue-50 text-xl">📊</div>
            <div>
                <p class="font-semibold text-[#0B2545]">
                    {{ $isAdminGudang ? 'Laporan Gudang' : 'Laporan Seluruh Gudang' }}
                </p>
                <p class="mt-1 text-sm leading-6 text-slate-500">
                    @if ($isAdminGudang)
                        Laporan hanya menampilkan data dari
                        <span class="font-semibold text-[#123F7A]">{{ $gudangUser?->nama_gudang ?? 'gudang Anda' }}</span>.
                    @else
                        Laporan dapat menampilkan data dari seluruh gudang sesuai hak akses Anda.
                    @endif
                </p>
            </div>
        </div>
    </section>

    {{-- PILIH JENIS + FILTER --}}
    <section class="overflow-hidden rounded-[1.5rem] border border-slate-200/80 bg-white/95 shadow-lg">
        <div class="border-b border-slate-100 px-6 py-5 sm:px-7">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-blue-50 text-lg">📄</div>
                <div>
                    <h2 class="text-lg font-bold text-[#0B2545]">Pilih Jenis Laporan</h2>
                    <p class="mt-0.5 text-sm text-slate-500">Tentukan data yang ingin kamu lihat.</p>
                </div>
            </div>
        </div>

        <form method="GET" action="{{ route('laporan.index') }}" class="p-6 sm:p-7">
            <div class="grid grid-cols-1 gap-3 md:grid-cols-2 xl:grid-cols-4">
                @foreach ($jenisList as $val => $label)
                    @if ($isAdminGudang && $val === 'per_gudang')
                        @continue
                    @endif
                    @php
                        $icon = match ($val) {
                            'ba_rampung' => '📄',
                            'per_mitra' => '🤝',
                            'per_gudang' => '🏭',
                            'catatan' => '📝',
                            default => '📊',
                        };
                        $desc = match ($val) {
                            'ba_rampung' => 'Rekap seluruh BA Rampung',
                            'per_mitra' => 'Rekap berdasarkan mitra',
                            'per_gudang' => 'Rekap berdasarkan gudang',
                            'catatan' => 'Daftar BA yang memiliki catatan',
                            default => 'Ringkasan data laporan',
                        };
                    @endphp
                    <label class="group cursor-pointer">
                        <input type="radio" name="jenis" value="{{ $val }}" class="peer sr-only" @checked($jenis === $val)>
                        <div class="h-full rounded-2xl border-2 border-slate-200 bg-white p-4 transition-all duration-200 hover:-translate-y-0.5 hover:border-slate-300 hover:shadow-md peer-checked:border-[#123F7A] peer-checked:bg-[#F5F8FD] peer-checked:shadow-md">
                            <div class="flex items-start gap-3">
                                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-xl">{{ $icon }}</div>
                                <div class="min-w-0">
                                    <p class="text-sm font-bold text-slate-800">{{ $label }}</p>
                                    <p class="mt-1 text-xs leading-5 text-slate-400">{{ $desc }}</p>
                                </div>
                            </div>
                        </div>
                    </label>
                @endforeach
            </div>

            <div class="mt-7 rounded-2xl bg-[#F7F9FC] p-5 ring-1 ring-slate-100">
                <div class="mb-4 flex items-center gap-3">
                    <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-white text-sm shadow-sm">⌕</div>
                    <div>
                        <h3 class="text-sm font-bold text-[#0B2545]">Filter Data</h3>
                        <p class="text-xs text-slate-400">Gunakan filter berikut untuk menampilkan data yang ingin dilihat.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
                    <div>
                        <label class="mb-1.5 block text-xs font-semibold text-slate-600">Gudang</label>
                        @if ($isAdminGudang)
                            <input type="text" class="input bg-slate-100" value="{{ $gudangUser?->nama_gudang ?? '-' }}" readonly>
                            <input type="hidden" name="gudang_id" value="{{ $gudangUser?->id }}">
                        @else
                            <select name="gudang_id" class="input">
                                <option value="">Semua Gudang</option>
                                @foreach ($gudangs as $g)
                                    <option value="{{ $g->id }}" @selected(request('gudang_id') == $g->id)>{{ $g->nama_gudang }}</option>
                                @endforeach
                            </select>
                        @endif
                    </div>
                    <div>
                        <label class="mb-1.5 block text-xs font-semibold text-slate-600">Mitra Pengolahan</label>
                        <select name="mitra_pengolahan_id" class="input">
                            <option value="">Semua Mitra</option>
                            @foreach ($mitras as $m)
                                <option value="{{ $m->id }}" @selected(request('mitra_pengolahan_id') == $m->id)>{{ $m->nama_mitra }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="mb-1.5 block text-xs font-semibold text-slate-600">Bulan</label>
                        <select name="bulan" class="input">
                            <option value="">Semua Bulan</option>
                            @foreach (range(1, 12) as $bln)
                                <option value="{{ $bln }}" @selected((string) request('bulan') === (string) $bln)>{{ \Carbon\Carbon::create()->month($bln)->translatedFormat('F') }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="mb-1.5 block text-xs font-semibold text-slate-600">Tahun</label>
                        <select name="tahun" class="input">
                            <option value="">Semua Tahun</option>
                            @foreach (range(now()->year, now()->year - 3) as $y)
                                <option value="{{ $y }}" @selected((string) request('tahun') === (string) $y)>{{ $y }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mt-5 flex flex-col gap-3 border-t border-slate-200 pt-4 sm:flex-row sm:items-center sm:justify-between">
                    <a href="{{ route('laporan.index') }}" class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">↺ Reset Filter</a>
                    <button type="submit" name="tampilkan" value="1" class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#123F7A] px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-blue-900/10 transition hover:bg-[#0B3264]">📊 Tampilkan Laporan</button>
                </div>
            </div>
        </form>
    </section>

    @if ($sudahFilter)
        {{-- RINGKASAN --}}
        <section class="space-y-4">
            <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <div class="dashboard-kicker text-[#6D7D92]">Ringkasan Laporan</div>
                    <h2 class="mt-1 text-2xl font-bold text-[#0B2545]">{{ $jenisList[$jenis] }}</h2>
                    <p class="mt-1 text-sm text-slate-500">Berikut adalah ringkasan data berdasarkan filter yang dipilih.</p>
                </div>
                <div class="text-xs text-slate-400">Diperbarui: {{ now()->translatedFormat('d F Y, H:i') }}</div>
            </div>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
                <div class="rounded-2xl border border-slate-200 bg-white/95 p-5 shadow-lg">
                    <div class="flex items-center justify-between"><span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Total Data</span><span class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50">📄</span></div>
                    <div class="mt-4 text-3xl font-bold text-[#123F7A]">{{ $rows->count() }}</div>
                    <p class="mt-1 text-xs text-slate-400">Data pada laporan aktif</p>
                </div>
                <div class="rounded-2xl border border-slate-200 bg-white/95 p-5 shadow-lg">
                    <div class="flex items-center justify-between"><span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Total Gudang</span><span class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50">🏭</span></div>
                    <div class="mt-4 text-3xl font-bold text-[#123F7A]">{{ $gudangs->count() }}</div>
                    <p class="mt-1 text-xs text-emerald-600">Data gudang tersedia</p>
                </div>
                <div class="rounded-2xl border border-slate-200 bg-white/95 p-5 shadow-lg">
                    <div class="flex items-center justify-between"><span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Total Mitra</span><span class="flex h-10 w-10 items-center justify-center rounded-xl bg-orange-50">🤝</span></div>
                    <div class="mt-4 text-3xl font-bold text-[#123F7A]">{{ $mitras->count() }}</div>
                    <p class="mt-1 text-xs text-orange-600">Data mitra tersedia</p>
                </div>
                <div class="rounded-2xl border border-slate-200 bg-white/95 p-5 shadow-lg">
                    <div class="flex items-center justify-between"><span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Periode</span><span class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-50">📅</span></div>
                    <div class="mt-4 text-2xl font-bold text-[#123F7A]">{{ request('tahun') ?: 'Semua' }}</div>
                    <p class="mt-1 text-xs text-slate-400">{{ request('bulan') ? \Carbon\Carbon::create()->month((int) request('bulan'))->translatedFormat('F') : 'Semua bulan' }}</p>
                </div>
            </div>
        </section>

        {{-- HASIL --}}
        <section class="overflow-hidden rounded-[1.5rem] border border-slate-200/80 bg-white/95 shadow-lg">
            <div class="flex flex-col gap-4 border-b border-slate-100 p-6 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h3 class="text-lg font-bold text-[#0B2545]">Hasil Laporan</h3>
                    <p class="mt-1 text-sm text-slate-500">Data sesuai filter yang dipilih.</p>
                </div>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('laporan.export-excel', request()->query()) }}" class="inline-flex items-center rounded-xl border border-slate-200 bg-white px-3.5 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-50">⬇️ Export Excel</a>
                    <a href="{{ route('laporan.export-pdf', request()->query()) }}" target="_blank" class="inline-flex items-center rounded-xl border border-slate-200 bg-white px-3.5 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-50">📄 Export PDF</a>
                    <button type="button" onclick="window.print()" class="inline-flex items-center rounded-xl bg-[#123F7A] px-3.5 py-2 text-xs font-semibold text-white hover:bg-[#0B3264]">🖨️ Print</button>
                </div>
            </div>

            <div class="flex flex-wrap gap-2 border-b border-slate-100 px-6 py-4">
                @if ($isAdminGudang && $gudangUser)
                    <span class="rounded-full bg-blue-50 px-3 py-1.5 text-xs font-medium text-[#123F7A]">Gudang: {{ $gudangUser->nama_gudang }}</span>
                @elseif (request('gudang_id'))
                    @php $gudangAktif = $gudangs->firstWhere('id', request('gudang_id')); @endphp
                    @if ($gudangAktif)<span class="rounded-full bg-slate-100 px-3 py-1.5 text-xs font-medium text-slate-600">Gudang: {{ $gudangAktif->nama_gudang }}</span>@endif
                @else
                    <span class="rounded-full bg-slate-100 px-3 py-1.5 text-xs font-medium text-slate-600">Gudang: Semua</span>
                @endif
                @if (request('mitra_pengolahan_id'))
                    @php $mitraAktif = $mitras->firstWhere('id', request('mitra_pengolahan_id')); @endphp
                    @if ($mitraAktif)<span class="rounded-full bg-slate-100 px-3 py-1.5 text-xs font-medium text-slate-600">Mitra: {{ $mitraAktif->nama_mitra }}</span>@endif
                @else
                    <span class="rounded-full bg-slate-100 px-3 py-1.5 text-xs font-medium text-slate-600">Mitra: Semua</span>
                @endif
                @if (request('bulan'))
                    <span class="rounded-full bg-slate-100 px-3 py-1.5 text-xs font-medium text-slate-600">Bulan: {{ \Carbon\Carbon::create()->month((int) request('bulan'))->translatedFormat('F') }}</span>
                @else
                    <span class="rounded-full bg-slate-100 px-3 py-1.5 text-xs font-medium text-slate-600">Bulan: Semua</span>
                @endif
                @if (request('tahun'))
                    <span class="rounded-full bg-slate-100 px-3 py-1.5 text-xs font-medium text-slate-600">Tahun: {{ request('tahun') }}</span>
                @else
                    <span class="rounded-full bg-slate-100 px-3 py-1.5 text-xs font-medium text-slate-600">Tahun: Semua</span>
                @endif
            </div>

            <div class="overflow-x-auto">
                <table class="w-full min-w-[760px] text-sm">
                    <thead class="bg-[#F5F8FD]">
                        <tr class="border-b border-slate-100 text-left text-[11px] uppercase tracking-wider text-slate-500">
                            @foreach ($headings as $h)
                                <th class="px-5 py-4 font-bold whitespace-nowrap">{{ $h }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($rows as $row)
                            <tr class="transition hover:bg-blue-50/40">
                                @foreach ($row as $cell)
                                    <td class="px-5 py-3.5 text-slate-700 whitespace-nowrap">{{ $cell }}</td>
                                @endforeach
                            </tr>
                        @empty
                            <tr><td colspan="{{ count($headings) }}" class="px-5 py-16 text-center text-slate-500"><div class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-slate-50 text-2xl">📄</div><p class="mt-3 font-semibold text-slate-700">Tidak ada data</p><p class="mt-1 text-sm text-slate-400">Tidak ditemukan data untuk filter yang dipilih.</p></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    @else
        {{-- PANDUAN --}}
        <section class="rounded-[1.5rem] border border-slate-200/80 bg-white/95 p-6 shadow-lg">
            <div class="mb-5 flex items-center gap-3"><div class="flex h-10 w-10 items-center justify-center rounded-xl bg-orange-50">💡</div><div><h3 class="text-lg font-bold text-[#0B2545]">Panduan Singkat</h3><p class="text-sm text-slate-500">Tiga langkah untuk membuat laporan.</p></div></div>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                <div class="rounded-2xl bg-[#F7F9FC] p-5"><span class="flex h-9 w-9 items-center justify-center rounded-full bg-[#123F7A] text-sm font-bold text-white">1</span><p class="mt-4 font-semibold text-slate-800">Pilih jenis laporan</p><p class="mt-1 text-sm leading-6 text-slate-500">@if ($isAdminGudang) Pilih laporan BA Rampung, per Mitra, atau Catatan.@else Pilih laporan BA Rampung, per Mitra, per Gudang, atau Catatan.@endif</p></div>
                <div class="rounded-2xl bg-[#F7F9FC] p-5"><span class="flex h-9 w-9 items-center justify-center rounded-full bg-[#F39A24] text-sm font-bold text-white">2</span><p class="mt-4 font-semibold text-slate-800">Tentukan filter</p><p class="mt-1 text-sm leading-6 text-slate-500">Gunakan filter gudang, mitra, bulan, dan tahun sesuai kebutuhan.</p></div>
                <div class="rounded-2xl bg-[#F7F9FC] p-5"><span class="flex h-9 w-9 items-center justify-center rounded-full bg-emerald-500 text-sm font-bold text-white">3</span><p class="mt-4 font-semibold text-slate-800">Tampilkan atau export</p><p class="mt-1 text-sm leading-6 text-slate-500">Lihat hasil langsung atau export menjadi Excel dan PDF.</p></div>
            </div>
        </section>
    @endif

</div>

<style>
@media print {
    body * { visibility: hidden !important; }
    .overflow-x-auto, .overflow-x-auto * { visibility: visible !important; }
    .overflow-x-auto { position: absolute; left: 0; top: 0; width: 100%; }
}
</style>

@endsection
