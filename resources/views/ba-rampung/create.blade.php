@extends('layouts.app')

@section('title', 'Buat BA Rampung')

@section('content')

<form method="POST" action="{{ route('ba-rampung.store') }}"
      x-data="baForm({ gabah: {{ old('kuantum_gabah', 0) }}, beras: {{ old('kuantum_beras', 0) }}, menir: {{ old('kuantum_menir', 0) }}, bekatul: {{ old('kuantum_bekatul', 0) }}, tanggal: '{{ old('tanggal_ba', now()->toDateString()) }}' })"
      class="space-y-6">
    @csrf

    <div class="card p-6">
        <h3 class="font-semibold text-gray-900 mb-5">📄 1. Data BA Rampung</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
<div>
    <label class="label">Nomor BA</label>

    <div class="flex items-center gap-2">
        <span class="text-sm font-medium whitespace-nowrap">BA -</span>

        <input
            type="text"
            name="nomor_ba_1"
            value="{{ old('nomor_ba_1') }}"
            class="input"
            placeholder="Nomor"
        >

        <span>/</span>

        <input
            type="text"
            name="nomor_ba_2"
            value="{{ old('nomor_ba_2') }}"
            class="input"
            placeholder="Nomor"
        >

        <span>/</span>

        <select name="tahun_ba" class="input">
            @for ($tahun = date('Y') - 2; $tahun <= date('Y') + 2; $tahun++)
                <option value="{{ $tahun }}"
                    @selected(old('tahun_ba', date('Y')) == $tahun)>
                    {{ $tahun }}
                </option>
            @endfor
        </select>

        <span>/ 10040 / GKP</span>
    </div>
</div>
<div class="grid grid-cols-1 md:grid-cols-3 gap-3">

    <div>
        <label class="label">Hari</label>
        <input
            type="text"
            :value="hariNama"
            disabled
            class="input bg-gray-50 text-gray-500"
        >
    </div>

    <div>
        <label class="label">Tanggal BA</label>
        <input
            type="date"
            name="tanggal_ba"
            x-model="tanggal"
            required
            class="input"
        >
    </div>

    <div>
        <label class="label">Bulan & Tahun</label>
        <input
            type="text"
            :value="bulanTahunNama"
            disabled
            class="input bg-gray-50 text-gray-500"
        >
    </div>

</div>
            <div>
                <label class="label">Nomor Manufacturing Order (MO)</label>
                <input
    type="text"
    name="nomor_mo"
    value="{{ old('nomor_mo') }}"
    class="input"
    placeholder="Masukkan nomor MO"
>
            </div>
            <div>
                <label class="label">Nomor Purchase Order (PO)</label>
                <input
    type="text"
    name="nomor_po"
    value="{{ old('nomor_po') }}"
    class="input"
    placeholder="Masukkan nomor PO"
