@extends('layouts.app')

@section('title', 'Data Pimpinan')

@section('content')

<style>
    .pimpinan-page {
        padding-bottom: 40px;
    }

    /* =========================================================
       HERO
    ========================================================= */
    .pimpinan-hero {
        position: relative;
        overflow: hidden;
        min-height: 210px;
        border-radius: 28px;
        padding: 42px 44px;
        background:
            linear-gradient(
                105deg,
                rgba(9, 42, 79, .88) 0%,
                rgba(18, 63, 122, .76) 55%,
                rgba(18, 63, 122, .48) 100%
            );
        border: 1px solid rgba(255,255,255,.20);
        box-shadow: 0 20px 50px rgba(9, 42, 79, .18);
        backdrop-filter: blur(3px);
    }

    .pimpinan-hero::after {
        content: "";
        position: absolute;
        width: 260px;
        height: 260px;
        right: -90px;
        top: -120px;
        border-radius: 999px;
        background: rgba(255,255,255,.08);
        pointer-events: none;
    }

    .pimpinan-hero-content {
        position: relative;
        z-index: 2;
        max-width: 780px;
    }

    .pimpinan-kicker {
        margin-bottom: 8px;
        color: rgba(255,255,255,.72);
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .28em;
        text-transform: uppercase;
    }

    .pimpinan-title {
        margin: 0;
        color: white;
        font-family: Georgia, "Times New Roman", serif;
        font-size: clamp(42px, 5vw, 64px);
        line-height: .98;
        font-weight: 400;
        letter-spacing: -.03em;
    }

    .pimpinan-title span {
        color: #F28C28;
    }

    .pimpinan-description {
        margin-top: 14px;
        max-width: 650px;
        color: rgba(255,255,255,.88);
        font-size: 14px;
        line-height: 1.7;
    }

    .pimpinan-hero-action {
        position: absolute;
        right: 42px;
        bottom: 40px;
        z-index: 5;
    }

    .pimpinan-add-btn {
        display: inline-flex;
        align-items: center;
        gap: 9px;
        padding: 13px 20px;
        border-radius: 999px;
        background: #123F7A;
        color: white;
        font-size: 14px;
        font-weight: 700;
        text-decoration: none;
        box-shadow: 0 12px 28px rgba(4, 31, 65, .28);
        transition: .2s ease;
    }

    .pimpinan-add-btn:hover {
        transform: translateY(-2px);
        background: #0d3263;
    }

    /* =========================================================
       KPI
    ========================================================= */
    .pimpinan-kpi {
        position: relative;
        overflow: hidden;
        border-radius: 22px;
        border: 1px solid rgba(226,232,240,.9);
        background: rgba(255,255,255,.97);
        padding: 22px;
        box-shadow: 0 10px 28px rgba(15,23,42,.07);
        transition: .2s ease;
    }

    .pimpinan-kpi:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 32px rgba(15,23,42,.10);
    }

    .pimpinan-kpi-label {
        color: #8190a8;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .13em;
        text-transform: uppercase;
    }

    .pimpinan-kpi-number {
        margin-top: 8px;
        color: #123F7A;
        font-family: Georgia, "Times New Roman", serif;
        font-size: 34px;
        line-height: 1;
    }

    .pimpinan-kpi-number.green {
        color: #079669;
    }

    .pimpinan-kpi-number.gray {
        color: #334155;
    }

    .pimpinan-kpi-number.orange {
        color: #E47B0A;
    }

    .pimpinan-kpi-description {
        margin-top: 8px;
        color: #94a3b8;
        font-size: 12px;
    }

    .pimpinan-kpi-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 46px;
        height: 46px;
        border-radius: 15px;
        font-size: 19px;
    }

    /* =========================================================
       CONTENT CARDS
    ========================================================= */
    .pimpinan-card {
        overflow: hidden;
        border: 1px solid rgba(226,232,240,.95);
        border-radius: 24px;
        background: rgba(255,255,255,.97);
        box-shadow: 0 10px 30px rgba(15,23,42,.07);
    }

    .pimpinan-card-header {
        padding: 22px 24px;
        border-bottom: 1px solid #eef2f7;
    }

    .pimpinan-section-label {
        color: #123F7A;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .22em;
        text-transform: uppercase;
    }

    .pimpinan-section-title {
        margin-top: 4px;
        color: #0f172a;
        font-size: 19px;
        font-weight: 750;
    }

    .pimpinan-section-description {
        margin-top: 3px;
        color: #94a3b8;
        font-size: 12px;
    }

    /* =========================================================
       ACTIVE PROFILE
    ========================================================= */
    .pimpinan-profile {
        padding: 25px;
    }

    .pimpinan-profile-top {
        display: flex;
        align-items: center;
        gap: 15px;
        padding-bottom: 21px;
        border-bottom: 1px solid #edf1f6;
    }

    .pimpinan-avatar {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        width: 68px;
        height: 68px;
        border-radius: 21px;
        background: linear-gradient(135deg, #eaf3ff, #dcecff);
        color: #123F7A;
        font-family: Georgia, "Times New Roman", serif;
        font-size: 29px;
        font-weight: 700;
    }

    .pimpinan-name {
        color: #0f172a;
        font-size: 17px;
        font-weight: 750;
    }

    .pimpinan-position {
        margin-top: 4px;
        color: #64748b;
        font-size: 12px;
    }

    .pimpinan-status {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        margin-top: 9px;
        padding: 5px 9px;
        border-radius: 999px;
        background: #eaf9f1;
        color: #087f5b;
        font-size: 11px;
        font-weight: 700;
    }

    .pimpinan-info {
        display: grid;
        gap: 17px;
        margin-top: 22px;
    }

    .pimpinan-info-label {
        color: #94a3b8;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .12em;
        text-transform: uppercase;
    }

    .pimpinan-info-value {
        margin-top: 4px;
        color: #334155;
        font-size: 13px;
        line-height: 1.55;
        word-break: break-word;
    }

    .pimpinan-edit-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        margin-top: 23px;
        padding: 11px 16px;
        border: 1px solid #dbe4ef;
        border-radius: 13px;
        background: white;
        color: #123F7A;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        transition: .2s ease;
    }

    .pimpinan-edit-btn:hover {
        background: #eff6ff;
        border-color: #c9dcf3;
    }

    /* =========================================================
       HISTORY
    ========================================================= */
    .pimpinan-history-head {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .pimpinan-history-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 43px;
        height: 43px;
        border-radius: 14px;
        background: #eef5ff;
        color: #123F7A;
        font-size: 18px;
    }

    .pimpinan-table-wrap {
        overflow-x: auto;
    }

    .pimpinan-table {
        width: 100%;
        min-width: 700px;
        border-collapse: collapse;
        font-size: 13px;
    }

    .pimpinan-table thead {
        background: #f7f9fc;
    }

    .pimpinan-table th {
        padding: 14px 20px;
        border-bottom: 1px solid #e8edf4;
        color: #718096;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .12em;
        text-align: left;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .pimpinan-table td {
        padding: 16px 20px;
        border-bottom: 1px solid #eef2f6;
        color: #475569;
        vertical-align: middle;
    }

    .pimpinan-table tbody tr {
        transition: .18s ease;
    }

    .pimpinan-table tbody tr:hover {
        background: #f8fbff;
    }

    .pimpinan-table-name {
        color: #172033;
        font-weight: 700;
    }

    .pimpinan-number {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 29px;
        height: 29px;
        border-radius: 9px;
        background: #f1f5f9;
        color: #64748b;
        font-size: 11px;
        font-weight: 700;
    }

    .pimpinan-period {
        color: #64748b;
        white-space: nowrap;
    }

    .pimpinan-action {
        display: flex;
        justify-content: flex-end;
        gap: 7px;
    }

    .pimpinan-action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 11px;
        text-decoration: none;
        transition: .2s ease;
    }

    .pimpinan-action-view {
        background: #eff6ff;
        color: #123F7A;
    }

    .pimpinan-action-view:hover {
        background: #dbeafe;
    }

    .pimpinan-action-edit {
        background: #fff7e8;
        color: #d97706;
    }

    .pimpinan-action-edit:hover {
        background: #ffedd5;
    }

    .pimpinan-empty {
        padding: 60px 20px;
        color: #94a3b8;
        text-align: center;
    }

    .pimpinan-empty-icon {
        margin-bottom: 10px;
        font-size: 34px;
    }

    /* =========================================================
       RESPONSIVE
    ========================================================= */
    @media (max-width: 900px) {
        .pimpinan-hero {
            padding: 32px 28px;
        }

        .pimpinan-hero-action {
            position: static;
            margin-top: 25px;
        }

        .pimpinan-add-btn {
            width: fit-content;
        }
    }

    @media (max-width: 640px) {
        .pimpinan-hero {
            min-height: auto;
            border-radius: 22px;
            padding: 28px 22px;
        }

        .pimpinan-title {
            font-size: 42px;
        }

        .pimpinan-description {
            font-size: 13px;
        }

        .pimpinan-kpi {
            padding: 18px;
        }
    }
