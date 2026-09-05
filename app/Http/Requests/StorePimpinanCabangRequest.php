<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePimpinanCabangRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama' => ['required', 'string', 'max:255'],
            'jabatan' => ['required', 'string', 'max:255'],
            'periode_mulai' => ['required', 'date'],
            'periode_selesai' => ['nullable', 'date', 'after_or_equal:periode_mulai'],
            'email' => ['nullable', 'email', 'max:255'],
            'nomor_telepon' => ['nullable', 'string', 'max:50'],
            'alamat' => ['nullable', 'string'],
            'foto' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:aktif,nonaktif'],
        ];
    }
}