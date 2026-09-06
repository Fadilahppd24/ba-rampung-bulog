<?php

namespace App\Exports;

use App\Models\BaRampung;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;

class LaporanExport implements
    FromCollection,
    WithHeadings,
    WithStyles,
    WithColumnWidths,
    WithMapping
{
    /**
     * Ambil data laporan
     */
    public function collection(): Collection
    {
        return BaRampung::with([
            'gudang',
            'mitraPengolahan',
        ])
            ->latest('tanggal_ba')
            ->get();
    }

    /**
     * Judul kolom Excel
     */
    public function headings(): array
    {
        return [
            'No.',
            'Nomor BA',
            'Tanggal BA',
            'Gudang',
            'Mitra Pengolahan',
            'Nomor PO GKP',
            'Nomor MO',
            'Gabah (Kg)',
            'Beras (Kg)',
            'Rendemen (%)',
            'Status',
        ];
    }

    /**
     * Mapping data ke kolom Excel
     */
    public function map($ba): array
    {
        return [
            $ba->id,
            $ba->nomor_ba ?? '-',
            $ba->tanggal_ba
                ? \Carbon\Carbon::parse($ba->tanggal_ba)->format('d/m/Y')
                : '-',
            $ba->gudang->nama_gudang ?? '-',
            $ba->mitraPengolahan->nama_mitra ?? '-',
            $ba->nomor_po_gkp ?? '-',
            $ba->nomor_mo ?? '-',
            $ba->gabah ?? 0,
            $ba->beras ?? 0,
            $ba->rendemen ?? 0,
            ucfirst($ba->status ?? '-'),
        ];
    }

    /**
     * Styling worksheet
     */
    public function styles(Worksheet $sheet)
    {
        // Freeze header
        $sheet->freezePane('A2');

        // Tinggi baris header
        $sheet->getRowDimension(1)->setRowHeight(30);

        // Style header
        $sheet->getStyle('A1:K1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 11,
                'color' => [
                    'rgb' => 'FFFFFF',
                ],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => '14532D',
                ],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => [
                        'rgb' => 'D1D5DB',
                    ],
                ],
            ],
        ]);

        // Border seluruh tabel
        $lastRow = $sheet->getHighestRow();

        if ($lastRow >= 2) {
            $sheet->getStyle("A2:K{$lastRow}")->applyFromArray([
                'borders' => [
                    'insideHorizontal' => [
                        'borderStyle' => Border::BORDER_HAIR,
                        'color' => [
                            'rgb' => 'E5E7EB',
                        ],
                    ],
                    'outline' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => [
                            'rgb' => 'D1D5DB',
                        ],
                    ],
                ],
                'alignment' => [
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ]);

            // Zebra striping
            for ($row = 2; $row <= $lastRow; $row++) {
                if ($row % 2 === 0) {
                    $sheet->getStyle("A{$row}:K{$row}")
                        ->getFill()
                        ->setFillType(Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setRGB('F8FAFC');
                }
            }

            // Rata tengah
            $sheet->getStyle("A2:A{$lastRow}")
                ->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $sheet->getStyle("C2:C{$lastRow}")
                ->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $sheet->getStyle("K2:K{$lastRow}")
                ->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_CENTER);

            // Angka rata kanan
            $sheet->getStyle("H2:J{$lastRow}")
                ->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_RIGHT);

            // Format angka
            $sheet->getStyle("H2:I{$lastRow}")
                ->getNumberFormat()
                ->setFormatCode('#,##0.00');

            $sheet->getStyle("J2:J{$lastRow}")
                ->getNumberFormat()
                ->setFormatCode('0.00');
        }

        // Font seluruh worksheet
        $sheet->getStyle("A1:K{$lastRow}")
            ->getFont()
            ->setName('Calibri')
            ->setSize(10);

        return $sheet;
    }

    /**
     * Lebar kolom
     */
    public function columnWidths(): array
    {
        return [
            'A' => 7,
            'B' => 22,
            'C' => 15,
            'D' => 25,
            'E' => 28,
            'F' => 20,
            'G' => 18,
            'H' => 17,
            'I' => 17,
            'J' => 17,
            'K' => 18,
        ];
    }
}