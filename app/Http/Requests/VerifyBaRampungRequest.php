<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VerifyBaRampungRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('verify', $this->route('baRampung'));
    }

    public function rules(): array
    {
        return [
            'keputusan' => ['required', 'in:terima,tolak'],
            'alasan_penolakan' => ['required_if:keputusan,tolak', 'nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'keputusan.required' => 'Keputusan verifikasi wajib dipilih.',
            'alasan_penolakan.required_if' => 'Alasan penolakan wajib diisi jika BA ditolak.',
        ];
    }
}
