@extends('layouts.app')

@section('title', 'Edit BA Rampung')

@php
    $beras = $baRampung->produksis->firstWhere('produk_sesudah', 'Beras (HGL)');
    $menir = $baRampung->produksis->firstWhere('produk_sesudah', 'Menir');
    $bekatul = $baRampung->produksis->firstWhere('produk_sesudah', 'Bekatul');

    $gabahAwal = $beras->kuantum_sebelum ?? 0;
@endphp

@section('content')

<form
    method="POST"
    action="{{ route('ba-rampung.update', $baRampung) }}"
    x-data="baForm({
        gabah: {{ old('kuantum_gabah', $gabahAwal) }},
        beras: {{ old('kuantum_beras', $beras->kuantum_sesudah ?? 0) }},
        menir: {{ old('kuantum_menir', $menir->kuantum_sesudah ?? 0) }},
        bekatul: {{ old('kuantum_bekatul', $bekatul->kuantum_sesudah ?? 0) }},
        tanggal: '{{ old('tanggal_ba', $baRampung->tanggal_ba->toDateString()) }}'
    })"
    class="space-y-6"
>

    @csrf
    @method('PUT')


    {{-- ========================================================= --}}
    {{-- 1. DATA BA RAMPUNG --}}
    {{-- ========================================================= --}}

    <div class="card p-6">

        <h3 class="font-semibold text-gray-900 mb-5">
            📄 1. Data BA Rampung — {{ $baRampung->nomor_ba }}
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

            {{-- Nomor BA --}}
            <div>
                <label class="label">Nomor BA</label>

                <input
                    type="text"
                    disabled
                    value="{{ $baRampung->nomor_ba }}"
                    class="input bg-gray-50 text-gray-500"
                >
            </div>


            {{-- Hari / Tanggal / Tahun --}}
            <div class="grid grid-cols-3 gap-3">

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
                    <label class="label">Tahun</label>

                    <input
                        type="text"
                        :value="tahunNama"
                        disabled
                        class="input bg-gray-50 text-gray-500"
                    >
                </div>

            </div>


            {{-- Nomor MO --}}
            <div>
                <label class="label">
                    Nomor Manufacturing Order (MO)
                </label>

                <input
    type="text"
    name="nomor_mo"
    value="{{ old('nomor_mo', $baRampung->nomor_mo) }}"
    class="input"
    placeholder="Masukkan nomor MO (opsional)"
>
            </div>


            {{-- Nomor PO --}}
            <div>
                <label class="label">
                    Nomor Purchase Order (PO)
                </label>

                <input
    type="text"
    name="nomor_po"
    value="{{ old('nomor_po', $baRampung->nomor_po) }}"
    class="input"
    placeholder="Masukkan nomor PO (opsional)"
>
            </div>

        </div>

    </div>



    {{-- ========================================================= --}}
    {{-- 2. PENGOLAHAN --}}
    {{-- ========================================================= --}}

    <div class="card p-6">

        <h3 class="font-semibold text-gray-900 mb-1">
            🌾 2. Pengolahan Gabah (GKP) menjadi Beras Hasil Giling (HGL)
        </h3>

        <p class="text-xs text-gray-500 mb-5">
            Rendemen (%) di bawah ini hanya pratinjau — nilai final selalu
            dihitung ulang oleh server saat disimpan.
        </p>

        <div class="overflow-x-auto">

            <table class="w-full text-sm">

                <thead>
                    <tr class="bg-bulog-beige/60 text-left text-gray-600">

                        <th
                            class="px-4 py-2.5 font-medium"
                            colspan="2"
                        >
                            Sebelum Pengolahan
                        </th>

                        <th
                            class="px-4 py-2.5 font-medium"
                            colspan="2"
                        >
                            Setelah Pengolahan
                        </th>

                        <th class="px-4 py-2.5 font-medium">
                            Rendemen (%)
                        </th>

                    </tr>
                </thead>


                <tbody class="divide-y divide-gray-100">

                    {{-- GABAH -> BERAS --}}
                    <tr>

                        <td class="px-4 py-3 font-medium text-gray-700">
                            Gabah (GKP)
                        </td>

                        <td class="px-4 py-3 w-40">

                            <input
    type="number"
    step="1"
    min="1"
    name="kuantum_gabah"
    x-model.number="gabah"
    required
    class="input"
    placeholder="Masukkan KG"
