<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupplierAndCustomerRequest;
use App\Models\SupplierAndCustomer;

class SupplierAndCustomerController extends CRUDController
{
    public function __construct() {
        parent::__construct(
            SupplierAndCustomer::class, 
            SupplierAndCustomerRequest::class,
            ['user'],
            ['name','type','description','email','phone'],
            ['financialRecords'],
            ['financialRecords' => 'amount']);
    }
}
