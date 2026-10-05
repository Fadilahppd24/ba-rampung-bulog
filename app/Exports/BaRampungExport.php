<?php

namespace App\Exports;

use App\Models\BaRampung;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BaRampungExport implements WithMultipleSheets
{
    public function __construct(
        private array $filters = []
    ) {
    }

    /**
     * BUAT SHEET HANYA UNTUK BULAN YANG ADA DATANYA
     * (setelah semua filter diterapkan)
     */
    public function sheets(): array
    {
        $query = BaRampung::query();

        self::applyFilters($query, $this->filters);

        $months = $query
            ->whereNotNull('tanggal_ba')
            ->selectRaw('MONTH(tanggal_ba) as bulan')
            ->groupByRaw('MONTH(tanggal_ba)')
            ->orderByRaw('MONTH(tanggal_ba)')
            ->pluck('bulan');

        // Jika bulan dipilih, hasil export hanya 1 sheet.
        if (!empty($this->filters['bulan'])) {
            return [
                new BaRampungMonthSheet(
                    (int) $this->filters['bulan'],
                    $this->filters,
                    'DATA BA RAMPUNG'
                ),
            ];
        }

        // Jika bulan = Semua Bulan:
        // Sheet 1 = SEMUA DATA BA
        // Sheet berikutnya = bulan yang memiliki data setelah filter Gudang/Mitra/Status/Search/Tahun.
        $sheets = [
            new BaRampungMonthSheet(
                null,
                $this->filters,
                'SEMUA DATA BA'
            ),
        ];

        foreach ($months as $month) {
            $sheets[] = new BaRampungMonthSheet(
                (int) $month,
                $this->filters
            );
        }

        return $sheets;
    }

    /**
     * FILTER UTAMA
     *
     * Dipakai bersama oleh sheets() dan BaRampungMonthSheet::query()
     * supaya daftar bulan dan isi tiap sheet SELALU memakai
     * aturan filter yang sama. Aturannya disamakan dengan
     * halaman index BA Rampung (BaRampungController::index).
     */
    public static function applyFilters(Builder $query, array $filters): void
    {
        if (!empty($filters['gudang_id'])) {
            $gudangFilter = $filters['gudang_id'];

            // Dropdown halaman mengirim NAMA gudang.
            // Admin Gudang tetap mengirim ID gudang dari controller.
            if (is_numeric($gudangFilter)) {
                $query->where('gudang_id', (int) $gudangFilter);
            } else {
                $query->whereHas('gudang', function ($g) use ($gudangFilter) {
                    $g->where('nama_gudang', $gudangFilter);
                });
            }
        }

        if (!empty($filters['mitra_pengolahan_id'])) {
            $mitraFilter = $filters['mitra_pengolahan_id'];

            // Dropdown halaman mengirim NAMA mitra, bukan ID.
            if (is_numeric($mitraFilter)) {
                $query->where('mitra_pengolahan_id', (int) $mitraFilter);
            } else {
                $query->whereHas('mitraPengolahan', function ($m) use ($mitraFilter) {
                    $m->where('nama_mitra', $mitraFilter);
                });
            }
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['bulan'])) {
            $query->whereMonth('tanggal_ba', (int) $filters['bulan']);
        }

        if (!empty($filters['tahun'])) {
            $query->whereYear('tanggal_ba', (int) $filters['tahun']);
        }

        if (!empty($filters['search'])) {
            $search = $filters['search'];

            $query->where(function (Builder $q) use ($search) {
                $q->where('nomor_ba', 'like', "%{$search}%")
                    ->orWhereHas(
                        'gudang',
                        fn ($g) => $g->where('nama_gudang', 'like', "%{$search}%")
                    )
                    ->orWhereHas(
                        'mitraPengolahan',
                        fn ($m) => $m->where('nama_mitra', 'like', "%{$search}%")
                    );
            });
        }
    }
}


/*
|--------------------------------------------------------------------------
| SHEET PER BULAN
|--------------------------------------------------------------------------
*/