</style>


<div class="pimpinan-page space-y-6">

    {{-- =========================================================
         HERO
    ========================================================== --}}
    <div class="pimpinan-hero">

        <div class="pimpinan-hero-content">

            <div class="pimpinan-kicker">
                Master Data
            </div>

            <h1 class="pimpinan-title">
                Data <span>Pimpinan</span>
            </h1>

            <p class="pimpinan-description">
                Kelola data pimpinan cabang dan riwayat kepemimpinan
                dengan lebih mudah dan terstruktur.
            </p>

        </div>

        @if(auth()->check() && auth()->user()->role === 'admin_kantor')
            <div class="pimpinan-hero-action">
                <a
                    href="{{ route('pimpinan.create') }}"
                    class="pimpinan-add-btn"
                >
                    <span style="font-size:18px;line-height:1;">＋</span>
                    Tambah Pimpinan
                </a>
            </div>
        @endif

    </div>


    {{-- =========================================================
         KPI
    ========================================================== --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

        {{-- TOTAL RIWAYAT --}}
        <div class="pimpinan-kpi">

            <div class="flex items-start justify-between gap-4">

                <div>
                    <div class="pimpinan-kpi-label">
                        Total Riwayat
                    </div>

                    <div class="pimpinan-kpi-number">
                        {{ number_format($riwayat->total()) }}
                    </div>

                    <div class="pimpinan-kpi-description">
                        Seluruh riwayat pimpinan
                    </div>
                </div>

                <div
                    class="pimpinan-kpi-icon"
                    style="background:#eef5ff;"
                >
                    👔
                </div>

            </div>

        </div>


        {{-- PIMPINAN AKTIF --}}
        <div class="pimpinan-kpi">

            <div class="flex items-start justify-between gap-4">

                <div>
                    <div class="pimpinan-kpi-label">
                        Pimpinan Aktif
                    </div>

                    <div class="pimpinan-kpi-number green">
                        {{ $pimpinanAktif ? 1 : 0 }}
                    </div>

                    <div class="pimpinan-kpi-description">
                        Pimpinan yang sedang menjabat
                    </div>
                </div>

                <div
                    class="pimpinan-kpi-icon"
                    style="background:#eaf9f1;color:#079669;"
                >
                    ✓
                </div>

            </div>

        </div>


        {{-- RIWAYAT SELESAI --}}
        <div class="pimpinan-kpi">

            <div class="flex items-start justify-between gap-4">

                <div>
                    <div class="pimpinan-kpi-label">
                        Riwayat Selesai
                    </div>

                    <div class="pimpinan-kpi-number gray">
                        {{ number_format(max($riwayat->total() - ($pimpinanAktif ? 1 : 0), 0)) }}
                    </div>

                    <div class="pimpinan-kpi-description">
                        Periode kepemimpinan selesai
                    </div>
                </div>

                <div
                    class="pimpinan-kpi-icon"
                    style="background:#f1f5f9;color:#475569;"
                >
                    ◷
                </div>

            </div>

        </div>


        {{-- PERIODE AKTIF --}}
        <div class="pimpinan-kpi">

            <div class="flex items-start justify-between gap-4">

                <div>
                    <div class="pimpinan-kpi-label">
                        Periode Aktif
                    </div>

                    <div class="pimpinan-kpi-number orange">
                        {{ $pimpinanAktif?->periode_mulai?->format('Y') ?? '—' }}
                    </div>

                    <div class="pimpinan-kpi-description">
                        Tahun mulai menjabat
                    </div>
                </div>

                <div
                    class="pimpinan-kpi-icon"
                    style="background:#fff7e8;color:#e47b0a;"
                >
                    ◫
                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
         PROFILE + HISTORY
    ========================================================== --}}
    <div class="grid grid-cols-1 gap-5 xl:grid-cols-[360px_minmax(0,1fr)]">


        {{-- =====================================================
             PIMPINAN AKTIF
        ====================================================== --}}
        <div class="pimpinan-card">

            <div class="pimpinan-card-header">

                <div class="flex items-center justify-between gap-3">

                    <div>

                        <div class="pimpinan-section-label">
                            Pimpinan Aktif
                        </div>

                        <h2 class="pimpinan-section-title">
                            Informasi Pimpinan Cabang
                        </h2>

                    </div>

                    @if(auth()->check() && auth()->user()->role === 'admin_kantor')

                        <a
                            href="{{ route('pimpinan.create') }}"
                            class="text-sm font-bold text-[#123F7A] hover:underline"
                        >
                            ＋ Riwayat
                        </a>

                    @endif

                </div>

            </div>


            @if($pimpinanAktif)

                <div class="pimpinan-profile">

                    {{-- PROFILE HEADER --}}
                    <div class="pimpinan-profile-top">

                        <div class="pimpinan-avatar">
                            {{ strtoupper(substr($pimpinanAktif->nama, 0, 1)) }}
                        </div>

                        <div class="min-w-0">

                            <div class="pimpinan-name truncate">
                                {{ $pimpinanAktif->nama }}
                            </div>

                            <div class="pimpinan-position">
                                {{ $pimpinanAktif->jabatan }}
                            </div>

                            <div class="pimpinan-status">
                                <span>●</span>
                                Aktif
                            </div>

                        </div>

                    </div>


                    {{-- INFORMATION --}}
                    <div class="pimpinan-info">

                        <div>
                            <div class="pimpinan-info-label">
                                Email
                            </div>

                            <div class="pimpinan-info-value">
                                {{ $pimpinanAktif->email ?? '-' }}
                            </div>
                        </div>


                        <div>
                            <div class="pimpinan-info-label">
                                Telepon
                            </div>

                            <div class="pimpinan-info-value">
                                {{ $pimpinanAktif->nomor_telepon ?? '-' }}
                            </div>
                        </div>


                        <div>
                            <div class="pimpinan-info-label">
                                Alamat Kantor
                            </div>

                            <div class="pimpinan-info-value">
                                {{ $pimpinanAktif->alamat ?? '-' }}
                            </div>
                        </div>


                        <div>
                            <div class="pimpinan-info-label">
                                Menjabat Sejak
                            </div>

                            <div class="pimpinan-info-value">
                                {{ $pimpinanAktif->periode_mulai?->format('d/m/Y') ?? '-' }}
                            </div>
                        </div>

                    </div>


                    {{-- EDIT --}}
                    @if(auth()->check() && auth()->user()->role === 'admin_kantor')

                        <a
                            href="{{ route('pimpinan.edit', $pimpinanAktif) }}"
                            class="pimpinan-edit-btn"
                        >
                            ✎ &nbsp; Edit Profil
                        </a>

                    @endif

                </div>

            @else

                <div class="pimpinan-profile">

                    <div class="rounded-2xl bg-slate-50 px-5 py-12 text-center text-sm text-slate-500">

                        <div class="mb-3 text-3xl">
                            👔
                        </div>

                        Belum ada Pimpinan Cabang aktif.

                    </div>

                </div>

            @endif

        </div>


        {{-- =====================================================
             RIWAYAT PIMPINAN
        ====================================================== --}}
        <div class="pimpinan-card">

            <div class="pimpinan-card-header">

                <div class="pimpinan-history-head">

                    <div class="pimpinan-history-icon">
                        👔
                    </div>

                    <div>

                        <div class="pimpinan-section-label">
                            Master Data
                        </div>

                        <h2 class="pimpinan-section-title">
                            Riwayat Pimpinan
                        </h2>

                        <p class="pimpinan-section-description">
                            Menampilkan seluruh riwayat pimpinan cabang.
                        </p>

                    </div>

                </div>

            </div>


            <div class="pimpinan-table-wrap">

                <table class="pimpinan-table">

                    <thead>

                        <tr>

                            <th style="width:70px;">
                                No.
                            </th>

                            <th>
                                Nama
                            </th>

                            <th>
                                Periode
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

                        @forelse($riwayat as $i => $p)

                            <tr>

                                {{-- NO --}}
                                <td>

                                    <span class="pimpinan-number">
                                        {{ $riwayat->firstItem() + $i }}
                                    </span>

                                </td>


                                {{-- NAMA --}}
                                <td>

                                    <div class="pimpinan-table-name">
                                        {{ $p->nama }}
                                    </div>

                                </td>


                                {{-- PERIODE --}}
                                <td>

                                    <div class="pimpinan-period">

                                        {{ $p->periode_mulai?->format('Y') ?? '-' }}

                                        <span class="mx-1 text-slate-300">
                                            –
                                        </span>

                                        {{ $p->periode_selesai?->format('Y') ?? 'Sekarang' }}

                                    </div>

                                </td>


                                {{-- STATUS --}}
                                <td>

                                    <x-status-badge
                                        :color="$p->status === 'aktif' ? 'green' : 'gray'"
                                        :label="ucfirst($p->status)"
                                    />

                                </td>


                                {{-- AKSI --}}
                                <td>

                                    <div class="pimpinan-action">

                                        <a
                                            href="{{ route('pimpinan.show', $p) }}"
                                            title="Lihat"
                                            class="pimpinan-action-btn pimpinan-action-view"
                                        >
                                            👁
                                        </a>


                                        @if(auth()->check() && auth()->user()->role === 'admin_kantor')

                                            <a
                                                href="{{ route('pimpinan.edit', $p) }}"
                                                title="Edit"
                                                class="pimpinan-action-btn pimpinan-action-edit"
                                            >
                                                ✎
                                            </a>

                                        @endif

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="5"
                                    class="pimpinan-empty"
                                >

                                    <div class="pimpinan-empty-icon">
                                        👔
                                    </div>

                                    Belum ada riwayat Pimpinan Cabang.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- PAGINATION --}}
            @if($riwayat->hasPages())

                <div class="border-t border-slate-100 p-5">

                    {{ $riwayat->links() }}

                </div>

            @endif

        </div>

    </div>

</div>

@endsection