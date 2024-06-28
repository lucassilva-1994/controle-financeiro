<?php

namespace App\Http\Controllers;
use App\Http\Requests\FinancialRecordRequest;
use App\Models\FinancialRecord;

class FinancialRecordController extends CRUDController
{
    public function __construct() {
        parent::__construct(FinancialRecord::class,FinancialRecordRequest::class,['payment','supplierAndCustomer','categories']);
    }

    public function calculateIncomeExpense(){
        $totalIncome = round(FinancialRecord::whereHas('payment', function ($query) {
            $query->where('is_calculable', true);
        })->where('type', 'income')->where('payment_status', 'PAID')->sum('amount'), 2);
    
        $totalExpense = round(FinancialRecord::whereHas('payment', function ($query) {
            $query->where('is_calculable', true);
        })->where('type', 'expense')->where('payment_status', 'PAID')->sum('amount'), 2);
    
        $balance = round($totalIncome - $totalExpense, 2);
        return response()->json([
            'total_income' => $totalIncome,
            'total_expense' => $totalExpense,
            'balance' => $balance,
        ]);
    }
}
