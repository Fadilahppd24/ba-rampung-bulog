<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePegawaiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdminKantor() === true;
    }

    public function rules(): array
    {
        $pegawai = $this->route('pegawai');

        return [
            'nip' => [
                'required',
                'string',
                'max:30',
                Rule::unique('pegawais', 'nip')->ignore($pegawai->id),
            ],

            'nama' => [
                'required',
                'string',
                'max:150',
            ],

            'jabatan' => [
                'required',
                'string',
                'max:100',
            ],

            'gudang_id' => [
                'nullable',
                'exists:gudangs,id',
            ],

            'nomor_telepon' => [
                'nullable',
                'string',
                'max:30',
            ],

            'email' => [
                'required',
                'email',
                'max:150',
                Rule::unique('pegawais', 'email')->ignore($pegawai->id),
                Rule::unique('users', 'email')->ignore($pegawai->user_id),
            ],

            'role' => [
                'required',
                Rule::in([
                    'admin_gudang',
                    'admin_kantor',
                    'pimpinan_cabang',
                ]),
            ],

            'password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed',
            ],

            'status' => [
                'required',
                'in:aktif,nonaktif',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'nip.required' => 'NIP wajib diisi.',
            'nip.unique' => 'NIP sudah digunakan.',

            'nama.required' => 'Nama pegawai wajib diisi.',

            'jabatan.required' => 'Jabatan wajib diisi.',

            'gudang_id.exists' => 'Gudang yang dipilih tidak valid.',

            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan oleh akun lain.',

            'role.required' => 'Role akun wajib dipilih.',
            'role.in' => 'Role akun tidak valid.',

            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',

            'status.required' => 'Status wajib dipilih.',
        ];
    }
}