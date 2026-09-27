@extends('layouts.app')

@section('title', 'Data Pimpinan')

@section('content')

<div class="space-y-6">
    {{-- HEADER --}}
    <div class="flex flex-col gap-4 pt-2 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="dashboard-kicker text-white/75">Master Data</p>
            <h1 class="dashboard-display mt-2 text-4xl leading-tight text-white sm:text-5xl">
                Data <span class="text-[#F28C28]">Pimpinan</span>
            </h1>
            <p class="mt-2 text-sm text-white/85" style="text-shadow:0 1px 8px rgba(3,28,55,.2);">
                Kelola data pimpinan cabang dan riwayat kepemimpinan.
            </p>
        </div>
        @if(auth()->check() && auth()->user()->role === 'admin_kantor')
            <a href="{{ route('pimpinan.create') }}" class="inline-flex items-center justify-center gap-2 rounded-full bg-[#123F7A] px-5 py-3 text-sm font-bold text-white shadow-lg transition hover:-translate-y-0.5 hover:bg-[#0d3263]">
                <span class="text-lg leading-none">＋</span>
                Tambah Pimpinan
            </a>
        @endif
    </div>

    {{-- KPI --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Total Riwayat</p>
            <div class="mt-2 flex items-center justify-between"><p class="text-3xl font-bold text-[#123F7A]">{{ number_format($riwayat->total()) }}</p><div class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 text-xl">👔</div></div>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Pimpinan Aktif</p>
            <div class="mt-2 flex items-center justify-between"><p class="text-3xl font-bold text-emerald-600">{{ $pimpinanAktif ? 1 : 0 }}</p><div class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-50 text-xl">✓</div></div>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Riwayat Selesai</p>
            <div class="mt-2 flex items-center justify-between"><p class="text-3xl font-bold text-slate-700">{{ number_format(max($riwayat->total() - ($pimpinanAktif ? 1 : 0), 0)) }}</p><div class="flex h-11 w-11 items-center justify-center rounded-xl bg-slate-100 text-xl">◷</div></div>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Periode Aktif</p>
            <div class="mt-2 flex items-center justify-between"><p class="text-2xl font-bold text-amber-600">{{ $pimpinanAktif?->periode_mulai?->format('Y') ?? '—' }}</p><div class="flex h-11 w-11 items-center justify-center rounded-xl bg-amber-50 text-xl">◫</div></div>
        </div>
    </div>

    {{-- ACTIVE PROFILE + HISTORY --}}
    <div class="grid grid-cols-1 gap-5 xl:grid-cols-[360px_minmax(0,1fr)]">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="mb-5 flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Pimpinan Aktif</p>
                    <h2 class="mt-1 text-lg font-bold text-slate-900">Informasi Pimpinan Cabang</h2>
                </div>
                @if(auth()->check() && auth()->user()->role === 'admin_kantor')
                    <a href="{{ route('pimpinan.create') }}" class="text-sm font-semibold text-[#123F7A] hover:underline">＋ Riwayat</a>
                @endif
            </div>

            @if($pimpinanAktif)
                <div class="flex items-center gap-4 border-b border-slate-100 pb-5">
                    <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl bg-blue-50 text-2xl font-bold text-[#123F7A]">
                        {{ strtoupper(substr($pimpinanAktif->nama, 0, 1)) }}
                    </div>
                    <div class="min-w-0">
                        <p class="truncate font-bold text-slate-900">{{ $pimpinanAktif->nama }}</p>
                        <p class="mt-1 text-xs text-slate-500">{{ $pimpinanAktif->jabatan }}</p>
                        <span class="mt-2 inline-flex rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700">● Aktif</span>
                    </div>
                </div>
                <dl class="mt-5 space-y-4 text-sm">
                    <div><dt class="text-xs font-semibold uppercase tracking-wider text-slate-400">Email</dt><dd class="mt-1 font-medium text-slate-700">{{ $pimpinanAktif->email ?? '-' }}</dd></div>
                    <div><dt class="text-xs font-semibold uppercase tracking-wider text-slate-400">Telepon</dt><dd class="mt-1 font-medium text-slate-700">{{ $pimpinanAktif->nomor_telepon ?? '-' }}</dd></div>
                    <div><dt class="text-xs font-semibold uppercase tracking-wider text-slate-400">Alamat Kantor</dt><dd class="mt-1 leading-relaxed font-medium text-slate-700">{{ $pimpinanAktif->alamat ?? '-' }}</dd></div>
                    <div><dt class="text-xs font-semibold uppercase tracking-wider text-slate-400">Menjabat Sejak</dt><dd class="mt-1 font-medium text-slate-700">{{ $pimpinanAktif->periode_mulai?->format('d/m/Y') ?? '-' }}</dd></div>
                </dl>
                @if(auth()->check() && auth()->user()->role === 'admin_kantor')
                    <a href="{{ route('pimpinan.edit', $pimpinanAktif) }}" class="mt-6 inline-flex w-full items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-[#123F7A] transition hover:bg-blue-50">✎ Edit Profil</a>
                @endif
            @else
                <div class="rounded-2xl bg-slate-50 px-5 py-10 text-center text-sm text-slate-500">Belum ada Pimpinan Cabang aktif.</div>
            @endif
        </div>

        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="flex flex-col gap-3 border-b border-slate-100 px-5 py-5 sm:flex-row sm:items-center sm:justify-between">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-lg">👔</div>
                    <div><h2 class="font-bold text-gray-900">Riwayat Pimpinan</h2><p class="mt-1 text-xs text-gray-500">Menampilkan seluruh riwayat pimpinan cabang.</p></div>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full min-w-[700px] text-sm">
                    <thead><tr class="border-b border-slate-100 bg-slate-50 text-left text-xs uppercase tracking-wider text-slate-500">
                        <th class="px-5 py-3 font-semibold">No.</th><th class="px-5 py-3 font-semibold">Nama</th><th class="px-5 py-3 font-semibold">Periode</th><th class="px-5 py-3 font-semibold">Status</th><th class="px-5 py-3 text-right font-semibold">Aksi</th>
                    </tr></thead>
                    <tbody>
                    @forelse($riwayat as $i => $p)
                        <tr class="border-b border-slate-100 transition hover:bg-blue-50/40">
                            <td class="px-5 py-3.5 text-slate-500">{{ $riwayat->firstItem() + $i }}</td>
                            <td class="px-5 py-3.5 font-semibold text-slate-800">{{ $p->nama }}</td>
                            <td class="px-5 py-3.5 text-slate-600">{{ $p->periode_mulai?->format('Y') ?? '-' }} – {{ $p->periode_selesai?->format('Y') ?? 'Sekarang' }}</td>
                            <td class="px-5 py-3.5"><x-status-badge :color="$p->status === 'aktif' ? 'green' : 'gray'" :label="ucfirst($p->status)" /></td>
                            <td class="px-5 py-3.5"><div class="flex justify-end gap-2">
                                <a href="{{ route('pimpinan.show', $p) }}" title="Lihat" class="flex h-9 w-9 items-center justify-center rounded-lg bg-blue-50 text-[#123F7A] transition hover:bg-blue-100">👁</a>
                                @if(auth()->check() && auth()->user()->role === 'admin_kantor')
                                    <a href="{{ route('pimpinan.edit', $p) }}" title="Edit" class="flex h-9 w-9 items-center justify-center rounded-lg bg-amber-50 text-amber-600 transition hover:bg-amber-100">✎</a>
                                @endif
                            </div></td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-5 py-16 text-center text-slate-500"><p class="mb-2 text-3xl">👔</p>Belum ada riwayat Pimpinan Cabang.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            @if($riwayat->hasPages())
                <div class="border-t border-slate-100 p-5">{{ $riwayat->links() }}</div>
            @endif
        </div>
    </div>
</div>
@endsection
