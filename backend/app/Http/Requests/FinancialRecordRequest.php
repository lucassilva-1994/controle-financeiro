<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FinancialRecordRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'description' => ['required','min:3','max:100'],
            'amount' => ['required','numeric'],
            'financial_record_date' => ['required','date'],
            'financial_record_due_date' => ['nullable','date'],
            'payment_id' => ['required']
        ];
    }
}
