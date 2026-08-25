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
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BaRampungExport implements
    FromQuery,
    WithHeadings,
    WithMapping,
    ShouldAutoSize,
    WithStyles,
    WithColumnFormatting
{
    public function __construct(private array $filters = [])
    {
    }

    public function query(): Builder
    {
        $query = BaRampung::query()
            ->with([
                'gudang',
                'mitraPengolahan',
                'produksis',
            ])
            ->orderByDesc('tanggal_ba');

        if (!empty($this->filters['gudang_id'])) {
            $query->where('gudang_id', $this->filters['gudang_id']);
        }

        if (!empty($this->filters['mitra_pengolahan_id'])) {
            $query->where(
                'mitra_pengolahan_id',
                $this->filters['mitra_pengolahan_id']
            );
        }

        if (!empty($this->filters['status'])) {
            $query->where('status', $this->filters['status']);
        }

        if (!empty($this->filters['bulan'])) {
            $query->whereMonth('tanggal_ba', $this->filters['bulan']);
        }

        if (!empty($this->filters['tahun'])) {
            $query->whereYear('tanggal_ba', $this->filters['tahun']);
        }

        if (!empty($this->filters['search'])) {
            $search = $this->filters['search'];

            $query->where(function (Builder $q) use ($search) {
                $q->where('nomor_ba', 'like', "%{$search}%")
                    ->orWhereHas(
                        'gudang',
                        fn ($g) =>
                            $g->where(
                                'nama_gudang',
                                'like',
                                "%{$search}%"
                            )
                    )
                    ->orWhereHas(
                        'mitraPengolahan',
                        fn ($m) =>
                            $m->where(
                                'nama_mitra',
                                'like',
                                "%{$search}%"
                            )
                    );
            });
        }

        return $query;
    }

    public function headings(): array
    {
        return [
            'No.',
            'Nomor BA',
            'Tanggal BA',
            'Gudang',
            'Nama Mitra',
            'Nomor MO',
            'Nomor PO',

            'Gabah (GKP) KG',

            'Beras (HGL) KG',
            'Rendemen Beras (%)',

            'Menir KG',
            'Rendemen Menir (%)',

            'Bekatul KG',
            'Rendemen Bekatul (%)',

            'Status Verifikasi',
            'Status PBP',
            'Catatan',
        ];
    }

    public function map($ba): array
    {
        static $no = 0;
        $no++;

        /*
         * Data produksi:
         *
         * Gabah  = kuantum_sebelum
         * Beras  = kuantum_sesudah + rendemen
         * Menir  = kuantum_sesudah + rendemen
         * Bekatul = kuantum_sesudah + rendemen
         */

        $gabah = 0;
        $beras = 0;
        $rendemenBeras = 0;
        $menir = 0;
        $rendemenMenir = 0;
        $bekatul = 0;
        $rendemenBekatul = 0;

        foreach ($ba->produksis as $produksi) {

            // Gabah (GKP)
            if ($produksi->produk_sebelum === 'Gabah (GKP)') {
                $gabah = (float) $produksi->kuantum_sebelum;
            }

            // Beras (HGL)
            if ($produksi->produk_sesudah === 'Beras (HGL)') {
                $beras = (float) $produksi->kuantum_sesudah;
                $rendemenBeras = (float) $produksi->rendemen;
            }

            // Menir
            if ($produksi->produk_sesudah === 'Menir') {
                $menir = (float) $produksi->kuantum_sesudah;
                $rendemenMenir = (float) $produksi->rendemen;
            }

            // Bekatul
            if ($produksi->produk_sesudah === 'Bekatul') {
                $bekatul = (float) $produksi->kuantum_sesudah;
                $rendemenBekatul = (float) $produksi->rendemen;
            }
        }

        return [
            $no,

            $ba->nomor_ba,

            $ba->tanggal_ba
                ? $ba->tanggal_ba->format('d/m/Y')
                : '-',

            $ba->gudang?->nama_gudang ?? '-',

            $ba->mitraPengolahan?->nama_mitra ?? '-',

            $ba->nomor_mo ?? '-',

            $ba->nomor_po ?? '-',

            // Gabah
            $gabah,

            // Beras
            $beras,
            $rendemenBeras,

            // Menir
            $menir,
            $rendemenMenir,

            // Bekatul
            $bekatul,
            $rendemenBekatul,

            $ba->statusLabel(),

            $ba->statusPbpLabel(),

            $ba->catatan ?? '-',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => DataType::TYPE_NUMERIC,

            'H' => '0.00',
            'I' => '0.00',
            'J' => '0.00',
            'K' => '0.00',
            'L' => '0.00',
            'M' => '0.00',
            'N' => '0.00',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => [
                    'bold' => true,
                ],
                'fill' => [
                    'fillType' =>
                        \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,

                    'startColor' => [
                        'rgb' => 'EFE7D3',
                    ],
                ],
            ],
        ];
    }
}