>
            </div>
        </div>
    </div>

    <div class="card p-6">
        <h3 class="font-semibold text-gray-900 mb-1">🌾 2. Pengolahan Gabah (GKP) menjadi Beras Hasil Giling (HGL)</h3>
        <p class="text-xs text-gray-500 mb-5">Rendemen (%) di bawah ini hanya pratinjau — nilai final selalu dihitung ulang oleh server saat disimpan.</p>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-bulog-beige/60 text-left text-gray-600">
                        <th class="px-4 py-2.5 font-medium" colspan="2">Sebelum Pengolahan</th>
                        <th class="px-4 py-2.5 font-medium" colspan="2">Setelah Pengolahan</th>
                        <th class="px-4 py-2.5 font-medium">Rendemen (%)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <tr>
                        <td class="px-4 py-3 font-medium text-gray-700">Gabah (GKP)</td>
                        <td class="px-4 py-3 w-40">
                            <input type="number" step="1" min="1" name="kuantum_gabah" x-model.number="gabah" required class="input" placeholder="Masukkan KG">
                        </td>
                        <td class="px-4 py-3 font-medium text-gray-700">Beras (HGL)</td>
                        <td class="px-4 py-3 w-40">
                            <input type="number" step="1" min="0" name="kuantum_beras" x-model.number="beras" required class="input" placeholder="Masukkan KG">
                        </td>
                        <td class="px-4 py-3 text-gray-500" x-text="rendemen(beras) + ' %'"></td>
                    </tr>
                    <tr>
                        <td class="px-4 py-3"></td>
                        <td class="px-4 py-3"></td>
                        <td class="px-4 py-3 font-medium text-gray-700">Menir</td>
                        <td class="px-4 py-3 w-40">
                            <input type="number" step="1" min="0" name="kuantum_menir" x-model.number="menir" class="input" placeholder="Masukkan KG">
                        </td>
                        <td class="px-4 py-3 text-gray-500" x-text="rendemen(menir) + ' %'"></td>
                    </tr>
                    <tr>
                        <td class="px-4 py-3"></td>
                        <td class="px-4 py-3"></td>
                        <td class="px-4 py-3 font-medium text-gray-700">Bekatul</td>
                        <td class="px-4 py-3 w-40">
                            <input type="number" step="1" min="0" name="kuantum_bekatul" x-model.number="bekatul" class="input" placeholder="Masukkan KG">
                        </td>
                        <td class="px-4 py-3 text-gray-500" x-text="rendemen(bekatul) + ' %'"></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <p class="text-xs text-gray-400 mt-2">* Rendemen (%) dihitung otomatis oleh sistem</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="card p-6">
            <h3 class="font-semibold text-gray-900 mb-5">🤝 3. Pihak yang Terlibat</h3>
            <div class="space-y-4">
                <div>
                    <label class="label">Pihak Kesatu (Gudang)</label>
                    <select name="gudang_id" required class="input">
                        <option value="">Pilih Gudang</option>
                        @foreach ($gudangs as $g)
                            <option value="{{ $g->id }}" @selected(old('gudang_id') == $g->id)>{{ $g->nama_gudang }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="label">Pihak Kedua (Mitra Pengolahan)</label>
                    <select name="mitra_pengolahan_id" required class="input">
                        <option value="">Pilih Mitra Pengolahan</option>
                        @foreach ($mitras as $m)
                            <option value="{{ $m->id }}" @selected(old('mitra_pengolahan_id') == $m->id)>{{ $m->nama_mitra }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="label">Status PBP</label>
                    <select name="status_pbp" class="input">
                        @foreach (\App\Models\BaRampung::STATUS_PBP as $val => $label)
                            <option value="{{ $val }}" @selected(old('status_pbp') === $val)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="card p-6">
            <h3 class="font-semibold text-gray-900 mb-5">✍️ 4. Penandatanganan Pihak Kesatu (Gudang)</h3>
            <div class="space-y-4">
                <div>
                    <label class="label">Nama Penandatangan</label>
                    <input list="pegawai-list" name="nama_penandatangan" value="{{ old('nama_penandatangan') }}" required class="input" placeholder="Pilih atau ketik nama pegawai">
                    <datalist id="pegawai-list">
                        @foreach ($pegawais as $p)
                            <option value="{{ $p->nama }}">{{ $p->jabatan }}</option>
                        @endforeach
                    </datalist>
                </div>
                <div>
                    <label class="label">Jabatan</label>
                    <input type="text" name="jabatan_penandatangan" value="{{ old('jabatan_penandatangan', 'Pengelola Gudang') }}" required class="input">
                </div>

                <h3 class="font-semibold text-gray-900 pt-2">👔 5. Mengetahui</h3>
                <div>
                    <label class="label">Pimpinan Cabang BULOG</label>
                    <select name="pimpinan_cabang_id" required class="input">
                        <option value="">Pilih Pimpinan Cabang</option>
                        @foreach ($pimpinans as $p)
                            <option value="{{ $p->id }}" @selected(old('pimpinan_cabang_id') == $p->id)>{{ $p->nama }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="card p-6">
        <label class="label">Catatan (opsional)</label>
        <textarea name="catatan" rows="2" class="input">{{ old('catatan') }}</textarea>
    </div>

    <div class="flex items-center justify-between">
        <a href="{{ route('ba-rampung.index') }}" class="btn-secondary">← Kembali</a>
        <div class="flex gap-3">
            <button type="submit" name="action" value="draft" class="btn-secondary">💾 Simpan Draft</button>
            <button type="submit" name="action" value="submit" class="btn-primary">🖨️ Simpan &amp; Kirim Verifikasi</button>
        </div>
    </div>
</form>

@endsection
