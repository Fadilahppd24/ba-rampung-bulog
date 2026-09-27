@extends('layouts.app')

@section('title', 'Buat BA Rampung')

@section('content')

<div class="space-y-6">

    {{-- =========================================================
         FONT & STYLE HERO
         Sama persis dengan Dashboard & Daftar BA Rampung
         (dashboard-kicker / dashboard-display). Tidak mengubah logic.
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
         HERO / HEADER HALAMAN
    ========================================================== --}}
    <div class="flex flex-col gap-4 pt-2 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="dashboard-kicker text-white/75">
                Sistem BA Rampung
            </p>

            <h1 class="dashboard-display mt-2 text-4xl leading-tight text-white sm:text-5xl">
                Tambah <span class="text-[#F28C28]">BA Rampung</span>
            </h1>

            <p class="mt-2 text-sm text-white/85" style="text-shadow: 0 1px 8px rgba(3, 28, 55, .2);">
                Lengkapi informasi berikut untuk membuat BA Rampung baru.
            </p>
        </div>

        <a
            href="{{ route('ba-rampung.index') }}"
            class="inline-flex items-center justify-center gap-2 rounded-full bg-white px-5 py-3 text-sm font-bold text-[#123F7A] shadow-lg transition hover:-translate-y-0.5 hover:bg-slate-50"
        >
            ← Kembali ke Daftar BA
        </a>
    </div>


    {{-- =========================================================
         FORM
         action, method, x-data, @csrf, name attribute, validasi
         SEMUA DIPERTAHANKAN PERSIS SEPERTI SEBELUMNYA.
    ========================================================== --}}
    <form
        method="POST"
        action="{{ route('ba-rampung.store') }}"
        x-data="baForm({ gabah: {{ old('kuantum_gabah', 0) }}, beras: {{ old('kuantum_beras', 0) }}, menir: {{ old('kuantum_menir', 0) }}, bekatul: {{ old('kuantum_bekatul', 0) }}, tanggal: '{{ old('tanggal_ba', now()->toDateString()) }}' })"
        class="space-y-6"
    >
        @csrf

        {{-- =========================================================
             SECTION 01 — DATA BA RAMPUNG
        ========================================================== --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">

            <div class="mb-6 flex items-center gap-3">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#123F7A] text-base font-bold text-white">
                    01
                </div>
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-xl">
                    📄
                </div>
                <div>
                    <h3 class="text-base font-bold text-gray-900">
                        Data BA Rampung
                    </h3>
                    <p class="text-xs text-gray-500">
                        Informasi dasar BA Rampung.
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

                <div>
                    <label class="label">Nomor BA (Otomatis)</label>

                    <div class="relative">
                        <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-gray-400">📄</span>
                        <input
                            type="text"
                            disabled
                            value="Akan dibuat otomatis setelah disimpan"
                            class="input bg-gray-50 pl-10 text-xs italic text-gray-400"
                        >
                    </div>
                </div>

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
                        <div class="relative">
                            <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-gray-400 text-sm">📅</span>
                            <input
                                type="date"
                                name="tanggal_ba"
                                x-model="tanggal"
                                required
                                class="input pl-9"
                            >
                        </div>
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

                <div>
                    <label class="label">Nomor Manufacturing Order (MO)</label>
                    <input
                        type="text"
                        name="nomor_mo"
                        value="{{ old('nomor_mo') }}"
                        required
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
                        required
                        class="input"
                        placeholder="Masukkan nomor PO"
                    >
                </div>

            </div>
        </div>


        {{-- =========================================================
             SECTION 02 — PENGOLAHAN GABAH (GKP) MENJADI HGL
             Semua name attribute, x-model, dan rendemen(x-text)
             PERSIS seperti sebelumnya. Hanya tampilan yang diubah.
        ========================================================== --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">

            <div class="mb-6 flex items-center gap-3">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#123F7A] text-base font-bold text-white">
                    02
                </div>
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-xl">
                    🌾
                </div>
                <div>
                    <h3 class="text-base font-bold text-gray-900">
                        Pengolahan Gabah (GKP) menjadi Beras Hasil Giling (HGL)
                    </h3>
                    <p class="text-xs text-gray-500">
                        Masukkan data hasil pengolahan. Rendemen (%) dihitung otomatis oleh sistem.
                    </p>
                </div>
            </div>

            {{-- ALUR GKP -> PROSES --}}
            <div class="flex flex-col items-stretch gap-3 lg:flex-row lg:items-center lg:gap-4">

                <div class="rounded-2xl border border-amber-100 bg-amber-50/60 p-5 text-center lg:w-52">
                    <div class="mx-auto mb-2 flex h-12 w-12 items-center justify-center rounded-full bg-white text-2xl shadow-sm">
                        🌾
                    </div>
                    <p class="text-sm font-bold text-gray-800">
                        Gabah (GKP)
                    </p>
                    <div class="relative mt-3">
                        <input
                            type="number"
                            step="0.01"
                            min="0.01"
                            name="kuantum_gabah"
                            x-model.number="gabah"
                            required
                            class="input pr-10 text-center"
                            placeholder="0"
                        >
                        <span class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-xs text-gray-400">kg</span>
                    </div>
                </div>

                <div class="flex justify-center text-2xl text-slate-300">
                    <span class="lg:hidden">↓</span>
                    <span class="hidden lg:inline">→</span>
                </div>

                <div class="rounded-2xl border border-blue-100 bg-blue-50/60 p-5 text-center lg:w-52">
                    <div class="mx-auto mb-2 flex h-12 w-12 items-center justify-center rounded-full bg-white text-2xl shadow-sm">
                        ⚙️
                    </div>
                    <p class="text-sm font-bold leading-snug text-[#123F7A]">
                        Proses<br>Pengolahan
                    </p>
                </div>

                <div class="flex justify-center text-2xl text-slate-300">
                    <span class="lg:hidden">↓</span>
                    <span class="hidden lg:inline">→</span>
                </div>

                {{-- OUTPUT: BERAS / MENIR / BEKATUL --}}
                <div class="flex-1 space-y-3">

                    <div class="flex flex-wrap items-center gap-3 rounded-xl border border-slate-100 bg-slate-50/70 p-3">
                        <span class="text-lg">🍚</span>
                        <span class="w-24 shrink-0 text-sm font-semibold text-gray-700">Beras (HGL)</span>
                        <div class="relative min-w-[120px] flex-1">
                            <input
                                type="number"
                                step="0.01"
                                min="0"
                                name="kuantum_beras"
                                x-model.number="beras"
                                required
                                class="input py-2 pr-10"
                                placeholder="0"
                            >
                            <span class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-xs text-gray-400">kg</span>
                        </div>
                        <span
                            class="w-24 shrink-0 rounded-lg bg-emerald-50 px-2 py-1.5 text-center text-xs font-bold text-emerald-700"
                            x-text="'Rendemen ' + rendemen(beras) + '%'"
                        ></span>
                    </div>

                    <div class="flex flex-wrap items-center gap-3 rounded-xl border border-slate-100 bg-slate-50/70 p-3">
                        <span class="text-lg">🌰</span>
                        <span class="w-24 shrink-0 text-sm font-semibold text-gray-700">Menir</span>
                        <div class="relative min-w-[120px] flex-1">
                            <input
                                type="number"
                                step="0.01"
                                min="0"
                                name="kuantum_menir"
                                x-model.number="menir"
                                class="input py-2 pr-10"
                                placeholder="0"
                            >
                            <span class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-xs text-gray-400">kg</span>
                        </div>
                        <span
                            class="w-24 shrink-0 rounded-lg bg-amber-50 px-2 py-1.5 text-center text-xs font-bold text-amber-700"
                            x-text="'Rendemen ' + rendemen(menir) + '%'"
                        ></span>
                    </div>

                    <div class="flex flex-wrap items-center gap-3 rounded-xl border border-slate-100 bg-slate-50/70 p-3">
                        <span class="text-lg">🟤</span>
                        <span class="w-24 shrink-0 text-sm font-semibold text-gray-700">Bekatul</span>
                        <div class="relative min-w-[120px] flex-1">
                            <input
                                type="number"
                                step="0.01"
                                min="0"
                                name="kuantum_bekatul"
                                x-model.number="bekatul"
                                class="input py-2 pr-10"
                                placeholder="0"
                            >
                            <span class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-xs text-gray-400">kg</span>
                        </div>
                        <span
                            class="w-24 shrink-0 rounded-lg bg-orange-50 px-2 py-1.5 text-center text-xs font-bold text-orange-700"
                            x-text="'Rendemen ' + rendemen(bekatul) + '%'"
                        ></span>
                    </div>

                </div>

            </div>

            {{-- INFORMASI --}}
            <div class="mt-6 flex gap-3 rounded-xl border border-blue-100 bg-blue-50/60 p-4">
                <span class="text-lg">ℹ️</span>
                <ul class="list-disc space-y-1 pl-4 text-xs leading-relaxed text-slate-600">
                    <li>Masukkan berat hasil pengolahan dalam satuan kilogram (kg).</li>
                    <li>Nilai rendemen (%) di atas hanya pratinjau di sisi browser — nilai final selalu dihitung ulang oleh server saat disimpan.</li>
                    <li>Pastikan data yang dimasukkan sudah sesuai dengan hasil penimbangan aktual.</li>
                </ul>
            </div>

        </div>


        {{-- =========================================================
             SECTION 03 — INFORMASI GUDANG & MITRA
        ========================================================== --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">

            <div class="mb-6 flex items-center gap-3">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#123F7A] text-base font-bold text-white">
                    03
                </div>
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-xl">
                    🤝
                </div>
                <div>
                    <h3 class="text-base font-bold text-gray-900">
                        Informasi Gudang &amp; Mitra
                    </h3>
                    <p class="text-xs text-gray-500">
                        Pilih gudang dan mitra pengolahan yang terkait dengan BA Rampung ini.
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

                <div>
                    <label class="label">Gudang</label>

                    <div class="relative">
                        <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-gray-400">🏠</span>
                        <select
                            name="gudang_id"
                            required
                            class="input appearance-none pl-10"
                        >
                            <option value="">Pilih Gudang</option>

                            @foreach ($gudangs as $g)
                                <option
                                    value="{{ $g->id }}"
                                    @selected(old('gudang_id') == $g->id)
                                >
                                    {{ $g->nama_gudang }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label class="label">Mitra Pengolahan</label>

                    <div class="relative">
                        <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-gray-400">🤝</span>
                        <select
                            name="mitra_pengolahan_id"
                            required
                            class="input appearance-none pl-10"
                        >
                            <option value="">Pilih Mitra Pengolahan</option>

                            @foreach ($mitras as $m)
                                <option
                                    value="{{ $m->id }}"
                                    @selected(old('mitra_pengolahan_id') == $m->id)
                                >
                                    {{ $m->nama_mitra }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

            </div>
        </div>


        {{-- =========================================================
             SECTION 04 — PENANDATANGANAN & VERIFIKASI
             Field ini tidak ada di mockup, tapi TETAP DIPERTAHANKAN
             sesuai instruksi (tidak boleh menghapus field existing).
             Catatan: duplikat input "Nama Penandatangan" pada file
             lama (dua input dengan name yang sama) digabung jadi
             satu field bersih — tidak ada name/value yang hilang.
        ========================================================== --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">

            <div class="mb-6 flex items-center gap-3">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#123F7A] text-base font-bold text-white">
                    04
                </div>
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-xl">
                    ✍️
                </div>
                <div>
                    <h3 class="text-base font-bold text-gray-900">
                        Penandatanganan &amp; Verifikasi
                    </h3>
                    <p class="text-xs text-gray-500">
                        Penandatangan Pihak Gudang dan pimpinan cabang yang mengetahui.
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

                <div>
                    <label class="label">Nama Penandatangan</label>
                    <input
                        list="pegawai-list"
                        type="text"
                        name="nama_penandatangan"
                        value="{{ old('nama_penandatangan') }}"
                        required
                        class="input"
                        placeholder="Pilih atau ketik nama pegawai"
                    >
                </div>

                <div>
                    <label class="label">Jabatan</label>
                    <input
                        type="text"
                        name="jabatan_penandatangan"
                        value="{{ old('jabatan_penandatangan', 'Pengelola Gudang') }}"
                        required
                        class="input"
                    >
                </div>

                <div class="md:col-span-2">
                    <label class="label">Pimpinan Cabang BULOG (Mengetahui)</label>

                    <div class="relative">
                        <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-gray-400">👔</span>
                        <select
                            name="pimpinan_cabang_id"
                            required
                            class="input appearance-none pl-10"
                        >
                            <option value="">Pilih Pimpinan Cabang</option>

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
             CATATAN (OPSIONAL)
        ========================================================== --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
            <label class="label">Catatan (opsional)</label>
            <textarea
                name="catatan"
                rows="2"
                class="input"
            >{{ old('catatan') }}</textarea>
        </div>


        {{-- =========================================================
             ACTION BAR
             name="action" value="draft"/"submit" DIPERTAHANKAN PERSIS
             (fungsi Simpan Draft & Simpan+Kirim Verifikasi existing).
        ========================================================== --}}
        <div class="flex flex-col-reverse gap-3 pb-2 sm:flex-row sm:items-center sm:justify-between">

            <a
                href="{{ route('ba-rampung.index') }}"
                class="inline-flex items-center justify-center gap-2 rounded-xl border border-[#123F7A] bg-white px-5 py-3 text-sm font-bold text-[#123F7A] transition hover:bg-blue-50"
            >
                ✕ Batal
            </a>

            <div class="flex flex-col gap-3 sm:flex-row">

                <button
                    type="submit"
                    name="action"
                    value="draft"
                    class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-600 transition hover:bg-slate-50"
                >
                    💾 Simpan Draft
                </button>

                <button
                    type="submit"
                    name="action"
                    value="submit"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#123F7A] px-5 py-3 text-sm font-bold text-white shadow-lg transition hover:-translate-y-0.5 hover:bg-[#0d3263]"
                >
                    ✓ Simpan BA Rampung
                </button>

            </div>

        </div>

    </form>

</div>

@endsection