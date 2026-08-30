<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">

    <style>
        @page {
            margin: 35px 45px 40px 45px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            color: #111;
            line-height: 1.45;
        }

        .header {
            text-align: center;
            margin-bottom: 14px;
        }

        .header-title {
            font-size: 16px;
            font-weight: bold;
            margin: 0;
        }

        .header-subtitle {
            font-size: 11px;
            margin-top: 4px;
        }

        .header-line {
            border-bottom: 2px solid #000;
            margin-top: 16px;
        }

        .nomor {
            text-align: center;
            margin: 18px 0 18px 0;
            font-size: 10px;
        }

        .nomor strong {
            font-weight: bold;
        }

        .opening {
            text-align: justify;
            margin-bottom: 18px;
        }

        .section-title {
            font-size: 11px;
            font-weight: bold;
            margin-top: 15px;
            margin-bottom: 5px;
            padding-bottom: 4px;
            border-bottom: 1px solid #999;
        }

        table {
            border-collapse: collapse;
        }

        /* =========================
           DATA ADMINISTRASI
        ========================= */

        .admin-table {
            width: 100%;
            margin-bottom: 18px;
        }

        .admin-table td {
            padding: 3px 4px;
            vertical-align: top;
        }

        .admin-label {
            width: 160px;
        }

        .admin-separator {
            width: 15px;
            text-align: center;
        }

        /* =========================
           TABEL PENGOLAHAN
        ========================= */

        .produksi-table {
            width: 100%;
            margin-top: 8px;
            margin-bottom: 18px;
        }

        .produksi-table th,
        .produksi-table td {
            border: 1px solid #777;
            padding: 6px 7px;
            font-size: 9.5px;
        }

        .produksi-table th {
            background-color: #efe7d3;
            font-weight: bold;
            text-align: left;
        }

        .produksi-table td {
            vertical-align: middle;
        }

        .produksi-table .num {
            text-align: left;
            white-space: nowrap;
        }

        /* =========================
           PENUTUP
        ========================= */

        .closing {
            margin-top: 18px;
            margin-bottom: 26px;
            text-align: justify;
        }

        /* =========================
           TANDA TANGAN
        ========================= */

        .signature-table {
            width: 100%;
            margin-top: 10px;
        }

        .signature-table td {
            width: 33.33%;
            text-align: center;
            vertical-align: top;
            padding: 0 8px;
        }

        .signature-title {
            min-height: 42px;
            line-height: 1.5;
        }

        .signature-space {
            height: 62px;
        }

        .signature-name {
            font-weight: bold;
            text-transform: uppercase;
            margin: 0;
        }

        .signature-position {
            margin: 3px 0 0 0;
            font-size: 9px;
        }

        .footer-note {
            font-size: 7.5px;
            color: #777;
            text-align: center;
            margin-top: 25px;
        }
    </style>
</head>

