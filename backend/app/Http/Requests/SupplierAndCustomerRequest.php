<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplierAndCustomerRequest extends FormRequest
{
    public function authorize(): bool{
        return true;
    }
    public function rules(): array
    {
        return [
            'name' => ['required','min:3','max:60'],
            'email' => ['nullable','min:3','max:100','email','email:dns'],
            'phone' => ['nullable','min:14','max:15'],
            'type' => ['in:SUPPLIER,CUSTOMER,BOTH'],
            'description' => ['nullable','min:3','max:100']
        ];
    }
}
