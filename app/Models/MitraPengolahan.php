<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MitraPengolahan extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_mitra',
        'nama_mitra',
        'jenis_usaha',
        'alamat',
        'kecamatan',
        'desa',
        'nomor_telepon',
        'email',
        'penanggung_jawab',
        'status',
    ];

    public function baRampungs(): HasMany
    {
        return $this->hasMany(BaRampung::class);
    }

    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }
}