<body>

    {{-- =========================================================
         HEADER
    ========================================================== --}}

    <div class="header">
        <div class="header-title">
            BERITA ACARA RAMPUNG
        </div>

        <div class="header-subtitle">
            Perum BULOG Cabang Indramayu
        </div>

        <div class="header-line"></div>
    </div>


    {{-- =========================================================
         NOMOR
    ========================================================== --}}

    <div class="nomor">
        Nomor:
        <strong>{{ $baRampung->nomor_ba }}</strong>
    </div>


    {{-- =========================================================
         PEMBUKA
    ========================================================== --}}

    <div class="opening">
        Pada hari ini,
        <strong>{{ $baRampung->hari }}</strong>,
        tanggal
        <strong>
            {{ $baRampung->tanggal_ba->format('d') }}
            {{ $baRampung->bulan }}
            {{ $baRampung->tahun }}
        </strong>,
        telah dilaksanakan serah terima hasil pengolahan
        Gabah Kering Panen (GKP) menjadi
        Beras Hasil Giling (HGL) antara Gudang dan Mitra Pengolahan
        sebagaimana rincian berikut:
    </div>


    {{-- =========================================================
         1. DATA ADMINISTRASI
    ========================================================== --}}

    <div class="section-title">
        1. Data Administrasi
    </div>

    <table class="admin-table">

        <tr>
            <td class="admin-label">
                Nomor Manufacturing Order (MO)
            </td>

            <td class="admin-separator">
                :
            </td>

            <td>
                {{ $baRampung->nomor_mo }}
            </td>
        </tr>

        <tr>
            <td class="admin-label">
                Nomor Purchase Order (PO)
            </td>

            <td class="admin-separator">
                :
            </td>

            <td>
                {{ $baRampung->nomor_po }}
            </td>
        </tr>

        <tr>
            <td class="admin-label">
                Pihak Kesatu (Gudang)
            </td>

            <td class="admin-separator">
                :
            </td>

            <td>
                {{ $baRampung->gudang->nama_gudang ?? '-' }}

                @if (!empty($baRampung->gudang->alamat))
                    — {{ $baRampung->gudang->alamat }}
                @endif
            </td>
        </tr>

        <tr>
            <td class="admin-label">
                Pihak Kedua (Mitra Pengolahan)
            </td>

            <td class="admin-separator">
                :
            </td>

            <td>
                {{ $baRampung->mitraPengolahan->nama_mitra ?? '-' }}

                @if (!empty($baRampung->mitraPengolahan->alamat))
                    — {{ $baRampung->mitraPengolahan->alamat }}
                @endif
            </td>
        </tr>

    </table>


    {{-- =========================================================
         2. RINCIAN PENGOLAHAN
    ========================================================== --}}

    <div class="section-title">
        2. Rincian Pengolahan
    </div>

    <table class="produksi-table">

        <thead>
            <tr>
                <th style="width: 22%;">
                    Produk Sebelum
                </th>

                <th style="width: 20%;">
                    Kuantum (Kg)
                </th>

                <th style="width: 22%;">
                    Produk Sesudah
                </th>

                <th style="width: 20%;">
                    Kuantum (Kg)
                </th>

                <th style="width: 16%;">
                    Rendemen (%)
                </th>
            </tr>
        </thead>

        <tbody>

            @forelse ($baRampung->produksis as $p)

                <tr>

                    <td>
                        {{ $p->produk_sebelum }}
                    </td>

                    <td class="num">
                        {{ number_format($p->kuantum_sebelum, 2) }}
                    </td>

                    <td>
                        {{ $p->produk_sesudah }}
                    </td>

                    <td class="num">
                        {{ number_format($p->kuantum_sesudah, 2) }}
                    </td>

                    <td class="num">
                        {{ number_format($p->rendemen, 2) }}%
                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="5" style="text-align:center;">
                        Tidak ada data pengolahan.
                    </td>
                </tr>

            @endforelse

        </tbody>

    </table>


    {{-- =========================================================
         CATATAN
    ========================================================== --}}

    @if ($baRampung->catatan)

        <div style="margin-top: 8px; margin-bottom: 12px;">
            <strong>Catatan:</strong>
            {{ $baRampung->catatan }}
        </div>

    @endif


    {{-- =========================================================
         PENUTUP
    ========================================================== --}}

    <div class="closing">
        Demikian Berita Acara Rampung ini dibuat dengan sebenarnya
        untuk dipergunakan sebagaimana mestinya.
    </div>


    {{-- =========================================================
         TANDA TANGAN
         3 KOLOM:
         PIHAK KESATU | PIHAK KEDUA | MENGETAHUI
    ========================================================== --}}

    <table class="signature-table">

        <tr>

            {{-- PIHAK KESATU --}}
            <td>

                <div class="signature-title">
                    Pihak Kesatu
                    <br>
                    (Gudang)
                </div>

                <div class="signature-space"></div>

                <p class="signature-name">
                    {{ $baRampung->nama_penandatangan ?? '-' }}
                </p>

                <p class="signature-position">
                    {{ $baRampung->jabatan_penandatangan ?? '' }}
                </p>

            </td>


            {{-- PIHAK KEDUA --}}
            <td>

                <div class="signature-title">
                    Pihak Kedua
                    <br>
                    (Mitra Pengolahan)
                </div>

                <div class="signature-space"></div>

                <p class="signature-name">
                    {{ $baRampung->nama_penandatangan_pihak_kedua ?? '-' }}
                </p>

                <p class="signature-position">
                    {{ $baRampung->jabatan_penandatangan_pihak_kedua ?? '' }}
                </p>

            </td>


            {{-- MENGETAHUI --}}
            <td>

                <div class="signature-title">
                    Mengetahui,
                    <br>
                    Pimpinan Cabang BULOG Indramayu
                </div>

                <div class="signature-space"></div>

                <p class="signature-name">
                    {{ $baRampung->pimpinanCabang->nama ?? '-' }}
                </p>

                <p class="signature-position">
                    {{ $baRampung->pimpinanCabang->jabatan ?? '' }}
                </p>

            </td>

        </tr>

    </table>


    {{-- =========================================================
         FOOTER
    ========================================================== --}}

    <div class="footer-note">
        Dokumen ini dicetak melalui Sistem Administrasi BA Rampung —
        Perum BULOG Cabang Indramayu
        pada {{ now()->format('d/m/Y H:i') }} WIB.
    </div>

</body>
</html>