@extends('layouts.app')


@section('title', 'Edit BA Rampung')

@php
    $beras = $baRampung->produksis->firstWhere('produk_sesudah', 'Beras (HGL)');
    $menir = $baRampung->produksis->firstWhere('produk_sesudah', 'Menir');
    $bekatul = $baRampung->produksis->firstWhere('produk_sesudah', 'Bekatul');

    $gabahAwal = $beras->kuantum_sebelum ?? 0;
@endphp

@section('content')


{{-- POPUP NOTIFIKASI BERHASIL / GAGAL --}}
@if(session('success') || session('error') || $errors->any())
    <div id="ba-rampung-alert" class="ba-rampung-alert-overlay" role="dialog" aria-modal="true" aria-labelledby="ba-rampung-alert-title">
        <div class="ba-rampung-alert-card">
            @if(session('success'))
                <div class="ba-rampung-alert-icon success" aria-hidden="true">✓</div>
                <h2 id="ba-rampung-alert-title">Berhasil!</h2>
                <p>{{ session('success') }}</p>
            @else
                <div class="ba-rampung-alert-icon error" aria-hidden="true">!</div>
                <h2 id="ba-rampung-alert-title">Gagal!</h2>
                <p>{{ session('error') ?? $errors->first() ?? 'Data BA Rampung belum berhasil disimpan.' }}</p>
                @if($errors->count() > 1)
                    <ul class="ba-rampung-alert-errors">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
            @endif
            <button type="button" class="ba-rampung-alert-ok" onclick="closeBaRampungAlert()">OKE</button>
        </div>
    </div>
@endif

