<?php

namespace App\Policies;

use App\Models\BaRampung;
use App\Models\User;

class BaRampungPolicy
{
    public function viewAny(User $user): bool
    {
        return true; // all authenticated + active roles can see the list, scoped by controller
    }

    public function view(User $user, BaRampung $ba): bool
    {
        if ($user->isAdminSistem() || $user->isPimpinanCabang()) {
            return true;
        }

        // Admin Gudang only sees BA belonging to their own gudang
        return $user->gudang_id === $ba->gudang_id;
    }

    public function create(User $user): bool
    {
        return $user->isAdminGudang() || $user->isAdminSistem();
    }

    public function update(User $user, BaRampung $ba): bool
    {
        if (! $this->view($user, $ba)) {
            return false;
        }

        // Cannot edit once verified or completed
        return in_array($ba->status, [BaRampung::STATUS_DRAFT, BaRampung::STATUS_MENUNGGU_VERIFIKASI], true)
            && ($user->isAdminGudang() || $user->isAdminSistem());
    }

    public function delete(User $user, BaRampung $ba): bool
    {
        if ($user->isAdminSistem()) {
            return true;
        }

        return $user->isAdminGudang()
            && $user->gudang_id === $ba->gudang_id
            && $ba->status === BaRampung::STATUS_DRAFT;
    }

    public function verify(User $user, BaRampung $ba): bool
    {
        return ($user->isPimpinanCabang() || $user->isAdminSistem())
            && $ba->status === BaRampung::STATUS_MENUNGGU_VERIFIKASI;
    }
}