class BaRampungMonthSheet implements
    FromQuery,
    WithHeadings,
    WithMapping,
    WithTitle,
    WithStyles,
    WithColumnWidths,
    WithColumnFormatting,
    WithEvents
{
    /**
     * Aturan bisnis: 1 KOLI = 50 KG
     */
    private const KG_PER_KOLI = 50;

    private int $no = 0;

    public function __construct(
        private ?int $month,
        private array $filters = [],
        private ?string $sheetTitle = null
    ) {
    }

    /**
     * QUERY DATA
     */
    public function query(): Builder
    {
        $query = BaRampung::query()
            ->with([
                'gudang',
                'mitraPengolahan',
                'produksis',
            ])
            ->orderBy('tanggal_ba')
            ->orderBy('id');

        // Semua filter dari halaman (gudang, mitra, status, bulan, tahun, search)
        BaRampungExport::applyFilters($query, $this->filters);

        // Bulan milik sheet ini
        if ($this->month !== null) {
            $query->whereMonth('tanggal_ba', $this->month);
        }

        return $query;
    }

    /**
     * NAMA SHEET (wajib WithTitle supaya benar-benar dipakai Excel)
     */
    public function title(): string
    {
        $bulan = [
            1 => 'JANUARI',
            2 => 'FEBRUARI',
            3 => 'MARET',
            4 => 'APRIL',
            5 => 'MEI',
            6 => 'JUNI',
            7 => 'JULI',
            8 => 'AGUSTUS',
            9 => 'SEPTEMBER',
            10 => 'OKTOBER',
            11 => 'NOVEMBER',
            12 => 'DESEMBER',
        ];

        return $this->sheetTitle
            ?? ($this->month === null
                ? 'SEMUA DATA BA'
                : ($bulan[$this->month] ?? 'DATA BA RAMPUNG'));
    }

    /**
     * HEADER EXCEL (2 baris, 21 kolom: A - U)
     */
    public function headings(): array
    {
        return [
            [
                'NO',                    // A
                'NAMA MITRA',            // B
                'TANGGAL PO GKP',        // C
                'NOMOR PO GKP',          // D
                'KUANTUM PO (KG)',       // E
                'NO TM',                 // F
                'TANGGAL TM',            // G
                'TM HASIL',              // H (merge H:I)
                '',                      // I
                'NO MO',                 // J
                'TANGGAL MO',            // K
                'HASIL GILING',          // L (merge L:M)
                '',                      // M
                'RENDEMEN %',            // N (merge N:O)
                '',                      // O
                'BEKATUL',               // P (merge P:Q)
                '',                      // Q
                'MENIR',                 // R (merge R:S)
                '',                      // S
                'HASIL SAMPING',         // T
                'GUDANG PENERIMA HGL',   // U
            ],
            [
                '', '', '', '', '', '', '',
                'NO',   // H
                'TGL',  // I
                '', '',
                'KOLI', // L
                'KG',   // M
                'KG',   // N
                '%',    // O
                'KG',   // P
                '%',    // Q
                'KG',   // R
                '%',    // S
                '',     // T
                '',     // U
            ],
        ];
    }

    /**
     * Cari baris produksi berdasarkan nama produk (tidak peka huruf
     * besar/kecil, toleran terhadap variasi penulisan).
     */
    private function cariProduksi($produksis, array $kataKunci)
    {
        return $produksis->first(function ($p) use ($kataKunci) {
            $nama = strtolower((string) $p->produk_sesudah);

            foreach ($kataKunci as $kata) {
                if (str_contains($nama, $kata)) {
                    return true;
                }
            }

            return false;
        });
    }

    /**
     * DATA SETIAP BARIS
     *
     * Semua nilai dihitung di PHP, sehingga langsung benar
     * saat file pertama kali dibuka (tidak bergantung rumus Excel).
     */
    public function map($ba): array
    {
        // Nomor urut dimulai dari 1 di setiap sheet
        $this->no++;

        $produksis = $ba->produksis;

        $rowBeras   = $this->cariProduksi($produksis, ['beras', 'hgl']);
        $rowMenir   = $this->cariProduksi($produksis, ['menir']);
        $rowBekatul = $this->cariProduksi($produksis, ['bekatul']);

        // GKP digunakan sebagai dasar perhitungan rendemen.
        $gabah = (float) ($produksis->first()?->kuantum_sebelum ?? 0);

        $beras   = (float) ($rowBeras?->kuantum_sesudah ?? 0);
        $menir   = (float) ($rowMenir?->kuantum_sesudah ?? 0);
        $bekatul = (float) ($rowBekatul?->kuantum_sesudah ?? 0);

        // Rendemen tetap mengambil nilai yang tersimpan di database.
        // Jika kosong, dihitung dari GKP.
        $hitung = fn (float $kg) =>
            $gabah > 0 ? round(($kg / $gabah) * 100, 2) : 0.0;

        $rendemenBeras = $rowBeras?->rendemen !== null
            ? (float) $rowBeras->rendemen
            : $hitung($beras);

        $rendemenMenir = $rowMenir?->rendemen !== null
            ? (float) $rowMenir->rendemen
            : $hitung($menir);

        $rendemenBekatul = $rowBekatul?->rendemen !== null
            ? (float) $rowBekatul->rendemen
            : $hitung($bekatul);

        // Format nomor PO dan MO untuk Excel.
        // Input database tetap hanya nomor, misalnya 5678 dan 3728.
        // Format Excel:
        // PO/5678/02/2026/10040
        // MO/3728/02/2026/10040
        $bulanBa = $ba->tanggal_ba
            ? \Carbon\Carbon::parse($ba->tanggal_ba)->format('m')
            : '';

        $tahunBa = $ba->tanggal_ba
            ? \Carbon\Carbon::parse($ba->tanggal_ba)->format('Y')
            : '';

        $nomorPo = trim((string) ($ba->nomor_po ?? ''));
        $nomorMo = trim((string) ($ba->nomor_mo ?? ''));

        $nomorPoLengkap = $nomorPo !== '' && $bulanBa !== '' && $tahunBa !== ''
            ? "PO/{$nomorPo}/{$bulanBa}/{$tahunBa}/10040"
            : ($nomorPo !== '' ? "PO/{$nomorPo}" : '');

        $nomorMoLengkap = $nomorMo !== '' && $bulanBa !== '' && $tahunBa !== ''
            ? "MO/{$nomorMo}/{$bulanBa}/{$tahunBa}/10040"
            : ($nomorMo !== '' ? "MO/{$nomorMo}" : '');

        /*
         * KOLOM YANG DIISI:
         * B  = Nama Mitra
         * D  = Nomor PO GKP
         * J  = Nomor MO
         * N  = Rendemen KG
         * O  = Rendemen %
         * P  = Bekatul KG
         * Q  = Bekatul %
         * R  = Menir KG
         * S  = Menir %
         * U  = Gudang Penerima HGL
         *
         * Kolom lainnya sengaja dikosongkan.
         */
        return [
            // A - NO
            $this->no,

            // B - NAMA MITRA
            $ba->mitraPengolahan?->nama_mitra ?? '',

            // C - TANGGAL PO GKP
            null,

            // D - NOMOR PO GKP
            $nomorPoLengkap,

            // E - KUANTUM (KG)
            $gabah,

            // F - NO TM
            null,

            // G - TANGGAL TM
            null,

            // H - TM HASIL NO
            null,

            // I - TM HASIL TGL
            null,

            // J - NO MO
            $nomorMoLengkap,

            // K - TANGGAL MO
            null,

            // L - HASIL GILING KOLI
            null,

            // M - HASIL GILING KG
            null,

            // N - RENDEMEN KG
            $beras,

            // O - RENDEMEN %
            $rendemenBeras,

            // P - BEKATUL KG
            $bekatul,

            // Q - BEKATUL %
            $rendemenBekatul,

            // R - MENIR KG
            $menir,

            // S - MENIR %
            $rendemenMenir,

            // T - HASIL SAMPING
            null,

            // U - GUDANG PENERIMA HGL
            $ba->gudang?->nama_gudang ?? '',
        ];
    }

    /**
     * FORMAT KOLOM
     */
    public function columnFormats(): array
    {
        return [
            'A' => '0',

            'E' => '#,##0',

            'L' => '#,##0.00',
            'M' => '#,##0',
            'N' => '#,##0',
            'P' => '#,##0',
            'R' => '#,##0',

            'O' => '0.00',
            'Q' => '0.00',
            'S' => '0.00',
            'T' => '0.00',
        ];
    }

    /**
     * LEBAR KOLOM (tetap, TIDAK auto-size)
     *
     * Auto-size dimatikan karena PhpSpreadsheet mengabaikan sel yang
     * di-merge saat menghitung lebar. Kolom yang datanya kosong
     * (tanggal PO, TM, tanggal MO, dst.) jadi menyusut dan judulnya
     * terlihat hilang.
     */
    public function columnWidths(): array
    {
        return [
            'A' => 6,
            'B' => 32,
            'C' => 16,
            'D' => 27,
            'E' => 18,
            'F' => 12,
            'G' => 14,
            'H' => 10,
            'I' => 12,
            'J' => 20,
            'K' => 14,
            'L' => 12,
            'M' => 14,
            'N' => 14,
            'O' => 12,
            'P' => 14,
            'Q' => 12,
            'R' => 14,
            'S' => 12,
            'T' => 16,
            'U' => 30,
        ];
    }

    /**
     * STYLE DASAR
     */
    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true]],
            2 => ['font' => ['bold' => true]],
        ];
    }

    /**
     * EVENT SETELAH SHEET DIBUAT: merge header & styling
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                $sheet = $event->sheet->getDelegate();

                // ---------- MERGE HEADER ----------
                foreach (['A', 'B', 'C', 'D', 'E', 'F', 'G', 'J', 'K', 'T', 'U'] as $col) {
                    $sheet->mergeCells("{$col}1:{$col}2");
                }

                foreach (['H1:I1', 'L1:M1', 'N1:O1', 'P1:Q1', 'R1:S1'] as $range) {
                    $sheet->mergeCells($range);
                }

                // ---------- TINGGI HEADER ----------
                $sheet->getRowDimension(1)->setRowHeight(30);
                $sheet->getRowDimension(2)->setRowHeight(30);

                // ---------- STYLE HEADER ----------
                $sheet->getStyle('A1:U2')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['rgb' => '000000'],
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'FFF200'],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                        'wrapText' => true,
                    ],
                    'borders' => [
                        'allBorders' => ['borderStyle' => Border::BORDER_THIN],
                    ],
                ]);

                // ---------- STYLE DATA ----------
                $highestRow = $sheet->getHighestRow();

                if ($highestRow >= 3) {
                    $sheet->getStyle("A3:U{$highestRow}")->applyFromArray([
                        'borders' => [
                            'allBorders' => ['borderStyle' => Border::BORDER_THIN],
                        ],
                        'alignment' => [
                            'vertical' => Alignment::VERTICAL_CENTER,
                        ],
                    ]);
                }

                // ---------- FREEZE HEADER ----------
                $sheet->freezePane('A3');
            },
        ];
    }
}
