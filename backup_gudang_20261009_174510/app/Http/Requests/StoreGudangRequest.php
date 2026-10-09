<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreGudangRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdminKantor() === true;
    }

    public function rules(): array
    {
        return [
            // kode_gudang SENGAJA tidak divalidasi/diterima dari form.
            // Kode dibuat 100% oleh backend (GudangController).

            'jenis_gudang' => [
                'required',
                Rule::in(['utama', 'filial']),
            ],

            'gudang_induk_id' => [
                Rule::requiredIf(
                    fn () => $this->input('jenis_gudang') === 'filial'
                ),
                'nullable',
                // Induk harus berupa Gudang Utama (bukan filial lain)
                Rule::exists('gudangs', 'id')
                    ->whereNull('gudang_induk_id'),
            ],

            'nama_gudang' => [
                'required',
                'string',
                'max:150',
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

            'kapasitas' => [
                'nullable',
                'numeric',
                'min:0',
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
            'jenis_gudang.required' =>
                'Jenis Gudang wajib dipilih.',

            'jenis_gudang.in' =>
                'Jenis Gudang tidak valid.',

            'gudang_induk_id.required' =>
                'Gudang Induk wajib dipilih untuk Gudang Filial.',

            'gudang_induk_id.exists' =>
                'Gudang induk harus berupa Gudang Utama yang valid.',

            'nama_gudang.required' =>
                'Nama Gudang wajib diisi.',

            'email.email' =>
                'Format email tidak valid.',

            'kapasitas.numeric' =>
                'Kapasitas harus berupa angka.',

            'kapasitas.min' =>
                'Kapasitas tidak boleh negatif.',

            'status.required' =>
                'Status wajib dipilih.',
        ];
    }
}