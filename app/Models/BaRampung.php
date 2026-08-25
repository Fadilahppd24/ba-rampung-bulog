<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BaRampung extends Model
{
    use HasFactory;

    public const STATUS_DRAFT = 'draft';
    public const STATUS_MENUNGGU_VERIFIKASI = 'menunggu_verifikasi';
    public const STATUS_TERVERIFIKASI = 'terverifikasi';
    public const STATUS_DITOLAK = 'ditolak';
    public const STATUS_SELESAI = 'selesai';

    public const STATUSES = [
        self::STATUS_DRAFT => 'Draft',
        self::STATUS_MENUNGGU_VERIFIKASI => 'Menunggu Verifikasi',
        self::STATUS_TERVERIFIKASI => 'Terverifikasi',
        self::STATUS_DITOLAK => 'Ditolak',
        self::STATUS_SELESAI => 'Selesai',
    ];

    

    protected $fillable = [
        'nomor_ba',
        'tanggal_ba',
        'hari',
        'bulan',
        'tahun',
        'nomor_mo',
        'nomor_po',
        'gudang_id',
        'mitra_pengolahan_id',
        'nama_penandatangan',
        'jabatan_penandatangan',
        'nama_penandatangan_pihak_kedua',
        'jabatan_penandatangan_pihak_kedua',
        'pimpinan_cabang_id',
        'status',
        'catatan',
        'alasan_penolakan',
        'created_by',
        'verified_by',
        'verified_at',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_ba' => 'date',
            'verified_at' => 'datetime',
        ];
    }

    public function gudang(): BelongsTo
    {
        return $this->belongsTo(Gudang::class);
    }

    public function mitraPengolahan(): BelongsTo
    {
        return $this->belongsTo(MitraPengolahan::class);
    }

    public function pimpinanCabang(): BelongsTo
    {
        return $this->belongsTo(PimpinanCabang::class);
    }

    public function pembuat(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function verifikator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function produksis(): HasMany
    {
        return $this->hasMany(BaRampungProduksi::class);
    }

    public function statusLabel(): string
    {
        return self::STATUSES[$this->status] ?? $this->status;
    }


    public function statusBadgeColor(): string
    {
        return match ($this->status) {
            self::STATUS_TERVERIFIKASI, self::STATUS_SELESAI => 'green',
            self::STATUS_MENUNGGU_VERIFIKASI => 'yellow',
            self::STATUS_DITOLAK => 'red',
            default => 'gray',
        };
    }

    /**
     * Generate a unique BA number in the format:
     * BA-{urutan}/{bulan}/{tahun}/{urutTahun}/GKP
     * e.g. BA-007/07/2026/10040/GKP
     *
     * This runs entirely on the backend to guarantee uniqueness and format;
     * never trust a number posted from the client.
     */
    public static function generateNomorBa(\DateTimeInterface $tanggal): string
    {
        $bulan = $tanggal->format('m');
        $tahun = $tanggal->format('Y');

        $urutanBulan = self::whereYear('tanggal_ba', $tahun)
            ->whereMonth('tanggal_ba', $bulan)
            ->count() + 1;

        $urutanTahun = self::whereYear('tanggal_ba', $tahun)->count() + 10001;

        do {
            $nomor = sprintf(
                'BA-%03d/%s/%s/%d/GKP',
                $urutanBulan,
                $bulan,
                $tahun,
                $urutanTahun
            );
            $exists = self::where('nomor_ba', $nomor)->exists();
            if ($exists) {
                $urutanBulan++;
                $urutanTahun++;
            }
        } while ($exists);

        return $nomor;
    }
}
