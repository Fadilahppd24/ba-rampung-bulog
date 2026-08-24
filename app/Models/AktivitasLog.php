<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AktivitasLog extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'aktivitas',
        'modul',
        'data_id',
        'keterangan',
        'ip_address',
        'created_at',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
