<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<style>
    @page { margin: 90px 60px 70px 60px; }
    body { font-family: 'DejaVu Sans', sans-serif; font-size: 11px; color: #1a1a1a; line-height: 1.5; }
    h1 { font-size: 15px; text-align: center; text-transform: uppercase; margin: 0 0 4px 0; }
    h2 { font-size: 11px; text-align: center; margin: 0 0 18px 0; font-weight: normal; }
    .header-doc { text-align: center; border-bottom: 2px solid #1F4732; padding-bottom: 10px; margin-bottom: 18px; }
    .nomor { text-align: center; font-size: 11px; margin-bottom: 18px; }
    table.data { width: 100%; border-collapse: collapse; margin-bottom: 16px; }
    table.data td { padding: 3px 4px; vertical-align: top; }
    table.data td.label { width: 160px; color: #444; }
    table.data td.sep { width: 10px; }
    table.produksi { width: 100%; border-collapse: collapse; margin: 12px 0 20px 0; }
    table.produksi th, table.produksi td { border: 1px solid #999; padding: 6px 8px; font-size: 10.5px; }
    table.produksi th { background-color: #EFE7D3; text-align: left; }
    .section-title { font-weight: bold; font-size: 12px; margin: 18px 0 8px 0; color: #1F4732; border-bottom: 1px solid #ccc; padding-bottom: 3px; }
    .ttd-wrap { width: 100%; margin-top: 40px; }
    .ttd-col { width: 48%; display: inline-block; text-align: center; vertical-align: top; }
    .ttd-space { height: 60px; }
    .catatan-box { border: 1px solid #ccc; padding: 8px; margin-top: 10px; font-size: 10.5px; background: #fafafa; }
    .footer-note { font-size: 9px; color: #888; text-align: center; margin-top: 30px; }
</style>
</head>
<body>

    <div class="header-doc">
        <h1>Berita Acara Rampung</h1>
        <h2>Perum BULOG Cabang Indramayu</h2>
    </div>

    <p class="nomor">Nomor: <strong>{{ $baRampung->nomor_ba }}</strong></p>

    <p>
        Pada hari ini, <strong>{{ $baRampung->hari }}</strong>, tanggal
        <strong>{{ $baRampung->tanggal_ba->format('d') }} {{ $baRampung->bulan }} {{ $baRampung->tahun }}</strong>,
        telah dilaksanakan serah terima hasil pengolahan Gabah Kering Panen (GKP) menjadi
        Beras Hasil Giling (HGL) antara Gudang dan Mitra Pengolahan sebagaimana rincian berikut:
    </p>

    <div class="section-title">1. Data Administrasi</div>
    <table class="data">
        <tr>
            <td class="label">Nomor Manufacturing Order (MO)</td><td class="sep">:</td><td>{{ $baRampung->nomor_mo }}</td>
        </tr>
        <tr>
            <td class="label">Nomor Purchase Order (PO)</td><td class="sep">:</td><td>{{ $baRampung->nomor_po }}</td>
        </tr>
        <tr>
            <td class="label">Pihak Kesatu (Gudang)</td><td class="sep">:</td><td>{{ $baRampung->gudang->nama_gudang }} — {{ $baRampung->gudang->alamat }}</td>
        </tr>
        <tr>
            <td class="label">Pihak Kedua (Mitra Pengolahan)</td><td class="sep">:</td><td>{{ $baRampung->mitraPengolahan->nama_mitra }} — {{ $baRampung->mitraPengolahan->alamat }}</td>
        </tr>
        <tr>
            <td class="label">Status PBP</td><td class="sep">:</td><td>{{ $baRampung->statusPbpLabel() }}</td>
        </tr>
    </table>

    <div class="section-title">2. Rincian Pengolahan</div>
    <table class="produksi">
        <thead>
            <tr>
                <th>Produk Sebelum</th>
                <th>Kuantum (Kg)</th>
                <th>Produk Sesudah</th>
                <th>Kuantum (Kg)</th>
                <th>Rendemen (%)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($baRampung->produksis as $p)
                <tr>
                    <td>{{ $p->produk_sebelum }}</td>
                    <td>{{ number_format($p->kuantum_sebelum, 2) }}</td>
                    <td>{{ $p->produk_sesudah }}</td>
                    <td>{{ number_format($p->kuantum_sesudah, 2) }}</td>
                    <td>{{ number_format($p->rendemen, 2) }}%</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @if ($baRampung->catatan)
        <div class="catatan-box">
            <strong>Catatan:</strong> {{ $baRampung->catatan }}
        </div>
    @endif

    <p style="margin-top: 20px;">
        Demikian Berita Acara Rampung ini dibuat dengan sebenarnya untuk dipergunakan sebagaimana mestinya.
    </p>

    <table class="ttd-wrap" style="margin-top: 30px;">
        <tr>
            <td style="width: 50%; text-align: center;">
                <p>Pihak Kesatu (Gudang)</p>
                <div class="ttd-space"></div>
                <p><strong>{{ $baRampung->nama_penandatangan }}</strong><br>{{ $baRampung->jabatan_penandatangan }}</p>
            </td>
            <td style="width: 50%; text-align: center;">
                <p>Mengetahui,<br>Pimpinan Cabang BULOG Indramayu</p>
                <div class="ttd-space"></div>
                <p><strong>{{ $baRampung->pimpinanCabang->nama ?? '-' }}</strong><br>{{ $baRampung->pimpinanCabang->jabatan ?? '' }}</p>
            </td>
        </tr>
    </table>

    <p class="footer-note">
        Dokumen ini dicetak melalui Sistem Administrasi BA Rampung — Perum BULOG Cabang Indramayu
        pada {{ now()->format('d/m/Y H:i') }} WIB. Status saat cetak: {{ $baRampung->statusLabel() }}.
    </p>

</body>
</html>
