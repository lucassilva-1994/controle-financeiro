<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReleaseRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'description' => 'required',
            'value' => 'required',
            'date' => 'required|date',
            'type' => 'required',
            'category_id' => 'required'
        ];
    }
}
