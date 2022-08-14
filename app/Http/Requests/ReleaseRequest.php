<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReleaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
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
            'category_id.required' => 'Categoria é obrigatório.',
            'start_date.after' => 'A data inicial não pode ser superior que a data final.',
            'end_date.before' => 'A data final não pode ser inferior a data inicial'
        ];
    }
}
