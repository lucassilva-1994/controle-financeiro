<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasswordRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            "cpassword" => "required|between:10,100",
            "ccpassword" => "same:cpassword"
        ];
    }

    public function messages()
    {
        return [
            "cpassword.required" => "A senha é obrigatório.",
            "cpassword.between" => "A senha deve ter entre :min e :max caracteres.",
            "ccpassword.same" => "As senhas não conferem."
        ];
    }
}
