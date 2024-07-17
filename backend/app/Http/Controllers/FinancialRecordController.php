<?php

namespace App\Http\Controllers;

use App\Http\Requests\FinancialRecordRequest;
use App\Models\File;
use App\Models\FinancialRecord;
use App\Traits\ModelTrait;

class FinancialRecordController extends CRUDController
{
    use ModelTrait;
    public function __construct()
    {
        parent::__construct(
            FinancialRecord::class,
            FinancialRecordRequest::class,
            ['payment', 'supplierAndCustomer', 'files','category'],
            [
                'description', 'amount', 'details',
                'payment' => ['payments.name'],
                'supplier_and_customer' => ['suppliers_and_customers.name'],
                'category' => ['categories.name']
            ],
            ['files']
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
        // Validando se é um lançamento recorrente
        $installmentTotal = request()->installment_total;
        $successMessage = '';
        // Quantidade de dias entre uma parcela e outra
        $interval = request()->has('increment_interval') ? intval(request()->increment_interval) : 1;
        $financialRecordDate = now()->parse(request()->financial_record_date);
        $financialRecordDueDate = now()->parse(request()->financial_record_due_date);
        $files = request()->file('files', []);
    
        if ($installmentTotal > 1) {
            for ($i = 1; $i <= $installmentTotal; $i++) {
                request()->merge([
                    'installment_number' => $i,
                    'financial_record_date' => $financialRecordDate->format('Y-m-d'),
                    'financial_record_due_date' => $financialRecordDueDate->format('Y-m-d')
                ]);
                $successMessage = parent::store();
                $financialRecordId = $successMessage->getData()->data->id;
                foreach ($files as $file) {
                    self::createRecord(File::class, [
                        'financial_record_id' => $financialRecordId,
                        'path' => $file->store('financial_records/' . auth()->user()->id . '/' . $financialRecordId, 'public'),
                        'name' => $file->getClientOriginalName()
                    ]);
                }
    
                // Incrementar as datas para a próxima parcela
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
            $financialRecordId = $successMessage->getData()->data->id;
    
            // Processar e armazenar os arquivos para o registro único
            foreach ($files as $file) {
                self::createRecord(File::class, [
                    'financial_record_id' => $financialRecordId,
                    'path' => $file->store('financial_records/' . auth()->user()->id . '/' . $financialRecordId, 'public'),
                    'name' => $file->getClientOriginalName()
                ]);
            }
        }
        return $successMessage;
    }
}
