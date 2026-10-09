<?php

namespace App\Exports;

use App\Models\Gudang;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class GudangExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [new GudangIndukSheet(), new GudangFilialSheet()];
    }
}

class GudangIndukSheet implements FromCollection, WithHeadings, WithTitle, WithStyles
{
    public function title(): string
    {
        return 'Gudang Induk';
    }

    public function collection(): Collection
    {
        return Gudang::query()
            ->whereNull('gudang_induk_id')
            ->orderBy('kode_gudang', 'asc')
            ->get()
            ->map(fn (Gudang $gudang) => [
                $gudang->kode_gudang ?? '-',
                $gudang->nama_gudang ?? '-',
                $gudang->alamat ?? '-',
                $gudang->kecamatan ?? '-',
                $gudang->desa ?? '-',
                $gudang->kapasitas,
                $gudang->status ?? '-',
            ]);
    }

    public function headings(): array
    {
        return ['Kode Gudang', 'Nama Gudang', 'Alamat', 'Kecamatan', 'Desa', 'Kapasitas (Ton)', 'Status'];
    }

    public function styles(Worksheet $sheet): array
    {
        $sheet->getStyle('A1:G1')->getFont()->setBold(true)->getColor()->setRGB('FFFFFF');
        $sheet->getStyle('A1:G1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('123F7A');
        $sheet->getStyle('A1:G1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        foreach (range('A', 'G') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }
        return [];
    }
}

class GudangFilialSheet implements FromCollection, WithTitle, WithEvents
{
    public function title(): string
    {
        return 'Gudang Filial';
    }

    public function collection(): Collection
    {
        return Gudang::query()
            ->with('gudangInduk')
            ->whereNotNull('gudangs.gudang_induk_id')
            ->join('gudangs as induk', 'gudangs.gudang_induk_id', '=', 'induk.id')
            ->orderBy('induk.nama_gudang', 'asc')
            ->orderBy('gudangs.kode_gudang', 'asc')
            ->select('gudangs.*')
            ->get()
            ->values()
            ->map(function (Gudang $gudang, int $index) {
                $lokasi = collect([
                    $gudang->desa ? 'Desa ' . $gudang->desa : null,
                    $gudang->kecamatan ? 'Kec. ' . $gudang->kecamatan : null,
                    $gudang->alamat,
                ])->filter(fn ($value) => filled($value))->implode(' ');

                return [
                    $index + 1,
                    $gudang->nama_gudang ?? '-',
                    $gudang->luas_m2,
                    $gudang->kapasitas,
                    $gudang->panjang_m,
                    $gudang->lebar_m,
                    $gudang->tinggi_m,
                    $lokasi !== '' ? $lokasi : '-',
                    $gudang->gudangInduk->nama_gudang ?? '-',
                ];
            });
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $sheet->insertNewRowBefore(1, 4);

                $sheet->mergeCells('A2:I2');
                $sheet->setCellValue('A2', 'GUDANG NON BULOG FILIAL KANCAB INDRAMAYU TH ' . date('Y'));

                foreach (['A3:A4', 'B3:B4', 'C3:C4', 'D3:D4', 'E3:G3', 'H3:H4', 'I3:I4'] as $range) {
                    $sheet->mergeCells($range);
                }

                $headers = [
                    'A3' => 'NO',
                    'B3' => 'NAMA GUDANG FILIAL',
                    'C3' => 'LUAS M²',
                    'D3' => 'KAPASITAS (TON)',
                    'E3' => 'UKURAN',
                    'E4' => 'PANJANG (M)',
                    'F4' => 'LEBAR (M)',
                    'G4' => 'TINGGI (M)',
                    'H3' => 'LOKASI',
                    'I3' => 'GUDANG INDUK',
                ];
                foreach ($headers as $cell => $value) {
                    $sheet->setCellValue($cell, $value);
                }

                $lastRow = max(4, $sheet->getHighestRow());
                $sheet->getStyle("A3:I{$lastRow}")->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
                $sheet->getStyle('A3:I4')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('FFF0C2');
                $sheet->getStyle('A3:I4')->getFont()->setBold(true);
                $sheet->getStyle('A2:I4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER)->setWrapText(true);
                $sheet->getStyle('A2:I2')->getFont()->setBold(true)->setSize(14);
                $sheet->getStyle('A2:I2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT)->setVertical(Alignment::VERTICAL_CENTER);

                $widths = ['A' => 7, 'B' => 34, 'C' => 13, 'D' => 17, 'E' => 14, 'F' => 13, 'G' => 13, 'H' => 48, 'I' => 24];
                foreach ($widths as $column => $width) {
                    $sheet->getColumnDimension($column)->setWidth($width);
                }
                if ($lastRow >= 5) {
                    $sheet->getStyle("A5:I{$lastRow}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                    $sheet->getStyle("A5:A{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle("C5:G{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
                    $sheet->setAutoFilter("A4:I{$lastRow}");
                }
                $sheet->getRowDimension(2)->setRowHeight(28);
                $sheet->getRowDimension(3)->setRowHeight(30);
                $sheet->getRowDimension(4)->setRowHeight(30);
                $sheet->freezePane('A5');
            },
        ];
    }
}
