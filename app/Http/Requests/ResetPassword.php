<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResetPassword extends FormRequest {

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
            'cpassword' => 'required|min:08|max:30|same:ccpassword',
            'ccpassword' => 'required|min:08| max:30',
        ];
    }

    public function messages() {
        return [
            'cpassword.required' => 'A senha é obrigatória.',
            'cpassword.min' => 'A senha deve ter pelo menos :min caracteres.',
            'cpassword.max' => 'A senha pode conter no máximo :max caracteres.',
            'cpassword.same' => 'Senha e confirmação de senha não conferem.',
            'ccpassword.required' => 'A confirmação de senha é obrigatória.',
            'ccpassword.min' => 'A confirmação de senha deve ter pelo menos :min caracteres.',
            'ccpassword.max' => 'A confirmação de senha pode conter no máximo :max caracteres.'
        ];
    }

}