<style>
    .ba-rampung-alert-overlay {
        position: fixed;
        inset: 0;
        z-index: 99999;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        background: rgba(5, 18, 35, .62);
        backdrop-filter: blur(5px);
        -webkit-backdrop-filter: blur(5px);
    }
    .ba-rampung-alert-card {
        width: min(100%, 420px);
        padding: 30px 28px 26px;
        border: 1px solid rgba(15, 43, 82, .12);
        border-radius: 22px;
        background: #fff;
        color: #102A48;
        text-align: center;
        box-shadow: 0 24px 70px rgba(0,0,0,.28);
        animation: baRampungAlertIn .22s ease-out;
    }
    .ba-rampung-alert-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 62px;
        height: 62px;
        margin: 0 auto 14px;
        border-radius: 50%;
        font-size: 36px;
        font-weight: 800;
    }
    .ba-rampung-alert-icon.success { background: #DCFCE7; color: #15803D; }
    .ba-rampung-alert-icon.error { background: #FEE2E2; color: #B91C1C; }
    .ba-rampung-alert-card h2 { margin: 0 0 9px; font-size: 24px; font-weight: 800; color: #102A48; }
    .ba-rampung-alert-card p { margin: 0; color: #52657A; line-height: 1.6; overflow-wrap: anywhere; }
    .ba-rampung-alert-errors { margin: 12px 0 0; padding-left: 20px; text-align: left; color: #B91C1C; font-size: 13px; }
    .ba-rampung-alert-ok {
        min-width: 110px;
        margin-top: 22px;
        padding: 10px 24px;
        border: 0;
        border-radius: 10px;
        background: #0B2E59;
        color: #fff;
        font-weight: 700;
        cursor: pointer;
    }
    .ba-rampung-alert-ok:hover { background: #164477; }
    @keyframes baRampungAlertIn {
        from { opacity: 0; transform: translateY(8px) scale(.97); }
        to { opacity: 1; transform: translateY(0) scale(1); }
    }
</style>
<script>
    function closeBaRampungAlert() {
        const popup = document.getElementById('ba-rampung-alert');
        if (popup) popup.remove();
    }
    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') closeBaRampungAlert();
    });
</script>


<style>
    /* =========================================================
       EDIT BA RAMPUNG — HEADER + LIGHT/DARK MODE
       ========================================================= */
    .ba-edit-page {
        position: relative;
        width: 100%;
        color: #0B2545;
    }

    .ba-edit-page .ba-edit-header {
        position: relative;
        width: 100%;
        margin: 0 auto 1.5rem;
        padding: .25rem 190px .5rem;
        text-align: center;
    }

    .ba-edit-page .ba-edit-kicker {
        color: #DBEAFE !important;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .32em;
        line-height: 1.5;
        text-transform: uppercase;
        margin: 0 0 8px;
        text-shadow: 0 2px 8px rgba(0,0,0,.35);
    }

    .ba-edit-page .ba-edit-title {
        color: #FFFFFF !important;
        font-family: 'Cormorant Garamond', Georgia, serif;
        font-size: clamp(38px, 4.5vw, 58px);
        font-weight: 500;
        letter-spacing: -.025em;
        line-height: .98;
        text-shadow: 0 3px 14px rgba(0,0,0,.42);
        margin: 0 !important;
    }

    .ba-edit-page .ba-edit-title .title-accent {
        color: #F28C28 !important;
    }

    .ba-edit-page .ba-edit-back {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: .45rem;
        padding: .65rem 1rem;
        border-radius: .75rem;
        background: #082F63 !important;
        border: 1px solid rgba(255,255,255,.18);
        color: #FFFFFF !important;
        font-size: .85rem;
        font-weight: 600;
        text-decoration: none;
        box-shadow: 0 8px 20px rgba(8,47,99,.25);
        transition: background-color .2s ease, transform .2s ease;
    }

    .ba-edit-page .ba-edit-back:hover {
        background: #0B4387 !important;
        color: #FFFFFF !important;
        transform: translateY(-1px);
    }

    @media (min-width: 768px) {
        .ba-edit-page .ba-edit-back {
            position: absolute;
            top: 1.4rem;
            right: .25rem;
        }
    }

    @media (max-width: 767px) {
        .ba-edit-page .ba-edit-back {
            margin-top: .8rem;
        }
    }

    .ba-edit-page .ba-edit-subtitle {
        color: rgba(255,255,255,.86) !important;
        font-size: 12px;
        margin-top: .55rem;
        text-shadow: 0 2px 8px rgba(0,0,0,.4);
    }

    @media (max-width: 767px) {
        .ba-edit-page .ba-edit-header {
            padding: .25rem 0 .5rem;
        }

        .ba-edit-page .ba-edit-title {
            font-size: clamp(36px, 9vw, 48px);
        }
    }

    .ba-edit-page .card {
        position: relative;
        overflow: hidden;
        background: rgba(250,251,253,.96) !important;
        border: 1px solid rgba(15,43,82,.08);
        border-radius: 1.5rem;
        box-shadow: 0 12px 35px rgba(15,23,42,.10);
        transition: background-color .2s ease, color .2s ease, border-color .2s ease;
    }

    .ba-edit-page .card::before {
        content: "";
        position: absolute;
        left: 0;
        right: 0;
        top: 0;
        height: 3px;
        background: linear-gradient(
            90deg,
            #F28C28 0,
            #F28C28 84px,
            #082F63 84px,
            rgba(8,47,99,.85) 100%
        );
        pointer-events: none;
    }

    .ba-edit-page .card h3,
    .ba-edit-page .card th,
    .ba-edit-page .card td {
        color: #0B2545 !important;
    }

    .ba-edit-page .card p,
    .ba-edit-page .card .text-gray-500 {
        color: #64748B !important;
    }

    .ba-edit-page .card .text-gray-600 {
        color: #475569 !important;
    }

    .ba-edit-page .card .text-gray-700 {
        color: #334155 !important;
    }

    .ba-edit-page .label {
        display: block;
        margin-bottom: .45rem;
        color: #475569 !important;
        font-size: .72rem;
        font-weight: 700;
        letter-spacing: .06em;
        text-transform: uppercase;
    }

    .ba-edit-page .input {
        border: 1px solid #D9E2EC !important;
        border-radius: .85rem;
        background-color: #F8FAFC !important;
        color: #0B2545 !important;
        outline: none;
        transition: border-color .2s ease, box-shadow .2s ease, background-color .2s ease;
    }

    .ba-edit-page .input:focus {
        border-color: #F28C28 !important;
        background-color: #FFFFFF !important;
        box-shadow: 0 0 0 3px rgba(242,140,40,.18);
    }

    .ba-edit-page .input::placeholder {
        color: #94A3B8 !important;
    }

    .ba-edit-page .bg-gray-50 {
        background-color: #F1F5F9 !important;
        color: #64748B !important;
    }

    .ba-edit-page .divide-gray-100 > :not([hidden]) ~ :not([hidden]) {
        border-color: #E2E8F0 !important;
    }

    /* ---------------- DARK MODE ----------------
       Mendukung semua penanda theme yang dipakai layout.
    */
    .ba-edit-page.is-dark,
    html.dark .ba-edit-page,
    body.dark .ba-edit-page,
    html.dark-mode .ba-edit-page,
    body.dark-mode .ba-edit-page,
    html.theme-dark .ba-edit-page,
    body.theme-dark .ba-edit-page,
    html[data-theme="dark"] .ba-edit-page,
    body[data-theme="dark"] .ba-edit-page,
    html[data-bs-theme="dark"] .ba-edit-page,
    body[data-bs-theme="dark"] .ba-edit-page {
        color: #E7EEF7 !important;
    }

    .ba-edit-page.is-dark .ba-edit-title,
    html.dark .ba-edit-page .ba-edit-title,
    body.dark .ba-edit-page .ba-edit-title,
    html.dark-mode .ba-edit-page .ba-edit-title,
    body.dark-mode .ba-edit-page .ba-edit-title,
    html.theme-dark .ba-edit-page .ba-edit-title,
    body.theme-dark .ba-edit-page .ba-edit-title,
    html[data-theme="dark"] .ba-edit-page .ba-edit-title,
    body[data-theme="dark"] .ba-edit-page .ba-edit-title {
        color: #F1F5F9 !important;
    }

    .ba-edit-page.is-dark .ba-edit-subtitle,
    html.dark .ba-edit-page .ba-edit-subtitle,
    body.dark .ba-edit-page .ba-edit-subtitle,
    html.dark-mode .ba-edit-page .ba-edit-subtitle,
    body.dark-mode .ba-edit-page .ba-edit-subtitle,
    html.theme-dark .ba-edit-page .ba-edit-subtitle,
    body.theme-dark .ba-edit-page .ba-edit-subtitle,
    html[data-theme="dark"] .ba-edit-page .ba-edit-subtitle,
    body[data-theme="dark"] .ba-edit-page .ba-edit-subtitle {
        color: #AFC0D4 !important;
    }

    .ba-edit-page.is-dark .card,
    html.dark .ba-edit-page .card,
    body.dark .ba-edit-page .card,
    html.dark-mode .ba-edit-page .card,
    body.dark-mode .ba-edit-page .card,
    html.theme-dark .ba-edit-page .card,
    body.theme-dark .ba-edit-page .card,
    html[data-theme="dark"] .ba-edit-page .card,
    body[data-theme="dark"] .ba-edit-page .card,
    html[data-bs-theme="dark"] .ba-edit-page .card,
    body[data-bs-theme="dark"] .ba-edit-page .card {
        background: rgba(11,27,47,.95) !important;
        border-color: rgba(148,163,184,.18) !important;
        box-shadow: 0 16px 40px rgba(0,0,0,.28);
    }

    .ba-edit-page.is-dark .card h3,
    .ba-edit-page.is-dark .card th,
    .ba-edit-page.is-dark .card td,
    html.dark .ba-edit-page .card h3,
    html.dark .ba-edit-page .card th,
    html.dark .ba-edit-page .card td,
    body.dark .ba-edit-page .card h3,
    body.dark .ba-edit-page .card th,
    body.dark .ba-edit-page .card td {
        color: #E7EEF7 !important;
    }

    .ba-edit-page.is-dark .card p,
    .ba-edit-page.is-dark .card .text-gray-500,
    .ba-edit-page.is-dark .card .text-gray-600,
    html.dark .ba-edit-page .card p,
    html.dark .ba-edit-page .card .text-gray-500,
    html.dark .ba-edit-page .card .text-gray-600 {
        color: #AFC0D4 !important;
    }

    .ba-edit-page.is-dark .label,
    html.dark .ba-edit-page .label,
    body.dark .ba-edit-page .label {
        color: #B9C8D9 !important;
    }

    .ba-edit-page.is-dark .input,
    html.dark .ba-edit-page .input,
    body.dark .ba-edit-page .input,
    html.dark-mode .ba-edit-page .input,
    body.dark-mode .ba-edit-page .input,
    html[data-theme="dark"] .ba-edit-page .input,
    body[data-theme="dark"] .ba-edit-page .input {
        background-color: #17283D !important;
        border-color: #304760 !important;
        color: #E7EEF7 !important;
    }

    .ba-edit-page.is-dark .input:focus,
    html.dark .ba-edit-page .input:focus,
    body.dark .ba-edit-page .input:focus {
        background-color: #1B3048 !important;
        border-color: #F28C28 !important;
    }

    .ba-edit-page.is-dark .bg-gray-50,
    html.dark .ba-edit-page .bg-gray-50,
    body.dark .ba-edit-page .bg-gray-50 {
        background-color: #17283D !important;
        color: #AFC0D4 !important;
    }

    .ba-edit-page.is-dark .divide-gray-100 > :not([hidden]) ~ :not([hidden]),
    html.dark .ba-edit-page .divide-gray-100 > :not([hidden]) ~ :not([hidden]) {
        border-color: rgba(148,163,184,.16) !important;
    }

    /* =========================================================
       FIX DARK MODE — LAYOUT UTAMA MENGGUNAKAN html.dark-theme
       ========================================================= */

    html.dark-theme .ba-edit-page .ba-edit-title {
        color: #F1F5F9 !important;
    }

    html.dark-theme .ba-edit-page .ba-edit-subtitle {
        color: #AFC0D4 !important;
    }

    html.dark-theme .ba-edit-page .ba-edit-kicker {
        color: #F28C28 !important;
    }

    html.dark-theme .ba-edit-page .card {
        background: rgba(7, 26, 46, .92) !important;
        border-color: rgba(148,163,184,.18) !important;
        box-shadow: 0 16px 40px rgba(0,0,0,.30) !important;
        color: #E7EEF7 !important;
    }

    html.dark-theme .ba-edit-page .card h3,
    html.dark-theme .ba-edit-page .card h4,
    html.dark-theme .ba-edit-page .card th,
    html.dark-theme .ba-edit-page .card td,
    html.dark-theme .ba-edit-page .card label,
    html.dark-theme .ba-edit-page .card span,
    html.dark-theme .ba-edit-page .card p {
        color: #E7EEF7 !important;
    }

    html.dark-theme .ba-edit-page .card .text-gray-500,
    html.dark-theme .ba-edit-page .card .text-gray-600,
    html.dark-theme .ba-edit-page .card .text-gray-700 {
        color: #AFC0D4 !important;
    }

    html.dark-theme .ba-edit-page .label {
        color: #D5E0EC !important;
    }

    html.dark-theme .ba-edit-page .input,
    html.dark-theme .ba-edit-page select.input,
    html.dark-theme .ba-edit-page textarea.input {
        background-color: #162B43 !important;
        border-color: #38536F !important;
        color: #F1F5F9 !important;
        -webkit-text-fill-color: #F1F5F9 !important;
    }

    html.dark-theme .ba-edit-page .input:disabled,
    html.dark-theme .ba-edit-page .input[readonly],
    html.dark-theme .ba-edit-page select.input:disabled {
        background-color: #20354C !important;
        border-color: #46617B !important;
        color: #DCE7F2 !important;
        -webkit-text-fill-color: #DCE7F2 !important;
        opacity: 1 !important;
    }

    html.dark-theme .ba-edit-page .input::placeholder {
        color: #91A6BB !important;
    }

    html.dark-theme .ba-edit-page select.input option {
        background: #162B43 !important;
        color: #F1F5F9 !important;
    }

    html.dark-theme .ba-edit-page .bg-gray-50 {
        background-color: #162B43 !important;
        color: #C7D4E2 !important;
    }

    html.dark-theme .ba-edit-page .divide-gray-100 > :not([hidden]) ~ :not([hidden]) {
        border-color: rgba(148,163,184,.18) !important;
    }

    /* Tombol: jangan tetap putih saat mode gelap */
    html.dark-theme .ba-edit-page .btn-secondary {
        background: rgba(22,43,67,.96) !important;
        border-color: #46617B !important;
        color: #E7EEF7 !important;
    }

    html.dark-theme .ba-edit-page .btn-secondary:hover {
        background: #29435E !important;
        color: #FFFFFF !important;
    }

    html.dark-theme .ba-edit-page .btn-primary {
        background: #0B4D93 !important;
        border-color: #0B4D93 !important;
        color: #FFFFFF !important;
    }

    html.dark-theme .ba-edit-page .btn-primary:hover {
        background: #0E61B5 !important;
        color: #FFFFFF !important;
    }

    html.dark-theme .ba-edit-page button,
    html.dark-theme .ba-edit-page a {
        -webkit-text-fill-color: currentColor;
    }


    /* HEADER TABEL DARK MODE — teks harus kontras */
    html.dark-theme .ba-edit-page .card thead,
    html.dark-theme .ba-edit-page .card thead tr {
        background: #29435E !important;
    }

    html.dark-theme .ba-edit-page .card thead th {
        background: #29435E !important;
        color: #F8FAFC !important;
        -webkit-text-fill-color: #F8FAFC !important;
        font-weight: 700 !important;
        border-color: #46617B !important;
    }

    html.dark-theme .ba-edit-page .card thead th * {
        color: #F8FAFC !important;
        -webkit-text-fill-color: #F8FAFC !important;
    }

    html.dark-theme .ba-edit-page .card tbody td {
        color: #E7EEF7 !important;
        -webkit-text-fill-color: #E7EEF7 !important;
    }

</style>

<div class="ba-edit-page">
    <div class="ba-edit-header">
        <div class="ba-edit-kicker">BA RAMPUNG</div>
        <h1 class="ba-edit-title">Edit <span class="title-accent">BA Rampung</span></h1>
        <p class="ba-edit-subtitle">
            Perbarui data BA Rampung {{ $baRampung->nomor_ba }}.
        </p>
        <a href="{{ route('ba-rampung.show', $baRampung) }}" class="ba-edit-back">
            ← Kembali
        </a>
    </div>



<form
    method="POST"
    action="{{ route('ba-rampung.update', $baRampung) }}"
    x-data="baForm({
        gabah: {{ old('kuantum_gabah', $gabahAwal) }},
        beras: {{ old('kuantum_beras', $beras->kuantum_sesudah ?? 0) }},
        menir: {{ old('kuantum_menir', $menir->kuantum_sesudah ?? 0) }},
        bekatul: {{ old('kuantum_bekatul', $bekatul->kuantum_sesudah ?? 0) }},
        tanggal: '{{ old('tanggal_ba', $baRampung->tanggal_ba->toDateString()) }}'
    })"
    class="space-y-6"
>

    @csrf
    @method('PUT')


    {{-- ========================================================= --}}
    {{-- 1. DATA BA RAMPUNG --}}
    {{-- ========================================================= --}}

    <div class="card p-6">

        <h3 class="font-semibold text-gray-900 mb-5">
            📄 1. Data BA Rampung — {{ $baRampung->nomor_ba }}
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

            {{-- Nomor BA --}}
            <div>
                <label class="label">Nomor BA</label>

                <input
    type="text"
    name="nomor_ba"
    value="{{ old('nomor_ba', $baRampung->nomor_ba) }}"
    class="input"
    placeholder="Masukkan nomor BA"
>
            </div>


            {{-- Hari / Tanggal / Tahun --}}
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

                    <input
                        type="date"
                        name="tanggal_ba"
                        x-model="tanggal"
                        required
                        class="input"
                    >
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


            {{-- Nomor dan Tanggal MO (opsional) --}}
            <div class="space-y-3">
                <div>
                    <label class="label">Nomor Manufacturing Order (MO)</label>
                    <input type="text" name="nomor_mo"
                        value="{{ old('nomor_mo', $baRampung->nomor_mo) }}"
                        class="input w-full" placeholder="Masukkan nomor MO (opsional)">
                </div>
                <div>
                    <label class="label">Tanggal Manufacturing Order (MO)</label>
                    <input type="date" name="tanggal_mo"
                        value="{{ old('tanggal_mo', $baRampung->tanggal_mo?->format('Y-m-d')) }}"
                        class="input w-full">
                </div>
            </div>

            {{-- Nomor dan Tanggal PO (opsional) --}}
            <div class="space-y-3">
                <div>
                    <label class="label">Nomor Purchase Order (PO)</label>
                    <input type="text" name="nomor_po"
                        value="{{ old('nomor_po', $baRampung->nomor_po) }}"
                        class="input w-full" placeholder="Masukkan nomor PO (opsional)">
                </div>
                <div>
                    <label class="label">Tanggal Purchase Order (PO)</label>
                    <input type="date" name="tanggal_po"
                        value="{{ old('tanggal_po', $baRampung->tanggal_po?->format('Y-m-d')) }}"
                        class="input w-full">
                </div>
            </div>

        </div>

    </div>



    {{-- ========================================================= --}}
    {{-- 2. PENGOLAHAN --}}
    {{-- ========================================================= --}}

    <div class="card p-6">

        <h3 class="font-semibold text-gray-900 mb-1">
            🌾 2. Pengolahan Gabah (GKP) menjadi Beras Hasil Giling (HGL)
        </h3>

        <p class="text-xs text-gray-500 mb-5">
            Rendemen (%) di bawah ini hanya pratinjau — nilai final selalu
            dihitung ulang oleh server saat disimpan.
        </p>

        <div class="overflow-x-auto">

            <table class="w-full text-sm">

                <thead>
                    <tr class="bg-bulog-beige/60 text-left text-gray-600">

                        <th
                            class="px-4 py-2.5 font-medium"
                            colspan="2"
                        >
                            Sebelum Pengolahan
                        </th>

                        <th
                            class="px-4 py-2.5 font-medium"
                            colspan="2"
                        >
                            Setelah Pengolahan
                        </th>

                        <th class="px-4 py-2.5 font-medium">
                            Rendemen (%)
                        </th>

                    </tr>
                </thead>


                <tbody class="divide-y divide-gray-100">

                    {{-- GABAH -> BERAS --}}
                    <tr>

                        <td class="px-4 py-3 font-medium text-gray-700">
                            Gabah (GKP)
                        </td>

                        <td class="px-4 py-3 w-40">

                            <input
    type="number"
    step="1"
    min="1"
    name="kuantum_gabah"
    x-model.number="gabah"
    required
    class="input"
    placeholder="Masukkan KG"
>

                        </td>

                        <td class="px-4 py-3 font-medium text-gray-700">
                            Beras (HGL)
                        </td>

                        <td class="px-4 py-3 w-40">

                            <input
    type="number"
    step="1"
    min="0"
    name="kuantum_beras"
    x-model.number="beras"
    required
    class="input"
    placeholder="Masukkan KG"
>

                        </td>

                        <td
                            class="px-4 py-3 text-gray-500"
                            x-text="rendemen(beras) + ' %'"
                        ></td>

                    </tr>


                    {{-- MENIR --}}
                    <tr>

                        <td colspan="2"></td>

                        <td class="px-4 py-3 font-medium text-gray-700">
                            Menir
                        </td>

                        <td class="px-4 py-3 w-40">

                            <input
    type="number"
    step="1"
    min="0"
    name="kuantum_menir"
    x-model.number="menir"
    class="input"
    placeholder="Masukkan KG"
>

                        </td>

                        <td
                            class="px-4 py-3 text-gray-500"
                            x-text="rendemen(menir) + ' %'"
                        ></td>

                    </tr>


                    {{-- BEKATUL --}}
                    <tr>

                        <td colspan="2"></td>

                        <td class="px-4 py-3 font-medium text-gray-700">
                            Bekatul
                        </td>

                        <td class="px-4 py-3 w-40">

                            <input
    type="number"
    step="1"
    min="0"
    name="kuantum_bekatul"
    x-model.number="bekatul"
    class="input"
    placeholder="Masukkan KG"
>

                        </td>

                        <td
                            class="px-4 py-3 text-gray-500"
                            x-text="rendemen(bekatul) + ' %'"
                        ></td>

                    </tr>

                </tbody>

            </table>

        </div>

    </div>



    {{-- ========================================================= --}}
    {{-- 3. PIHAK YANG TERLIBAT --}}
    {{-- ========================================================= --}}

    <div class="card p-6">

        <h3 class="font-semibold text-gray-900 mb-5">
            🤝 3. Pihak yang Terlibat
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

            {{-- Pihak Kesatu --}}
            <div>

                <label class="label">
                    Pihak Kesatu (Gudang)
                </label>

                <select
                    name="gudang_id"
                    required
                    class="input"
                >

                    @foreach ($gudangs as $g)

                        <option
                            value="{{ $g->id }}"
                            @selected(
                                old('gudang_id', $baRampung->gudang_id) == $g->id
                            )
                        >
                            {{ $g->nama_gudang }}
                        </option>

                    @endforeach

                </select>

            </div>


            {{-- Pihak Kedua --}}
            <div>

                <label class="label">
                    Pihak Kedua (Mitra Pengolahan)
                </label>

                <select
                    name="mitra_pengolahan_id"
                    required
                    class="input"
                >

                    @foreach ($mitras as $m)

                        <option
                            value="{{ $m->id }}"
                            @selected(
                                old(
                                    'mitra_pengolahan_id',
                                    $baRampung->mitra_pengolahan_id
                                ) == $m->id
                            )
                        >
                            {{ $m->nama_mitra }}
                        </option>

                    @endforeach

                </select>

            </div>

        </div>

    </div>



    {{-- ========================================================= --}}
    {{-- 4. PENANDATANGAN PIHAK KESATU --}}
    {{-- ========================================================= --}}

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <div class="card p-6">

            <h3 class="font-semibold text-gray-900 mb-5">
                ✍️ 4. Penandatanganan Pihak Kesatu (Gudang)
            </h3>

            <div class="space-y-4">

                {{-- Nama --}}
<div>

    <label class="label">
        Nama Penandatangan
    </label>

    <input
        type="text"
        name="nama_penandatangan"
        value="{{ old(
            'nama_penandatangan',
            $baRampung->nama_penandatangan
        ) }}"
        required
        class="input"
        placeholder="Masukkan nama penandatangan"
    >

