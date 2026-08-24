<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public const ROLE_ADMIN_GUDANG = 'admin_gudang';
    public const ROLE_PIMPINAN_CABANG = 'pimpinan_cabang';
    public const ROLE_ADMIN_SISTEM = 'admin_sistem';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'gudang_id',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    public function gudang(): BelongsTo
    {
        return $this->belongsTo(Gudang::class);
    }

    public function isAdminSistem(): bool
    {
        return $this->role === self::ROLE_ADMIN_SISTEM;
    }

    public function isPimpinanCabang(): bool
    {
        return $this->role === self::ROLE_PIMPINAN_CABANG;
    }

    public function isAdminGudang(): bool
    {
        return $this->role === self::ROLE_ADMIN_GUDANG;
    }

    public function roleLabel(): string
    {
        return match ($this->role) {
            self::ROLE_ADMIN_GUDANG => 'Admin Gudang',
            self::ROLE_PIMPINAN_CABANG => 'Pimpinan Cabang',
            self::ROLE_ADMIN_SISTEM => 'Admin Sistem',
            default => $this->role,
        };
    }
}
