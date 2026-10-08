@extends('layouts.app')

@section('title', 'Edit Data Pimpinan')

@section('content')

<style>
    /* =========================================================
       EDIT PIMPINAN CABANG
       ========================================================= */

    .pimpinan-edit-page {
        min-height: calc(100vh - 250px);
        padding-bottom: 40px;
        color: #1e293b;
    }

    /* =========================
       INFO ALERT
       ========================= */

    .pimpinan-edit-alert {
        width: 100%;
        max-width: 760px;
        margin: 0 auto 14px auto;
        padding: 14px 18px;
        border-radius: 16px;
        border: 1px solid #bfdbfe;
        background: #eff6ff;
        color: #1d4ed8;
        font-size: 13px;
        line-height: 1.6;
    }

    /* =========================
       FORM CARD
       ========================= */

    .pimpinan-edit-card {
        width: 100%;
        max-width: 760px;
        margin: 0 auto;
        padding: 28px 30px;
        border-radius: 18px;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        color: #1e293b;
        box-shadow: 0 12px 35px rgba(15, 23, 42, .08);
    }

    /* =========================
       LABEL
       ========================= */

    .pimpinan-edit-label {
        display: block;
        margin-bottom: 7px;
        color: #334155;
        font-size: 13px;
        font-weight: 600;
    }

    /* =========================
       INPUT
       ========================= */

    .pimpinan-edit-input {
        width: 100%;
        min-height: 42px;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        background: #ffffff;
        color: #1e293b;
        padding: 10px 13px;
        font-size: 13px;
        outline: none;
        transition:
            border-color .2s ease,
            box-shadow .2s ease,
            background-color .2s ease,
            color .2s ease;
    }

    .pimpinan-edit-input:focus {
        border-color: #F28C28;
        box-shadow: 0 0 0 3px rgba(242, 140, 40, .15);
    }

    .pimpinan-edit-input::placeholder {
        color: #94a3b8;
    }

    /* =========================
       BUTTON KEMBALI
       ========================= */

    .pimpinan-edit-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 16px;
        border-radius: 10px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        color: #334155;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        transition: all .2s ease;
    }

    .pimpinan-edit-back:hover {
        background: #f8fafc;
        border-color: #123F7A;
        color: #123F7A;
    }

    /* =========================================================
       DARK MODE
       PROJECT MENGGUNAKAN html.dark-theme
       ========================================================= */

    html.dark-theme .pimpinan-edit-page {
        color: #e5e7eb !important;
    }

    html.dark-theme .pimpinan-edit-alert {
        background: rgba(30, 64, 175, .18) !important;
        border-color: rgba(96, 165, 250, .30) !important;
        color: #bfdbfe !important;
    }

    html.dark-theme .pimpinan-edit-card {
        background: #101C2D !important;
        border-color: #263B55 !important;
        color: #e5e7eb !important;
        box-shadow: 0 18px 45px rgba(0, 0, 0, .30) !important;
    }

    html.dark-theme .pimpinan-edit-label {
        color: #cbd5e1 !important;
    }

    html.dark-theme .pimpinan-edit-input {
        background: #111D2E !important;
        border-color: #2B405A !important;
        color: #F8FAFC !important;
    }

    html.dark-theme .pimpinan-edit-input:focus {
        background: #0F1A2B !important;
        border-color: #F28C28 !important;
        color: #F8FAFC !important;
        box-shadow: 0 0 0 3px rgba(242, 140, 40, .20) !important;
    }

    html.dark-theme .pimpinan-edit-input::placeholder {
        color: #64748B !important;
    }

    html.dark-theme .pimpinan-edit-input option {
        background: #101C2D !important;
        color: #F8FAFC !important;
    }

    html.dark-theme .pimpinan-edit-back {
        background: #13263D !important;
        border-color: #2B405A !important;
        color: #F8FAFC !important;
    }

    html.dark-theme .pimpinan-edit-back:hover {
        background: #1A3150 !important;
        border-color: #60A5FA !important;
        color: #FFFFFF !important;
    }

    /* =========================
       PAGE HEADER
       ========================= */

    .pimpinan-edit-header {
        width: 100%;
        max-width: 760px;
        margin: 0 auto 22px auto;
        text-align: center;
    }

    .pimpinan-edit-eyebrow {
        margin-bottom: 5px;
        color: #dbeafe;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .28em;
        text-transform: uppercase;
    }

    .pimpinan-edit-title {
        margin: 0;
        font-family: Georgia, 'Times New Roman', serif;
        font-size: clamp(38px, 5vw, 52px);
        line-height: 1;
        font-weight: 500;
        color: #ffffff;
        text-shadow: 0 2px 12px rgba(0, 0, 0, .18);
    }

    .pimpinan-edit-title span {
        color: #F28C28;
    }

    .pimpinan-edit-subtitle {
        margin: 10px 0 0;
        color: rgba(255, 255, 255, .78);
        font-size: 13px;
    }

    html.dark-theme .pimpinan-edit-eyebrow {
        color: #cbd5e1 !important;
    }

    html.dark-theme .pimpinan-edit-title {
        color: #ffffff !important;
    }

    html.dark-theme .pimpinan-edit-subtitle {
        color: #cbd5e1 !important;
    }

    /* =========================
       RESPONSIVE
       ========================= */

    @media (max-width: 768px) {

        .pimpinan-edit-page {
            min-height: calc(100vh - 220px);
        }

        .pimpinan-edit-card {
            padding: 22px;
        }
    }
