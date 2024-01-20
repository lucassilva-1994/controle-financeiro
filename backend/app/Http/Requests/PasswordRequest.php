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
}
