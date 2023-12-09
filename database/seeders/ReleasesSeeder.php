<?php

namespace Database\Seeders;

use App\Models\HelperModel;
use App\Models\Release;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class ReleasesSeeder extends Seeder
{
    public function run()
    {
        $descriptions = [
            "Salário",
            "Aluguel Residencial",
            "Aluguel Comercial",
            "Hipoteca",
            "Conta de Luz",
            "Conta de Água",
            "Gás",
            "Internet",
            "TV a Cabo",
            "Telefone",
            "Supermercado",
            "Restaurante",
            "Café/Comida Rápida",
            "Delivery",
            "Roupas e Acessórios",
            "Calçados",
            "Farmácia",
            "Gastos com Saúde",
            "Academia",
            "Seguro Saúde",
            "Impostos",
            "Taxa de Condomínio",
            "Manutenção de Veículo",
            "Combustível",
            "Transporte Público",
            "Uber/Táxi",
            "Estacionamento",
            "Manutenção Residencial",
            "Serviços de Limpeza",
            "Assinatura de Jornal/Revista",
            "Lazer e Entretenimento",
            "Cinema/Teatro",
            "Assinatura de Streaming",
            "Viagens",
            "Presentes",
            "Doações",
            "Educação",
            "Cursos",
            "Livros",
            "Materiais de Escritório",
            "Hobbies",
            "Eletrônicos",
            "Gastos com Animais de Estimação",
            "Cuidados Pessoais",
            "Cabeleireiro/Barbeiro",
            "Produtos de Beleza",
            "Spa/Salão de Beleza",
            "Casamento",
            "Eventos Sociais",
            "Taxa Bancária",
            "Tarifa de Cartão de Crédito",
            "Transferências Bancárias",
            "Juros e Multas",
            "Investimentos",
            "Compra de Ações",
            "Fundos de Investimento",
            "Renda Fixa",
            "Pagamento de Empréstimo",
            "Reembolso",
            "Receitas Extras",
            "Freelance",
            "Venda de Itens Usados",
            "Prêmios e Loterias",
            "Bônus no Trabalho",
            "Restituição de Impostos",
            "Mesada",
            "Economias",
            "Transferência entre Contas",
            "Compra de Criptomoedas",
            "Pagamento de Faturas",
            "Mensalidade de Serviços",
            "Aluguel de Equipamentos",
            "Despesas Governamentais",
            "Taxa Ambiental",
            "Eventos Esportivos",
            "Patrocínio",
            "Consultoria Financeira",
            "Manutenção de Computadores",
            "Comissões e Taxas",
            "Compras Online",
            "Compras em Lojas Físicas",
            "Mudança Residencial",
            "Despesas de Mudança",
            "Manutenção de Jardim",
            "Material de Construção",
            "Pagamento de Advogado",
            "Despesas com Caridade",
            "Assinatura de Aplicativos",
            "Comida para Viagem",
            "Móveis e Decoração",
            "Equipamentos de Escritório",
            "Serviços de Consultoria",
            "Treinamentos",
            "Desenvolvimento Profissional",
            "Manutenção de Equipamentos",
            "Equipamentos de Lazer",
            "Assinatura de Cursos Online",
            "Assinatura de Software",
            "Despesas com Filhos",
            "Educação Infantil",
            "Despesas com Crianças",
            "Produtos para Bebê",
            "Despesas com Adolescentes",
            "Gastos com Faculdade",
            "Jogos e Brinquedos",
            "Despesas com a Casa dos Pais",
            "Assistência Técnica",
            "Materiais para Artes e Artesanato",
            "Assinatura de Clubes",
            "Café da Manhã/Padaria",
            "Tutoriais Online",
            "Desenvolvimento Pessoal",
            "Assinatura de Apresentações",
            "Despesas com Podcasts",
            "Despesas com Música",
            "Despesas com Arte",
            "Cuidados com a Saúde Mental",
            "Terapia",
            "Cursos de Idiomas",
            "Roupas de Dormir",
            "Assinatura de Quadrinhos",
            "Despesas com Tecnologia",
            "Assinatura de Antivírus",
            "Manutenção de Dispositivos Eletrônicos",
            "Assinatura de Backup Online",
            "Gastos com Redes Sociais",
            "Assinatura de VPN",
            "Assinatura de Armazenamento na Nuvem",
            "Gastos com Energia Solar",
            "Despesas de Marketing",
            "Publicidade Online",
            "Marketing de Conteúdo",
            "Despesas com Freelancers",
            "Patrocínio de Eventos",
            "Equipamentos de Filmagem",
          ];
          $users = User::get();
          foreach($users as $user){
            foreach($descriptions as $description){
                HelperModel::setData([
                    'description' => $description,
                    'value' => fake()->randomFloat(2,10,1500),
                    'date' => fake()->date(),
                    'status_pay' => Arr::random(['QUITADO','ABERTO']),
                    'type' => Arr::random(['ENTRADA','SAIDA']),
                    'user_id' => $user->id,
                    'category_id' => Arr::random($user->categories->pluck('id')->toArray()),
                    'payment_id' => Arr::random($user->payments->pluck('id')->toArray()),
                ],Release::class);
            }
          }

    }
}
