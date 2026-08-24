<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<style>
    @page { margin: 60px 40px; }
    body { font-family: 'DejaVu Sans', sans-serif; font-size: 10.5px; color: #1a1a1a; }
    h1 { font-size: 15px; text-align: center; margin: 0 0 2px 0; }
    h2 { font-size: 11px; text-align: center; margin: 0 0 16px 0; font-weight: normal; color: #444; }
    table { width: 100%; border-collapse: collapse; margin-top: 10px; }
    th, td { border: 1px solid #999; padding: 5px 8px; text-align: left; }
    th { background-color: #EFE7D3; }
    .footer-note { font-size: 8.5px; color: #888; text-align: center; margin-top: 20px; }
</style>
</head>
<body>
    <h1>{{ $judul }}</h1>
    <h2>Perum BULOG Cabang Indramayu — dicetak {{ now()->format('d/m/Y H:i') }} WIB</h2>

    <table>
        <thead>
            <tr>
                @foreach ($headings as $h)
                    <th>{{ $h }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @forelse ($rows as $row)
                <tr>
                    @foreach ($row as $cell)
                        <td>{{ $cell }}</td>
                    @endforeach
                </tr>
            @empty
                <tr><td colspan="{{ count($headings) }}" style="text-align:center; padding: 20px;">Tidak ada data.</td></tr>
            @endforelse
        </tbody>
    </table>

    <p class="footer-note">Dicetak melalui Sistem Administrasi BA Rampung — Perum BULOG Cabang Indramayu.</p>
</body>
</html>
