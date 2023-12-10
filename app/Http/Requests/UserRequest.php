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
            'username' => 'required|max:30|min:05|unique:users',
            'email' => 'required| max:100|unique:users|email:rfc,dns',
        ];
    }

}
