<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResetPassword extends FormRequest {

    public function authorize() {
        return true;
    }
    public function rules() {
        return [
            'cpassword' => 'required|min:08|max:30|same:ccpassword',
            'ccpassword' => 'required|min:08| max:30',
        ];
    }

}
