<?php

namespace App\Http\Controllers;

use App\Http\Requests\FinancialPlanRequest;
use App\Models\FinancialPlan;

class FinancialPlanController extends CRUDController
{
    public function __construct() {
        parent::__construct(
            FinancialPlan::class, 
            FinancialPlanRequest::class,[],[],['financialPlanItems']);
    }
}
