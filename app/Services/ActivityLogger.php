<?php

namespace App\Services;

use App\Models\AktivitasLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ActivityLogger
{
    public static function log(string $aktivitas, string $modul, ?int $dataId = null, ?string $keterangan = null): void
    {
        AktivitasLog::create([
            'user_id' => Auth::id(),
            'aktivitas' => $aktivitas,
            'modul' => $modul,
            'data_id' => $dataId,
            'keterangan' => $keterangan,
            'ip_address' => Request::ip(),
            'created_at' => now(),
        ]);
    }
}
