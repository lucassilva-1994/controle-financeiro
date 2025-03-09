<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FinancialPlanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'name' => ['required','min:3','max:40'],
            'description' => ['nullable','min:3','max:150'],
            'plan_type' => ['required','in:SHOPPING_LIST,BUDGET']
        ];
    }
}
