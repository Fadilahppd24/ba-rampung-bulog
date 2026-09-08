@extends('layouts.app')

@section('title', 'Buat BA Rampung')

@section('content')

<form method="POST"
      action="{{ route('ba-rampung.store') }}"
      x-data="baForm({
          gabah: {{ old('kuantum_gabah', 0) }},
          beras: {{ old('kuantum_beras', 0) }},
          menir: {{ old('kuantum_menir', 0) }},
          bekatul: {{ old('kuantum_bekatul', 0) }},
          tanggal: '{{ old('tanggal_ba', now()->toDateString()) }}'
      })"
      class="space-y-6">

    @csrf

    {{-- =========================================================
         1. DATA BA RAMPUNG
    ========================================================== --}}
    <div class="card p-6">
        <h3 class="font-semibold text-gray-900 mb-5">
            📄 1. Data BA Rampung
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

            <div>
                <label class="label">Nomor BA</label>

                <div class="flex items-center gap-2">

                    <span class="text-sm font-medium whitespace-nowrap">
                        BA -
                    </span>

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
                            <option
                                value="{{ $tahun }}"
                                @selected(old('tahun_ba', date('Y')) == $tahun)
                            >
                                {{ $tahun }}
                            </option>
                        @endfor
                    </select>

<span>/ 10040 / {{ $pengaturan->suffix_nomor_ba ?? 'GKP' }}</span>
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


    {{-- =========================================================
         2. PENGOLAHAN GABAH
    ========================================================== --}}
    <div class="card p-6">

        <h3 class="font-semibold text-gray-900 mb-1">
            🌾 2. Pengolahan Gabah (GKP) menjadi Beras Hasil Giling (HGL)
        </h3>

        <p class="text-xs text-gray-500 mb-5">
            Rendemen (%) di bawah ini hanya pratinjau — nilai final selalu dihitung ulang oleh server saat disimpan.
        </p>

        <div class="overflow-x-auto">

            <table class="w-full text-sm">

                <thead>
                    <tr class="bg-bulog-beige/60 text-left text-gray-600">

                        <th class="px-4 py-2.5 font-medium" colspan="2">
                            Sebelum Pengolahan
                        </th>

                        <th class="px-4 py-2.5 font-medium" colspan="2">
                            Setelah Pengolahan
                        </th>

                        <th class="px-4 py-2.5 font-medium">
                            Rendemen (%)
                        </th>

                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">

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


                    <tr>

                        <td class="px-4 py-3"></td>
                        <td class="px-4 py-3"></td>

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


                    <tr>

                        <td class="px-4 py-3"></td>
                        <td class="px-4 py-3"></td>

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

        <p class="text-xs text-gray-400 mt-2">
            * Rendemen (%) dihitung otomatis oleh sistem
        </p>

    </div>


    {{-- =========================================================
         3. PIHAK YANG TERLIBAT
    ========================================================== --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <div class="card p-6">

            <h3 class="font-semibold text-gray-900 mb-5">
                🤝 3. Pihak yang Terlibat
            </h3>

            <div class="space-y-4">

                {{-- =======================
                     PIHAK KESATU / GUDANG
                ======================== --}}
                <div
                    x-data="{
                        open: false,
                        search: '',
                        selected: '{{ old('gudang_id') }}',

                        gudangs: [
                            @foreach ($gudangs as $g)
                                {
                                    id: '{{ $g->id }}',
                                    nama: @js($g->nama_gudang)
                                },
                            @endforeach
                        ],

                        get filteredGudangs() {

                            if (!this.search) {
                                return this.gudangs;
                            }

                            return this.gudangs.filter(gudang =>
                                gudang.nama
                                    .toLowerCase()
                                    .includes(this.search.toLowerCase())
                            );
                        },

                        pilihGudang(gudang) {

                            this.selected = gudang.id;
                            this.search = gudang.nama;
                            this.open = false;

                        }
                    }"
                    class="relative"
                >

                    <label class="label">
                        Pihak Kesatu (Gudang)
                    </label>

                    <input
                        type="hidden"
                        name="gudang_id"
                        x-model="selected"
                    >

                    <input
                        type="text"
                        x-model="search"
                        @focus="open = true"
                        @click="open = true"
                        @input="open = true"
                        @keydown.escape="open = false"
                        class="input"
                        placeholder="Ketik nama gudang..."
                        autocomplete="off"
                        required
                    >

                    <div
                        x-show="open"
                        @click.outside="open = false"
                        x-cloak
                        class="absolute z-50 left-0 right-0 mt-1 bg-white border border-gray-200 rounded-lg shadow-lg max-h-60 overflow-y-auto"
                    >

                        <template
                            x-for="gudang in filteredGudangs"
                            :key="gudang.id"
                        >

                            <button
                                type="button"
                                @click="pilihGudang(gudang)"
                                class="w-full text-left px-4 py-3 hover:bg-gray-50 border-b border-gray-100"
                            >

                                <span
                                    class="font-medium text-gray-900"
                                    x-text="gudang.nama"
                                ></span>

                            </button>

                        </template>

                        <div
                            x-show="filteredGudangs.length === 0"
                            class="px-4 py-3 text-sm text-gray-500"
                        >
                            Gudang tidak ditemukan.
                        </div>

                    </div>

                </div>


                {{-- =======================
                     PIHAK KEDUA / MITRA
                ======================== --}}
                <div
                    x-data="{
                        open: false,
                        search: '',
                        selected: '{{ old('mitra_pengolahan_id') }}',

                        mitras: [
                            @foreach ($mitras as $m)
                                {
                                    id: '{{ $m->id }}',
                                    nama: @js($m->nama_mitra)
                                },
                            @endforeach
                        ],

                        get filteredMitras() {

                            if (!this.search) {
                                return this.mitras;
                            }

                            return this.mitras.filter(mitra =>
                                mitra.nama
                                    .toLowerCase()
                                    .includes(this.search.toLowerCase())
                            );
                        },

                        pilihMitra(mitra) {

                            this.selected = mitra.id;
                            this.search = mitra.nama;
                            this.open = false;

                        }
                    }"
                    class="relative"
                >

                    <label class="label">
                        Pihak Kedua (Mitra Pengolahan)
                    </label>

                    <input
                        type="hidden"
                        name="mitra_pengolahan_id"
                        x-model="selected"
                    >

                    <input
                        type="text"
                        x-model="search"
                        @focus="open = true"
                        @click="open = true"
                        @input="open = true"
                        @keydown.escape="open = false"
                        class="input"
                        placeholder="Ketik nama mitra..."
                        autocomplete="off"
                        required
                    >

                    <div
                        x-show="open"
                        @click.outside="open = false"
                        x-cloak
                        class="absolute z-50 left-0 right-0 mt-1 bg-white border border-gray-200 rounded-lg shadow-lg max-h-60 overflow-y-auto"
                    >

                        <template
                            x-for="mitra in filteredMitras"
                            :key="mitra.id"
                        >

                            <button
                                type="button"
                                @click="pilihMitra(mitra)"
                                class="w-full text-left px-4 py-3 hover:bg-gray-50 border-b border-gray-100"
                            >

                                <span
                                    class="font-medium text-gray-900"
                                    x-text="mitra.nama"
                                ></span>

                            </button>

                        </template>

                        <div
                            x-show="filteredMitras.length === 0"
                            class="px-4 py-3 text-sm text-gray-500"
                        >
                            Mitra tidak ditemukan.
                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- =====================================================
             4, 5, 6. PENANDATANGANAN
        ====================================================== --}}
        <div class="card p-6">

            <h3 class="font-semibold text-gray-900 mb-5">
                ✍️ 4. Penandatanganan Pihak Kesatu (Gudang)
            </h3>

            <div class="space-y-4">

                <div>

                    <label class="label">
                        Nama Penandatangan
                    </label>

                <input
    list="penandatangan-kesatu-list"
    name="nama_penandatangan"
    value="{{ old('nama_penandatangan') }}"
    required
    class="input"
    placeholder="Ketik atau pilih nama penandatangan"
