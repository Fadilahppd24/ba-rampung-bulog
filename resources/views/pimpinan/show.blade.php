@extends('layouts.app')

@section('title', 'Detail Pimpinan')

@section('content')

<style>
    /* =========================================================
       DETAIL PIMPINAN CABANG
       ========================================================= */

    .pimpinan-detail-page {
        min-height: calc(100vh - 250px);
        padding-bottom: 40px;
        color: #1e293b;
    }

    /* MODERN PAGE HEADER */
    .pimpinan-modern-header {
        width: 100%;
        max-width: 1100px;
        margin: 0 auto 24px auto;
        text-align: center;
        position: relative;
    }

    .pimpinan-modern-eyebrow {
        margin-bottom: 8px;
        color: #cbd5e1;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .28em;
        text-transform: uppercase;
    }

    .pimpinan-modern-title {
        margin: 0;
        color: #ffffff;
        font-family: Georgia, 'Times New Roman', serif;
        font-size: 52px;
        font-weight: 400;
        line-height: 1.05;
        letter-spacing: -.025em;
    }

    .pimpinan-modern-title span {
        color: #F28C28;
    }

    .pimpinan-modern-subtitle {
        margin-top: 8px;
        color: rgba(226, 232, 240, .82);
        font-size: 14px;
    }

    .pimpinan-modern-actions {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 12px;
        margin-top: 14px;
    }

    /* HEADER */
    .pimpinan-header {
        width: 100%;
        max-width: 1100px;
        margin: 0 auto 24px auto;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
    }

    .pimpinan-title {
        color: #0f172a;
        font-size: 20px;
        font-weight: 700;
        line-height: 1.3;
    }

    .pimpinan-jabatan {
        color: #64748b;
        font-size: 14px;
        margin-top: 4px;
    }

    /* CARD INFORMASI */
    .pimpinan-info-card {
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

    .pimpinan-info-title {
        margin-bottom: 22px;
        color: #0f172a;
        font-size: 17px;
        font-weight: 700;
    }

    .pimpinan-info-list {
        display: flex;
        flex-direction: column;
        gap: 0;
    }

    .pimpinan-info-row {
        display: grid;
        grid-template-columns: 180px minmax(0, 1fr);
        gap: 24px;
        padding: 15px 0;
        border-bottom: 1px solid #e2e8f0;
    }

    .pimpinan-info-row:last-child {
        border-bottom: none;
    }

    .pimpinan-info-label {
        color: #64748b;
        font-size: 14px;
    }

    .pimpinan-info-value {
        color: #1e293b;
        font-size: 14px;
        font-weight: 600;
        text-align: right;
        word-break: break-word;
    }

    /* TOMBOL KEMBALI */
    .pimpinan-back-wrapper {
        width: 100%;
        max-width: 760px;
        margin: 20px auto 0 auto;
    }

    .pimpinan-back-btn {
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

    .pimpinan-back-btn:hover {
        background: #f8fafc;
        border-color: #123F7A;
        color: #123F7A;
    }

    /* =========================================================
       DARK MODE
       PROJECT MENGGUNAKAN html.dark-theme
       ========================================================= */

    html.dark-theme .pimpinan-detail-page {
        color: #e5e7eb !important;
    }

    html.dark-theme .pimpinan-title {
        color: #f8fafc !important;
    }

    html.dark-theme .pimpinan-jabatan {
        color: #94a3b8 !important;
    }

    html.dark-theme .pimpinan-info-card {
        background: #101c2d !important;
        border-color: #263b55 !important;
        color: #e5e7eb !important;
        box-shadow: 0 18px 45px rgba(0, 0, 0, .30) !important;
    }

    .pimpinan-person-summary {
        margin-bottom: 22px;
        padding-bottom: 18px;
        border-bottom: 1px solid #e2e8f0;
    }

    .pimpinan-person-name {
        color: #0f172a;
        font-size: 20px;
        font-weight: 700;
    }

    .pimpinan-person-role {
        margin-top: 4px;
        color: #64748b;
        font-size: 13px;
    }

    html.dark-theme .pimpinan-person-summary {
        border-color: rgba(148, 163, 184, .16) !important;
    }

    html.dark-theme .pimpinan-person-name {
        color: #f8fafc !important;
    }

    html.dark-theme .pimpinan-person-role {
        color: #94a3b8 !important;
    }

    html.dark-theme .pimpinan-info-title {
        color: #f8fafc !important;
    }

    html.dark-theme .pimpinan-info-row {
        border-color: rgba(148, 163, 184, .16) !important;
    }

    html.dark-theme .pimpinan-info-label {
        color: #94a3b8 !important;
    }

    html.dark-theme .pimpinan-info-value {
        color: #f1f5f9 !important;
    }

    html.dark-theme .pimpinan-back-btn {
        background: #13263d !important;
        border-color: #2b405a !important;
        color: #f8fafc !important;
    }

    html.dark-theme .pimpinan-back-btn:hover {
        background: #1a3150 !important;
        border-color: #60a5fa !important;
        color: #ffffff !important;
    }

    /* RESPONSIVE */
    @media (max-width: 768px) {

        .pimpinan-detail-page {
            min-height: calc(100vh - 220px);
        }

        .pimpinan-modern-title {
            font-size: 38px;
        }

        .pimpinan-modern-actions {
            flex-wrap: wrap;
        }

        .pimpinan-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .pimpinan-info-card {
            padding: 22px;
        }

        .pimpinan-info-row {
            grid-template-columns: 1fr;
            gap: 6px;
        }

        .pimpinan-info-value {
            text-align: left;
        }

        .pimpinan-back-wrapper {
            margin-top: 16px;
        }
    }
</style>


<div class="pimpinan-detail-page">

    {{-- HEADER --}}
    <div class="pimpinan-modern-header">
        <div class="pimpinan-modern-eyebrow">MASTER DATA</div>

        <h1 class="pimpinan-modern-title">
            Detail <span>Pimpinan</span>
        </h1>

        <p class="pimpinan-modern-subtitle">
            Informasi lengkap data pimpinan cabang.
        </p>

        <div class="pimpinan-modern-actions">
            <x-status-badge
                :color="$pimpinan->status === 'aktif' ? 'green' : 'gray'"
                :label="ucfirst($pimpinan->status)"
            />

            @role('admin_sistem')
                <a
                    href="{{ route('pimpinan.edit', $pimpinan) }}"
                    class="btn-secondary"
                >
                    ✏️ Edit
                </a>
            @endrole
        </div>
    </div>


    {{-- CARD INFORMASI --}}
    <div class="pimpinan-info-card">

        <div class="pimpinan-person-summary">
            <div>
                <div class="pimpinan-person-name">{{ $pimpinan->nama }}</div>
                <div class="pimpinan-person-role">{{ $pimpinan->jabatan }}</div>
            </div>
        </div>

        <h3 class="pimpinan-info-title">
            Informasi Pimpinan
        </h3>


        <div class="pimpinan-info-list">

            {{-- PERIODE --}}
            <div class="pimpinan-info-row">

                <dt class="pimpinan-info-label">
                    Periode
                </dt>

                <dd class="pimpinan-info-value">
                    {{ $pimpinan->periode_mulai->format('d/m/Y') }}
                    –
                    {{ $pimpinan->periode_selesai?->format('d/m/Y') ?? 'Sekarang' }}
                </dd>

            </div>


            {{-- EMAIL --}}
            <div class="pimpinan-info-row">

                <dt class="pimpinan-info-label">
                    Email
                </dt>

                <dd class="pimpinan-info-value">
                    {{ $pimpinan->email ?? '-' }}
                </dd>

            </div>


            {{-- TELEPON --}}
            <div class="pimpinan-info-row">

                <dt class="pimpinan-info-label">
                    Telepon
                </dt>

                <dd class="pimpinan-info-value">
                    {{ $pimpinan->nomor_telepon ?? '-' }}
                </dd>

            </div>


            {{-- ALAMAT --}}
            <div class="pimpinan-info-row">

                <dt class="pimpinan-info-label">
                    Alamat Kantor
                </dt>

                <dd class="pimpinan-info-value">
                    {{ $pimpinan->alamat ?? '-' }}
                </dd>

            </div>

        </div>

    </div>


    {{-- KEMBALI --}}
    <div class="pimpinan-back-wrapper">

        <a
            href="{{ route('pimpinan.index') }}"
            class="pimpinan-back-btn"
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

            Kembali ke Riwayat
        </a>

    </div>

</div>

@endsection