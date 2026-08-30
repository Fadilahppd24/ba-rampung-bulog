<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">

<style>
    @page {
        margin: 70px 45px 65px 45px;
    }

    body {
        font-family: 'DejaVu Sans', sans-serif;
        font-size: 11px;
        color: #1a1a1a;
        line-height: 1.5;
    }

    h1 {
        font-size: 15px;
        text-align: center;
        text-transform: uppercase;
        margin: 0 0 4px 0;
    }

    h2 {
        font-size: 11px;
        text-align: center;
        margin: 0 0 18px 0;
        font-weight: normal;
    }

    .header-doc {
        text-align: center;
        border-bottom: 2px solid #1F4732;
        padding-bottom: 10px;
        margin-bottom: 18px;
    }

    .nomor {
        text-align: center;
        font-size: 11px;
        margin-bottom: 18px;
    }

    table.data {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 16px;
    }

    table.data td {
        padding: 4px 4px;
        vertical-align: top;
    }

    table.data td.label {
        width: 160px;
        color: #444;
    }

    table.data td.sep {
        width: 10px;
    }

    table.produksi {
        width: 100%;
        border-collapse: collapse;
        margin: 12px 0 20px 0;
    }

    table.produksi th,
    table.produksi td {
        border: 1px solid #999;
        padding: 6px 8px;
        font-size: 10.5px;
    }

    table.produksi th {
        background-color: #EFE7D3;
        text-align: left;
    }

    .section-title {
        font-weight: bold;
        font-size: 12px;
        margin: 18px 0 8px 0;
        color: #1F4732;
        border-bottom: 1px solid #ccc;
        padding-bottom: 3px;
    }

    .catatan-box {
        border: 1px solid #ccc;
        padding: 8px;
        margin-top: 10px;
        font-size: 10.5px;
        background: #fafafa;
    }

    /*
     * TANDA TANGAN
     */
    table.ttd {
        width: 100%;
        border-collapse: collapse;
        margin-top: 38px;
    }

    table.ttd td {
        width: 33.33%;
        text-align: center;
        vertical-align: top;
        padding: 0 8px;
    }

    .ttd-title {
        height: 42px;
        margin: 0;
    }

    .ttd-space {
        height: 65px;
    }

    .ttd-name {
        margin: 0;
        font-weight: bold;
    }

    .ttd-jabatan {
        margin: 2px 0 0 0;
    }

    .footer-note {
        font-size: 8.5px;
        color: #888;
        text-align: center;
        margin-top: 28px;
    }
</style>
</head>

