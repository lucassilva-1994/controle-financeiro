<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentRequest;
use App\Models\Payment;

class PaymentController extends CRUDController
{
    public function __construct() {
        parent::__construct(
            Payment::class, 
            PaymentRequest::class,
            ['user'],
            ['name','description','type','is_calculable'],
            ['financialRecords'],
            ['financialRecords' => 'amount']
        );
    }

    public function showWithoutPagination()
    {
        if (request()->has('type')) {
            if (request()->type === 'EXPENSE') {
                request()->merge(['additional_filter' => [['type', '=', 'EXPENSE'], ['type', '=', 'BOTH']]]);
            } elseif (request()->type === 'INCOME') {
                request()->merge(['additional_filter' => [['type', '=', 'INCOME'], ['type', '=', 'BOTH']]]);
            }
        }
        return parent::showWithoutPagination();
    }
}
