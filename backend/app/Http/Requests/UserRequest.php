<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest {
    public function authorize() {
        return true;
    }
    
    public function rules() {
        return [
            'name' => ['required','min:3','max:100'],
            'username' => ['required','max:30','min:03',Rule::unique('users')],
            'email' => ['required','max:100','email:rfc,dns', Rule::unique('users')],
        ];
    }

}
