<?php

namespace App\Observers;

use App\Mail\Welcome;
use App\Models\{Category, Payment, User};
use App\Traits\ModelTrait;
use Illuminate\Support\Facades\Mail;

class UserObserver
{
    use ModelTrait;
    public function created(User $user): void
    {
        Mail::to($user->email)->send(new Welcome($user));
        self::paymentsAndCategoriesAndSuppliers($user->id->toString());
    }

    public static function paymentsAndCategoriesAndSuppliers($user_id)
    {
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
            ['name' => 'PayPal', 'type' => 'BOTH', 'description' => 'Pagamento via PayPal', 'is_calculable' => true],
            ['name' => 'Google Pay', 'type' => 'BOTH', 'description' => 'Pagamento utilizando Google Pay', 'is_calculable' => true],
            ['name' => 'Apple Pay', 'type' => 'BOTH', 'description' => 'Pagamento utilizando Apple Pay', 'is_calculable' => true],
            ['name' => 'Depósito Bancário', 'type' => 'BOTH', 'description' => 'Depósito direto em conta bancária', 'is_calculable' => true],
            ['name' => 'TED', 'type' => 'BOTH', 'description' => 'Transferência Eletrônica Disponível', 'is_calculable' => true],
            ['name' => 'DOC', 'type' => 'BOTH', 'description' => 'Documento de Ordem de Crédito', 'is_calculable' => true],
            ['name' => 'Dinheiro Eletrônico', 'type' => 'BOTH', 'description' => 'Pagamento utilizando dinheiro eletrônico', 'is_calculable' => true],
            ['name' => 'Payoneer', 'type' => 'BOTH', 'description' => 'Pagamento utilizando Payoneer', 'is_calculable' => true],
            ['name' => 'Western Union', 'type' => 'BOTH', 'description' => 'Transferência de dinheiro via Western Union', 'is_calculable' => true]
        ];


        $categories = [
            ['name' => 'Salário', 'type' => 'INCOME', 'description' => 'Recebimento mensal de salário'],
            ['name' => 'Renda Extra', 'type' => 'INCOME', 'description' => 'Renda adicional proveniente de trabalhos extras'],
            ['name' => 'Renda de Investimentos', 'type' => 'INCOME', 'description' => 'Ganhos provenientes de investimentos financeiros'],
            ['name' => 'Renda de Aluguel', 'type' => 'INCOME', 'description' => 'Renda obtida com aluguéis de imóveis'],
            ['name' => 'Presentes', 'type' => 'INCOME', 'description' => 'Ganhos provenientes de presentes recebidos'],
            ['name' => 'Renda de Juros', 'type' => 'INCOME', 'description' => 'Ganhos provenientes de juros de investimentos'],
            ['name' => 'Outras Receitas', 'type' => 'INCOME', 'description' => 'Outras fontes de renda'],
            ['name' => 'Bônus', 'type' => 'INCOME', 'description' => 'Bônus recebidos do trabalho'],
            ['name' => 'Dividendos', 'type' => 'INCOME', 'description' => 'Recebimento de dividendos de ações'],
            ['name' => 'Prêmios', 'type' => 'INCOME', 'description' => 'Ganhos provenientes de prêmios e sorteios'],
            ['name' => 'Renda Freelance', 'type' => 'INCOME', 'description' => 'Renda de trabalhos freelance'],
            ['name' => 'Renda de Pensão', 'type' => 'INCOME', 'description' => 'Recebimento de pensão'],
            ['name' => 'Reembolsos', 'type' => 'INCOME', 'description' => 'Dinheiro reembolsado'],
            ['name' => 'Vendas de Produtos', 'type' => 'INCOME', 'description' => 'Renda de vendas de produtos'],
            ['name' => 'Consultoria', 'type' => 'INCOME', 'description' => 'Receita proveniente de serviços de consultoria'],
            ['name' => 'Aluguel', 'type' => 'EXPENSE', 'description' => 'Pagamento mensal do aluguel do imóvel'],
            ['name' => 'Despesas de Utilidades', 'type' => 'EXPENSE', 'description' => 'Despesas mensais com água, luz, gás, etc.'],
            ['name' => 'Compras de Supermercado', 'type' => 'EXPENSE', 'description' => 'Despesas com compras de alimentos e produtos de supermercado'],
            ['name' => 'Transporte', 'type' => 'EXPENSE', 'description' => 'Despesas relacionadas a transporte público ou privado'],
            ['name' => 'Seguro', 'type' => 'EXPENSE', 'description' => 'Pagamento de seguros diversos'],
            ['name' => 'Despesas Médicas', 'type' => 'EXPENSE', 'description' => 'Despesas com consultas médicas, medicamentos, etc.'],
            ['name' => 'Entretenimento', 'type' => 'EXPENSE', 'description' => 'Gastos com entretenimento, como cinema, teatro, etc.'],
            ['name' => 'Educação', 'type' => 'EXPENSE', 'description' => 'Gastos com mensalidades escolares, cursos, etc.'],
            ['name' => 'Pagamentos de Dívidas', 'type' => 'EXPENSE', 'description' => 'Pagamentos de parcelas de dívidas'],
            ['name' => 'Outras Despesas', 'type' => 'EXPENSE', 'description' => 'Outras despesas não categorizadas'],
            ['name' => 'Vestuário', 'type' => 'EXPENSE', 'description' => 'Gastos com roupas e acessórios'],
            ['name' => 'Assinaturas', 'type' => 'EXPENSE', 'description' => 'Despesas com assinaturas de serviços'],
            ['name' => 'Viagens', 'type' => 'EXPENSE', 'description' => 'Gastos com viagens e passeios'],
            ['name' => 'Doações', 'type' => 'EXPENSE', 'description' => 'Dinheiro doado a caridade'],
            ['name' => 'Manutenção do Carro', 'type' => 'EXPENSE', 'description' => 'Despesas com manutenção e reparos do carro']
        ];

        foreach ($payments as $payment) {
            $payment['user_id'] = $user_id;
            self::createRecord(Payment::class, $payment);
        }

        foreach ($categories as $category) {
            $category['user_id'] = $user_id;
            self::createRecord(Category::class, $category);
        }
    }
}
