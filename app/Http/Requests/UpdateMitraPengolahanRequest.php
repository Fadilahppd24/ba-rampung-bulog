<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMitraPengolahanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() &&
            in_array($this->user()->role, [
                'admin_gudang',
                'admin_kantor',
            ], true);
    }

    public function rules(): array
    {
        return [
            'kode_mitra' => [
                'required',
                'string',
                'max:20',
                'unique:mitra_pengolahans,kode_mitra,' . $this->route('mitra')->id,
            ],

            'nama_mitra' => [
                'required',
                'string',
                'max:150',
            ],

            'jenis_usaha' => [
                'nullable',
                'string',
                'max:100',
            ],

            'alamat' => [
                'nullable',
                'string',
                'max:500',
            ],

            'kecamatan' => [
                'nullable',
                'string',
                'max:100',
            ],

            'desa' => [
                'nullable',
                'string',
                'max:100',
            ],

            'nomor_telepon' => [
                'nullable',
                'string',
                'max:30',
            ],

            'email' => [
                'nullable',
                'email',
                'max:150',
            ],

            'penanggung_jawab' => [
                'nullable',
                'string',
                'max:150',
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
            'kode_mitra.required' => 'Kode Mitra wajib diisi.',
            'kode_mitra.unique' => 'Kode Mitra sudah digunakan, gunakan kode lain.',
            'nama_mitra.required' => 'Nama Mitra wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'status.required' => 'Status wajib dipilih.',
        ];
    }
}