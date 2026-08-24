<?php

namespace App\Exports;

use App\Models\BaRampung;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

/**
 * Streams the (filtered) BA Rampung list as .xlsx.
 * Uses FromQuery + chunked reading under the hood (maatwebsite/excel)
 * so large result sets don't get pulled fully into memory.
 */
class BaRampungExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithColumnFormatting
{
    public function __construct(private array $filters = [])
    {
    }

    public function query(): Builder
    {
        $query = BaRampung::query()->with(['gudang', 'mitraPengolahan'])->orderByDesc('tanggal_ba');

        if (! empty($this->filters['gudang_id'])) {
            $query->where('gudang_id', $this->filters['gudang_id']);
        }

        if (! empty($this->filters['mitra_pengolahan_id'])) {
            $query->where('mitra_pengolahan_id', $this->filters['mitra_pengolahan_id']);
        }

        if (! empty($this->filters['status'])) {
            $query->where('status', $this->filters['status']);
        }

        if (! empty($this->filters['bulan'])) {
            $query->whereMonth('tanggal_ba', $this->filters['bulan']);
        }

        if (! empty($this->filters['tahun'])) {
            $query->whereYear('tanggal_ba', $this->filters['tahun']);
        }

        if (! empty($this->filters['search'])) {
            $search = $this->filters['search'];
            $query->where(function (Builder $q) use ($search) {
                $q->where('nomor_ba', 'like', "%{$search}%")
                    ->orWhereHas('gudang', fn ($g) => $g->where('nama_gudang', 'like', "%{$search}%"))
                    ->orWhereHas('mitraPengolahan', fn ($m) => $m->where('nama_mitra', 'like', "%{$search}%"));
            });
        }

        return $query;
    }

    public function headings(): array
    {
        return [
            'No.', 'Nomor BA', 'Tanggal BA', 'Gudang', 'Mitra Pengolahan',
            'Nomor MO', 'Nomor PO', 'Status Verifikasi', 'Status PBP', 'Catatan',
        ];
    }

    public function map($ba): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $ba->nomor_ba,
            $ba->tanggal_ba->format('d/m/Y'),
            $ba->gudang->nama_gudang,
            $ba->mitraPengolahan->nama_mitra,
            $ba->nomor_mo,
            $ba->nomor_po,
            $ba->statusLabel(),
            $ba->statusPbpLabel(),
            $ba->catatan ?? '-',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => DataType::TYPE_NUMERIC,
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true], 'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'EFE7D3'],
            ]],
        ];
    }
}
