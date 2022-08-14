<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder {

    public function run() {
        $names = [
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
        foreach ($names as $name) {
            Category::create([
                'name' => $name
            ]);
        }
    }
}
