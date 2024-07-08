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

    public function showWithoutPagination()
    {
        if (request()->has('type')) {
            if (request()->type === 'EXPENSE') {
                request()->merge(['additional_filter' => [['type', '=', 'SUPPLIER'], ['type', '=', 'BOTH']]]);
            } elseif (request()->type === 'INCOME') {
                request()->merge(['additional_filter' => [['type', '=', 'CUSTOMER'], ['type', '=', 'BOTH']]]);
            }
        }
        return parent::showWithoutPagination();
    }
}
