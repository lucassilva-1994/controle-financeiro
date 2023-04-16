<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReleaseRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'description' => 'required',
            'value' => 'required',
            'date' => 'required',
            'type' => 'required',
            'category_id' => 'required'
        ];
    }

    public function messages(): array {
        return [
            'description.required' => 'A descrição é obrigatório.',
            'value.required' => 'O valor do lançamento é obrigatório.',
            'date.required' => 'A data do lançamento é obrigatório.',
            'type.required' => 'Tipo é obrigatório.',
            'category_id.required' => 'Categoria é obrigatório.'
        ];
    }
}
