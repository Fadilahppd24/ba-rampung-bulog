@extends('layouts.app')

@section('title', 'Edit User')

@section('content')

<style>
    /* =========================================================
       EDIT USER
    ========================================================= */

    .user-edit-page {
        --ue-card: rgba(255,255,255,.96);
        --ue-border: rgba(15,42,74,.10);

        --ue-title: #0B2545;
        --ue-text: #334155;
        --ue-muted: #64748B;

        --ue-input-bg: #FFFFFF;
        --ue-input-border: #CBD5E1;
        --ue-input-text: #334155;

        --ue-navy: #123F7A;
        --ue-navy-dark: #0D315F;

        --ue-orange: #F28C28;

        --ue-shadow:
            0 18px 45px rgba(15,42,74,.10);
    }

    /* =========================================================
       CARD
    ========================================================= */

    .user-edit-page .ue-card {
        border: 1px solid var(--ue-border);
        border-radius: 24px;

        background: var(--ue-card);

        box-shadow: var(--ue-shadow);

        padding: 28px;
    }

    /* =========================================================
       BACK
    ========================================================= */

    .user-edit-page .ue-back {
        display: inline-flex;
        align-items: center;
        gap: 7px;

        margin-bottom: 18px;

        color: var(--ue-muted);

        font-size: 13px;
        font-weight: 700;

        transition: .2s ease;
    }

    .user-edit-page .ue-back:hover {
        color: var(--ue-navy);
        transform: translateX(-2px);
    }

    /* =========================================================
       TITLE
    ========================================================= */

    .user-edit-page .ue-title {
        color: var(--ue-title);

        font-size: 23px;
        font-weight: 800;
        letter-spacing: -.02em;
    }

    .user-edit-page .ue-subtitle {
        margin-top: 5px;

        color: var(--ue-muted);

        font-size: 13px;
    }

    /* =========================================================
       LABEL
    ========================================================= */

    .user-edit-page .ue-label {
        display: block;

        margin-bottom: 8px;

        color: var(--ue-title);

        font-size: 13px;
        font-weight: 700;
    }

    /* =========================================================
       INPUT / SELECT
    ========================================================= */

    .user-edit-page .ue-input {
        width: 100%;

        min-height: 46px;

        border: 1px solid var(--ue-input-border);
        border-radius: 12px;

        padding: 0 14px;

        background: var(--ue-input-bg) !important;

        color: var(--ue-input-text) !important;

        font-size: 13px;

        outline: none;

        transition: .2s ease;
    }

    .user-edit-page .ue-input::placeholder {
        color: #94A3B8 !important;
    }

    .user-edit-page .ue-input:focus {
        border-color: rgba(242,140,40,.65) !important;

        box-shadow:
            0 0 0 4px rgba(242,140,40,.10);

        outline: none;
    }

    .user-edit-page .ue-input option {
        background: #FFFFFF;
        color: #334155;
    }

    .user-edit-page .ue-help {
        margin-top: 6px;

        color: var(--ue-muted);

        font-size: 11px;
    }

    /* =========================================================
       ERROR
    ========================================================= */

    .user-edit-page .ue-error {
        margin-bottom: 20px;

        border: 1px solid rgba(239,68,68,.18);
        border-radius: 14px;

        padding: 13px 16px;

        background: rgba(239,68,68,.07);

        color: #B91C1C;

        font-size: 13px;
    }

    /* =========================================================
       FORM FOOTER
    ========================================================= */

    .user-edit-page .ue-form-footer {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 10px;

        margin-top: 26px;

        padding-top: 20px;

        border-top: 1px solid var(--ue-border);
    }

    .user-edit-page .ue-cancel {
        display: inline-flex;
        align-items: center;
        justify-content: center;

        min-height: 42px;

        border: 1px solid #CBD5E1;
        border-radius: 11px;

        padding: 0 17px;

        background: #FFFFFF;

        color: #475569;

        font-size: 12px;
        font-weight: 700;

        transition: .2s ease;
    }

    .user-edit-page .ue-cancel:hover {
        background: #F8FAFC;
        border-color: #94A3B8;
    }

    .user-edit-page .ue-save {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;

        min-height: 42px;

        border: 0;
        border-radius: 11px;

        padding: 0 19px;

        background:
            linear-gradient(
                135deg,
                #123F7A,
                #0D315F
            );

        color: #FFFFFF;

        font-size: 12px;
        font-weight: 800;

        box-shadow:
            0 7px 18px rgba(18,63,122,.20);

        transition: .2s ease;
    }

    .user-edit-page .ue-save:hover {
        transform: translateY(-1px);

        box-shadow:
            0 10px 22px rgba(18,63,122,.27);
    }

    /* =========================================================
       DARK MODE
    ========================================================= */

    html.dark-theme .user-edit-page {
        --ue-card: rgba(8,27,48,.94);
        --ue-border: rgba(148,163,184,.13);

        --ue-title: #F1F5F9;
        --ue-text: #D5DFEA;
        --ue-muted: #93A6BB;

        --ue-input-bg: rgba(4,20,36,.88);
        --ue-input-border: rgba(148,163,184,.24);
        --ue-input-text: #E7EEF7;
    }

    html.dark-theme .user-edit-page .ue-card {
        background:
            linear-gradient(
                135deg,
                rgba(10,34,59,.96),
                rgba(7,25,44,.94)
            );

        border-color: rgba(255,255,255,.08);

        box-shadow:
            0 22px 55px rgba(0,0,0,.25);
    }

    html.dark-theme .user-edit-page .ue-back {
        color: #93A6BB;
    }

    html.dark-theme .user-edit-page .ue-back:hover {
        color: #FFB454;
    }

    html.dark-theme .user-edit-page .ue-input {
        background: rgba(4,20,36,.88) !important;
        color: #E7EEF7 !important;

        border-color: rgba(148,163,184,.24) !important;
    }

    html.dark-theme .user-edit-page .ue-input option {
        background: #0B2949;
        color: #E7EEF7;
    }

    html.dark-theme .user-edit-page .ue-cancel {
        border-color: rgba(148,163,184,.24);

        background: rgba(255,255,255,.04);

        color: #CBD5E1;
    }

    html.dark-theme .user-edit-page .ue-cancel:hover {
        background: rgba(148,163,184,.10);
    }

    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media (max-width: 768px) {

        .user-edit-page .ue-card {
            padding: 20px;
            border-radius: 18px;
        }

        .user-edit-page .ue-form-footer {
            flex-direction: column-reverse;
        }

        .user-edit-page .ue-cancel,
        .user-edit-page .ue-save {
            width: 100%;
        }
    }
