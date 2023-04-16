<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules(): array
    {
        return [
            "email" => "required|exists:users,email",
            "password" =>  "required"
        ];
    }

    public function messages(): array
    {
        return [
            "email.required" => "Email é obrigatório",
            "email.exists" => "Email não cadastrado.",
            "password.required" => "A senha é obrigatório."
        ];
    }
}
