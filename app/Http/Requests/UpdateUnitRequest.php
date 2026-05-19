<?php

namespace App\Http\Requests;

use App\Models\Unit;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUnitRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'number'   => ['required', 'string', 'max:20'],
            'type'     => ['nullable', Rule::in(array_keys(Unit::TYPES))],
            'floor'    => ['nullable', 'integer', 'min:0', 'max:200'],
            'block_id' => ['nullable', 'integer', 'exists:blocks,id'],
        ];
    }

    public function attributes(): array
    {
        return [
            'number'   => 'número',
            'type'     => 'tipo',
            'floor'    => 'andar',
            'block_id' => 'bloco',
        ];
    }
}