</style>


<div class="user-edit-page">

    <div class="ue-card">

        {{-- KEMBALI --}}
        <a
            href="{{ route('pengaturan.users.index') }}"
            class="ue-back"
        >
            <svg
                width="16"
                height="16"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
            >
                <path d="M19 12H5"/>
                <path d="M12 19l-7-7 7-7"/>
            </svg>

            Kembali ke Manajemen User
        </a>


        {{-- HEADER --}}
        <div class="mb-6">

            <h1 class="ue-title">
                Edit User
            </h1>

            <p class="ue-subtitle">
                Perbarui akun {{ $user->name }}.
            </p>

        </div>


        {{-- ERROR --}}
        @if($errors->any())

            <div class="ue-error">

                <ul class="list-disc space-y-1 pl-5">

                    @foreach($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

        @endif


        {{-- FORM UTAMA --}}
        <form
            method="POST"
            action="{{ route('pengaturan.users.update', $user) }}"
            id="user-form"
        >

            @csrf

            @method('PUT')


            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

                {{-- NAMA --}}
                <div>

                    <label class="ue-label">
                        Nama
                    </label>

                    <input
                        type="text"
                        name="name"
                        value="{{ old('name', $user->name ?? '') }}"
                        class="ue-input"
                        required
                    >

                </div>


                {{-- EMAIL --}}
                <div>

                    <label class="ue-label">
                        Email
                    </label>

                    <input
                        type="email"
                        name="email"
                        value="{{ old('email', $user->email ?? '') }}"
                        class="ue-input"
                        required
                    >

                </div>


                {{-- ROLE --}}
                <div>

                    <label class="ue-label">
                        Role
                    </label>

                    <select
                        name="role"
                        id="role"
                        class="ue-input"
                        required
                    >

                        <option value="">
                            Pilih Role
                        </option>

                        <option
                            value="admin_kantor"
                            @selected(old('role', $user->role ?? '') === 'admin_kantor')
                        >
                            Admin Kantor
                        </option>

                        <option
                            value="admin_gudang"
                            @selected(old('role', $user->role ?? '') === 'admin_gudang')
                        >
                            Admin Gudang
                        </option>

                    </select>

                </div>


                {{-- GUDANG INDUK --}}
                <div id="gudang-wrapper">

                    <label class="ue-label">
                        Gudang Induk
                    </label>

                    <select
                        name="gudang_id"
                        id="gudang_id"
                        class="ue-input"
                    >

                        <option value="">
                            Pilih Gudang Induk
                        </option>

                        @foreach($gudangs as $gudang)

                            <option
                                value="{{ $gudang->id }}"
                                @selected(
                                    (string) old(
                                        'gudang_id',
                                        $user->gudang_id ?? ''
                                    ) === (string) $gudang->id
                                )
                            >
                                {{ $gudang->kode_gudang }}
                                —
                                {{ $gudang->nama_gudang }}
                            </option>

                        @endforeach

                    </select>

                    <p class="ue-help">
                        Hanya Gudang Induk yang aktif. Filial tidak memiliki akun.
                    </p>

                </div>


                {{-- PASSWORD BARU --}}
                <div>

                    <label class="ue-label">
                        Password Baru (opsional)
                    </label>

                    <input
                        type="password"
                        name="password"
                        class="ue-input"
                        autocomplete="new-password"
                    >

                    <p class="ue-help">
                        Kosongkan jika password tidak ingin diubah.
                    </p>

                </div>


                {{-- KONFIRMASI PASSWORD --}}
                <div>

                    <label class="ue-label">
                        Konfirmasi Password
                    </label>

                    <input
                        type="password"
                        name="password_confirmation"
                        class="ue-input"
                        autocomplete="new-password"
                    >

                </div>


                {{-- STATUS --}}
                <div>

                    <label class="ue-label">
                        Status
                    </label>

                    <select
                        name="is_active"
                        class="ue-input"
                        required
                    >

                        <option
                            value="1"
                            @selected(
                                (string) old(
                                    'is_active',
                                    isset($user)
                                        ? (int) $user->is_active
                                        : 1
                                ) === '1'
                            )
                        >
                            Aktif
                        </option>

                        <option
                            value="0"
                            @selected(
                                (string) old(
                                    'is_active',
                                    isset($user)
                                        ? (int) $user->is_active
                                        : 1
                                ) === '0'
                            )
                        >
                            Nonaktif
                        </option>

                    </select>

                </div>

            </div>


            {{-- BUTTON --}}
            <div class="ue-form-footer">

                <a
                    href="{{ route('pengaturan.users.index') }}"
                    class="ue-cancel"
                >
                    Batal
                </a>

                <button
                    type="submit"
                    class="ue-save"
                >

                    <svg
                        width="15"
                        height="15"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <path d="M19 21H5a2 2 0 0 1 2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2Z"/>
                        <path d="M17 21v-8H7v8"/>
                        <path d="M7 3v5h8"/>
                    </svg>

                    Simpan Perubahan

                </button>

            </div>

        </form>

    </div>

</div>

@endsection