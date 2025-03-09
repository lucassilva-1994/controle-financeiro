<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FinancialPlanItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required','min:3','max:150'],
            'amount' => ['nullable', Rule::requiredIf($this->plan_type == 'BUDGET')],
            'qtd' => ['nullable', Rule::requiredIf($this->plan_type == 'SHOPPING_LIST')],
            'unit' => ['nullable','string', Rule::requiredIf($this->plan_type == 'SHOPPING_LIST')],
            'due_date' => ['nullable','date', Rule::requiredIf($this->plan_type == 'BUDGET')]
        ];
    }
}
