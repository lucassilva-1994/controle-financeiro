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
        if ($this->routeIs('restore.password')) {
            return [
                'current_password' => ['required','current_password'],
                'password' => ['required', 'min:5', 'max:20', 'different:current_password', 'confirmed', 'regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[^\w\d\s]).*$/']
            ];
        } else if($this->routeIs('forgot.password')){
            return [
                'email' => ['required', 'email', 'exists:users,email']
            ];
        } else {
            return [
                'name' => ['required', 'min:5', 'max:100','regex:/^[A-Z][a-z]*(\s[A-Z][a-z]*)*$/'],
                'username' => ['nullable', 'min:5', 'max:40', 'regex:/^[a-zA-Z0-9_]+$/', Rule::unique('users')],
                'email' => ['required', 'min:5', 'max:100', 'email', 'email:dns', Rule::unique('users')],
                'password' => ['required', 'min:5', 'max:20', 'confirmed', 'regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[^\w\d\s]).*$/']
            ];
        }
    }

    public function messages(): array
    {
        return [
            'name.regex' => 'Cada palavra no campo :attribute deve começar com uma letra maiúscula.',
            'username.regex' => 'O campo usuário não pode ter espaço e caracteres especiais.',
            'password.regex' => 'A senha deve conter pelo menos uma letra maiúscula, uma letra minúscula, um número e um caractere especial.'
        ];
    }
}
