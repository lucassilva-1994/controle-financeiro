<?php

namespace App\Http\Controllers;
use App\Http\Requests\FinancialRecordRequest;
use App\Models\FinancialRecord;

class FinancialRecordController extends CRUDController
{
    public function __construct() {
        parent::__construct(FinancialRecord::class,FinancialRecordRequest::class,['payment','supplierAndCustomer','categories']);
    }

    public function store() {
        return parent::store();
    }
}
