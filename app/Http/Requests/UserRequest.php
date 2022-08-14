<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules() {
        return [
            'name' => 'required|max:100',
            'user' => 'required|max:30|min:05|unique:users',
            'email' => 'required| max:100|unique:users|email:rfc,dns',
            'cpassword' => 'required | min:08| max:20',
            'ccpassword' => 'required| min:08| max:20| same:cpassword'
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
            'email.unique' => 'Email já cadastrado.',
            'cpassword.min' => 'A senha deve conter no mínimo :min caracteres.',
            'cpassword.max' => 'A senha não pode ter mais de :max caracteres.',
            'cpassword.required' => 'A senha é obrigatório.',
            'ccpassword.required' => 'A confirmação de senha é obrigatório.',
            'ccpassword.min' => 'A confirmação de senha deve conter no mínimo :min caracteres',
            'ccpassword.max' =>'A confirmação de senha não pode ter mais de :max caracteres',
            'ccpassword.same' => 'As senhas não conferem.',
        ];
    }

}
