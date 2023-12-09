<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\HelperModel;
use App\Models\User;
use Illuminate\Support\Arr;

class CategorySeeder extends Seeder {

    public function run() {
        $categories = [
            "Alimentação",
            "Saúde",
            "Lazer",
            "Academia",
            "Salário",
            "Fatura do cartão",
            "Combustível",
            "Supermercado",
            "Escola",
            "Entretenimento",
            "Emprestimos",
            "Viagem",
            "Doação",
            "Crediário",
            "Bonificação",
            "Investimentos",
            "Lanches",
            "Compras online",
            "Outros",
            "Consórcio",
            "Telefone",
            "Gastos fixos",
            "Contas mensais",
            "Transportes",
            "Vestuário",
            "Serviços",
            "Restaurante",
            "Casa",
            "Eletrônicos",
            "Vendas",
            "Bebidas",
            "Serviços online",
            "Água, energia ou internet",
            "Estética",
            "Açougue",
            "Livraria",
            "Cosméticos",
            "Medicamentos",
            "Consertos",
        ];
        $users = User::get();
        foreach($users as $user){
            foreach($categories as $category){
                HelperModel::setData([
                    'name' => $category,
                    'user_id' => $user->id,
                    'type' => Arr::random(['ENTRADA','SAIDA','AMBOS'])
                ],Category::class);
            }
        }
    }
}
