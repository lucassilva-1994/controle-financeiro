<?php

namespace App\Observers;

use App\Mail\Welcome;
use App\Models\{Category, Payment, SupplierAndCustomer, User};
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

        $suppliers = [
            ['name' => 'Amazon', 'description' => 'Fornecedor global de produtos diversos', 'email' => 'contact@amazon.com', 'type' => 'BOTH'],
            ['name' => 'Alibaba', 'description' => 'Plataforma de comércio eletrônico B2B', 'email' => 'contact@alibaba.com', 'type' => 'BOTH'],
            ['name' => 'Walmart', 'description' => 'Varejista e fornecedor de produtos variados', 'email' => 'contact@walmart.com', 'type' => 'BOTH'],
            ['name' => 'Samsung', 'description' => 'Fornecedor de eletrônicos e tecnologia', 'email' => 'contact@samsung.com', 'type' => 'BOTH'],
            ['name' => 'Sony', 'description' => 'Fornecedor de produtos eletrônicos e de entretenimento', 'email' => 'contact@sony.com', 'type' => 'BOTH'],
            ['name' => 'LG', 'description' => 'Fornecedor de eletrônicos, eletrodomésticos e tecnologia', 'email' => 'contact@lg.com', 'type' => 'BOTH'],
            ['name' => 'Microsoft', 'description' => 'Fornecedor de software, hardware e serviços de TI', 'email' => 'contact@microsoft.com', 'type' => 'BOTH'],
            ['name' => 'Apple', 'description' => 'Fornecedor de produtos de tecnologia e eletrônicos', 'email' => 'contact@apple.com', 'type' => 'BOTH'],
            ['name' => 'HP', 'description' => 'Fornecedor de computadores, impressoras e acessórios', 'email' => 'contact@hp.com', 'type' => 'BOTH'],
            ['name' => 'Dell', 'description' => 'Fornecedor de computadores, servidores e soluções de TI', 'email' => 'contact@dell.com', 'type' => 'BOTH'],
            ['name' => 'Intel', 'description' => 'Fornecedor de processadores e tecnologias de computação', 'email' => 'contact@intel.com', 'type' => 'BOTH'],
            ['name' => 'Cisco', 'description' => 'Fornecedor de equipamentos de rede e telecomunicações', 'email' => 'contact@cisco.com', 'type' => 'BOTH'],
            ['name' => 'Oracle', 'description' => 'Fornecedor de software e soluções de banco de dados', 'email' => 'contact@oracle.com', 'type' => 'BOTH'],
            ['name' => 'IBM', 'description' => 'Fornecedor de hardware, software e serviços de TI', 'email' => 'contact@ibm.com', 'type' => 'BOTH'],
            ['name' => 'Siemens', 'description' => 'Fornecedor de soluções de engenharia e tecnologia', 'email' => 'contact@siemens.com', 'type' => 'BOTH'],
            ['name' => 'Procter & Gamble', 'description' => 'Fornecedor de bens de consumo', 'email' => 'contact@pg.com', 'type' => 'BOTH'],
            ['name' => 'Unilever', 'description' => 'Fornecedor de bens de consumo', 'email' => 'contact@unilever.com', 'type' => 'BOTH'],
            ['name' => 'Nestlé', 'description' => 'Fornecedor de alimentos e bebidas', 'email' => 'contact@nestle.com', 'type' => 'BOTH'],
            ['name' => 'PepsiCo', 'description' => 'Fornecedor de alimentos e bebidas', 'email' => 'contact@pepsico.com', 'type' => 'BOTH'],
            ['name' => 'Coca-Cola', 'description' => 'Fornecedor de bebidas', 'email' => 'contact@coca-cola.com', 'type' => 'BOTH'],
            ['name' => 'Johnson & Johnson', 'description' => 'Fornecedor de produtos de saúde e higiene', 'email' => 'contact@jnj.com', 'type' => 'BOTH'],
            ['name' => 'Pfizer', 'description' => 'Fornecedor de produtos farmacêuticos', 'email' => 'contact@pfizer.com', 'type' => 'BOTH'],
            ['name' => 'Merck', 'description' => 'Fornecedor de produtos farmacêuticos e químicos', 'email' => 'contact@merck.com', 'type' => 'BOTH'],
            ['name' => 'Novartis', 'description' => 'Fornecedor de produtos farmacêuticos e de saúde', 'email' => 'contact@novartis.com', 'type' => 'BOTH'],
            ['name' => 'GlaxoSmithKline', 'description' => 'Fornecedor de produtos farmacêuticos e de saúde', 'email' => 'contact@gsk.com', 'type' => 'BOTH'],
            ['name' => 'Toyota', 'description' => 'Fornecedor de veículos e soluções de mobilidade', 'email' => 'contact@toyota.com', 'type' => 'BOTH'],
            ['name' => 'Volkswagen', 'description' => 'Fornecedor de veículos e soluções de mobilidade', 'email' => 'contact@volkswagen.com', 'type' => 'BOTH'],
            ['name' => 'Ford', 'description' => 'Fornecedor de veículos e soluções de mobilidade', 'email' => 'contact@ford.com', 'type' => 'BOTH'],
            ['name' => 'General Motors', 'description' => 'Fornecedor de veículos e soluções de mobilidade', 'email' => 'contact@gm.com', 'type' => 'BOTH'],
            ['name' => 'Honda', 'description' => 'Fornecedor de veículos e soluções de mobilidade', 'email' => 'contact@honda.com', 'type' => 'BOTH'],
            ['name' => 'Nissan', 'description' => 'Fornecedor de veículos e soluções de mobilidade', 'email' => 'contact@nissan.com', 'type' => 'BOTH'],
            ['name' => 'Hyundai', 'description' => 'Fornecedor de veículos e soluções de mobilidade', 'email' => 'contact@hyundai.com', 'type' => 'BOTH'],
            ['name' => 'Google', 'description' => 'Fornecedor de serviços de internet e publicidade', 'email' => 'contact@google.com', 'type' => 'BOTH'],
            ['name' => 'Facebook', 'description' => 'Fornecedor de serviços de redes sociais e publicidade', 'email' => 'contact@facebook.com', 'type' => 'BOTH'],
            ['name' => 'Twitter', 'description' => 'Fornecedor de serviços de redes sociais e microblogging', 'email' => 'contact@twitter.com', 'type' => 'BOTH'],
            ['name' => 'LinkedIn', 'description' => 'Fornecedor de serviços de redes sociais profissionais', 'email' => 'contact@linkedin.com', 'type' => 'BOTH'],
            ['name' => 'Adobe', 'description' => 'Fornecedor de software de design e soluções criativas', 'email' => 'contact@adobe.com', 'type' => 'BOTH'],
            ['name' => 'Salesforce', 'description' => 'Fornecedor de soluções de CRM e serviços em nuvem', 'email' => 'contact@salesforce.com', 'type' => 'BOTH'],
            ['name' => 'SAP', 'description' => 'Fornecedor de software empresarial e soluções de TI', 'email' => 'contact@sap.com', 'type' => 'BOTH'],
            ['name' => '3M', 'description' => 'Fornecedor de produtos industriais, de saúde e consumo', 'email' => 'contact@3m.com', 'type' => 'BOTH'],
            ['name' => 'Honeywell', 'description' => 'Fornecedor de produtos de automação e controle', 'email' => 'contact@honeywell.com', 'type' => 'BOTH'],
            ['name' => 'GE', 'description' => 'Fornecedor de soluções de energia e tecnologias industriais', 'email' => 'contact@ge.com', 'type' => 'BOTH'],
            ['name' => 'Boeing', 'description' => 'Fornecedor de aeronaves e tecnologias aeroespaciais', 'email' => 'contact@boeing.com', 'type' => 'BOTH'],
            ['name' => 'Airbus', 'description' => 'Fornecedor de aeronaves e tecnologias aeroespaciais', 'email' => 'contact@airbus.com', 'type' => 'BOTH'],
            ['name' => 'ExxonMobil', 'description' => 'Fornecedor de petróleo e gás', 'email' => 'contact@exxonmobil.com', 'type' => 'BOTH'],
            ['name' => 'Shell', 'description' => 'Fornecedor de petróleo, gás e produtos energéticos', 'email' => 'contact@shell.com', 'type' => 'BOTH'],
            ['name' => 'Chevron', 'description' => 'Fornecedor de petróleo, gás e produtos energéticos', 'email' => 'contact@chevron.com', 'type' => 'BOTH'],
            ['name' => 'BP', 'description' => 'Fornecedor de petróleo, gás e produtos energéticos', 'email' => 'contact@bp.com', 'type' => 'BOTH'],
            ['name' => 'Total', 'description' => 'Fornecedor de petróleo, gás e produtos energéticos', 'email' => 'contact@total.com', 'type' => 'BOTH'],
            ['name' => 'Schlumberger', 'description' => 'Fornecedor de serviços e tecnologia para a indústria de petróleo', 'email' => 'contact@slb.com', 'type' => 'BOTH']
        ];

        foreach ($payments as $payment) {
            $payment['user_id'] = $user_id;
            self::createRecord(Payment::class, $payment);
        }

        foreach ($categories as $category) {
            $category['user_id'] = $user_id;
            self::createRecord(Category::class, $category);
        }

        foreach ($suppliers as $supplier) {
            $supplier['user_id'] = $user_id;
            self::createRecord(SupplierAndCustomer::class, $supplier);
        }
    }
}
