<?php

namespace App\Exports;

use App\Models\BaRampung;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithStyles;
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
     */
    public function sheets(): array
    {
        $query = BaRampung::query();

        $this->applyFilters($query);

        $months = $query
            ->selectRaw('MONTH(tanggal_ba) as bulan')
            ->whereNotNull('tanggal_ba')
            ->groupByRaw('MONTH(tanggal_ba)')
            ->orderByRaw('MONTH(tanggal_ba)')
            ->pluck('bulan');

        $sheets = [];

        foreach ($months as $month) {
            $sheets[] = new BaRampungMonthSheet(
                (int) $month,
                $this->filters
            );
        }

        /*
         * Kalau tidak ada data sama sekali,
         * tetap buat satu sheet kosong supaya Excel tidak error.
         */
        if (empty($sheets)) {
            $sheets[] = new BaRampungMonthSheet(
                null,
                $this->filters
            );
        }

        return $sheets;
    }

    /**
     * FILTER UTAMA
     */
    private function applyFilters(Builder $query): void
    {
        if (!empty($this->filters['gudang_id'])) {
            $query->where(
                'gudang_id',
                $this->filters['gudang_id']
            );
        }

        if (!empty($this->filters['mitra_pengolahan_id'])) {
            $query->where(
                'mitra_pengolahan_id',
                $this->filters['mitra_pengolahan_id']
            );
        }

        if (!empty($this->filters['status'])) {
            $query->where(
                'status',
                $this->filters['status']
            );
        }

        if (!empty($this->filters['bulan'])) {
            $query->whereMonth(
                'tanggal_ba',
                $this->filters['bulan']
            );
        }

        if (!empty($this->filters['tahun'])) {
            $query->whereYear(
                'tanggal_ba',
                $this->filters['tahun']
            );
        }

        if (!empty($this->filters['search'])) {
            $search = $this->filters['search'];

            $query->where(function (Builder $q) use ($search) {

                $q->where(
                    'nomor_ba',
                    'like',
                    "%{$search}%"
                )

                ->orWhere(
                    'nomor_po',
                    'like',
                    "%{$search}%"
                )

                ->orWhere(
                    'nomor_mo',
                    'like',
                    "%{$search}%"
                )

                ->orWhereHas(
                    'gudang',
                    fn ($g) => $g->where(
                        'nama_gudang',
                        'like',
                        "%{$search}%"
                    )
                )

                ->orWhereHas(
                    'mitraPengolahan',
                    fn ($m) => $m->where(
                        'nama_mitra',
                        'like',
                        "%{$search}%"
                    )
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
    ShouldAutoSize,
    WithStyles,
    WithColumnFormatting,
    WithEvents
{
    private int $no = 0;

    public function __construct(
        private ?int $month,
        private array $filters = []
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

        /*
         * FILTER DARI HALAMAN
         */
        if (!empty($this->filters['gudang_id'])) {
            $query->where(
                'gudang_id',
                $this->filters['gudang_id']
            );
        }

        if (!empty($this->filters['mitra_pengolahan_id'])) {
            $query->where(
                'mitra_pengolahan_id',
                $this->filters['mitra_pengolahan_id']
            );
        }

        if (!empty($this->filters['status'])) {
            $query->where(
                'status',
                $this->filters['status']
            );
        }

        /*
         * BULAN SHEET
         */
        if ($this->month !== null) {
            $query->whereMonth(
                'tanggal_ba',
                $this->month
            );
        }

        /*
         * TAHUN
         */
        if (!empty($this->filters['tahun'])) {
            $query->whereYear(
                'tanggal_ba',
                $this->filters['tahun']
            );
        }

        /*
         * SEARCH
         */
        if (!empty($this->filters['search'])) {
            $search = $this->filters['search'];

            $query->where(function (Builder $q) use ($search) {

                $q->where(
                    'nomor_ba',
                    'like',
                    "%{$search}%"
                )

                ->orWhere(
                    'nomor_po',
                    'like',
                    "%{$search}%"
                )

                ->orWhere(
                    'nomor_mo',
                    'like',
                    "%{$search}%"
                )

                ->orWhereHas(
                    'gudang',
                    fn ($g) => $g->where(
                        'nama_gudang',
                        'like',
                        "%{$search}%"
                    )
                )

                ->orWhereHas(
                    'mitraPengolahan',
                    fn ($m) => $m->where(
                        'nama_mitra',
                        'like',
                        "%{$search}%"
                    )
                );
            });
        }

        return $query;
    }

    /**
     * NAMA SHEET
     */
    public function title(): string
    {
        if ($this->month === null) {
            return 'DATA';
        }

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

        return $bulan[$this->month] ?? 'DATA';
    }

    /**
     * HEADER EXCEL
     *
     * 21 KOLOM: A - U
     */
    public function headings(): array
    {
        return [
            [
                'NO',
                'NAMA MITRA',
                'TANGGL PO GKP',
                'NOMOR PO GKP',
                'KUANTUM PO (KG)',
                'NO TM',
                'TANGGAL TM',
                'TM HASIL',
                '',
                'NO. MO',
                'TANGGAL MO',
                'HASIL GILING',
                '',
                'RENDEMEN %',
                '',
                'BEKATUL',
                '',
                'MENIR',
                '',
                'HASIL SAMPING',
                'GUDANG PENERIMA HGL',
            ],

            [
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                'NO',
                'TGL',
                '',
                '',
                'KOLI',
                'KG',
                'KG',
                '%',
                'KG',
                '%',
                'KG',
                '%',
                '',
                'INDUK',
            ],
        ];
    }

    /**
     * DATA SETIAP BARIS
     */
    public function map($ba): array
    {
        /*
         * Nomor selalu mulai dari 1
         * pada setiap sheet.
         */
        $this->no++;

        $gabah = 0;

        $beras = 0;
        $rendemenBeras = 0;

        $menir = 0;
        $rendemenMenir = 0;

        $bekatul = 0;
        $rendemenBekatul = 0;

        foreach ($ba->produksis as $produksi) {

            /*
             * GABAH / GKP
             */
            if (
                $produksi->produk_sebelum === 'Gabah (GKP)'
            ) {
                $gabah =
                    (float) $produksi->kuantum_sebelum;
            }

            /*
             * BERAS / HGL
             */
            if (
                $produksi->produk_sesudah === 'Beras (HGL)'
            ) {
                $beras =
                    (float) $produksi->kuantum_sesudah;

                $rendemenBeras =
                    (float) $produksi->rendemen;
            }

            /*
             * MENIR
             */
            if (
                $produksi->produk_sesudah === 'Menir'
            ) {
                $menir =
                    (float) $produksi->kuantum_sesudah;

                $rendemenMenir =
                    (float) $produksi->rendemen;
            }

            /*
             * BEKATUL
             */
            if (
                $produksi->produk_sesudah === 'Bekatul'
            ) {
                $bekatul =
                    (float) $produksi->kuantum_sesudah;

                $rendemenBekatul =
                    (float) $produksi->rendemen;
            }
        }

        return [

            // A - NO
            $this->no,

            // B - NAMA MITRA
            $ba->mitraPengolahan?->nama_mitra ?? '-',

            // C - TANGGAL PO GKP
            // Belum ada field tanggal PO
            null,

            // D - NOMOR PO GKP
            $ba->nomor_po ?? '-',

            // E - KUANTUM PO GKP
            $gabah,

            // F - NO TM BAHAN
            null,

            // G - TANGGAL TM
            $ba->tanggal_ba,

            // H - TM HASIL NO
            null,

            // I - TM HASIL TGL
            $ba->tanggal_ba,

            // J - NOMOR MO
            $ba->nomor_mo ?? '-',

            // K - TANGGAL MO
            null,

            // L - HASIL GILING KOLI
            null,

            // M - HASIL GILING KG
            $beras,

            // N - RENDEMEN KG
            null,

            // O - RENDEMEN %
            $rendemenBeras,

            // P - BEKATUL KG
            $bekatul,

            // Q - BEKATUL %
            $rendemenBekatul,

            // R - MENIR KG
            $menir,

            // S - RENDEMEN %
            $rendemenMenir,

            // T - HASIL SAMPING %
            null,

            // U - GUDANG PENERIMA HGL
            $ba->gudang?->nama_gudang ?? '-',
        ];
    }

    /**
     * FORMAT KOLOM
     */
    public function columnFormats(): array
    {
        return [
            'A' => '0',

            'C' => 'dd/mm/yyyy',
            'G' => 'dd/mm/yyyy',
            'I' => 'dd/mm/yyyy',
            'K' => 'dd/mm/yyyy',

            'E' => '#,##0',

            'L' => '0.00',

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
     * STYLE DASAR
     */
    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => [
                    'bold' => true,
                ],
            ],

            2 => [
                'font' => [
                    'bold' => true,
                ],
            ],
        ];
    }

    /**
     * EVENT SETELAH SHEET DIBUAT
     */
    public function registerEvents(): array
    {
        return [

            AfterSheet::class => function (
                AfterSheet $event
            ) {

                $sheet =
                    $event->sheet->getDelegate();

                /*
                 * =========================
                 * MERGE HEADER
                 * =========================
                 */

                $sheet->mergeCells('A1:A2');
                $sheet->mergeCells('B1:B2');
                $sheet->mergeCells('C1:C2');
                $sheet->mergeCells('D1:D2');
                $sheet->mergeCells('E1:E2');

                $sheet->mergeCells('F1:F2');
                $sheet->mergeCells('G1:G2');

                $sheet->mergeCells('H1:I1');

                $sheet->mergeCells('J1:J2');
                $sheet->mergeCells('K1:K2');

                $sheet->mergeCells('L1:M1');
                $sheet->mergeCells('N1:O1');
                $sheet->mergeCells('P1:Q1');
                $sheet->mergeCells('R1:S1');

                $sheet->mergeCells('T1:T2');
                $sheet->mergeCells('U1:U2');

                /*
                 * =========================
                 * TINGGI HEADER
                 * =========================
                 */

                $sheet
                    ->getRowDimension(1)
                    ->setRowHeight(30);

                $sheet
                    ->getRowDimension(2)
                    ->setRowHeight(30);

                /*
                 * =========================
                 * STYLE HEADER
                 * =========================
                 */

                $sheet
                    ->getStyle('A1:U2')
                    ->applyFromArray([

                        'font' => [
                            'bold' => true,
                        ],

                        'fill' => [
                            'fillType' =>
                                Fill::FILL_SOLID,

                            'startColor' => [
                                'rgb' => 'FFF200',
                            ],
                        ],

                        'alignment' => [
                            'horizontal' =>
                                Alignment::HORIZONTAL_CENTER,

                            'vertical' =>
                                Alignment::VERTICAL_CENTER,

                            'wrapText' => true,
                        ],

                        'borders' => [
                            'allBorders' => [
                                'borderStyle' =>
                                    Border::BORDER_THIN,
                            ],
                        ],
                    ]);

                /*
                 * =========================
                 * DATA
                 * =========================
                 */

                $highestRow =
                    $sheet->getHighestRow();

                if ($highestRow >= 3) {

                    $sheet
                        ->getStyle(
                            "A3:U{$highestRow}"
                        )
                        ->applyFromArray([

                            'borders' => [
                                'allBorders' => [
                                    'borderStyle' =>
                                        Border::BORDER_THIN,
                                ],
                            ],

                            'alignment' => [
                                'vertical' =>
                                    Alignment::VERTICAL_CENTER,
                            ],
                        ]);

                    /*
                     * =========================
                     * RUMUS EXCEL
                     * =========================
                     */

                    for (
                        $row = 3;
                        $row <= $highestRow;
                        $row++
                    ) {

                        /*
                         * HASIL GILING - KOLI
                         *
                         * 1 KOLI = 50 KG
                         */
                        $sheet->setCellValue(
                            "L{$row}",
                            "=IFERROR(M{$row}/50,0)"
                        );

                        /*
                         * RENDEMEN BERAS
                         */
                        $sheet->setCellValue(
                            "O{$row}",
                            "=IFERROR(M{$row}/E{$row}*100,0)"
                        );

                        /*
                         * RENDEMEN BEKATUL
                         */
                        $sheet->setCellValue(
                            "Q{$row}",
                            "=IFERROR(P{$row}/E{$row}*100,0)"
                        );

                        /*
                         * RENDEMEN MENIR
                         */
                        $sheet->setCellValue(
                            "S{$row}",
                            "=IFERROR(R{$row}/E{$row}*100,0)"
                        );

                        /*
                         * HASIL SAMPING
                         */
                        $sheet->setCellValue(
                            "T{$row}",
                            "=IFERROR((P{$row}+R{$row})/E{$row}*100,0)"
                        );

                        /*
                         * FORMAT KUANTUM
                         */
                        $sheet
                            ->getStyle("E{$row}")
                            ->getNumberFormat()
                            ->setFormatCode('#,##0');

                        $sheet
                            ->getStyle("M{$row}")
                            ->getNumberFormat()
                            ->setFormatCode('#,##0');

                        $sheet
                            ->getStyle("P{$row}")
                            ->getNumberFormat()
                            ->setFormatCode('#,##0');

                        $sheet
                            ->getStyle("R{$row}")
                            ->getNumberFormat()
                            ->setFormatCode('#,##0');

                        /*
                         * FORMAT KOLI
                         */
                        $sheet
                            ->getStyle("L{$row}")
                            ->getNumberFormat()
                            ->setFormatCode('0.00');

                        /*
                         * FORMAT RENDEMEN
                         */
                        $sheet
                            ->getStyle("O{$row}")
                            ->getNumberFormat()
                            ->setFormatCode('0.00');

                        $sheet
                            ->getStyle("Q{$row}")
                            ->getNumberFormat()
                            ->setFormatCode('0.00');

                        $sheet
                            ->getStyle("S{$row}")
                            ->getNumberFormat()
                            ->setFormatCode('0.00');

                        $sheet
                            ->getStyle("T{$row}")
                            ->getNumberFormat()
                            ->setFormatCode('0.00');
                    }
                }

                /*
                 * =========================
                 * LEBAR KOLOM
                 * =========================
                 */

                $widths = [

                    'A' => 6,
                    'B' => 30,
                    'C' => 15,
                    'D' => 27,
                    'E' => 18,
                    'F' => 12,
                    'G' => 13,
                    'H' => 12,
                    'I' => 13,
                    'J' => 20,
                    'K' => 13,
                    'L' => 10,
                    'M' => 14,
                    'N' => 12,
                    'O' => 12,
                    'P' => 14,
                    'Q' => 12,
                    'R' => 12,
                    'S' => 12,
                    'T' => 16,
                    'U' => 28,
                ];

                foreach (
                    $widths as $column => $width
                ) {
                    $sheet
                        ->getColumnDimension($column)
                        ->setWidth($width);
                }

                /*
                 * =========================
                 * FREEZE HEADER
                 * =========================
                 */

                $sheet->freezePane('A3');

                /*
                 * =========================
                 * FILTER
                 * =========================
                 */

                if ($highestRow >= 3) {
                    $sheet->setAutoFilter(
                        "A2:U{$highestRow}"
                    );
                }
            },
        ];
    }
}