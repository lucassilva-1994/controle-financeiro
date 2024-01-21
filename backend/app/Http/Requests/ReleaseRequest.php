<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ReleaseRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            // 'description' => ['required','max:255'],
            // 'value' => ['required'],
            // 'date' => ['required','date'],
            // 'type' => ['required', Rule::in(['INCOME','EXPENSE'])],
            // 'category_id' => ['required'],
            // 'status' => ['required', Rule::in(['PENDING','PAID'])],
            // 'payment_id' => ['required']
        ];
    }
}
