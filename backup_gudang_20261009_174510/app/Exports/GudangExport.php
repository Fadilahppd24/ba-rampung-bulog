<?php

namespace App\Exports;

use App\Models\Gudang;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class GudangExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new GudangDataSheet('induk'),
            new GudangDataSheet('filial'),
        ];
    }
}

class GudangDataSheet implements FromCollection, WithHeadings, WithTitle, WithStyles
{
    private string $jenis;

    public function __construct(string $jenis)
    {
        $this->jenis = $jenis;
    }

    public function title(): string
    {
        return $this->jenis === 'induk' ? 'Gudang Induk' : 'Gudang Filial';
    }

    public function collection(): Collection
    {
        $query = Gudang::query()->with('gudangInduk');

        if ($this->jenis === 'induk') {
            $query->whereNull('gudang_induk_id')
                ->orderBy('kode_gudang', 'asc');
        } else {
            $query->whereNotNull('gudangs.gudang_induk_id')
                // Kelompokkan filial berdasarkan nama gudang induk,
                // kemudian urutkan kode filial dari terkecil ke terbesar.
                ->join('gudangs as induk', 'gudangs.gudang_induk_id', '=', 'induk.id')
                ->orderBy('induk.nama_gudang', 'asc')
                ->orderBy('gudangs.kode_gudang', 'asc')
                ->select('gudangs.*');
        }

        return $query
            ->get()
            ->map(function (Gudang $gudang) {
                return [
                    'kode_gudang' => $gudang->kode_gudang ?? '-',
                    'nama_gudang' => $gudang->nama_gudang ?? '-',
                    'gudang_induk' => $gudang->gudangInduk->nama_gudang ?? '-',
                    'alamat' => $gudang->alamat ?? '-',
                    'kecamatan' => $gudang->kecamatan ?? '-',
                    'desa' => $gudang->desa ?? '-',
                    'kapasitas_ton' => $gudang->kapasitas,
                    'status' => $gudang->status ?? '-',
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Kode Gudang',
            'Nama Gudang',
            'Gudang Induk',
            'Alamat',
            'Kecamatan',
            'Desa',
            'Kapasitas (Ton)',
            'Status',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => 'solid',
                    'startColor' => ['rgb' => '123F7A'],
                ],
            ],
        ];
    }
}