</style>


<div class="pimpinan-edit-page">

    {{-- PAGE HEADER --}}
    <div class="pimpinan-edit-header">
        <div class="pimpinan-edit-eyebrow">MASTER DATA</div>
        <h1 class="pimpinan-edit-title">
            Edit <span>Pimpinan</span>
        </h1>
        <p class="pimpinan-edit-subtitle">
            Perbarui informasi data pimpinan cabang.
        </p>
    </div>

    {{-- INFO --}}
    <div class="pimpinan-edit-alert">
        Jika Status diatur ke <strong>Aktif</strong>, seluruh riwayat
        Pimpinan Cabang lain akan otomatis ditutup periodenya
        (dijadikan Nonaktif).
    </div>


    {{-- FORM --}}
    <form
        method="POST"
        action="{{ route('pimpinan.update', $pimpinan) }}"
        class="pimpinan-edit-card"
    >

        @csrf
        @method('PUT')


        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

            {{-- NAMA --}}
            <div class="md:col-span-2">

                <label class="pimpinan-edit-label">
                    Nama
                </label>

                <input
                    type="text"
                    name="nama"
                    value="{{ old('nama', $pimpinan->nama) }}"
                    required
                    class="pimpinan-edit-input"
                >

            </div>


            {{-- JABATAN --}}
            <div class="md:col-span-2">

                <label class="pimpinan-edit-label">
                    Jabatan
                </label>

                <input
                    type="text"
                    name="jabatan"
                    value="{{ old('jabatan', $pimpinan->jabatan) }}"
                    required
                    class="pimpinan-edit-input"
                >

            </div>


            {{-- PERIODE MULAI --}}
            <div>

                <label class="pimpinan-edit-label">
                    Periode Mulai
                </label>

                <input
                    type="date"
                    name="periode_mulai"
                    value="{{ old('periode_mulai', $pimpinan->periode_mulai->toDateString()) }}"
                    required
                    class="pimpinan-edit-input"
                >

            </div>


            {{-- PERIODE SELESAI --}}
            <div>

                <label class="pimpinan-edit-label">
                    Periode Selesai (opsional)
                </label>

                <input
                    type="date"
                    name="periode_selesai"
                    value="{{ old('periode_selesai', $pimpinan->periode_selesai?->toDateString()) }}"
                    class="pimpinan-edit-input"
                >

            </div>


            {{-- EMAIL --}}
            <div>

                <label class="pimpinan-edit-label">
                    Email
                </label>

                <input
                    type="email"
                    name="email"
                    value="{{ old('email', $pimpinan->email) }}"
                    class="pimpinan-edit-input"
                >

            </div>


            {{-- TELEPON --}}
            <div>

                <label class="pimpinan-edit-label">
                    Nomor Telepon
                </label>

                <input
                    type="text"
                    name="nomor_telepon"
                    value="{{ old('nomor_telepon', $pimpinan->nomor_telepon) }}"
                    class="pimpinan-edit-input"
                >

            </div>


            {{-- ALAMAT --}}
            <div class="md:col-span-2">

                <label class="pimpinan-edit-label">
                    Alamat Kantor
                </label>

                <textarea
                    name="alamat"
                    rows="3"
                    class="pimpinan-edit-input"
                >{{ old('alamat', $pimpinan->alamat) }}</textarea>

            </div>


            {{-- STATUS --}}
            <div>

                <label class="pimpinan-edit-label">
                    Status
                </label>

                <select
                    name="status"
                    class="pimpinan-edit-input"
                >

                    <option
                        value="nonaktif"
                        @selected(old('status', $pimpinan->status) === 'nonaktif')
                    >
                        Nonaktif (riwayat)
                    </option>

                    <option
                        value="aktif"
                        @selected(old('status', $pimpinan->status) === 'aktif')
                    >
                        Aktif (menjabat sekarang)
                    </option>

                </select>

            </div>

        </div>


        {{-- ACTION --}}
        <div class="mt-6 flex items-center justify-between gap-3">

            <a
                href="{{ route('pimpinan.index') }}"
                class="pimpinan-edit-back"
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
                💾 Simpan Perubahan
            </button>

        </div>

    </form>

</div>

@endsection