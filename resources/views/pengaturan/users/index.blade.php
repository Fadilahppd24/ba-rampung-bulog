@extends('layouts.app')

@section('title', 'Manajemen User')

@section('content')

<style>
    /* =========================================================
       MANAJEMEN USER
       Hanya visual halaman ini.
    ========================================================= */

    .user-management-page {
        --um-card: rgba(255, 255, 255, .94);
        --um-card-soft: rgba(248, 250, 252, .92);
        --um-border: rgba(15, 42, 74, .10);
        --um-border-strong: rgba(15, 42, 74, .16);

        --um-title: #0B2545;
        --um-text: #263B55;
        --um-muted: #6B7D93;

        --um-navy: #123F7A;
        --um-navy-dark: #0B2E5C;

        --um-orange: #F28C28;
        --um-orange-dark: #D96F08;

        --um-input: rgba(255, 255, 255, .78);
        --um-row-hover: rgba(242, 140, 40, .055);

        --um-shadow:
            0 18px 45px rgba(15, 42, 74, .10);

        color: var(--um-text);
    }


    /* =========================================================
       HEADER — mengikuti gaya Data Gudang / Data Mitra
    ========================================================= */

    .um-header {
        position: relative;
        overflow: hidden;
        min-height: 205px;
        border: 1px solid rgba(255,255,255,.18);
        border-top: 2px solid #F28C28;
        border-radius: 24px;
        padding: 30px 44px;
        background:
            linear-gradient(
                135deg,
                rgba(8, 42, 78, .86) 0%,
                rgba(18, 67, 116, .72) 48%,
                rgba(30, 88, 145, .52) 100%
            );
        box-shadow:
            0 18px 45px rgba(5,25,48,.18),
            inset 0 1px 0 rgba(255,255,255,.10);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
    }

    .um-header::before {
        content: "";
        position: absolute;
        inset: 0;
        pointer-events: none;
        background:
            radial-gradient(circle at 88% 22%, rgba(242,140,40,.20) 0, rgba(242,140,40,.08) 16%, transparent 38%),
            linear-gradient(90deg, rgba(7,34,62,.12), transparent 55%);
    }

    .um-header::after {
        content: "";
        position: absolute;
        width: 320px;
        height: 320px;
        right: -150px;
        bottom: -220px;
        border-radius: 999px;
        pointer-events: none;
        background: radial-gradient(circle, rgba(82,157,230,.18), transparent 68%);
    }

    .um-header-content {
        position: relative;
        z-index: 2;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .um-back {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        width: fit-content;
        margin-bottom: 18px;
        color: rgba(235,243,252,.78);
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .01em;
        transition: .2s ease;
    }

    .um-back:hover {
        color: #FFFFFF;
        transform: translateX(-2px);
    }

    .um-title-row {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 30px;
    }

    .um-title-wrap {
        display: block;
    }

    .um-title-icon {
        display: none;
    }

    .um-kicker {
        margin-bottom: 5px;
        color: rgba(235,243,252,.82);
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .28em;
        text-transform: uppercase;
    }

    .um-title {
        margin: 0;
        color: #FFFFFF;
        font-family: Georgia, "Times New Roman", serif;
        font-size: clamp(42px, 4vw, 58px);
        line-height: .98;
        font-weight: 400;
        letter-spacing: -.035em;
    }

    .um-title-accent {
        color: #F28C28;
    }

    .um-subtitle {
        margin-top: 13px;
        color: rgba(239,246,255,.84);
        font-size: 14px;
        line-height: 1.5;
    }

    .um-header-actions {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        justify-content: flex-end;
        gap: 12px;
        flex-shrink: 0;
    }

    .um-status-card {
        min-width: 160px;
        padding: 10px 16px;
        border: 1px solid rgba(255,255,255,.12);
        border-radius: 16px;
        background: rgba(7,31,57,.30);
        box-shadow: inset 0 1px 0 rgba(255,255,255,.06);
        backdrop-filter: blur(8px);
    }

    .um-status-label {
        display: block;
        margin-bottom: 4px;
        color: rgba(224,235,247,.62);
        font-size: 9px;
        font-weight: 800;
        letter-spacing: .18em;
        text-transform: uppercase;
    }

    .um-status-value {
        display: flex;
        align-items: center;
        gap: 7px;
        color: #FFFFFF;
        font-size: 12px;
        font-weight: 700;
    }

    .um-status-value::before {
        content: "";
        width: 9px;
        height: 9px;
        border-radius: 50%;
        background: #34D399;
        box-shadow: 0 0 0 4px rgba(52,211,153,.12), 0 0 12px rgba(52,211,153,.35);
    }

    /* =========================================================
       ADD BUTTON
    ========================================================= */


    .um-add-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;

        min-height: 44px;

        padding: 0 18px;

        border-radius: 13px;

        color: white;

        background:
            linear-gradient(
                135deg,
                #F28C28,
                #E9780C
            );

        box-shadow:
            0 8px 20px rgba(242,140,40,.28),
            inset 0 1px 0 rgba(255,255,255,.12);

        font-size: 13px;
        font-weight: 800;

        transition: .2s ease;
    }

    .um-add-btn:hover {
        transform: translateY(-1px);

        box-shadow:
            0 12px 24px rgba(242,140,40,.30);
    }


    /* =========================================================
       FILTER CARD
    ========================================================= */

    .um-filter-card {
        margin-top: 16px;

        padding: 18px;

        border: 1px solid var(--um-border);
        border-radius: 20px;

        background: var(--um-card-soft);

        box-shadow:
            0 8px 24px rgba(15,42,74,.05);
    }

    .um-filter-grid {
        display: grid;

        grid-template-columns:
            minmax(0, 1.4fr)
            minmax(0, 1fr)
            minmax(0, 1fr);

        gap: 12px;
    }

    .um-field {
        position: relative;
    }

    .um-input,
    .um-select {
        width: 100%;

        min-height: 45px;

        border: 1px solid var(--um-border-strong);
        border-radius: 12px;

        padding: 0 14px;

        background: var(--um-input);

        color: var(--um-text);

        font-size: 13px;

        outline: none;

        transition: .2s ease;
    }

    .um-input::placeholder {
        color: #91A0B2;
    }

    .um-input:focus,
    .um-select:focus {
        border-color: rgba(242,140,40,.65);

        box-shadow:
            0 0 0 4px rgba(242,140,40,.10);
    }

    .um-filter-actions {
        display: flex;
        align-items: center;
        gap: 8px;

        margin-top: 12px;
    }

    .um-search-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;

        min-height: 42px;

        padding: 0 17px;

        border-radius: 11px;

        color: white;

        background: var(--um-navy);

        font-size: 13px;
        font-weight: 700;

        transition: .2s ease;
    }

    .um-search-btn:hover {
        background: var(--um-navy-dark);
        transform: translateY(-1px);
    }

    .um-reset-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;

        min-height: 42px;

        padding: 0 17px;

        border: 1px solid var(--um-border-strong);
        border-radius: 11px;

        color: var(--um-text);

        background: transparent;

        font-size: 13px;
        font-weight: 700;

        transition: .2s ease;
    }

    .um-reset-btn:hover {
        border-color: rgba(18,63,122,.25);
        background: rgba(18,63,122,.06);
        color: var(--um-navy);
    }


    /* =========================================================
       ALERT
    ========================================================= */

    .um-alert {
        border-radius: 15px;

        padding: 13px 16px;

        font-size: 13px;
        font-weight: 600;
    }

    .um-alert-success {
        border: 1px solid rgba(16,185,129,.18);
        background: rgba(16,185,129,.08);
        color: #047857;
    }

    .um-alert-error {
        border: 1px solid rgba(239,68,68,.18);
        background: rgba(239,68,68,.08);
        color: #B91C1C;
    }


    /* =========================================================
       TABLE
    ========================================================= */

    .um-table-card {
        margin-top: 16px;

        overflow: hidden;

        border: 1px solid var(--um-border);
        border-radius: 20px;

        background: var(--um-card);

        box-shadow: var(--um-shadow);
    }

    .um-table-wrap {
        overflow-x: auto;
    }

    .um-table {
        width: 100%;

        border-collapse: separate;
        border-spacing: 0;

        font-size: 13px;
    }

    .um-table thead th {
        padding: 14px 16px;

        border-bottom: 1px solid var(--um-border);

        color: var(--um-muted);

        background: rgba(18,63,122,.045);

        font-size: 11px;
        font-weight: 800;

        text-transform: uppercase;
        letter-spacing: .06em;

        white-space: nowrap;
    }

    .um-table tbody tr {
        transition: .18s ease;
    }

    .um-table tbody tr:hover {
        background: var(--um-row-hover);
    }

    .um-table tbody td {
        padding: 15px 16px;

        border-bottom: 1px solid var(--um-border);

        vertical-align: middle;
    }

    .um-table tbody tr:last-child td {
        border-bottom: 0;
    }

    .um-name {
        color: var(--um-title);
        font-weight: 750;
    }

    .um-email {
        color: var(--um-muted);
    }

    .um-gudang {
        color: var(--um-text);
        font-weight: 600;
    }


    /* =========================================================
       BADGES
    ========================================================= */

    .um-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;

        padding: 6px 10px;

        border-radius: 999px;

        font-size: 11px;
        font-weight: 800;

        white-space: nowrap;
    }

    .um-badge-role {
        border: 1px solid rgba(18,63,122,.10);

        color: var(--um-navy);

        background: rgba(18,63,122,.08);
    }

    .um-badge-active {
        border: 1px solid rgba(16,185,129,.16);

        color: #047857;

        background: rgba(16,185,129,.10);
    }

    .um-badge-inactive {
        border: 1px solid rgba(100,116,139,.15);

        color: #64748B;

        background: rgba(100,116,139,.09);
    }

    .um-status-dot {
        width: 6px;
        height: 6px;

        border-radius: 999px;

        background: currentColor;
    }


    /* =========================================================
       ACTION BUTTONS
    ========================================================= */

    .um-actions {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 7px;
    }

    .um-edit-btn,
    .um-status-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;

        min-height: 34px;

        padding: 0 11px;

        border-radius: 9px;

        font-size: 11px;
        font-weight: 750;

        transition: .18s ease;
    }

    .um-edit-btn {
        border: 1px solid rgba(18,63,122,.20);

        color: var(--um-navy);

        background: rgba(18,63,122,.045);
    }

    .um-edit-btn:hover {
        background: var(--um-navy);
        color: white;
    }

    .um-status-off {
        border: 1px solid rgba(239,68,68,.22);

        color: #DC2626;

        background: rgba(239,68,68,.04);
    }

    .um-status-off:hover {
        background: #DC2626;
        color: white;
    }

    .um-status-on {
        border: 1px solid rgba(16,185,129,.22);

        color: #047857;

        background: rgba(16,185,129,.05);
    }

    .um-status-on:hover {
        background: #059669;
        color: white;
    }


    /* =========================================================
       EMPTY
    ========================================================= */

    .um-empty {
        padding: 55px 20px;

        text-align: center;

        color: var(--um-muted);
    }

    .um-empty-icon {
        display: flex;
        align-items: center;
        justify-content: center;

        width: 54px;
        height: 54px;

        margin: 0 auto 12px;

        border-radius: 16px;

        color: var(--um-navy);

        background: rgba(18,63,122,.08);
    }


    /* =========================================================
       PAGINATION
    ========================================================= */

    .um-pagination {
        padding: 15px 18px;

        border-top: 1px solid var(--um-border);
    }


    /* =========================================================
       DARK MODE
       Mengikuti html.dark-theme dari layout utama.
    ========================================================= */

    html.dark-theme .user-management-page {
        --um-card: rgba(8, 27, 48, .91);
        --um-card-soft: rgba(7, 25, 44, .86);

        --um-border: rgba(148,163,184,.13);
        --um-border-strong: rgba(148,163,184,.22);

        --um-title: #F1F5F9;
        --um-text: #D5DFEA;
        --um-muted: #93A6BB;

        --um-input: rgba(3, 19, 35, .82);

        --um-row-hover: rgba(242,140,40,.07);

        --um-shadow:
            0 20px 50px rgba(0,0,0,.24);
    }

    html.dark-theme .um-header {
        border-color: rgba(255,255,255,.12);
        background:
            linear-gradient(
                135deg,
                rgba(5,25,46,.92) 0%,
                rgba(8,38,67,.84) 48%,
                rgba(13,55,96,.70) 100%
            );
    }

    html.dark-theme .um-title-icon {
        color: #93C5FD;

        background:
            linear-gradient(
                135deg,
                rgba(59,130,246,.14),
                rgba(242,140,40,.10)
            );

        border-color: rgba(148,163,184,.12);
    }

    html.dark-theme .um-back:hover {
        color: #FFB454;
    }

    html.dark-theme .um-filter-card {
        background: rgba(7,25,44,.86);
    }

    html.dark-theme .um-input,
    html.dark-theme .um-select {
        color: #E7EEF7;
    }

    html.dark-theme .um-input::placeholder {
        color: #71869E;
    }

    html.dark-theme .um-table thead th {
        background: rgba(148,163,184,.055);
        color: #9FB0C4;
    }

    html.dark-theme .um-table tbody td {
        border-color: rgba(148,163,184,.11);
    }

    html.dark-theme .um-name {
        color: #F1F5F9;
    }

    html.dark-theme .um-email,
    html.dark-theme .um-gudang {
        color: #A9B9CB;
    }

    html.dark-theme .um-badge-role {
        border-color: rgba(96,165,250,.18);

        color: #93C5FD;

        background: rgba(59,130,246,.12);
    }

    html.dark-theme .um-badge-active {
        color: #6EE7B7;
        background: rgba(16,185,129,.12);
    }

    html.dark-theme .um-badge-inactive {
        color: #A7B3C2;
        background: rgba(148,163,184,.10);
    }

    html.dark-theme .um-edit-btn {
        border-color: rgba(96,165,250,.24);
        color: #93C5FD;
        background: rgba(59,130,246,.08);
    }

    html.dark-theme .um-edit-btn:hover {
        background: #2563EB;
        color: white;
    }

    html.dark-theme .um-reset-btn {
        color: #CBD5E1;
        background: transparent;
    }

    html.dark-theme .um-reset-btn:hover {
        background: rgba(148,163,184,.10);
    }


    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media (max-width: 900px) {

        .um-filter-grid {
            grid-template-columns: 1fr;
        }

        .um-title-row {
            align-items: flex-start;
            flex-direction: column;
        }

        .um-header-actions {
            width: 100%;
            align-items: flex-start;
            flex-direction: row;
            flex-wrap: wrap;
        }

        .um-add-btn {
            width: auto;
        }
    }

    @media (max-width: 640px) {

        .um-header {
            min-height: 0;
            padding: 22px 20px;
            border-radius: 18px;
        }

        .um-title {
            font-size: 40px;
        }

        .um-header-actions {
            flex-direction: column;
            align-items: stretch;
        }

        .um-status-card {
            min-width: 0;
            width: 100%;
        }

        .um-add-btn {
            width: 100%;
        }

        .um-filter-card {
            padding: 14px;
        }

        .um-table-card {
            border-radius: 16px;
        }

        .um-actions {
            justify-content: flex-start;
            flex-wrap: wrap;
        }
    }
