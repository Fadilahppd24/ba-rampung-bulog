<?php

namespace App\Policies;

use App\Models\BaRampung;
use App\Models\User;

class BaRampungPolicy
{
    public function viewAny(User $user): bool
{
    return $user->isAdminKantor()
        || $user->isAdminGudang()
        || $user->isPimpinanCabang();
}

    public function view(User $user, BaRampung $ba): bool
    {
        // Admin Kantor dan Pimpinan Cabang bisa melihat semua BA
        if ($user->isAdminKantor() || $user->isPimpinanCabang()) {
            return true;
        }

        // Admin Gudang hanya bisa melihat BA dari gudangnya sendiri
        return $user->gudang_id === $ba->gudang_id;
    }

    public function create(User $user): bool
    {
        // Hanya Admin Gudang yang berhak membuat BA Rampung.
        return $user->isAdminGudang();
    }

   public function update(User $user, BaRampung $ba): bool
{
    // Hanya Admin Gudang yang boleh mengedit
    if (! $user->isAdminGudang()) {
        return false;
    }

    // Hanya pembuat BA tersebut yang boleh mengedit
    if ((int) $ba->created_by !== (int) $user->id) {
        return false;
    }

    // BA yang masih boleh diedit
    return in_array(
        $ba->status,
        [
            BaRampung::STATUS_DRAFT,
            BaRampung::STATUS_MENUNGGU_VERIFIKASI,
            BaRampung::STATUS_DITOLAK,
        ],
        true
    );
}

    public function delete(User $user, BaRampung $ba): bool
    {
        // Admin Kantor bisa menghapus semua BA
        if ($user->isAdminKantor()) {
            return true;
        }

        // Admin Gudang hanya bisa menghapus BA draft
        // milik gudangnya sendiri
        return $user->isAdminGudang()
            && $user->gudang_id === $ba->gudang_id
            && $ba->status === BaRampung::STATUS_DRAFT;
    }

    public function verify(User $user, BaRampung $ba): bool
    {
        return $user->isAdminKantor()
            && $ba->status === BaRampung::STATUS_MENUNGGU_VERIFIKASI;
    }
}