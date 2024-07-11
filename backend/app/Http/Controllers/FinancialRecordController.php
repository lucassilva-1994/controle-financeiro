<?php

namespace App\Http\Controllers;

use App\Http\Requests\FinancialRecordRequest;
use App\Models\FinancialRecord;
use Illuminate\Support\Facades\DB;

class FinancialRecordController extends CRUDController
{
    public function __construct()
    {
        parent::__construct(
            FinancialRecord::class,
            FinancialRecordRequest::class,
            ['payment', 'supplierAndCustomer', 'categories', 'files'],
            [
                'description', 'amount', 'details',
                'payment' => ['payments.name'],
                'supplier_and_customer' => ['suppliers_and_customers.name'],
                'categories' => ['categories.name']
            ],
            ['categories']
        );
    }

    public function calculateIncomeExpense()
    {
        $totalIncome = round(FinancialRecord::whereHas('payment', function ($query) {
            $query->where('is_calculable', true);
        })->where('financial_record_type', 'income')->where('paid', true)->sum('amount'), 2);

        $totalExpense = round(FinancialRecord::whereHas('payment', function ($query) {
            $query->where('is_calculable', true);
        })->where('financial_record_type', 'expense')->where('paid', true)->sum('amount'), 2);

        $balance = round($totalIncome - $totalExpense, 2);
        return response()->json([
            'total_income' => $totalIncome,
            'total_expense' => $totalExpense,
            'balance' => $balance,
        ]);
    }

    public function store()
    {
        //Validando se é um lançamento recorrente, se for pegar o valor que foi informado como total de papel de parcelas e ir incrementando até chegar ao número informado
        $installmentTotal = request()->installment_total;
        $successMessage = '';
        //Logo abaixo vai ser a quantidade de dias que vai ter entre uma parcela ou outra, isso será definido pelo usuario
        $interval = request()->has('increment_interval') ? intval(request()->increment_interval) : 1;
        $financialRecordDate = now()->parse(request()->financial_record_date);
        $financialRecordDueDate = now()->parse(request()->financial_record_due_date);
        if ($installmentTotal > 1) {
            for ($i = 1; $i <= $installmentTotal; $i++) {
                request()->merge([
                    'installment_number' => $i,
                    'financial_record_date' => $financialRecordDate->format('Y-m-d'),
                    'financial_record_due_date' => $financialRecordDueDate->format('Y-m-d')
                ]);
                $successMessage = parent::store();
                $financialRecordDate->addDays($interval);
                $financialRecordDueDate->addDays($interval);
            }
        } else {
            request()->merge([
                'installment_number' => 1,
                'financial_record_date' => $financialRecordDate->format('Y-m-d'),
                'financial_record_due_date' => $financialRecordDueDate->format('Y-m-d')
            ]);
            $successMessage = parent::store();
        }
        return $successMessage;
    }

    public function update(string $id)
    {

        $existingCategories = DB::table('category_financial_record')
            ->where('financial_record_id', $id)
            ->pluck('category_id')
            ->toArray();
        $categoriesToRemove = array_diff($existingCategories, request()->categories);
        $categoriesToAdd = array_diff(request()->categories, $existingCategories);
        if ($categoriesToRemove) {
            DB::table('category_financial_record')
                ->where('financial_record_id', $id)
                ->whereIn('category_id', $categoriesToRemove)
                ->delete();
        }
        foreach ($categoriesToAdd as $category) {
            DB::table('category_financial_record')->insert([
                'category_id' => $category,
                'financial_record_id' => $id
            ]);
        }
        return parent::update($id);
    }
}
