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
            'description' => ['required', 'min:3', 'max:100'],
            'amount' => ['required'],
            'paid' => ['between:0,1'],
            'financial_record_date' => ['required', 'date'],
            'financial_record_due_date' => ['nullable', 'date','after_or_equal:financial_record_date'],
            'financial_record_type' => ['required','in:INCOME,EXPENSE'],
            'payment_id' => ['required', 'exists:payments,id'],
            'category_id' => ['required']
        ];
    }

    public function messages()
    {
        return [
            'financial_record_type.in' => 'O campo tipo de registro financeiro selecionado é inválido, os valores aceitos são Entrada ou Saída',
            'paid.between' => 'O campo PAGO é obrigatório.'
        ];
    }
}
