<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBaRampungRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', \App\Models\BaRampung::class);
    }

    public function rules(): array
    {
        return [
            'tanggal_ba' => ['required', 'date'],
            'nomor_ba_1' => ['nullable', 'string', 'max:50'],
'nomor_ba_2' => ['nullable', 'string', 'max:50'],
'tahun_ba' => ['required', 'integer', 'min:2000', 'max:2100'],
            'nomor_mo' => ['nullable', 'string', 'max:100'],
            'nomor_po' => ['nullable', 'string', 'max:100'],
            'gudang_id' => ['required', 'exists:gudangs,id'],
            'mitra_pengolahan_id' => ['required', 'exists:mitra_pengolahans,id'],
            'nama_penandatangan' => ['required', 'string', 'max:150'],
            'nama_penandatangan_pihak_kedua' => ['required', 'string', 'max:150'],
'jabatan_penandatangan_pihak_kedua' => ['required', 'string', 'max:150'],
            'jabatan_penandatangan' => ['required', 'string', 'max:150'],
            'pimpinan_cabang_id' => ['required', 'exists:pimpinan_cabangs,id'],

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

        'tahun_ba.required' => 'Tahun BA wajib dipilih.',
        'tahun_ba.integer' => 'Tahun BA tidak valid.',

        'gudang_id.required' => 'Gudang (Pihak Kesatu) wajib dipilih.',
        'gudang_id.exists' => 'Gudang yang dipilih tidak valid.',

        'mitra_pengolahan_id.required' => 'Mitra Pengolahan (Pihak Kedua) wajib dipilih.',
        'mitra_pengolahan_id.exists' => 'Mitra Pengolahan yang dipilih tidak valid.',

        'nama_penandatangan.required' => 'Nama penandatangan wajib diisi.',
        'jabatan_penandatangan.required' => 'Jabatan penandatangan wajib diisi.',

        'pimpinan_cabang_id.required' => 'Pimpinan Cabang (Mengetahui) wajib dipilih.',

        'kuantum_gabah.required' => 'Kuantum Gabah (GKP) wajib diisi.',
        'kuantum_gabah.numeric' => 'Kuantum Gabah harus berupa angka.',
        'kuantum_gabah.min' => 'Kuantum Gabah tidak boleh nol atau negatif.',

        'kuantum_beras.required' => 'Kuantum Beras (HGL) wajib diisi.',
        'kuantum_beras.numeric' => 'Kuantum Beras harus berupa angka.',
        'kuantum_beras.min' => 'Kuantum Beras tidak boleh negatif.',

        'kuantum_menir.numeric' => 'Kuantum Menir harus berupa angka.',
        'kuantum_bekatul.numeric' => 'Kuantum Bekatul harus berupa angka.',
    ];
}
}
