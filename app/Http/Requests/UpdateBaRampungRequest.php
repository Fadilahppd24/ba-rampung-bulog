<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBaRampungRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('baRampung'));
    }

    public function rules(): array
    {
        return [
            'tanggal_ba' => ['required', 'date'],

            // Nomor MO dan PO boleh kosong
            'nomor_mo' => ['nullable', 'string', 'max:100'],
            'nomor_po' => ['nullable', 'string', 'max:100'],

            'gudang_id' => ['required', 'exists:gudangs,id'],
            'mitra_pengolahan_id' => ['required', 'exists:mitra_pengolahans,id'],

            // Penandatangan Pihak Kesatu
            'nama_penandatangan' => ['required', 'string', 'max:150'],
            'jabatan_penandatangan' => ['required', 'string', 'max:150'],

            // Penandatangan Pihak Kedua
            'nama_penandatangan_pihak_kedua' => ['required', 'string', 'max:150'],
            'jabatan_penandatangan_pihak_kedua' => ['required', 'string', 'max:150'],

            'pimpinan_cabang_id' => ['required', 'exists:pimpinan_cabangs,id'],

            // Kuantum produksi dalam KG
            'kuantum_gabah' => ['required', 'integer', 'min:1'],
            'kuantum_beras' => ['required', 'integer', 'min:0'],
            'kuantum_menir' => ['nullable', 'integer', 'min:0'],
            'kuantum_bekatul' => ['nullable', 'integer', 'min:0'],

            'catatan' => ['nullable', 'string', 'max:1000'],

            'action' => ['required', 'in:draft,submit'],
        ];
    }

    public function messages(): array
    {
        return [
            'tanggal_ba.required' => 'Tanggal BA wajib diisi.',
            'tanggal_ba.date' => 'Tanggal BA tidak valid.',

            'gudang_id.required' => 'Gudang (Pihak Kesatu) wajib dipilih.',
            'gudang_id.exists' => 'Gudang yang dipilih tidak valid.',

            'mitra_pengolahan_id.required' => 'Mitra Pengolahan (Pihak Kedua) wajib dipilih.',
            'mitra_pengolahan_id.exists' => 'Mitra Pengolahan yang dipilih tidak valid.',

            'nama_penandatangan.required' => 'Nama penandatangan pihak kesatu wajib diisi.',
            'jabatan_penandatangan.required' => 'Jabatan penandatangan pihak kesatu wajib diisi.',

            'nama_penandatangan_pihak_kedua.required' => 'Nama penandatangan pihak kedua wajib diisi.',
            'jabatan_penandatangan_pihak_kedua.required' => 'Jabatan penandatangan pihak kedua wajib diisi.',

            'pimpinan_cabang_id.required' => 'Pimpinan Cabang (Mengetahui) wajib dipilih.',

            'kuantum_gabah.required' => 'Kuantum Gabah (GKP) wajib diisi.',
            'kuantum_gabah.integer' => 'Kuantum Gabah harus berupa angka bulat.',
            'kuantum_gabah.min' => 'Kuantum Gabah harus lebih dari 0.',

            'kuantum_beras.required' => 'Kuantum Beras (HGL) wajib diisi.',
            'kuantum_beras.integer' => 'Kuantum Beras harus berupa angka bulat.',
            'kuantum_beras.min' => 'Kuantum Beras tidak boleh negatif.',

            'kuantum_menir.integer' => 'Kuantum Menir harus berupa angka bulat.',
            'kuantum_menir.min' => 'Kuantum Menir tidak boleh negatif.',

            'kuantum_bekatul.integer' => 'Kuantum Bekatul harus berupa angka bulat.',
            'kuantum_bekatul.min' => 'Kuantum Bekatul tidak boleh negatif.',
        ];
    }
}