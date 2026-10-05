<div class="grid grid-cols-1 gap-5 md:grid-cols-2">
    <div>
        <label class="mb-2 block text-sm font-semibold text-slate-700">Nama</label>
        <input type="text" name="name" value="{{ old('name', $user->name ?? '') }}" class="input w-full" required>
    </div>

    <div>
        <label class="mb-2 block text-sm font-semibold text-slate-700">Email</label>
        <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}" class="input w-full" required>
    </div>

    <div>
        <label class="mb-2 block text-sm font-semibold text-slate-700">Role</label>
        <select name="role" id="role" class="input w-full" required>
            <option value="">Pilih Role</option>
            <option value="admin_kantor" @selected(old('role', $user->role ?? '') === 'admin_kantor')>Admin Kantor</option>
            <option value="admin_gudang" @selected(old('role', $user->role ?? '') === 'admin_gudang')>Admin Gudang</option>
        </select>
    </div>

    <div id="gudang-wrapper">
        <label class="mb-2 block text-sm font-semibold text-slate-700">Gudang Induk</label>
        <select name="gudang_id" id="gudang_id" class="input w-full">
            <option value="">Pilih Gudang Induk</option>
            @foreach($gudangs as $gudang)
                <option value="{{ $gudang->id }}" @selected((string) old('gudang_id', $user->gudang_id ?? '') === (string) $gudang->id)>
                    {{ $gudang->kode_gudang }} — {{ $gudang->nama_gudang }}
                </option>
            @endforeach
        </select>
        <p class="mt-1 text-xs text-slate-400">Hanya Gudang Induk yang aktif. Filial tidak memiliki akun.</p>
    </div>

    <div>
        <label class="mb-2 block text-sm font-semibold text-slate-700">{{ $mode === 'edit' ? 'Password Baru (opsional)' : 'Password' }}</label>
        <input type="password" name="password" class="input w-full" {{ $mode === 'create' ? 'required' : '' }} autocomplete="new-password">
        <p class="mt-1 text-xs text-slate-400">Minimal 8 karakter.</p>
    </div>

    <div>
        <label class="mb-2 block text-sm font-semibold text-slate-700">Konfirmasi Password</label>
        <input type="password" name="password_confirmation" class="input w-full" {{ $mode === 'create' ? 'required' : '' }} autocomplete="new-password">
    </div>

    <div>
        <label class="mb-2 block text-sm font-semibold text-slate-700">Status</label>
        <select name="is_active" class="input w-full" required>
            <option value="1" @selected((string) old('is_active', isset($user) ? (int) $user->is_active : 1) === '1')>Aktif</option>
            <option value="0" @selected((string) old('is_active', isset($user) ? (int) $user->is_active : 1) === '0')>Nonaktif</option>
        </select>
    </div>
</div>

<div class="mt-6 flex flex-col-reverse gap-3 border-t border-slate-100 pt-5 sm:flex-row sm:justify-end">
    <a href="{{ route('pengaturan.users.index') }}" class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold text-slate-600 hover:bg-slate-50">Batal</a>
    <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-[#123F7A] px-5 py-2.5 text-sm font-bold text-white hover:bg-[#0d315f]">
        {{ $mode === 'edit' ? 'Simpan Perubahan' : 'Simpan User' }}
    </button>
</div>
