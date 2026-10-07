@extends('layouts.app')

@section('title', 'Edit Mitra Pengolahan')

@section('content')

<style>
    .mitra-edit-page {
        color: #1e293b;
    }

    .mitra-edit-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        color: #1e293b;
        box-shadow: 0 10px 30px rgba(15, 23, 42, .06);
    }

    .mitra-edit-title {
        color: #0f172a;
        text-align: center;
    }

    .mitra-edit-header {
        width: 100%;
        text-align: center;
    }

    .mitra-edit-form {
        width: min(100%, 860px);
        margin-left: auto !important;
        margin-right: auto !important;
    }

    .mitra-edit-subtitle {
        color: #64748b;
    }

    .mitra-edit-label {
        color: #475569;
    }

    .mitra-edit-input {
        width: 100%;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        color: #1e293b;
        border-radius: 10px;
        padding: 10px 13px;
        outline: none;
        transition:
            border-color .2s ease,
            box-shadow .2s ease,
            background-color .2s ease;
    }

    .mitra-edit-input:focus {
        border-color: #F28C28;
        background: #ffffff;
        box-shadow: 0 0 0 3px rgba(242, 140, 40, .15);
    }

    .mitra-edit-input::placeholder {
        color: #94A3B8;
    }

    .mitra-edit-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 15px;
        border-radius: 10px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        color: #334155;
        font-size: 14px;
        font-weight: 600;
        transition: .2s ease;
    }

    .mitra-edit-back:hover {
        border-color: #123F7A;
        color: #123F7A;
        background: #f8fafc;
    }

    /* =========================================================
       DARK MODE
       PROJECT MENGGUNAKAN html.dark-theme
       ========================================================= */

    html.dark-theme .mitra-edit-page {
        color: #E5E7EB !important;
    }

    html.dark-theme .mitra-edit-card {
        background: #101C2D !important;
        border-color: #263B55 !important;
        color: #E5E7EB !important;
        box-shadow: 0 16px 40px rgba(0, 0, 0, .30) !important;
    }

    html.dark-theme .mitra-edit-title {
        color: #F8FAFC !important;
        text-align: center;
    }

    html.dark-theme .mitra-edit-header {
        text-align: center;
    }

    html.dark-theme .mitra-edit-subtitle,
    html.dark-theme .mitra-edit-label {
        color: #94A3B8 !important;
    }

    html.dark-theme .mitra-edit-input {
        background: #111D2E !important;
        border-color: #2B405A !important;
        color: #F8FAFC !important;
    }

    html.dark-theme .mitra-edit-input:focus {
        background: #0F1A2B !important;
        border-color: #F28C28 !important;
        color: #F8FAFC !important;
        box-shadow: 0 0 0 3px rgba(242, 140, 40, .20) !important;
    }

    html.dark-theme .mitra-edit-input::placeholder {
        color: #64748B !important;
    }

    html.dark-theme .mitra-edit-input option {
        background: #101C2D !important;
        color: #F8FAFC !important;
    }

    html.dark-theme .mitra-edit-back {
        background: #13263D !important;
        border-color: #2B405A !important;
        color: #F8FAFC !important;
    }

    html.dark-theme .mitra-edit-back:hover {
        background: #1A3150 !important;
        border-color: #60A5FA !important;
        color: #FFFFFF !important;
    }
</style>


