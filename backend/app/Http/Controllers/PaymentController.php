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
}
