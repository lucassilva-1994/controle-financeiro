<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    
    public function rules(): array
    {
        return [
            'name' => ['required','min:5','max:100'],
            'username' => ['nullable','min:5','max:40', Rule::unique('users')],
            'email' => ['required','min:5','max:100', Rule::unique('users')],
        ];
    }
}
