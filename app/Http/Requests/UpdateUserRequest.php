<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdminKantor() === true;
    }

    public function rules(): array
    {
        $user = $this->route('user');

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user?->id),
            ],
            'role' => ['required', Rule::in(User::availableRoles())],
            'gudang_id' => [
                'nullable',
                'integer',
                Rule::requiredIf(fn () => $this->input('role') === User::ROLE_ADMIN_GUDANG),
                Rule::exists('gudangs', 'id')->where(fn ($query) => $query
                    ->whereNull('gudang_induk_id')
                    ->where('status', 'aktif')),
            ],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'is_active' => ['required', 'boolean'],
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->input('role') === User::ROLE_ADMIN_KANTOR) {
            $this->merge(['gudang_id' => null]);
        }
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'role.required' => 'Role wajib dipilih.',
            'role.in' => 'Role yang dipilih tidak valid.',
            'gudang_id.required' => 'Gudang wajib dipilih untuk Admin Gudang.',
            'gudang_id.exists' => 'Gudang harus merupakan Gudang Induk yang aktif.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak sama.',
        ];
    }
}
