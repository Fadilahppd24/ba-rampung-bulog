<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Gudang extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_gudang',
        'nama_gudang',
        'alamat',
        'kecamatan',
        'desa',
        'nomor_telepon',
        'email',
        'kapasitas',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'kapasitas' => 'decimal:2',
        ];
    }

    public function pegawais(): HasMany
    {
        return $this->hasMany(Pegawai::class);
    }

    public function baRampungs(): HasMany
    {
        return $this->hasMany(BaRampung::class);
    }

    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }
}
