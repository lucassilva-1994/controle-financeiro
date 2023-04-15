<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest {
    public function authorize() {
        return true;
    }
    public function rules() {
        return [
            'name' => 'required|max:100',
            'user' => 'required|max:30|min:05|unique:users',
            'email' => 'required| max:100|unique:users|email:rfc,dns',
        ];
    }

    public function messages() {
        return [
            'name.required' => 'O nome é obrigatório.',
            'user.required' => 'O usuário é obrigatório.',
            'user.unique' => 'Usuário já cadastrado.',
            'user.max' => 'O usuário não pode conter mais de :max caracteres.',
            'user.min' => 'O usuário não pode conter menos de :min caracteres.',
            'email.required' => 'O email é obrigatório.',
            'email.email' => 'Informe um endereço de email válido.',
            'email.max' => 'O email não pode ter mais de :max caracteres.',
            'email.unique' => 'Email já cadastrado.'
        ];
    }

}
