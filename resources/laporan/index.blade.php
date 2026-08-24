@extends('layouts.app')

@section('title', 'Laporan')

@section('content')

<div class="card p-5">
    <h3 class="font-semibold text-gray-900 mb-4">Pilih Jenis Laporan</h3>
    <form method="GET" action="{{ route('laporan.index') }}" class="space-y-4">
        <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
            @foreach ($jenisList as $val => $label)
                <label class="cursor-pointer">
                    <input type="radio" name="jenis" value="{{ $val }}" class="hidden peer" @checked($jenis === $val)>
                    <div class="rounded-xl border-2 border-gray-200 peer-checked:border-bulog-700 peer-checked:bg-bulog-cream/40 p-3 text-center text-xs font-medium text-gray-600 peer-checked:text-bulog-800 transition-colors">
                        {{ $label }}
                    </div>
                </label>
            @endforeach
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
            <select name="gudang_id" class="input">
                <option value="">Semua Gudang</option>
                @foreach ($gudangs as $g)
                    <option value="{{ $g->id }}" @selected(request('gudang_id') == $g->id)>{{ $g->nama_gudang }}</option>
                @endforeach
            </select>
            <select name="mitra_pengolahan_id" class="input">
                <option value="">Semua Mitra</option>
                @foreach ($mitras as $m)
                    <option value="{{ $m->id }}" @selected(request('mitra_pengolahan_id') == $m->id)>{{ $m->nama_mitra }}</option>
                @endforeach
            </select>
            <select name="bulan" class="input">
                <option value="">Semua Bulan</option>
                @foreach (range(1, 12) as $bln)
                    <option value="{{ $bln }}" @selected((string) request('bulan') === (string) $bln)>{{ \Carbon\Carbon::create()->month($bln)->translatedFormat('F') }}</option>
                @endforeach
            </select>
            <select name="tahun" class="input">
                <option value="">Semua Tahun</option>
                @foreach (range(now()->year, now()->year - 3) as $y)
                    <option value="{{ $y }}" @selected((string) request('tahun') === (string) $y)>{{ $y }}</option>
                @endforeach
            </select>
        </div>

        <div class="flex justify-between">
            <a href="{{ route('laporan.index') }}" class="btn-secondary">↺ Reset</a>
            <button type="submit" name="tampilkan" value="1" class="btn-primary">📊 Tampilkan Laporan</button>
        </div>
    </form>
</div>

@if ($sudahFilter)
    <div class="card overflow-hidden">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 p-5 pb-0">
            <div>
                <h3 class="font-semibold text-gray-900">{{ $jenisList[$jenis] }}</h3>
                <p class="text-sm text-gray-500">Menampilkan {{ $rows->count() }} baris data</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('laporan.export-excel', request()->query()) }}" class="btn-secondary">⬇️ Export Excel</a>
                <a href="{{ route('laporan.export-pdf', request()->query()) }}" target="_blank" class="btn-secondary">📄 Export PDF</a>
                <a href="{{ route('laporan.export-pdf', request()->query()) }}" target="_blank" class="btn-primary">🖨️ Print</a>
            </div>
        </div>

        <div class="overflow-x-auto mt-4">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-y border-gray-100 text-left text-gray-500">
                        @foreach ($headings as $h)
                            <th class="px-5 py-3 font-medium">{{ $h }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse ($rows as $row)
                        <tr class="hover:bg-gray-50">
                            @foreach ($row as $cell)
                                <td class="px-5 py-3 text-gray-700">{{ $cell }}</td>
                            @endforeach
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ count($headings) }}" class="px-5 py-16 text-center text-gray-500">
                                <p class="text-3xl mb-2">📄</p>
                                Tidak ada data untuk filter yang dipilih.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="h-5"></div>
    </div>
@endif

@endsection
