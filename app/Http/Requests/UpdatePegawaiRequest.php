<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePegawaiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return in_array(
            $this->user()?->role,
            ['admin_gudang', 'admin_kantor'],
            true
        );
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
            'status.required' => 'Status wajib dipilih.',
        ];
    }
}