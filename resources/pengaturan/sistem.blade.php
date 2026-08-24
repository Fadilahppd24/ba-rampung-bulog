@extends('layouts.app')

@section('title', 'Pengaturan Sistem')

@section('content')

@include('pengaturan._tabs')

<div class="card p-4 bg-info-bg text-info-text text-sm max-w-2xl">
    Catatan: mengubah nilai di bawah ini <strong>tidak mengubah retroaktif</strong> nomor BA yang sudah dibuat sebelumnya.
    Nomor BA yang sudah ada tetap seperti semula.
</div>

<form method="POST" action="{{ route('pengaturan.sistem.update') }}" class="card p-6 space-y-5 max-w-2xl">
    @csrf

    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <div>
            <label class="label">Prefix Nomor BA</label>
            <input type="text" name="prefix_nomor_ba" value="{{ old('prefix_nomor_ba', $pengaturan->prefix_nomor_ba) }}" required class="input" placeholder="BA">
        </div>
        <div>
            <label class="label">Suffix Nomor BA</label>
            <input type="text" name="suffix_nomor_ba" value="{{ old('suffix_nomor_ba', $pengaturan->suffix_nomor_ba) }}" required class="input" placeholder="GKP">
        </div>
        <div>
            <label class="label">Tahun Aktif</label>
            <input type="number" name="tahun_aktif" value="{{ old('tahun_aktif', $pengaturan->tahun_aktif) }}" required class="input">
        </div>
        <div>
            <label class="label">Item per Halaman (Pagination)</label>
            <input type="number" name="item_per_halaman" value="{{ old('item_per_halaman', $pengaturan->item_per_halaman) }}" min="5" max="100" required class="input">
        </div>
    </div>

    <div class="rounded-lg bg-gray-50 p-4 text-xs text-gray-500">
        Contoh format nomor BA saat ini: <strong>{{ $pengaturan->prefix_nomor_ba }}-007/07/{{ $pengaturan->tahun_aktif }}/10040/{{ $pengaturan->suffix_nomor_ba }}</strong>
    </div>

    <div class="flex justify-end pt-2">
        <button type="submit" class="btn-primary">💾 Simpan Perubahan</button>
    </div>
</form>

@endsection
