<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BaRampungProduksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'ba_rampung_id',
        'produk_sebelum',
        'kuantum_sebelum',
        'produk_sesudah',
        'kuantum_sesudah',
        'rendemen',
    ];

    protected function casts(): array
    {
        return [
            'kuantum_sebelum' => 'decimal:2',
            'kuantum_sesudah' => 'decimal:2',
            'rendemen' => 'decimal:2',
        ];
    }

    public function baRampung(): BelongsTo
    {
        return $this->belongsTo(BaRampung::class);
    }
}