>

                        </td>

                        <td class="px-4 py-3 font-medium text-gray-700">
                            Beras (HGL)
                        </td>

                        <td class="px-4 py-3 w-40">

                            <input
    type="number"
    step="1"
    min="0"
    name="kuantum_beras"
    x-model.number="beras"
    required
    class="input"
    placeholder="Masukkan KG"
>

                        </td>

                        <td
                            class="px-4 py-3 text-gray-500"
                            x-text="rendemen(beras) + ' %'"
                        ></td>

                    </tr>


                    {{-- MENIR --}}
                    <tr>

                        <td colspan="2"></td>

                        <td class="px-4 py-3 font-medium text-gray-700">
                            Menir
                        </td>

                        <td class="px-4 py-3 w-40">

                            <input
    type="number"
    step="1"
    min="0"
    name="kuantum_menir"
    x-model.number="menir"
    class="input"
    placeholder="Masukkan KG"
>

                        </td>

                        <td
                            class="px-4 py-3 text-gray-500"
                            x-text="rendemen(menir) + ' %'"
                        ></td>

                    </tr>


                    {{-- BEKATUL --}}
                    <tr>

                        <td colspan="2"></td>

                        <td class="px-4 py-3 font-medium text-gray-700">
                            Bekatul
                        </td>

                        <td class="px-4 py-3 w-40">

                            <input
    type="number"
    step="1"
    min="0"
    name="kuantum_bekatul"
    x-model.number="bekatul"
    class="input"
    placeholder="Masukkan KG"
