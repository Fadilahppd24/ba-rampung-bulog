@extends('layouts.app')
@section('title', 'Detail BA Rampung')


@section('content')

<style>
    /* =========================================================
       DETAIL BA RAMPUNG — DARK MODE
       Hanya mengubah tampilan, tidak mengubah fungsi/data.
       ========================================================= */

    .ba-detail-page {
        padding-bottom: 90px;
        --detail-card-bg: rgba(255,255,255,.95);
        --detail-card-border: rgba(15,43,82,.07);
        --detail-text: #111827;
        --detail-muted: #6B7280;
        --detail-soft: #F8FAFC;
    }

    .ba-detail-page .card {
        transition: background-color .2s ease, border-color .2s ease,
                    color .2s ease, box-shadow .2s ease;
    }

    /* Mode gelap */
    .ba-detail-page.is-dark {
        color-scheme: dark;
        color: #E5E7EB;
    }

    .ba-detail-page.is-dark .card {
        background: rgba(16,28,45,.95) !important;
        border-color: #263B55 !important;
        color: #E5E7EB !important;
        box-shadow: 0 14px 36px rgba(0,0,0,.30) !important;
    }

    .ba-detail-page.is-dark .text-gray-900 {
        color: #F8FAFC !important;
    }

    .ba-detail-page.is-dark .text-gray-600,
    .ba-detail-page.is-dark .text-gray-500 {
        color: #94A3B8 !important;
    }

    .ba-detail-page.is-dark .text-gray-700 {
        color: #E2E8F0 !important;
    }

    .ba-detail-page.is-dark .text-gray-400 {
        color: #94A3B8 !important;
    }

    .ba-detail-page.is-dark .divide-gray-100 > :not([hidden]) ~ :not([hidden]) {
        border-color: rgba(148,163,184,.16) !important;
    }

    .ba-detail-page.is-dark .bg-bulog-beige\/60 {
        background: linear-gradient(90deg, rgba(147,197,253,.32), rgba(96,165,250,.22)) !important;
        color: #FFFFFF !important;
        border-bottom: 1px solid rgba(147,197,253,.55) !important;
    }

    .ba-detail-page.is-dark thead tr {
        color: #E2E8F0 !important;
    }

    .ba-detail-page.is-dark tbody tr {
        border-color: rgba(148,163,184,.16) !important;
    }

    .ba-detail-page.is-dark tbody tr:hover {
        background-color: rgba(255,255,255,.04) !important;
    }

    /* Status badge: tetap terbaca jelas di atas background foto */
    .ba-detail-page > .flex:first-child x-status-badge,
    .ba-detail-page > .flex:first-child [class*="success"],
    .ba-detail-page > .flex:first-child [class*="warning"] {
        text-shadow: 0 1px 3px rgba(0,0,0,.18);
    }

    .ba-detail-page.is-dark .text-success-text,
    .ba-detail-page.is-dark [class*="text-success-text"] {
        color: #166534 !important;
        font-weight: 700 !important;
    }

    .ba-detail-page .bg-success-bg,
    .ba-detail-page [class*="bg-success-bg"] {
        background-color: #22C55E !important;
        color: #064E3B !important;
        border: 1px solid #15803D !important;
        font-weight: 800 !important;
    }

    .ba-detail-page.is-dark .bg-success-bg,
    .ba-detail-page.is-dark [class*="bg-success-bg"] {
        background-color: #16A34A !important;
        color: #ECFDF5 !important;
        border-color: #22C55E !important;
        font-weight: 800 !important;
        box-shadow: 0 4px 14px rgba(34,197,94,.20) !important;
    }

    /* Status terverifikasi — mode gelap:
       hijau dibuat lebih pekat, tulisan tetap gelap */
    .ba-detail-page .bg-success-bg *,
    .ba-detail-page [class*="bg-success-bg"] * {
        color: inherit !important;
        font-weight: 800 !important;
    }

    .ba-detail-page.is-dark .bg-success-bg *,
    .ba-detail-page.is-dark [class*="bg-success-bg"] * {
        color: #ECFDF5 !important;
        font-weight: 800 !important;
    }

    .ba-detail-page.is-dark .bg-success-bg,
    .ba-detail-page.is-dark [class*="bg-success-bg"] {
        font-weight: 800 !important;
        text-shadow: none !important;
    }

    .ba-detail-page.is-dark .text-warning-text,
    .ba-detail-page.is-dark [class*="text-warning-text"] {
        color: #92400E !important;
        font-weight: 700 !important;
    }

    .ba-detail-page.is-dark .bg-warning-bg,
    .ba-detail-page.is-dark [class*="bg-warning-bg"] {
        background-color: #FEF3C7 !important;
        color: #92400E !important;
    }

    .ba-detail-page.is-dark .bg-danger-bg {
        background-color: rgba(239,68,68,.14) !important;
    }

    .ba-detail-page.is-dark .text-danger-text {
        color: #FCA5A5 !important;
    }

    .ba-detail-page.is-dark .border-danger-text\/30 {
        border-color: rgba(252,165,165,.30) !important;
    }

    .ba-detail-page.is-dark .bg-black\/40 {
        background-color: rgba(0,0,0,.62) !important;
    }

    /* Kontras teks utama pada mode terang */
    .ba-detail-page .text-gray-900 {
        color: #0F172A !important;
    }

    .ba-detail-page .text-gray-600 {
        color: #475569 !important;
    }

    .ba-detail-page .text-gray-500 {
        color: #64748B !important;
    }

    .ba-detail-page .font-medium {
        color: #1E293B;
    }

    /* Kontras teks utama pada mode gelap */
    .ba-detail-page.is-dark .font-medium {
        color: #F8FAFC !important;
    }

    .ba-detail-page.is-dark dt {
        color: #A8B6C8 !important;
    }

    .ba-detail-page.is-dark dd {
        color: #F1F5F9 !important;
    }

    .ba-detail-page.is-dark h2,
    .ba-detail-page.is-dark h3 {
        color: #F8FAFC !important;
    }

    .ba-detail-page.is-dark p {
        color: #CBD5E1;
    }

    .ba-detail-page.is-dark table {
        color: #E2E8F0 !important;
    }

    .ba-detail-page.is-dark thead th {
        color: #FFFFFF !important;
        background: linear-gradient(90deg, rgba(147,197,253,.32), rgba(96,165,250,.22)) !important;
        border-bottom: 1px solid rgba(147,197,253,.55) !important;
    }

    /* Header/detail title di atas background foto */
    .ba-detail-page > .flex:first-child h2 {
        color: #FFFFFF !important;
        text-shadow: 0 2px 10px rgba(0,0,0,.55);
    }

    .ba-detail-page > .flex:first-child p {
        color: rgba(255,255,255,.92) !important;
        text-shadow: 0 2px 8px rgba(0,0,0,.55);
    }

    .ba-detail-page > .flex:first-child .btn-secondary {
        color: #0F172A !important;
        background: rgba(255,255,255,.96) !important;
    }

    .ba-detail-page.is-dark > .flex:first-child h2,
    .ba-detail-page.is-dark > .flex:first-child p {
        color: #FFFFFF !important;
    }

    .ba-detail-page.is-dark > .flex:first-child p {
        color: rgba(255,255,255,.95) !important;
    }

    .ba-detail-page.is-dark tbody td {
        color: #E2E8F0 !important;
    }

    .ba-detail-page.is-dark .text-bulog-700 {
        color: #93C5FD !important;
    }

    .ba-detail-page.is-dark .text-bulog-700,
    .ba-detail-page.is-dark [class*="text-bulog-700"] {
        color: #93C5FD !important;
    }

    .ba-detail-page.is-dark .btn-secondary,
    .ba-detail-page.is-dark a.btn-secondary {
        color: #E2E8F0 !important;
        border-color: #475569 !important;
        background: #111D2E !important;
        background-color: #111D2E !important;
        box-shadow: 0 8px 22px rgba(0,0,0,.22) !important;
    }

    .ba-detail-page.is-dark .btn-secondary:hover,
    .ba-detail-page.is-dark a.btn-secondary:hover {
        color: #FFFFFF !important;
        border-color: #F28C28 !important;
        background: #172A42 !important;
        background-color: #172A42 !important;
    }

    .ba-detail-page.is-dark .btn-primary {
        color: #FFFFFF !important;
    }

    .ba-detail-page.is-dark .text-warning-text {
        color: #FDBA74 !important;
    }

    .ba-detail-page.is-dark .bg-warning-bg {
        background-color: rgba(245,158,11,.18) !important;
    }

    .ba-detail-page.is-dark .input {
        background-color: #111D2E !important;
        border-color: #2B405A !important;
        color: #F8FAFC !important;
    }

    .ba-detail-page.is-dark .input::placeholder {
        color: #94A3B8 !important;
    }

    .ba-detail-page #modal-verifikasi .card {
        background: #FFFFFF;
        border: 1px solid rgba(15,43,82,.10);
    }

    .ba-detail-page.is-dark #modal-verifikasi .card {
        background: #101C2D !important;
        border-color: #263B55 !important;
        color: #E5E7EB !important;
        box-shadow: 0 24px 60px rgba(0,0,0,.45) !important;
    }

    .ba-detail-page.is-dark #modal-verifikasi h3 {
        color: #F8FAFC !important;
    }

    .ba-detail-page.is-dark #modal-verifikasi p {
        color: #AEBFD1 !important;
    }

    .ba-detail-page.is-dark #modal-verifikasi .bg-blue-100 {
        background: rgba(59,130,246,.16) !important;
        color: #93C5FD !important;
    }

