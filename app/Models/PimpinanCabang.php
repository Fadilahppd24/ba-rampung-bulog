<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PimpinanCabang extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'jabatan',
        'periode_mulai',
        'periode_selesai',
        'email',
        'nomor_telepon',
        'alamat',
        'foto',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'periode_mulai' => 'date',
            'periode_selesai' => 'date',
        ];
    }

    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }
}
