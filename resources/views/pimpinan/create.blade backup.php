@extends('layouts.app')

@section('title', 'Tambah Riwayat Pimpinan Cabang')

@section('content')

<style>
    /* =========================================================
       TAMBAH PIMPINAN CABANG
       ========================================================= */

    .pimpinan-create-page {
        min-height: calc(100vh - 250px);
        padding-bottom: 40px;
        color: #1e293b;
    }

    /* =========================
       ALERT
       ========================= */

    .pimpinan-create-alert {
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

    .pimpinan-create-card {
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

    .pimpinan-create-label {
        display: block;
        margin-bottom: 7px;
        color: #334155;
        font-size: 13px;
        font-weight: 600;
    }

    /* =========================
       INPUT
       ========================= */

    .pimpinan-create-input {
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

    .pimpinan-create-input:focus {
        border-color: #F28C28;
        box-shadow: 0 0 0 3px rgba(242, 140, 40, .15);
    }

    .pimpinan-create-input::placeholder {
        color: #94a3b8;
    }

    /* =========================
       BUTTON KEMBALI
       ========================= */

    .pimpinan-create-back {
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

    .pimpinan-create-back:hover {
        background: #f8fafc;
        border-color: #123F7A;
        color: #123F7A;
    }

    /* =========================================================
       DARK MODE
       ========================================================= */

    html.dark-theme .pimpinan-create-page {
        color: #e5e7eb !important;
    }

    html.dark-theme .pimpinan-create-alert {
        background: rgba(30, 64, 175, .18) !important;
        border-color: rgba(96, 165, 250, .30) !important;
        color: #bfdbfe !important;
    }

    html.dark-theme .pimpinan-create-card {
        background: #101C2D !important;
        border-color: #263B55 !important;
        color: #e5e7eb !important;
        box-shadow: 0 18px 45px rgba(0, 0, 0, .30) !important;
    }

    html.dark-theme .pimpinan-create-label {
        color: #cbd5e1 !important;
    }

    html.dark-theme .pimpinan-create-input {
        background: #111D2E !important;
        border-color: #2B405A !important;
        color: #F8FAFC !important;
    }

    html.dark-theme .pimpinan-create-input:focus {
        background: #0F1A2B !important;
        border-color: #F28C28 !important;
        color: #F8FAFC !important;
        box-shadow: 0 0 0 3px rgba(242, 140, 40, .20) !important;
    }

    html.dark-theme .pimpinan-create-input::placeholder {
        color: #64748B !important;
    }

    html.dark-theme .pimpinan-create-input option {
        background: #101C2D !important;
        color: #F8FAFC !important;
    }

    html.dark-theme .pimpinan-create-back {
        background: #13263D !important;
        border-color: #2B405A !important;
        color: #F8FAFC !important;
    }

    html.dark-theme .pimpinan-create-back:hover {
        background: #1A3150 !important;
        border-color: #60A5FA !important;
        color: #FFFFFF !important;
    }

    /* =========================
       RESPONSIVE
       ========================= */

    @media (max-width: 768px) {

        .pimpinan-create-page {
            min-height: calc(100vh - 220px);
        }

        .pimpinan-create-card {
            padding: 22px;
        }
    }
</style>


<div class="pimpinan-create-page">

    {{-- INFO --}}
    <div class="pimpinan-create-alert">
        Jika Status diatur ke <strong>Aktif</strong>, seluruh riwayat
        Pimpinan Cabang lain akan otomatis ditutup periodenya
        (dijadikan Nonaktif) — hanya boleh ada satu Pimpinan Cabang
        aktif pada satu waktu, karena data ini dipakai sebagai
        penandatangan "Mengetahui" pada setiap BA Rampung.
    </div>


    {{-- FORM --}}
    <form
        method="POST"
        action="{{ route('pimpinan.store') }}"
        class="pimpinan-create-card"
    >

        @csrf


        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

            {{-- NAMA --}}
            <div class="md:col-span-2">

                <label class="pimpinan-create-label">
                    Nama
                </label>

                <input
                    type="text"
                    name="nama"
                    value="{{ old('nama') }}"
                    required
                    class="pimpinan-create-input"
                >

            </div>


            {{-- JABATAN --}}
            <div class="md:col-span-2">

                <label class="pimpinan-create-label">
                    Jabatan
                </label>

                <input
                    type="text"
                    name="jabatan"
                    value="{{ old('jabatan', 'Pimpinan Cabang BULOG Indramayu') }}"
                    required
                    class="pimpinan-create-input"
                >

            </div>


            {{-- PERIODE MULAI --}}
            <div>

                <label class="pimpinan-create-label">
                    Periode Mulai
                </label>

                <input
                    type="date"
                    name="periode_mulai"
                    value="{{ old('periode_mulai', now()->toDateString()) }}"
                    required
                    class="pimpinan-create-input"
                >

            </div>


            {{-- PERIODE SELESAI --}}
            <div>

                <label class="pimpinan-create-label">
                    Periode Selesai (opsional)
                </label>

                <input
                    type="date"
                    name="periode_selesai"
                    value="{{ old('periode_selesai') }}"
                    class="pimpinan-create-input"
                >

            </div>


            {{-- EMAIL --}}
            <div>

                <label class="pimpinan-create-label">
                    Email
                </label>

                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    class="pimpinan-create-input"
                >

            </div>


            {{-- NOMOR TELEPON --}}
            <div>

                <label class="pimpinan-create-label">
                    Nomor Telepon
                </label>

                <input
                    type="text"
                    name="nomor_telepon"
                    value="{{ old('nomor_telepon') }}"
                    class="pimpinan-create-input"
                >

            </div>


            {{-- ALAMAT --}}
            <div class="md:col-span-2">

                <label class="pimpinan-create-label">
                    Alamat Kantor
                </label>

                <textarea
                    name="alamat"
                    rows="3"
                    class="pimpinan-create-input"
                >{{ old('alamat') }}</textarea>

            </div>


            {{-- STATUS --}}
            <div>

                <label class="pimpinan-create-label">
                    Status
                </label>

                <select
                    name="status"
                    class="pimpinan-create-input"
                >

                    <option
                        value="nonaktif"
                        @selected(old('status', 'nonaktif') === 'nonaktif')
                    >
                        Nonaktif (riwayat)
                    </option>

                    <option
                        value="aktif"
                        @selected(old('status') === 'aktif')
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
                class="pimpinan-create-back"
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
                💾 Simpan
            </button>

        </div>

    </form>

</div>

@endsection