</style>

<div class="ba-detail-page">



<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
    <div>
    <p class="text-sm font-semibold uppercase tracking-wider text-orange-400">
        BA RAMPUNG
    </p>

    <h1 class="mt-1 text-2xl font-bold text-white">
        Detail BA Rampung
    </h1>

    <p class="mt-2 text-base font-semibold text-white/95">
        {{ $baRampung->nomor_ba }}
    </p>

    <p class="mt-1 text-sm text-white/80">
        Dibuat oleh {{ $baRampung->pembuat->name ?? '-' }}
        · {{ $baRampung->created_at?->timezone('Asia/Jakarta')->format('d/m/Y H:i') ?? '-' }}
    </p>
</div>

    <div class="flex flex-wrap items-center justify-end gap-3">
        {{-- KEMBALI KE DAFTAR BA --}}
        <a
            href="{{ route('ba-rampung.index') }}"
            class="btn-secondary"
        >
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 12H5m6-6-6 6 6 6"/>
            </svg>
            Kembali
        </a>

        <x-status-badge
            :color="$baRampung->statusBadgeColor()"
            :label="$baRampung->statusLabel()"
            class="text-sm px-3 py-1.5"
        />

        {{-- PDF HANYA MUNCUL JIKA BA SUDAH DISETUJUI / TERVERIFIKASI --}}
        @php
            $statusPdf = strtolower(trim((string) $baRampung->statusLabel()));
            $bolehCetakPdf = in_array($statusPdf, [
                'disetujui',
                'terverifikasi',
                'diterima',
            ], true);
        @endphp

        @if($bolehCetakPdf)
            <a
                href="{{ route('ba-rampung.pdf', $baRampung) }}"
                target="_blank"
                class="btn-secondary"
            >
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M6 9V4h12v5M6 18H4a2 2 0 0 0-2 2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2M6 14h12v6H6v-6Z"/>
                </svg>
                Cetak PDF
            </a>
        @endif

        @can('update', $baRampung)
            <a
                href="{{ route('ba-rampung.edit', $baRampung) }}"
                class="btn-secondary"
            >
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="m15.5 5.5 3 3M4 20l3.5-.7L19.2 7.6a2.1 2.1 0 0 0-3-3L4.5 16.3 4 20Z"/>
                </svg> Edit
            </a>
        @endcan
    </div>