>

<datalist id="penandatangan-kesatu-list">
    @foreach ($penandatanganKesatu as $p)
        <option
            value="{{ $p->nama_penandatangan }}"
            data-jabatan="{{ $p->jabatan_penandatangan }}"
        >
            {{ $p->jabatan_penandatangan }}
        </option>
    @endforeach
</datalist>

                </div>


                <div>

                    <label class="label">
                        Jabatan
                    </label>

                    <input
    type="text"
    id="jabatan-penandatangan-kesatu"
    name="jabatan_penandatangan"
    value="{{ old('jabatan_penandatangan', 'Pengelola Gudang') }}"
    required
    class="input"
>

                </div>


                {{-- =========================
                     5. PIHAK KEDUA
                ========================== --}}
                <h3 class="font-semibold text-gray-900 pt-2">
                    ✍️ 5. Penandatanganan Pihak Kedua (Mitra Pengolahan)
                </h3>

                <div>

                    <label class="label">
                        Nama Penandatangan Pihak Kedua
                    </label>

                    <input
    type="text"
    name="nama_penandatangan_pihak_kedua"
    value="{{ old('nama_penandatangan_pihak_kedua') }}"
    list="penandatangan-kedua-list"
    required
    class="input"
    placeholder="Ketik atau pilih nama penandatangan mitra"
