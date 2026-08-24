<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGudangRequest extends FormRequest
{
    public function authorize(): bool
    {
        return in_array($this->user()->role, ['admin_gudang', 'admin_sistem'], true);
    }

    public function rules(): array
    {
        return [
            'kode_gudang' => ['required', 'string', 'max:20', 'unique:gudangs,kode_gudang,' . $this->route('gudang')->id],
            'nama_gudang' => ['required', 'string', 'max:150'],
            'alamat' => ['nullable', 'string', 'max:500'],
            'kecamatan' => ['nullable', 'string', 'max:100'],
            'desa' => ['nullable', 'string', 'max:100'],
            'nomor_telepon' => ['nullable', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:150'],
            'kapasitas' => ['nullable', 'numeric', 'min:0'],
            'status' => ['required', 'in:aktif,nonaktif'],
        ];
    }

    public function messages(): array
    {
        return [
            'kode_gudang.required' => 'Kode Gudang wajib diisi.',
            'kode_gudang.unique' => 'Kode Gudang sudah digunakan, gunakan kode lain.',
            'nama_gudang.required' => 'Nama Gudang wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'kapasitas.numeric' => 'Kapasitas harus berupa angka.',
            'kapasitas.min' => 'Kapasitas tidak boleh negatif.',
            'status.required' => 'Status wajib dipilih.',
        ];
    }
}
