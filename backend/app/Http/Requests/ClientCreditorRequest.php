<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClientCreditorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'name' => ['required','max:100'],
            'type' => ['required', Rule::in(['CLIENT','CREDITOR','BOTH'])]
        ];
    }
}
