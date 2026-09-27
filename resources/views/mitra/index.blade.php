@extends('layouts.app')

@section('title', 'Data Mitra')

@section('content')

<div class="space-y-6">

    {{-- HEADER --}}
    <div class="flex flex-col gap-4 pt-2 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="dashboard-kicker text-white/75">Master Data</p>
            <h1 class="dashboard-display mt-2 text-4xl leading-tight text-white sm:text-5xl">
                Data <span class="text-[#F28C28]">Mitra</span>
            </h1>
            <p class="mt-2 text-sm text-white/85" style="text-shadow:0 1px 8px rgba(3,28,55,.2);">
                Kelola data mitra pengolahan BA Rampung.
            </p>
        </div>

        @role('admin_kantor', 'admin_gudang', 'admin_sistem')
            <a href="{{ route('mitra.create') }}"
               class="inline-flex items-center justify-center gap-2 rounded-full bg-[#123F7A] px-5 py-3 text-sm font-bold text-white shadow-lg transition hover:-translate-y-0.5 hover:bg-[#0d3263]">
                <span class="text-lg leading-none">＋</span>
                Tambah Mitra
            </a>
        @endrole
    </div>

    {{-- KPI --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-3">
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Total Mitra</p>
                    <p class="mt-2 text-3xl font-bold text-[#123F7A]">{{ number_format($mitras->total()) }}</p>
                </div>
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 text-xl">🤝</div>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Data Ditampilkan</p>
                    <p class="mt-2 text-3xl font-bold text-[#123F7A]">{{ number_format($mitras->count()) }}</p>
                </div>
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-50 text-xl">✓</div>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Jenis Usaha</p>
                    <p class="mt-2 text-3xl font-bold text-amber-600">{{ number_format(count($jenisUsahaOptions)) }}</p>
                </div>
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-amber-50 text-xl">▦</div>
            </div>
        </div>
    </div>

    {{-- FILTER --}}
    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
        <form method="GET" action="{{ route('mitra.index') }}" class="space-y-5">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-lg">⌕</div>
                    <div>
                        <h2 class="text-base font-bold text-gray-900">Filter Data</h2>
                        <p class="mt-0.5 text-xs text-gray-500">Cari dan saring data mitra pengolahan dengan lebih cepat.</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    @if(request('search') || request('jenis_usaha'))
                        <a href="{{ route('mitra.index') }}" class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">↺ Reset</a>
                    @endif
                    <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-[#123F7A] px-4 py-2.5 text-sm font-bold text-white transition hover:bg-[#0d3263]">⌕ Cari</button>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-3 md:grid-cols-2">
                <div>
                    <label class="mb-1.5 block text-xs font-semibold text-slate-500">Pencarian</label>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Cari nama mitra atau kode mitra..."
                           class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm text-gray-700 outline-none transition placeholder:text-slate-400 focus:border-[#123F7A] focus:ring-2 focus:ring-blue-100">
                </div>
                <div>
                    <label class="mb-1.5 block text-xs font-semibold text-slate-500">Jenis Usaha</label>
                    <select name="jenis_usaha" onchange="this.form.submit()"
                            class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm text-gray-700 outline-none focus:border-[#123F7A] focus:ring-2 focus:ring-blue-100">
                        <option value="">Semua Jenis Usaha</option>
                        @foreach($jenisUsahaOptions as $j)
                            <option value="{{ $j }}" @selected(request('jenis_usaha') === $j)>{{ $j }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </form>
    </div>

    {{-- TABLE --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="flex flex-col gap-2 border-b border-slate-100 px-5 py-5 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-lg">🤝</div>
                <div>
                    <h2 class="font-bold text-gray-900">Data Mitra</h2>
                    <p class="mt-1 text-xs text-gray-500">Menampilkan {{ $mitras->firstItem() ?? 0 }}–{{ $mitras->lastItem() ?? 0 }} dari {{ $mitras->total() }} data mitra.</p>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full min-w-[1050px] text-sm">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50 text-left text-xs uppercase tracking-wider text-slate-500">
                        <th class="px-5 py-3 font-semibold">No.</th>
                        <th class="px-5 py-3 font-semibold">Kode Mitra</th>
                        <th class="px-5 py-3 font-semibold">Nama Mitra</th>
                        <th class="px-5 py-3 font-semibold">Jenis Usaha</th>
                        <th class="px-5 py-3 font-semibold">Alamat</th>
                        <th class="px-5 py-3 font-semibold">Kontak</th>
                        <th class="px-5 py-3 font-semibold">Status</th>
                        <th class="px-5 py-3 text-right font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mitras as $i => $m)
                        <tr class="border-b border-slate-100 transition hover:bg-blue-50/40">
                            <td class="px-5 py-3.5 text-slate-500">{{ $mitras->firstItem() + $i }}</td>
                            <td class="px-5 py-3.5 font-semibold text-[#123F7A]">{{ $m->kode_mitra }}</td>
                            <td class="px-5 py-3.5 font-medium text-slate-800">{{ $m->nama_mitra }}</td>
                            <td class="px-5 py-3.5 text-slate-600">{{ $m->jenis_usaha ?? '-' }}</td>
                            <td class="max-w-[300px] px-5 py-3.5 text-slate-600">{{ $m->alamat ?? '-' }}</td>
                            <td class="px-5 py-3.5 text-slate-600">{{ $m->nomor_telepon ?? '-' }}</td>
                            <td class="px-5 py-3.5">
                                <x-status-badge :color="$m->status === 'aktif' ? 'green' : 'gray'" :label="ucfirst($m->status)" />
                            </td>
                            <td class="px-5 py-3.5">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('mitra.show', $m) }}" title="Detail" class="flex h-9 w-9 items-center justify-center rounded-lg bg-blue-50 text-[#123F7A] transition hover:bg-blue-100">👁</a>
                                    @role('admin_kantor', 'admin_gudang', 'admin_sistem')
                                        <a href="{{ route('mitra.edit', $m) }}" title="Edit" class="flex h-9 w-9 items-center justify-center rounded-lg bg-amber-50 text-amber-600 transition hover:bg-amber-100">✎</a>
                                        <form method="POST" action="{{ route('mitra.toggle-status', $m) }}" onsubmit="return confirm('{{ $m->status === 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }} mitra {{ $m->nama_mitra }}?');">
                                            @csrf @method('PATCH')
                                            <button type="submit" title="{{ $m->status === 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }}" class="flex h-9 w-9 items-center justify-center rounded-lg bg-slate-50 text-slate-500 transition hover:bg-slate-100">{{ $m->status === 'aktif' ? '⏸' : '▶' }}</button>
                                        </form>
                                    @endrole
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="px-5 py-16 text-center text-slate-500"><p class="mb-2 text-3xl">🤝</p>Belum ada data Mitra Pengolahan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($mitras->hasPages())
            <div class="border-t border-slate-100 p-5">{{ $mitras->links() }}</div>
        @endif
    </div>
</div>
@endsection