</style>


<div class="user-management-page space-y-4">

    {{-- =====================================================
         HEADER
    ====================================================== --}}

    <section class="um-header">

        <div class="um-header-content">

            <a
                href="{{ route('dashboard') }}"
                class="um-back"
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
                Kembali ke Dashboard
            </a>

            <div class="um-title-row">

                <div class="um-title-wrap">

                    <div class="um-kicker">
                        PENGATURAN
                    </div>

                    <h1 class="um-title">
                        Manajemen <span class="um-title-accent">User</span>
                    </h1>

                    <p class="um-subtitle">
                        Kelola akun Admin Kantor dan Admin Gudang dengan mudah dan terstruktur.
                    </p>

                </div>

                <div class="um-header-actions">

                    <div class="um-status-card">
                        <span class="um-status-label">Status Data</span>
                        <span class="um-status-value">Data user aktif</span>
                    </div>

                    <a
                        href="{{ route('pengaturan.users.create') }}"
                        class="um-add-btn"
                    >
                        <svg
                            width="17"
                            height="17"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        >
                            <path d="M12 5v14"/>
                            <path d="M5 12h14"/>
                        </svg>
                        Tambah User
                    </a>

                </div>

            </div>

        </div>

    </section>


    {{-- =====================================================
         TAB PENGATURAN
    ====================================================== --}}

    @include('pengaturan._tabs')


    {{-- =====================================================
         ALERT SUCCESS
    ====================================================== --}}

    @if(session('success'))

        <div class="um-alert um-alert-success">

            {{ session('success') }}

        </div>

    @endif


    {{-- =====================================================
         ALERT ERROR
    ====================================================== --}}

    @if($errors->any())

        <div class="um-alert um-alert-error">

            <ul class="list-disc space-y-1 pl-5">

                @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    {{-- =====================================================
         FILTER
    ====================================================== --}}

    <section class="um-filter-card">

        <form
            method="GET"
            class="space-y-0"
        >

            <div class="um-filter-grid">

                {{-- SEARCH --}}
                <div class="um-field">

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari nama atau email..."
                        class="um-input"
                    >

                </div>


                {{-- ROLE --}}
                <div class="um-field">

                    <select
                        name="role"
                        class="um-select"
                        onchange="this.form.submit()"
                    >

                        <option value="">
                            Semua Role
                        </option>

                        <option
                            value="admin_kantor"
                            @selected(request('role') === 'admin_kantor')
                        >
                            Admin Kantor
                        </option>

                        <option
                            value="admin_gudang"
                            @selected(request('role') === 'admin_gudang')
                        >
                            Admin Gudang
                        </option>

                    </select>

                </div>


                {{-- STATUS --}}
                <div class="um-field">

                    <select
                        name="status"
                        class="um-select"
                        onchange="this.form.submit()"
                    >

                        <option value="">
                            Semua Status
                        </option>

                        <option
                            value="aktif"
                            @selected(request('status') === 'aktif')
                        >
                            Aktif
                        </option>

                        <option
                            value="nonaktif"
                            @selected(request('status') === 'nonaktif')
                        >
                            Nonaktif
                        </option>

                    </select>

                </div>

            </div>


            <div class="um-filter-actions">

                <button
                    type="submit"
                    class="um-search-btn"
                >

                    <svg
                        width="15"
                        height="15"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                    >
                        <circle cx="11" cy="11" r="7"/>
                        <path d="m20 20-4-4"/>
                    </svg>

                    Cari

                </button>


                <a
                    href="{{ route('pengaturan.users.index') }}"
                    class="um-reset-btn"
                >
                    Reset
                </a>

            </div>

        </form>

    </section>


    {{-- =====================================================
         TABLE USER
    ====================================================== --}}

    <section class="um-table-card">

        <div class="um-table-wrap">

            <table class="um-table">

                <thead>

                    <tr>

                        <th>
                            Nama
                        </th>

                        <th>
                            Email
                        </th>

                        <th>
                            Role
                        </th>

                        <th>
                            Gudang
                        </th>

                        <th>
                            Status
                        </th>

                        <th class="text-right">
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($users as $user)

                        <tr>

                            {{-- NAMA --}}
                            <td>

                                <div class="um-name">
                                    {{ $user->name }}
                                </div>

                            </td>


                            {{-- EMAIL --}}
                            <td>

                                <div class="um-email">
                                    {{ $user->email }}
                                </div>

                            </td>


                            {{-- ROLE --}}
                            <td>

                                <span class="um-badge um-badge-role">

                                    {{ $user->roleLabel() }}

                                </span>

                            </td>


                            {{-- GUDANG --}}
                            <td>

                                <span class="um-gudang">

                                    {{ $user->gudang?->nama_gudang ?? '—' }}

                                </span>

                            </td>


                            {{-- STATUS --}}
                            <td>

                                @if($user->is_active)

                                    <span class="um-badge um-badge-active">

                                        <span class="um-status-dot"></span>

                                        Aktif

                                    </span>

                                @else

                                    <span class="um-badge um-badge-inactive">

                                        <span class="um-status-dot"></span>

                                        Nonaktif

                                    </span>

                                @endif

                            </td>


                            {{-- AKSI --}}
                            <td>

                                <div class="um-actions">

                                    {{-- EDIT --}}
                                    <a
                                        href="{{ route('pengaturan.users.edit', $user) }}"
                                        class="um-edit-btn"
                                    >

                                        <svg
                                            width="13"
                                            height="13"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                        >
                                            <path d="M12 20h9"/>
                                            <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z"/>
                                        </svg>

                                        Edit

                                    </a>


                                    {{-- TOGGLE STATUS --}}
                                    <form
                                        method="POST"
                                        action="{{ route('pengaturan.users.toggle-status', $user) }}"
                                    >

                                        @csrf

                                        @method('PATCH')

                                        @if($user->is_active)

                                            <button
                                                type="submit"
                                                class="um-status-btn um-status-off"
                                                onclick="return confirm('Nonaktifkan user ini?')"
                                            >

                                                <svg
                                                    width="13"
                                                    height="13"
                                                    viewBox="0 0 24 24"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    stroke-width="2"
                                                    stroke-linecap="round"
                                                >
                                                    <circle cx="12" cy="12" r="9"/>
                                                    <path d="M9 9l6 6"/>
                                                    <path d="M15 9l-6 6"/>
                                                </svg>

                                                Nonaktifkan

                                            </button>

                                        @else

                                            <button
                                                type="submit"
                                                class="um-status-btn um-status-on"
                                                onclick="return confirm('Aktifkan user ini?')"
                                            >

                                                <svg
                                                    width="13"
                                                    height="13"
                                                    viewBox="0 0 24 24"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    stroke-width="2"
                                                >
                                                    <path d="M20 6 9 17l-5-5"/>
                                                </svg>

                                                Aktifkan

                                            </button>

                                        @endif

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="6"
                                class="um-empty"
                            >

                                <div class="um-empty-icon">

                                    <svg
                                        width="25"
                                        height="25"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                    >
                                        <circle cx="11" cy="11" r="7"/>
                                        <path d="m20 20-4-4"/>
                                    </svg>

                                </div>

                                <div class="font-bold">
                                    Belum ada user yang sesuai.
                                </div>

                                <div class="mt-1 text-xs opacity-80">
                                    Coba ubah kata pencarian atau filter.
                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- PAGINATION --}}
        @if($users->hasPages())

            <div class="um-pagination">

                {{ $users->links() }}

            </div>

        @endif

    </section>

</div>

@endsection