</div>


{{-- ALASAN PENOLAKAN --}}
@if (
    $baRampung->status === \App\Models\BaRampung::STATUS_DITOLAK
    && $baRampung->alasan_penolakan
)
    <div class="rounded-xl bg-danger-bg text-danger-text px-4 py-3 text-sm mt-5">
        <p class="font-medium">Alasan Penolakan:</p>
        <p>{{ $baRampung->alasan_penolakan }}</p>
    </div>
@endif


{{-- VERIFIKASI --}}
@can('verify', $baRampung)

    <div class="card p-6 border-l-4 border-l-warning-text mt-5">
        <h3 class="font-semibold text-gray-900 mb-3 flex items-center gap-2">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="m9 12 2 2 4-4M12 3l7 3v5c0 4.5-3 8.2-7 10-4-1.8-7-5.5-7-10V6l7-3Z"/>
                </svg> Verifikasi &amp; Approval
        </h3>

        <p class="text-sm text-gray-500 mb-4">
            BA ini menunggu keputusan Anda sebagai Admin Kantor.
        </p>

        <div class="flex flex-wrap gap-3">

            {{-- TERIMA --}}
            <form
                method="POST"
                action="{{ route('ba-rampung.verify', $baRampung) }}"
                id="form-verifikasi-ba"
            >
                @csrf

                <input
                    type="hidden"
                    name="keputusan"
                    value="terima"
                >

                <button
                    type="button"
                    onclick="document.getElementById('modal-verifikasi').classList.remove('hidden')"
                    class="btn-primary"
                >
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m5 12 4 4L19 6"/>
                    </svg> Verifikasi &amp; Terima
                </button>
            </form>


            {{-- TOLAK --}}
            <button
                type="button"
                onclick="document.getElementById('modal-tolak').classList.remove('hidden')"
                class="btn-secondary text-danger-text border-danger-text/30"
            >
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M6 6l12 12M18 6 6 18"/>
                </svg> Tolak
            </button>

        </div>
    </div>


    {{-- MODAL KONFIRMASI VERIFIKASI --}}
    <div
        id="modal-verifikasi"
        class="hidden fixed inset-0 z-[9999] flex items-center justify-center bg-black/55 px-4 backdrop-blur-sm"
    >
        <div class="card w-full max-w-md rounded-2xl p-6 shadow-2xl">
            <div class="flex items-start gap-4">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-blue-100 text-[#123F7A]">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="m5 12 4 4L19 6"/>
                    </svg>
                </div>

                <div class="min-w-0 flex-1">
                    <h3 class="font-semibold text-gray-900">
                        Verifikasi BA Rampung
                    </h3>

                    <p class="mt-2 text-sm text-gray-500">
                        Apakah Anda yakin ingin memverifikasi dan menerima
                        BA Rampung <strong>{{ $baRampung->nomor_ba }}</strong>?
                    </p>
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button
                    type="button"
                    onclick="document.getElementById('modal-verifikasi').classList.add('hidden')"
                    class="btn-secondary"
                >
                    Batal
                </button>

                <button
                    type="button"
                    onclick="document.getElementById('form-verifikasi-ba').submit()"
                    class="btn-primary"
                >
                    Ya, Verifikasi
                </button>
            </div>
        </div>
    </div>

    {{-- MODAL TOLAK --}}
    <div
        id="modal-tolak"
        class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4"
    >
        <div class="card p-6 w-full max-w-md">

            <h3 class="font-semibold text-gray-900 mb-3 flex items-center gap-2">
                Tolak BA Rampung
            </h3>

            <form
                method="POST"
                action="{{ route('ba-rampung.verify', $baRampung) }}"
            >
                @csrf

                <input
                    type="hidden"
                    name="keputusan"
                    value="tolak"
                >

                <label class="label">
                    Alasan Penolakan
                </label>

                <textarea
                    name="alasan_penolakan"
                    rows="3"
                    required
                    class="input"
                    placeholder="Jelaskan alasan penolakan..."
                ></textarea>

                <div class="flex justify-end gap-3 mt-4">

                    <button
                        type="button"
                        onclick="document.getElementById('modal-tolak').classList.add('hidden')"
                        class="btn-secondary"
                    >
                        Batal
                    </button>

                    <button
                        type="submit"
                        class="btn-primary bg-danger-text hover:bg-danger-text/90"
                    >
                        Tolak BA
                    </button>

                </div>
            </form>

        </div>
    </div>

@endcan


{{-- DATA BA + PENANDATANGAN --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mt-5">

    {{-- DATA BA --}}
    <div class="card p-6">

        <h3 class="font-semibold text-gray-900 mb-4 flex items-center gap-2">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 3h7l4 4v14H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2Z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M14 3v5h5M9 13h6M9 17h6"/>
            </svg> Data BA Rampung
        </h3>

        <dl class="space-y-3 text-sm">

            <div class="flex justify-between gap-4">
                <dt class="text-gray-500">
                    Tanggal BA
                </dt>

                <dd class="font-medium text-right">
                    {{ $baRampung->hari }},
                    {{ $baRampung->tanggal_ba->format('d') }}
                    {{ $baRampung->bulan }}
                    {{ $baRampung->tahun }}
                </dd>
            </div>

            <div class="flex justify-between gap-4">
                <dt class="text-gray-500">
                    Nomor MO
                </dt>

                <dd class="font-medium text-right">
                    {{ $baRampung->nomor_mo ?? '-' }}
                </dd>
            </div>

            <div class="flex justify-between gap-4">
                <dt class="text-gray-500">
                    Nomor PO
                </dt>

                <dd class="font-medium text-right">
                    {{ $baRampung->nomor_po ?? '-' }}
                </dd>
            </div>

            <div class="flex justify-between gap-4">
                <dt class="text-gray-500">
                    Gudang
                </dt>

                <dd class="font-medium text-right">
                    {{ $baRampung->gudang->nama_gudang ?? '-' }}
                </dd>
            </div>

            <div class="flex justify-between gap-4">
                <dt class="text-gray-500">
                    Mitra Pengolahan
                </dt>

                <dd class="font-medium text-right">
                    {{ $baRampung->mitraPengolahan->nama_mitra ?? '-' }}
                </dd>
            </div>

        </dl>

    </div>


    {{-- PENANDATANGANAN --}}
    <div class="card p-6">

        <h3 class="font-semibold text-gray-900 mb-4 flex items-center gap-2">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 18c2.5-3 5.5-4 8-2.5 2.1 1.2 3.5 1 5.5-1M5 20h14M7 15l7-7 3 3-7 7H7v-3Z"/>
            </svg> Penandatanganan
        </h3>

        <dl class="space-y-3 text-sm">

            {{-- PIHAK KESATU --}}
            <div class="flex justify-between gap-4">
                <dt class="text-gray-500">
                    Pihak Kesatu
                </dt>

                <dd class="font-medium text-right">
                    {{ $baRampung->nama_penandatangan ?? '-' }}
                    —
                    {{ $baRampung->jabatan_penandatangan ?? '-' }}
                </dd>
            </div>


            {{-- PIHAK KEDUA --}}
            <div class="flex justify-between gap-4">
                <dt class="text-gray-500">
                    Pihak Kedua
                </dt>

                <dd class="font-medium text-right">
                    {{ $baRampung->nama_penandatangan_pihak_kedua ?? '-' }}
                    —
                    {{ $baRampung->jabatan_penandatangan_pihak_kedua ?? '-' }}
                </dd>
            </div>


            {{-- MENGETAHUI --}}
            <div class="flex justify-between gap-4">
                <dt class="text-gray-500">
                    Mengetahui
                </dt>

                <dd class="font-medium text-right">
                    {{ $baRampung->pimpinanCabang->nama ?? '-' }}
                </dd>
            </div>


            {{-- VERIFIKATOR --}}
            <div class="flex justify-between gap-4">
                <dt class="text-gray-500">
                    Diverifikasi oleh
                </dt>

                <dd class="font-medium text-right">
                    {{ $baRampung->verifikator->name ?? '-' }}
                </dd>
            </div>


            {{-- TANGGAL VERIFIKASI --}}
            <div class="flex justify-between gap-4">
                <dt class="text-gray-500">
                    Tanggal Verifikasi
                </dt>

                <dd class="font-medium text-right">
                    {{ $baRampung->verified_at?->format('d/m/Y H:i') ?? '-' }}
                </dd>
            </div>

        </dl>

    </div>

</div>


{{-- PRODUKSI --}}
<div class="card p-6 mt-5">

    <h3 class="font-semibold text-gray-900 mb-4 flex items-center gap-2">
        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 21c-4-3-6-6.2-6-10a6 6 0 0 1 6-6c0 4.2-2 7-5 9M12 21c4-3 6-6.2 6-10a6 6 0 0 0-6-6"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 5v16"/>
            </svg> Pengolahan Gabah (GKP)
        → Beras Hasil Giling (HGL)
    </h3>

    <div class="overflow-x-auto">

        <table class="w-full text-sm">

            <thead>

                <tr class="bg-bulog-beige/60 text-left text-gray-600">

                    <th class="px-4 py-2.5 font-medium">
                        Produk Sebelum
                    </th>

                    <th class="px-4 py-2.5 font-medium">
                        Kuantum (Kg)
                    </th>

                    <th class="px-4 py-2.5 font-medium">
                        Produk Sesudah
                    </th>

                    <th class="px-4 py-2.5 font-medium">
                        Kuantum (Kg)
                    </th>

                    <th class="px-4 py-2.5 font-medium">
                        Rendemen (%)
                    </th>

                </tr>

            </thead>

            <tbody class="divide-y divide-gray-100">

                @forelse ($baRampung->produksis as $index => $p)

                    <tr>

                        @if ($index === 0)
                            <td
                                rowspan="{{ $baRampung->produksis->count() }}"
                                class="px-4 py-3 align-middle"
                            >
                                {{ $p->produk_sebelum }}
                            </td>

                            <td
                                rowspan="{{ $baRampung->produksis->count() }}"
                                class="px-4 py-3 align-middle"
                            >
                                {{ number_format($p->kuantum_sebelum, 0, ',', '.') }}
                            </td>
                        @endif

                        <td class="px-4 py-3">
                            {{ $p->produk_sesudah }}
                        </td>

                        <td class="px-4 py-3">
                            {{ number_format($p->kuantum_sesudah, 0, ',', '.') }}
                        </td>

                        <td class="px-4 py-3 font-medium text-bulog-700">
                            {{ number_format($p->rendemen, 2, ',', '.') }}%
                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="5"
                            class="px-4 py-8 text-center text-gray-500"
                        >
                            Belum ada data produksi.
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>


{{-- CATATAN --}}
@if ($baRampung->catatan)

    <div class="card p-6 mt-5">

        <h3 class="font-semibold text-gray-900 mb-2 flex items-center gap-2">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5 4h14v16H5zM8 8h8M8 12h8M8 16h5"/>
            </svg> Catatan
        </h3>

        <p class="text-sm text-gray-600">
            {{ $baRampung->catatan }}
        </p>

    </div>

@endif


<script>
document.addEventListener('DOMContentLoaded', function () {
    const page = document.querySelector('.ba-detail-page');
    if (!page) return;

    const CLASS_OK  = /(dark|night)/i;
    const CLASS_BAD = /:|^(bg|text|border|btn|navbar|table|fill|stroke|ring|from|to|via|hover|focus|placeholder|divide|shadow|outline|alert|badge)[-_]/i;
    const ATTR_OK   = /^(dark|night)([-_ ]?(mode|theme))?$/i;

    function elementIsDark(el) {
        for (const t of el.classList) {
            if (CLASS_OK.test(t) && !CLASS_BAD.test(t)) return true;
        }

        for (const a of el.attributes) {
            if ((a.name.startsWith('data-') || a.name === 'theme') &&
                ATTR_OK.test((a.value || '').trim())) {
                return true;
            }
        }

        return false;
    }

    function markerDark() {
        for (let el = page.parentElement; el; el = el.parentElement) {
            if (elementIsDark(el)) return true;
        }

        const root = getComputedStyle(document.documentElement).colorScheme || '';
        const body = getComputedStyle(document.body).colorScheme || '';

        return root.trim() === 'dark' || body.trim() === 'dark';
    }

    const canvas = document.createElement('canvas');
    canvas.width = canvas.height = 1;
    const ctx = canvas.getContext('2d', { willReadFrequently: true });

    function rgba(color) {
        ctx.clearRect(0, 0, 1, 1);
        ctx.fillStyle = '#000';
        ctx.fillStyle = color;
        ctx.fillRect(0, 0, 1, 1);
        const d = ctx.getImageData(0, 0, 1, 1).data;
        return { r: d[0], g: d[1], b: d[2], a: d[3] / 255 };
    }

    function luminance(c) {
        return (0.2126 * c.r + 0.7152 * c.g + 0.0722 * c.b) / 255;
    }

    const probes = {
        bg: document.createElement('span'),
        t1: document.createElement('span'),
        t2: document.createElement('span')
    };

    probes.bg.className = 'bg-white';
    probes.t1.className = 'text-gray-700';
    probes.t2.className = 'text-gray-600';

    Object.values(probes).forEach(function (p) {
        p.hidden = true;
        p.setAttribute('aria-hidden', 'true');
        page.parentElement.insertBefore(p, page);
    });

    function probeDark() {
        const bg = rgba(getComputedStyle(probes.bg).backgroundColor);
        if (bg.a > 0.5 && luminance(bg) < 0.45) return true;

        const t1 = rgba(getComputedStyle(probes.t1).color);
        if (t1.a > 0.5 && luminance(t1) > 0.6) return true;

        const t2 = rgba(getComputedStyle(probes.t2).color);
        if (t2.a > 0.5 && luminance(t2) > 0.6) return true;

        return false;
    }

    function isDark() {
        return markerDark() || probeDark();
    }

    let last = null;

    function sync() {
        const dark = isDark();
        if (dark === last) return;

        last = dark;
        page.classList.toggle('is-dark', dark);
    }

    let raf = null;

    function schedule() {
        if (raf) cancelAnimationFrame(raf);
        raf = requestAnimationFrame(sync);
    }

    sync();

    const observer = new MutationObserver(schedule);

    for (let el = page.parentElement; el; el = el.parentElement) {
        observer.observe(el, { attributes: true });
    }

    document.addEventListener('click', function () {
        [50, 250, 600].forEach(function (ms) {
            setTimeout(schedule, ms);
        });
    });

    window.addEventListener('storage', schedule);

    if (window.matchMedia) {
        window.matchMedia('(prefers-color-scheme: dark)')
            .addEventListener('change', schedule);
    }
});
</script>

</div>

@endsection