>

<datalist id="penandatangan-kedua-list">
    @foreach ($penandatanganKedua as $p)
        <option value="{{ $p->nama_penandatangan_pihak_kedua }}">
            {{ $p->jabatan_penandatangan_pihak_kedua }}
        </option>
    @endforeach
</datalist>

                </div>


                <div>

                    <label class="label">
                        Jabatan Pihak Kedua
                    </label>

                    <input
    type="text"
    id="jabatan-penandatangan-kedua"
    name="jabatan_penandatangan_pihak_kedua"
    value="{{ old('jabatan_penandatangan_pihak_kedua') }}"
    required
    class="input"
    placeholder="Masukkan jabatan"
/>

                </div>


                {{-- =========================
                     6. MENGETAHUI
                ========================== --}}
                <h3 class="font-semibold text-gray-900 pt-2">
                    👔 6. Mengetahui
                </h3>

                <div>

                    <label class="label">
                        Pimpinan Cabang BULOG
                    </label>

                    <select
                        name="pimpinan_cabang_id"
                        required
                        class="input"
                    >

                        <option value="">
                            Pilih Pimpinan Cabang
                        </option>

                        @foreach ($pimpinans as $p)

                            <option
                                value="{{ $p->id }}"
                                @selected(old('pimpinan_cabang_id') == $p->id)
                            >
                                {{ $p->nama }}
                            </option>

                        @endforeach

                    </select>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
         CATATAN
    ========================================================== --}}
    <div class="card p-6">

        


    {{-- =========================================================
         TOMBOL
    ========================================================== --}}
    <div class="flex items-center justify-between">

        <a
            href="{{ route('ba-rampung.index') }}"
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
                💾 Simpan Draft
            </button>

            <button
                type="submit"
                name="action"
                value="submit"
                class="btn-primary"
            >
                🖨️ Simpan &amp; Kirim Verifikasi
            </button>

        </div>

    </div>

</form>

@endsection

<script>
document.addEventListener('DOMContentLoaded', function () {

    const namaKedua = document.querySelector(
        'input[name="nama_penandatangan_pihak_kedua"]'
    );

    const jabatanKedua = document.getElementById(
        'jabatan-penandatangan-kedua'
    );

    const dataKedua = @json($penandatanganKedua);

    namaKedua.addEventListener('change', function () {
        const nama = this.value.trim();

        const data = dataKedua.find(item =>
            item.nama_penandatangan_pihak_kedua === nama
        );

        if (data) {
            jabatanKedua.value =
                data.jabatan_penandatangan_pihak_kedua;
        }
    });

});
</script>