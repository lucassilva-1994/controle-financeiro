<?php

namespace App\Observers;

use App\Helpers\HelperModel;
use App\Models\{Category, Payment, User};

class UserObserver
{
    use HelperModel;
    public function created(User $user): void
    {
        self::paymentsAndCategories($user->id->toString());
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }

    public static function paymentsAndCategories($user_id){
        $payments =  [
            ['name' => 'Dinheiro', 'type' => 'BOTH', 'description' => 'Pagamento em dinheiro físico', 'is_calculable' => true],
            ['name' => 'Cartão de Crédito', 'type' => 'BOTH', 'description' => 'Pagamento utilizando cartão de crédito', 'is_calculable' => false],
            ['name' => 'Cartão de Débito', 'type' => 'BOTH', 'description' => 'Pagamento utilizando cartão de débito', 'is_calculable' => true],
            ['name' => 'Transferência Bancária', 'type' => 'BOTH', 'description' => 'Transferência entre contas bancárias', 'is_calculable' => true],
            ['name' => 'Boleto Bancário', 'type' => 'BOTH', 'description' => 'Pagamento através de boleto bancário', 'is_calculable' => true],
            ['name' => 'Pix', 'type' => 'BOTH', 'description' => 'Pagamento instantâneo via Pix', 'is_calculable' => true],
            ['name' => 'Cheque', 'type' => 'EXPENSE', 'description' => 'Pagamento através de cheque', 'is_calculable' => false],
            ['name' => 'Vale Alimentação', 'type' => 'BOTH', 'description' => 'Pagamento utilizando vale alimentação', 'is_calculable' => false],
            ['name' => 'Vale Refeição', 'type' => 'BOTH', 'description' => 'Pagamento utilizando vale refeição', 'is_calculable' => false],
            ['name' => 'Criptomoeda', 'type' => 'BOTH', 'description' => 'Pagamento utilizando criptomoeda', 'is_calculable' => true],
            ['name' => 'Outro', 'type' => 'BOTH', 'description' => 'Outro método de pagamento não especificado', 'is_calculable' => true],
        ];

        $categories = [
            ['name' => 'Salário', 'type' => 'INCOME', 'description' => 'Recebimento mensal de salário'],
            ['name' => 'Renda Extra', 'type' => 'INCOME', 'description' => 'Renda adicional proveniente de trabalhos extras'],
            ['name' => 'Renda de Investimentos', 'type' => 'INCOME', 'description' => 'Ganhos provenientes de investimentos financeiros'],
            ['name' => 'Renda de Aluguel', 'type' => 'INCOME', 'description' => 'Renda obtida com aluguéis de imóveis'],
            ['name' => 'Presentes', 'type' => 'INCOME', 'description' => 'Ganhos provenientes de presentes recebidos'],
            ['name' => 'Renda de Juros', 'type' => 'INCOME', 'description' => 'Ganhos provenientes de juros de investimentos'],
            ['name' => 'Outras Receitas', 'type' => 'INCOME', 'description' => 'Outras fontes de renda'],
            ['name' => 'Aluguel', 'type' => 'EXPENSE', 'description' => 'Pagamento mensal do aluguel do imóvel'],
            ['name' => 'Despesas de Utilidades', 'type' => 'EXPENSE', 'description' => 'Despesas mensais com água, luz, gás, etc.'],
            ['name' => 'Compras de Supermercado', 'type' => 'EXPENSE', 'description' => 'Despesas com compras de alimentos e produtos de supermercado'],
            ['name' => 'Transporte', 'type' => 'EXPENSE', 'description' => 'Despesas relacionadas a transporte público ou privado'],
            ['name' => 'Seguro', 'type' => 'EXPENSE', 'description' => 'Pagamento de seguros diversos'],
            ['name' => 'Despesas Médicas', 'type' => 'EXPENSE', 'description' => 'Despesas com consultas médicas, medicamentos, etc.'],
            ['name' => 'Entretenimento', 'type' => 'EXPENSE', 'description' => 'Gastos com entretenimento, como cinema, teatro, etc.'],
            ['name' => 'Educação', 'type' => 'EXPENSE', 'description' => 'Gastos com mensalidades escolares, cursos, etc.'],
            ['name' => 'Pagamentos de Dívidas', 'type' => 'EXPENSE', 'description' => 'Pagamentos de parcelas de dívidas'],
            ['name' => 'Outras Despesas', 'type' => 'EXPENSE', 'description' => 'Outras despesas não categorizadas']
        ];

        foreach($payments as $payment){
            $payment['user_id'] = $user_id;
            self::createRecord(Payment::class, $payment);
        }
        foreach($categories as $category){
            $category['user_id'] = $user_id;
            self::createRecord(Category::class, $category);
        }
    }
}