</div>


                {{-- Jabatan --}}
                <div>

                    <label class="label">
                        Jabatan
                    </label>

                    <input
                        type="text"
                        name="jabatan_penandatangan"
                        value="{{ old(
                            'jabatan_penandatangan',
                            $baRampung->jabatan_penandatangan
                        ) }}"
                        required
                        class="input"
                    >

                </div>

            </div>

        </div>



        {{-- ===================================================== --}}
        {{-- 5. PENANDATANGAN PIHAK KEDUA --}}
        {{-- ===================================================== --}}

        <div class="card p-6">

            <h3 class="font-semibold text-gray-900 mb-5">
                ✍️ 5. Penandatanganan Pihak Kedua (Mitra Pengolahan)
            </h3>

            <div class="space-y-4">

                {{-- Nama Penandatangan Pihak Kedua --}}
                <div>

                    <label class="label">
                        Nama Penandatangan Pihak Kedua
                    </label>

                    <input
                        type="text"
                        name="nama_penandatangan_pihak_kedua"
                        value="{{ old(
                            'nama_penandatangan_pihak_kedua',
                            $baRampung->nama_penandatangan_pihak_kedua
                        ) }}"
                        required
                        class="input"
                        placeholder="Masukkan nama penandatangan mitra"
                    >

                </div>


                {{-- Jabatan Pihak Kedua --}}
                <div>

                    <label class="label">
                        Jabatan Penandatangan Pihak Kedua
                    </label>

                    <input
                        type="text"
                        name="jabatan_penandatangan_pihak_kedua"
                        value="{{ old(
                            'jabatan_penandatangan_pihak_kedua',
                            $baRampung->jabatan_penandatangan_pihak_kedua
                        ) }}"
                        required
                        class="input"
                        placeholder="Masukkan jabatan penandatangan mitra"
                    >

                </div>

            </div>

        </div>

    </div>



    {{-- ========================================================= --}}
    {{-- 6. MENGETAHUI --}}
    {{-- ========================================================= --}}

    <div class="card p-6">

        <h3 class="font-semibold text-gray-900 mb-5">
            👔 6. Mengetahui
        </h3>

        <div class="max-w-xl">

            <label class="label">
                Pimpinan Cabang BULOG
            </label>

            <select
                name="pimpinan_cabang_id"
                required
                class="input"
            >

                @foreach ($pimpinans as $p)

                    <option
                        value="{{ $p->id }}"
                        @selected(
                            old(
                                'pimpinan_cabang_id',
                                $baRampung->pimpinan_cabang_id
                            ) == $p->id
                        )
                    >
                        {{ $p->nama }}
                    </option>

                @endforeach

            </select>

        </div>

    </div>



    {{-- ========================================================= --}}

    



    {{-- ========================================================= --}}
    {{-- BUTTON --}}
    {{-- ========================================================= --}}

    <div class="flex items-center justify-between">

        <div class="flex gap-3">

            


            <button
    type="submit"
    class="btn-primary"
>
    ✅ Simpan &amp; Kirim Verifikasi
</button>

        </div>

    </div>

</form>
</div>

<script>
(function () {
    const page = document.querySelector('.ba-edit-page');
    if (!page) return;

    function applyTheme() {
        let dark = document.documentElement.classList.contains('dark-theme');

        if (!dark) {
            try {
                dark = localStorage.getItem('bulog-theme') === 'dark';
            } catch (e) {}
        }

        page.classList.toggle('is-dark', dark);
    }

    applyTheme();

    try {
        new MutationObserver(applyTheme).observe(document.documentElement, {
            attributes: true,
            attributeFilter: ['class']
        });
    } catch (e) {}

    window.addEventListener('storage', applyTheme);

    document.addEventListener('click', function () {
        setTimeout(applyTheme, 50);
        setTimeout(applyTheme, 300);
    }, true);

    window.addEventListener('pageshow', applyTheme);
})();
</script>

@endsection