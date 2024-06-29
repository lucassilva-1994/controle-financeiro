<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'name' => ['required','min:3','max:40'],
            'description' => ['nullable','min:3','max:100'],
            'is_calculable' => ['numeric','between:0,1'],
            'type' => ['in:INCOME,EXPENSE,BOTH']
        ];
    }
}
