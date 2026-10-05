<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Gudang;
use App\Models\User;
use App\Services\ActivityLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Daftar seluruh user untuk Admin Kantor.
     */
    public function index(Request $request): View
    {
        $query = User::with('gudang')
            ->whereIn('role', [
                User::ROLE_ADMIN_KANTOR,
                User::ROLE_ADMIN_GUDANG,
            ])
            ->orderBy('name');

        if ($search = trim((string) $request->input('search'))) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role') && in_array($request->role, User::availableRoles(), true)) {
            $query->where('role', $request->role);
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'aktif');
        }

        $users = $query->paginate(15)->withQueryString();

        return view('pengaturan.users.index', compact('users'));
    }

    /**
     * Form tambah user.
     */
    public function create(): View
    {
        $gudangs = $this->gudangIndukAktif();

        return view('pengaturan.users.create', compact('gudangs'));
    }

    /**
     * Simpan user baru.
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data = $this->normaliseGudang($data);

        $this->ensureActiveGudangAvailable($data);

        $user = User::create($data);

        ActivityLogger::log(
            'Menambah User',
            'user',
            $user->id,
            "Nama: {$user->name}; Role: {$user->roleLabel()}"
        );

        return redirect()
            ->route('pengaturan.users.index')
            ->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * Form edit user.
     */
    public function edit(User $user): View
    {
        $this->ensureManageableUser($user);

        $gudangs = $this->gudangIndukAktif();

        return view('pengaturan.users.edit', compact('user', 'gudangs'));
    }

    /**
     * Update user.
     */
    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $this->ensureManageableUser($user);

        $data = $request->validated();
        $data = $this->normaliseGudang($data);

        $this->ensureActiveGudangAvailable($data, $user);

        // Password kosong saat edit = password lama tetap digunakan.
        if (empty($data['password'])) {
            unset($data['password']);
        }

        $user->update($data);

        ActivityLogger::log(
            'Mengubah User',
            'user',
            $user->id,
            "Nama: {$user->name}; Role: {$user->roleLabel()}"
        );

        return redirect()
            ->route('pengaturan.users.index')
            ->with('success', 'User berhasil diperbarui.');
    }

    /**
     * Aktif/nonaktif user. User tidak pernah dihapus dari database.
     */
    public function toggleStatus(User $user): RedirectResponse
    {
        $this->ensureManageableUser($user);

        if ($user->id === request()->user()->id && $user->is_active) {
            return back()->withErrors([
                'user' => 'Anda tidak dapat menonaktifkan akun yang sedang digunakan.',
            ]);
        }

        if (! $user->is_active) {
            $this->ensureActiveGudangAvailable([
                'role' => $user->role,
                'gudang_id' => $user->gudang_id,
                'is_active' => true,
            ], $user);
        }

        $user->update([
            'is_active' => ! $user->is_active,
        ]);

        ActivityLogger::log(
            $user->is_active ? 'Mengaktifkan User' : 'Menonaktifkan User',
            'user',
            $user->id,
            "Nama: {$user->name}; Status: " . ($user->is_active ? 'Aktif' : 'Nonaktif')
        );

        return back()->with(
            'success',
            $user->is_active ? 'User berhasil diaktifkan.' : 'User berhasil dinonaktifkan.'
        );
    }

    /**
     * Reset password user tanpa mengubah role/gudang/status.
     */
    public function resetPassword(Request $request, User $user): RedirectResponse
    {
        $this->ensureManageableUser($user);

        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'password.required' => 'Password baru wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak sama.',
        ]);

        $user->update([
            'password' => $request->password,
        ]);

        ActivityLogger::log(
            'Reset Password User',
            'user',
            $user->id,
            "Password user {$user->name} berhasil diubah oleh Admin Kantor."
        );

        return back()->with('success', 'Password user berhasil diubah.');
    }

    /**
     * Hanya Gudang Induk aktif yang boleh dipilih untuk Admin Gudang.
     */
    private function gudangIndukAktif()
    {
        return Gudang::aktif()
            ->whereNull('gudang_induk_id')
            ->orderBy('nama_gudang')
            ->get();
    }

    /**
     * Admin Kantor selalu tidak memiliki gudang.
     */
    private function normaliseGudang(array $data): array
    {
        if (($data['role'] ?? null) === User::ROLE_ADMIN_KANTOR) {
            $data['gudang_id'] = null;
        }

        return $data;
    }

    /**
     * Satu akun aktif untuk satu Gudang Induk.
     */
    private function ensureActiveGudangAvailable(array $data, ?User $except = null): void
    {
        if (($data['role'] ?? null) !== User::ROLE_ADMIN_GUDANG || empty($data['gudang_id'])) {
            return;
        }

        if (! (bool) ($data['is_active'] ?? true)) {
            return;
        }

        $query = User::query()
            ->where('role', User::ROLE_ADMIN_GUDANG)
            ->where('gudang_id', $data['gudang_id'])
            ->where('is_active', true);

        if ($except) {
            $query->where('id', '!=', $except->id);
        }

        if ($query->exists()) {
            throw ValidationException::withMessages([
                'gudang_id' => 'Gudang tersebut sudah memiliki satu Admin Gudang yang aktif.',
            ]);
        }
    }

    /**
     * Tahap 3 hanya mengelola dua role resmi.
     */
    private function ensureManageableUser(User $user): void
    {
        abort_unless(
            in_array($user->role, User::availableRoles(), true),
            404
        );
    }
}
