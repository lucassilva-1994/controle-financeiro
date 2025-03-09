<?php

namespace App\Http\Controllers;

use App\Http\Requests\FinancialPlanItemRequest;
use App\Models\FinancialPlanItem;
use App\Traits\ModelTrait;

class FinancialPlanItemController extends CRUDController
{
    use ModelTrait;
    public function __construct() {
        parent::__construct(
            FinancialPlanItem::class, 
            FinancialPlanItemRequest::class);
    }

    public function showByFinancialPlan(string $financial_plan_id){
        $query = FinancialPlanItem::where('financial_plan_id', $financial_plan_id)
        ->orderByDesc('id');
    return response()->json([
        'itens' => $query->get(),
        'sum_total' => 'R$ '.number_format($query->sum('amount'),2,',','.') ,
        'sum_checked' => 'R$ '.number_format($query->where('checked', 1)->sum('amount'), 2, ',', '.')
    ]);
    }

    public function toggleCheckFinancialPlanItem(){
        return self::updateRecord(FinancialPlanItem::class, request()->all(),['id' => request()->id]);
    }
}
