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
            'username' => ['nullable','min:5','max:40','regex:/^[a-zA-Z0-9_]+$/', Rule::unique('users')],
            'email' => ['required','min:5','max:100','email','email:dns', Rule::unique('users')],
            'password' => ['required','min:5','max:20','confirmed']
        ];
    }

    public function messages(): array{
        return [
            'username.regex' => 'O campo usuário não pode ter espaço e caracteres especiais.'
        ];
    }
}
