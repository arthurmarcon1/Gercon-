<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCondominiumRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'            => ['required', 'string', 'max:255'],
            'address.street'  => ['required', 'string', 'max:255'],
            'address.number'  => ['required', 'string', 'max:20'],
            'address.city'    => ['required', 'string', 'max:100'],
            'address.state'   => ['required', 'string', 'size:2'],
            'address.zip'     => ['required', 'string', 'regex:/^\d{5}-\d{3}$/'],
            'document'        => ['nullable', 'string', 'max:18'],
            'active'          => ['boolean'],
        ];
    }

    public function attributes(): array
    {
        return [
            'name'           => 'nome',
            'address.street' => 'rua',
            'address.number' => 'número',
            'address.city'   => 'cidade',
            'address.state'  => 'estado',
            'address.zip'    => 'CEP',
            'document'       => 'CNPJ',
        ];
    }
}
