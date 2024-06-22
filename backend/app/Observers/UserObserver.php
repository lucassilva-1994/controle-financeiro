<?php

namespace App\Observers;

use App\Helpers\HelperModel;
use App\Models\{Category, Payment, User};

class UserObserver
{
    use HelperModel;
    public function created(User $user): void
    {
        self::paymentsAndCategories($user->id);
    }

    public static function paymentsAndCategories($user_id){
        $payments =  [
            ['name' => 'Dinheiro', 'type' => 'BOTH', 'description' => 'Pagamento em dinheiro físico'],
            ['name' => 'Cartão de Crédito', 'type' => 'BOTH', 'description' => 'Pagamento utilizando cartão de crédito'],
            ['name' => 'Cartão de Débito', 'type' => 'BOTH', 'description' => 'Pagamento utilizando cartão de débito'],
            ['name' => 'Transferência Bancária', 'type' => 'BOTH', 'description' => 'Transferência entre contas bancárias'],
            ['name' => 'Boleto Bancário', 'type' => 'BOTH', 'description' => 'Pagamento através de boleto bancário'],
            ['name' => 'Pix', 'type' => 'BOTH', 'description' => 'Pagamento instantâneo via Pix'],
            ['name' => 'Cheque', 'type' => 'EXPENSE', 'description' => 'Pagamento através de cheque'],
            ['name' => 'Vale Alimentação', 'type' => 'BOTH', 'description' => 'Pagamento utilizando vale alimentação'],
            ['name' => 'Vale Refeição', 'type' => 'BOTH', 'description' => 'Pagamento utilizando vale refeição'],
            ['name' => 'Criptomoeda', 'type' => 'BOTH', 'description' => 'Pagamento utilizando criptomoeda'],
            ['name' => 'Outro', 'type' => 'BOTH', 'description' => 'Outro método de pagamento não especificado'],
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
