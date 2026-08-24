<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pegawai extends Model
{
    use HasFactory;

    protected $fillable = [
        'nip',
        'nama',
        'jabatan',
        'gudang_id',
        'nomor_telepon',
        'email',
        'status',
    ];

    public function gudang(): BelongsTo
    {
        return $this->belongsTo(Gudang::class);
    }

    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }
}
