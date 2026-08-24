@extends('layouts.app')

@section('title', 'Detail BA Rampung')

@section('content')

<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
    <div>
        <h2 class="text-lg font-semibold text-gray-900">{{ $baRampung->nomor_ba }}</h2>
        <p class="text-sm text-gray-500">Dibuat oleh {{ $baRampung->pembuat->name ?? '-' }} · {{ $baRampung->created_at->format('d/m/Y H:i') }}</p>
    </div>
    <div class="flex items-center gap-3">
        <x-status-badge :color="$baRampung->statusBadgeColor()" :label="$baRampung->statusLabel()" class="text-sm px-3 py-1.5" />
        <a href="{{ route('ba-rampung.pdf', $baRampung) }}" target="_blank" class="btn-secondary">🖨️ Cetak PDF</a>
        @can('update', $baRampung)
            <a href="{{ route('ba-rampung.edit', $baRampung) }}" class="btn-secondary">✏️ Edit</a>
        @endcan
    </div>
</div>

@if ($baRampung->status === \App\Models\BaRampung::STATUS_DITOLAK && $baRampung->alasan_penolakan)
    <div class="rounded-xl bg-danger-bg text-danger-text px-4 py-3 text-sm">
        <p class="font-medium">Alasan Penolakan:</p>
        <p>{{ $baRampung->alasan_penolakan }}</p>
    </div>
@endif

@can('verify', $baRampung)
    <div class="card p-6 border-l-4 border-l-warning-text">
        <h3 class="font-semibold text-gray-900 mb-3">🔎 Verifikasi & Approval</h3>
        <p class="text-sm text-gray-500 mb-4">BA ini menunggu keputusan Anda sebagai Pimpinan Cabang.</p>
        <div class="flex flex-wrap gap-3">
            <form method="POST" action="{{ route('ba-rampung.verify', $baRampung) }}" onsubmit="return confirm('Verifikasi dan terima BA {{ $baRampung->nomor_ba }}?');">
                @csrf
                <input type="hidden" name="keputusan" value="terima">
                <button class="btn-primary">✅ Verifikasi &amp; Terima</button>
            </form>

            <button type="button" onclick="document.getElementById('modal-tolak').classList.remove('hidden')" class="btn-secondary text-danger-text border-danger-text/30">
                ✖️ Tolak
            </button>
        </div>
    </div>

    <div id="modal-tolak" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4">
        <div class="card p-6 w-full max-w-md">
            <h3 class="font-semibold text-gray-900 mb-3">Tolak BA Rampung</h3>
            <form method="POST" action="{{ route('ba-rampung.verify', $baRampung) }}">
                @csrf
                <input type="hidden" name="keputusan" value="tolak">
                <label class="label">Alasan Penolakan</label>
                <textarea name="alasan_penolakan" rows="3" required class="input" placeholder="Jelaskan alasan penolakan…"></textarea>
                <div class="flex justify-end gap-3 mt-4">
                    <button type="button" onclick="document.getElementById('modal-tolak').classList.add('hidden')" class="btn-secondary">Batal</button>
                    <button type="submit" class="btn-primary bg-danger-text hover:bg-danger-text/90">Tolak BA</button>
                </div>
            </form>
        </div>
    </div>
@endcan

<div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
    <div class="card p-6">
        <h3 class="font-semibold text-gray-900 mb-4">📄 Data BA Rampung</h3>
        <dl class="space-y-3 text-sm">
            <div class="flex justify-between"><dt class="text-gray-500">Tanggal BA</dt><dd class="font-medium">{{ $baRampung->hari }}, {{ $baRampung->tanggal_ba->format('d') }} {{ $baRampung->bulan }} {{ $baRampung->tahun }}</dd></div>
            <div class="flex justify-between"><dt class="text-gray-500">Nomor MO</dt><dd class="font-medium">{{ $baRampung->nomor_mo }}</dd></div>
            <div class="flex justify-between"><dt class="text-gray-500">Nomor PO</dt><dd class="font-medium">{{ $baRampung->nomor_po }}</dd></div>
            <div class="flex justify-between"><dt class="text-gray-500">Gudang</dt><dd class="font-medium">{{ $baRampung->gudang->nama_gudang }}</dd></div>
            <div class="flex justify-between"><dt class="text-gray-500">Mitra Pengolahan</dt><dd class="font-medium">{{ $baRampung->mitraPengolahan->nama_mitra }}</dd></div>
            <div class="flex justify-between"><dt class="text-gray-500">Status PBP</dt><dd class="font-medium">{{ $baRampung->statusPbpLabel() }}</dd></div>
        </dl>
    </div>

    <div class="card p-6">
        <h3 class="font-semibold text-gray-900 mb-4">✍️ Penandatanganan</h3>
        <dl class="space-y-3 text-sm">
            <div class="flex justify-between"><dt class="text-gray-500">Pihak Kesatu</dt><dd class="font-medium">{{ $baRampung->nama_penandatangan }} — {{ $baRampung->jabatan_penandatangan }}</dd></div>
            <div class="flex justify-between"><dt class="text-gray-500">Mengetahui</dt><dd class="font-medium">{{ $baRampung->pimpinanCabang->nama ?? '-' }}</dd></div>
            <div class="flex justify-between"><dt class="text-gray-500">Diverifikasi oleh</dt><dd class="font-medium">{{ $baRampung->verifikator->name ?? '-' }}</dd></div>
            <div class="flex justify-between"><dt class="text-gray-500">Tanggal Verifikasi</dt><dd class="font-medium">{{ $baRampung->verified_at?->format('d/m/Y H:i') ?? '-' }}</dd></div>
        </dl>
    </div>
</div>

<div class="card p-6">
    <h3 class="font-semibold text-gray-900 mb-4">🌾 Pengolahan Gabah (GKP) → Beras Hasil Giling (HGL)</h3>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-bulog-beige/60 text-left text-gray-600">
                    <th class="px-4 py-2.5 font-medium">Produk Sebelum</th>
                    <th class="px-4 py-2.5 font-medium">Kuantum (Kg)</th>
                    <th class="px-4 py-2.5 font-medium">Produk Sesudah</th>
                    <th class="px-4 py-2.5 font-medium">Kuantum (Kg)</th>
                    <th class="px-4 py-2.5 font-medium">Rendemen (%)</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach ($baRampung->produksis as $p)
                    <tr>
                        <td class="px-4 py-3">{{ $p->produk_sebelum }}</td>
                        <td class="px-4 py-3">{{ number_format($p->kuantum_sebelum, 2) }}</td>
                        <td class="px-4 py-3">{{ $p->produk_sesudah }}</td>
                        <td class="px-4 py-3">{{ number_format($p->kuantum_sesudah, 2) }}</td>
                        <td class="px-4 py-3 font-medium text-bulog-700">{{ number_format($p->rendemen, 2) }}%</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@if ($baRampung->catatan)
    <div class="card p-6">
        <h3 class="font-semibold text-gray-900 mb-2">📝 Catatan</h3>
        <p class="text-sm text-gray-600">{{ $baRampung->catatan }}</p>
    </div>
@endif

@endsection