<div class="mitra-edit-page">

    {{-- HEADER --}}
    <div class="mitra-edit-header mb-5">

        <h2 class="mitra-edit-title text-xl font-semibold">
            Edit Mitra Pengolahan
        </h2>

        <p class="mitra-edit-subtitle mt-1 text-sm">
            Perbarui informasi mitra pengolahan.
        </p>

    </div>


    {{-- FORM --}}
    <form
        method="POST"
        action="{{ route('mitra.update', $mitra) }}"
        class="mitra-edit-card mitra-edit-form rounded-2xl p-6 space-y-5"
    >

        @csrf
        @method('PUT')


        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

            {{-- KODE MITRA --}}
            <div>
                <label class="mitra-edit-label mb-2 block text-sm font-medium">
                    Kode Mitra
                </label>

                <input
                    type="text"
                    name="kode_mitra"
                    value="{{ old('kode_mitra', $mitra->kode_mitra) }}"
                    required
                    class="mitra-edit-input"
                >
            </div>


            {{-- NAMA MITRA --}}
            <div>
                <label class="mitra-edit-label mb-2 block text-sm font-medium">
                    Nama Mitra
                </label>

                <input
                    type="text"
                    name="nama_mitra"
                    value="{{ old('nama_mitra', $mitra->nama_mitra) }}"
                    required
                    class="mitra-edit-input"
                >
            </div>


            {{-- JENIS USAHA --}}
            <div>
                <label class="mitra-edit-label mb-2 block text-sm font-medium">
                    Jenis Usaha
                </label>

                <input
                    type="text"
                    name="jenis_usaha"
                    value="{{ old('jenis_usaha', $mitra->jenis_usaha) }}"
                    class="mitra-edit-input"
                >
            </div>


            {{-- PENANGGUNG JAWAB --}}
            <div>
                <label class="mitra-edit-label mb-2 block text-sm font-medium">
                    Penanggung Jawab
                </label>

                <input
                    type="text"
                    name="penanggung_jawab"
                    value="{{ old('penanggung_jawab', $mitra->penanggung_jawab) }}"
                    class="mitra-edit-input"
                >
            </div>


            {{-- ALAMAT --}}
            <div class="md:col-span-2">

                <label class="mitra-edit-label mb-2 block text-sm font-medium">
                    Alamat
                </label>

                <textarea
                    name="alamat"
                    rows="2"
                    class="mitra-edit-input"
                >{{ old('alamat', $mitra->alamat) }}</textarea>

            </div>


            {{-- KECAMATAN --}}
            <div>
                <label class="mitra-edit-label mb-2 block text-sm font-medium">
                    Kecamatan
                </label>

                <input
                    type="text"
                    name="kecamatan"
                    value="{{ old('kecamatan', $mitra->kecamatan) }}"
                    class="mitra-edit-input"
                >
            </div>


            {{-- DESA --}}
            <div>
                <label class="mitra-edit-label mb-2 block text-sm font-medium">
                    Desa
                </label>

                <input
                    type="text"
                    name="desa"
                    value="{{ old('desa', $mitra->desa) }}"
                    class="mitra-edit-input"
                >
            </div>


            {{-- TELEPON --}}
            <div>
                <label class="mitra-edit-label mb-2 block text-sm font-medium">
                    Nomor Telepon
                </label>

                <input
                    type="text"
                    name="nomor_telepon"
                    value="{{ old('nomor_telepon', $mitra->nomor_telepon) }}"
                    class="mitra-edit-input"
                >
            </div>


            {{-- EMAIL --}}
            <div>
                <label class="mitra-edit-label mb-2 block text-sm font-medium">
                    Email
                </label>

                <input
                    type="email"
                    name="email"
                    value="{{ old('email', $mitra->email) }}"
                    class="mitra-edit-input"
                >
            </div>


            {{-- STATUS --}}
            <div>
                <label class="mitra-edit-label mb-2 block text-sm font-medium">
                    Status
                </label>

                <select
                    name="status"
                    class="mitra-edit-input"
                >
                    <option
                        value="aktif"
                        @selected(old('status', $mitra->status) === 'aktif')
                    >
                        Aktif
                    </option>

                    <option
                        value="nonaktif"
                        @selected(old('status', $mitra->status) === 'nonaktif')
                    >
                        Nonaktif
                    </option>
                </select>
            </div>

        </div>


        {{-- ACTION --}}
        <div class="flex flex-col-reverse gap-3 pt-3 sm:flex-row sm:items-center sm:justify-between">

            <a
                href="{{ route('mitra.index') }}"
                class="mitra-edit-back"
            >
                <svg
                    class="h-4 w-4"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1.8"
                        d="M19 12H5m6-6-6 6 6 6"
                    />
                </svg>

                Kembali
            </a>


            <button
                type="submit"
                class="btn-primary"
            >
                Simpan Perubahan
            </button>

        </div>

    </form>

</div>

@endsection