<body>

    {{-- ===================================================== --}}
    {{-- HEADER --}}
    {{-- ===================================================== --}}

    <div class="header-doc">

        <h1>Berita Acara Rampung</h1>

        <h2>
            Perum BULOG Cabang Indramayu
        </h2>

    </div>


    {{-- ===================================================== --}}
    {{-- NOMOR BA --}}
    {{-- ===================================================== --}}

    <p class="nomor">
        Nomor:
        <strong>
            {{ $baRampung->nomor_ba }}
        </strong>
    </p>


    {{-- ===================================================== --}}
    {{-- PEMBUKA --}}
    {{-- ===================================================== --}}

    @php
        $hariIndonesia = [
            'Sunday' => 'Minggu',
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
        ];

        $hari = $baRampung->tanggal_ba
            ? ($hariIndonesia[$baRampung->tanggal_ba->format('l')] ?? $baRampung->tanggal_ba->format('l'))
            : ($baRampung->hari ?? '-');
    @endphp

    <p>
        Pada hari ini,

        <strong>
            {{ $hari }}
        </strong>,

        tanggal

        <strong>
            {{ $baRampung->tanggal_ba->format('d') }}
            {{ $baRampung->bulan }}
            {{ $baRampung->tahun }}
        </strong>,

        telah dilaksanakan serah terima hasil pengolahan
        Gabah Kering Panen (GKP) menjadi
        Beras Hasil Giling (HGL) antara Gudang dan
        Mitra Pengolahan sebagaimana rincian berikut:
    </p>


    {{-- ===================================================== --}}
    {{-- 1. DATA ADMINISTRASI --}}
    {{-- ===================================================== --}}

    <div class="section-title">
        1. Data Administrasi
    </div>

    <table class="data">

        <tr>
            <td class="label">
                Nomor Manufacturing Order (MO)
            </td>

            <td class="sep">
                :
            </td>

            <td>
                {{ $baRampung->nomor_mo }}
            </td>
        </tr>

        <tr>
            <td class="label">
                Nomor Purchase Order (PO)
            </td>

            <td class="sep">
                :
            </td>

            <td>
                {{ $baRampung->nomor_po }}
            </td>
        </tr>

        <tr>
            <td class="label">
                Pihak Kesatu (Gudang)
            </td>

            <td class="sep">
                :
            </td>

            <td>
                {{ $baRampung->gudang->nama_gudang ?? '-' }}

                @if($baRampung->gudang?->alamat)
                    — {{ $baRampung->gudang->alamat }}
                @endif
            </td>
        </tr>

        <tr>
            <td class="label">
                Pihak Kedua (Mitra Pengolahan)
            </td>

            <td class="sep">
                :
            </td>

            <td>
                {{ $baRampung->mitraPengolahan->nama_mitra ?? '-' }}

                @if($baRampung->mitraPengolahan?->alamat)
                    — {{ $baRampung->mitraPengolahan->alamat }}
                @endif
            </td>
        </tr>

    </table>


    {{-- ===================================================== --}}
    {{-- 2. RINCIAN PENGOLAHAN --}}
    {{-- ===================================================== --}}

    <div class="section-title">
        2. Rincian Pengolahan
    </div>

    <table class="produksi">

        <thead>

            <tr>
                <th>
                    Produk Sebelum
                </th>

                <th>
                    Kuantum (Kg)
                </th>

                <th>
                    Produk Sesudah
                </th>

                <th>
                    Kuantum (Kg)
                </th>

                <th>
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

                    <td>
                        {{ number_format($p->kuantum_sebelum, 2) }}
                    </td>

                    <td>
                        {{ $p->produk_sesudah }}
                    </td>

                    <td>
                        {{ number_format($p->kuantum_sesudah, 2) }}
                    </td>

                    <td>
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


    {{-- ===================================================== --}}
    {{-- CATATAN --}}
    {{-- ===================================================== --}}

    @if ($baRampung->catatan)

        <div class="catatan-box">

            <strong>
                Catatan:
            </strong>

            {{ $baRampung->catatan }}

        </div>

    @endif


    {{-- ===================================================== --}}
    {{-- PENUTUP --}}
    {{-- ===================================================== --}}

    <p style="margin-top: 20px;">

        Demikian Berita Acara Rampung ini dibuat dengan
        sebenarnya untuk dipergunakan sebagaimana mestinya.

    </p>


    {{-- ===================================================== --}}
    {{-- 3 KOLOM TANDA TANGAN --}}
    {{-- ===================================================== --}}

    <table class="ttd">

        <tr>

            {{-- PIHAK KESATU --}}
            <td>

                <p class="ttd-title">

                    Pihak Kesatu
                    <br>
                    (Gudang)

                </p>

                <div class="ttd-space"></div>

                <p class="ttd-name">

                    {{ $baRampung->nama_penandatangan ?? '-' }}

                </p>

                <p class="ttd-jabatan">

                    {{ $baRampung->jabatan_penandatangan ?? '' }}

                </p>

            </td>


            {{-- PIHAK KEDUA --}}
            <td>

                <p class="ttd-title">

                    Pihak Kedua
                    <br>
                    (Mitra Pengolahan)

                </p>

                <div class="ttd-space"></div>

                <p class="ttd-name">

                    {{ $baRampung->nama_penandatangan_pihak_kedua ?? '-' }}

                </p>

                <p class="ttd-jabatan">

                    {{ $baRampung->jabatan_penandatangan_pihak_kedua ?? '' }}

                </p>

            </td>


            {{-- PIMPINAN CABANG --}}
            <td>

                <p class="ttd-title">

                    Mengetahui,
                    <br>
                    Pimpinan Cabang BULOG Indramayu

                </p>

                <div class="ttd-space"></div>

                <p class="ttd-name">

                    {{ $baRampung->pimpinanCabang->nama ?? '-' }}

                </p>

                <p class="ttd-jabatan">

                    {{ $baRampung->pimpinanCabang->jabatan ?? '' }}

                </p>

            </td>

        </tr>

    </table>


    {{-- ===================================================== --}}
    {{-- FOOTER --}}
    {{-- ===================================================== --}}

    <p class="footer-note">

        Dokumen ini dicetak melalui Sistem Administrasi BA Rampung —
        Perum BULOG Cabang Indramayu

        pada

        {{ now()->format('d/m/Y H:i') }}

        WIB.

        Status saat cetak:

        {{ $baRampung->statusLabel() }}.

    </p>

</body>
</html>