>

                        </td>

                        <td
                            class="px-4 py-3 text-gray-500"
                            x-text="rendemen(bekatul) + ' %'"
                        ></td>

                    </tr>

                </tbody>

            </table>

        </div>

    </div>



    {{-- ========================================================= --}}
    {{-- 3. PIHAK YANG TERLIBAT --}}
    {{-- ========================================================= --}}

    <div class="card p-6">

        <h3 class="font-semibold text-gray-900 mb-5">
            🤝 3. Pihak yang Terlibat
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

            {{-- Pihak Kesatu --}}
            <div>

                <label class="label">
                    Pihak Kesatu (Gudang)
                </label>

                <select
                    name="gudang_id"
                    required
                    class="input"
                >

                    @foreach ($gudangs as $g)

                        <option
                            value="{{ $g->id }}"
                            @selected(
                                old('gudang_id', $baRampung->gudang_id) == $g->id
                            )
                        >
                            {{ $g->nama_gudang }}
                        </option>

                    @endforeach

                </select>

            </div>


            {{-- Pihak Kedua --}}
            <div>

                <label class="label">
                    Pihak Kedua (Mitra Pengolahan)
                </label>

                <select
                    name="mitra_pengolahan_id"
                    required
                    class="input"
                >

                    @foreach ($mitras as $m)

                        <option
                            value="{{ $m->id }}"
                            @selected(
                                old(
                                    'mitra_pengolahan_id',
                                    $baRampung->mitra_pengolahan_id
                                ) == $m->id
                            )
                        >
                            {{ $m->nama_mitra }}
                        </option>

                    @endforeach

                </select>

            </div>

        </div>

    </div>



    {{-- ========================================================= --}}
    {{-- 4. PENANDATANGAN PIHAK KESATU --}}
    {{-- ========================================================= --}}

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <div class="card p-6">

            <h3 class="font-semibold text-gray-900 mb-5">
                ✍️ 4. Penandatanganan Pihak Kesatu (Gudang)
            </h3>

            <div class="space-y-4">

                {{-- Nama --}}
                <div>

                    <label class="label">
                        Nama Penandatangan
                    </label>

                    <input
                        list="pegawai-list"
                        name="nama_penandatangan"
                        value="{{ old(
                            'nama_penandatangan',
                            $baRampung->nama_penandatangan
                        ) }}"
                        required
                        class="input"
                    >

                    <datalist id="pegawai-list">

                        @foreach ($pegawais as $p)

                            <option value="{{ $p->nama }}">
                                {{ $p->jabatan }}
                            </option>

                        @endforeach

                    </datalist>

                </div>


                {{-- Jabatan --}}
                <div>

                    <label class="label">
                        Jabatan
                    </label>

                    <input
                        type="text"
                        name="jabatan_penandatangan"
                        value="{{ old(
                            'jabatan_penandatangan',
                            $baRampung->jabatan_penandatangan
                        ) }}"
                        required
                        class="input"
                    >

                </div>

            </div>

        </div>



        {{-- ===================================================== --}}
        {{-- 5. PENANDATANGAN PIHAK KEDUA --}}
        {{-- ===================================================== --}}

        <div class="card p-6">

            <h3 class="font-semibold text-gray-900 mb-5">
                ✍️ 5. Penandatanganan Pihak Kedua (Mitra Pengolahan)
            </h3>

            <div class="space-y-4">

                {{-- Nama Penandatangan Pihak Kedua --}}
                <div>

                    <label class="label">
                        Nama Penandatangan Pihak Kedua
                    </label>

                    <input
                        type="text"
                        name="nama_penandatangan_pihak_kedua"
                        value="{{ old(
                            'nama_penandatangan_pihak_kedua',
                            $baRampung->nama_penandatangan_pihak_kedua
                        ) }}"
                        required
                        class="input"
                        placeholder="Masukkan nama penandatangan mitra"
                    >

                </div>


                {{-- Jabatan Pihak Kedua --}}
                <div>

                    <label class="label">
                        Jabatan Penandatangan Pihak Kedua
                    </label>

                    <input
                        type="text"
                        name="jabatan_penandatangan_pihak_kedua"
                        value="{{ old(
                            'jabatan_penandatangan_pihak_kedua',
                            $baRampung->jabatan_penandatangan_pihak_kedua
                        ) }}"
                        required
                        class="input"
                        placeholder="Masukkan jabatan penandatangan mitra"
                    >

                </div>

            </div>

        </div>

    </div>



    {{-- ========================================================= --}}
    {{-- 6. MENGETAHUI --}}
    {{-- ========================================================= --}}

    <div class="card p-6">

        <h3 class="font-semibold text-gray-900 mb-5">
            👔 6. Mengetahui
        </h3>

        <div class="max-w-xl">

            <label class="label">
                Pimpinan Cabang BULOG
            </label>

            <select
                name="pimpinan_cabang_id"
                required
                class="input"
            >

                @foreach ($pimpinans as $p)

                    <option
                        value="{{ $p->id }}"
                        @selected(
                            old(
                                'pimpinan_cabang_id',
                                $baRampung->pimpinan_cabang_id
                            ) == $p->id
                        )
                    >
                        {{ $p->nama }}
                    </option>

                @endforeach

            </select>

        </div>

    </div>



    {{-- ========================================================= --}}
    {{-- CATATAN --}}
    {{-- ========================================================= --}}

    <div class="card p-6">

        <label class="label">
            Catatan (opsional)
        </label>

        <textarea
            name="catatan"
            rows="2"
            class="input"
        >{{ old('catatan', $baRampung->catatan) }}</textarea>

    </div>



    {{-- ========================================================= --}}
    {{-- BUTTON --}}
    {{-- ========================================================= --}}

    <div class="flex items-center justify-between">

        <a
            href="{{ route('ba-rampung.show', $baRampung) }}"
            class="btn-secondary"
        >
            ← Kembali
        </a>


        <div class="flex gap-3">

            <button
                type="submit"
                name="action"
                value="draft"
                class="btn-secondary"
            >
                💾 Simpan sebagai Draft
            </button>


            <button
                type="submit"
                name="action"
                value="submit"
                class="btn-primary"
            >
                ✅ Simpan &amp; Kirim Verifikasi
            </button>

        </div>

    </div>

</form>

@endsection