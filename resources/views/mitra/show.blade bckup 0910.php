@extends('layouts.app')

@section('title', 'Detail Mitra Pengolahan')

@section('content')

<style>
    .mitra-detail-page {
        color: #1e293b;
    }

    .mitra-detail-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        color: #1e293b;
    }

    .mitra-detail-title {
        color: #0f172a;
    }

    .mitra-detail-muted {
        color: #64748b;
    }

    .mitra-detail-label {
        color: #64748b;
    }

    .mitra-detail-value {
        color: #1e293b;
    }

    .mitra-detail-divider {
        border-color: #f1f5f9;
    }

    .mitra-detail-item:hover {
        background: #f8fafc;
    }

    .mitra-back-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 9px 15px;
        border-radius: 10px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        color: #334155;
        font-size: 14px;
        font-weight: 600;
        transition: .2s ease;
    }

    .mitra-back-btn:hover {
        border-color: #123F7A;
        color: #123F7A;
        background: #f8fafc;
    }

    /* =========================================================
       DARK MODE
       PROJECT MENGGUNAKAN html.dark-theme
       ========================================================= */

    html.dark-theme .mitra-detail-page {
        color: #E5E7EB !important;
    }

    html.dark-theme .mitra-detail-card {
        background: #101C2D !important;
        border-color: #263B55 !important;
        color: #E5E7EB !important;
        box-shadow: 0 14px 36px rgba(0, 0, 0, .25) !important;
    }

    html.dark-theme .mitra-detail-title {
        color: #F8FAFC !important;
    }

    html.dark-theme .mitra-detail-label,
    html.dark-theme .mitra-detail-muted {
        color: #94A3B8 !important;
    }

    html.dark-theme .mitra-detail-value {
        color: #F1F5F9 !important;
    }

    html.dark-theme .mitra-detail-divider {
        border-color: rgba(148, 163, 184, .16) !important;
    }

    html.dark-theme .mitra-detail-item:hover {
        background: rgba(255, 255, 255, .04) !important;
    }

    html.dark-theme .mitra-back-btn {
        background: #13263D !important;
        border-color: #2B405A !important;
        color: #F8FAFC !important;
    }

    html.dark-theme .mitra-back-btn:hover {
        background: #1A3150 !important;
        border-color: #60A5FA !important;
        color: #FFFFFF !important;
    }

    /* LINK LIHAT SEMUA */
    html.dark-theme .mitra-detail-card a.text-\[\#123F7A\] {
        color: #93C5FD !important;
    }
</style>


<div class="mitra-detail-page space-y-5">

    {{-- HEADER --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div class="flex items-center gap-3">

            {{-- TOMBOL KEMBALI --}}
            <a
                href="{{ route('mitra.index') }}"
                class="mitra-back-btn"
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

            <div>
                <h2 class="mitra-detail-title text-xl font-semibold">
                    {{ $mitra->nama_mitra }}
                </h2>

                <p class="mitra-detail-muted text-sm">
                    {{ $mitra->kode_mitra }}
                </p>
            </div>

        </div>

        <div class="flex items-center gap-3">

            <x-status-badge
                :color="$mitra->status === 'aktif' ? 'green' : 'gray'"
                :label="ucfirst($mitra->status)"
            />

            @role('admin_gudang', 'admin_sistem')
                <a
                    href="{{ route('mitra.edit', $mitra) }}"
                    class="btn-secondary"
                >
                    ✏️ Edit
                </a>
            @endrole

        </div>

    </div>


    {{-- CONTENT --}}
    <div class="grid grid-cols-1 gap-5 lg:grid-cols-3">

        {{-- INFORMASI MITRA --}}
        <div class="mitra-detail-card rounded-2xl p-6 lg:col-span-1">

            <h3 class="mitra-detail-title mb-5 font-semibold">
                Informasi Mitra
            </h3>

            <dl class="space-y-4 text-sm">

                <div>
                    <dt class="mitra-detail-label mb-1">
                        Penanggung Jawab
                    </dt>

                    <dd class="mitra-detail-value font-medium">
                        {{ $mitra->penanggung_jawab ?? '-' }}
                    </dd>
                </div>


                <div>
                    <dt class="mitra-detail-label mb-1">
                        Alamat
                    </dt>

                    <dd class="mitra-detail-value font-medium">
                        {{ $mitra->alamat ?? '-' }}
                    </dd>
                </div>


                <div>
                    <dt class="mitra-detail-label mb-1">
                        Kecamatan / Desa
                    </dt>

                    <dd class="mitra-detail-value font-medium">
                        {{ $mitra->kecamatan ?? '-' }}
                        /
                        {{ $mitra->desa ?? '-' }}
                    </dd>
                </div>


                <div>
                    <dt class="mitra-detail-label mb-1">
                        Telepon
                    </dt>

                    <dd class="mitra-detail-value font-medium">
                        {{ $mitra->nomor_telepon ?? '-' }}
                    </dd>
                </div>


                <div>
                    <dt class="mitra-detail-label mb-1">
                        Email
                    </dt>

                    <dd class="mitra-detail-value font-medium">
                        {{ $mitra->email ?? '-' }}
                    </dd>
                </div>


                <div>
                    <dt class="mitra-detail-label mb-1">
                        Total BA Rampung
                    </dt>

                    <dd class="mitra-detail-value font-medium">
                        {{ $mitra->ba_rampungs_count }}
                    </dd>
                </div>

            </dl>

        </div>


        {{-- BA RAMPUNG TERBARU --}}
        <div class="mitra-detail-card rounded-2xl p-6 lg:col-span-2">

            <div class="mb-4 flex items-center justify-between">

                <h3 class="mitra-detail-title font-semibold">
                    🧾 BA Rampung Terbaru dari Mitra Ini
                </h3>

                <a
                    href="{{ route('ba-rampung.index', ['mitra_pengolahan_id' => $mitra->id]) }}"
                    class="text-sm text-[#123F7A] hover:underline"
                >
                    Lihat Semua →
                </a>

            </div>


            @if ($baTerbaru->isEmpty())

                <p class="mitra-detail-muted py-6 text-center text-sm">
                    Belum ada data BA Rampung.
                </p>

            @else

                <div class="divide-y mitra-detail-divider">

                    @foreach ($baTerbaru as $ba)

                        <a
                            href="{{ route('ba-rampung.show', $ba) }}"
                            class="mitra-detail-item -mx-2 flex items-center justify-between rounded-lg px-2 py-3"
                        >

                            <div>

                                <p class="mitra-detail-value text-sm font-medium">
                                    {{ $ba->nomor_ba }}
                                </p>

                                <p class="mitra-detail-muted text-xs">
                                    {{ $ba->gudang->nama_gudang }}
                                </p>

                            </div>

                            <x-status-badge
                                :color="$ba->statusBadgeColor()"
                                :label="$ba->statusLabel()"
                            />

                        </a>

                    @endforeach

                </div>

            @endif

        </div>

    </div>

</div>

@endsection