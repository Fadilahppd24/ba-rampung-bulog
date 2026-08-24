<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaturan extends Model
{
    protected $fillable = [
        'nama_cabang',
        'alamat_kantor',
        'telepon',
        'email',
        'logo_path',
        'warna_tema',
        'prefix_nomor_ba',
        'suffix_nomor_ba',
        'tahun_aktif',
        'item_per_halaman',
    ];

    /**
     * Settings are stored as a single row (id = 1). This helper fetches
     * it, creating a default row on first use so the rest of the app
     * never has to null-check "has settings been configured yet".
     */
    public static function current(): self
    {
        return self::firstOrCreate(['id' => 1]);
    }
}
