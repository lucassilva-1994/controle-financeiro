<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\HelperModel;
use App\Models\User;

class CategorySeeder extends Seeder {

    public function run() {

        $users = User::get();
        foreach($users as $user){
            $categories = [
                ['name' => 'Alimentação', 'type' => 'SAIDA','user_id' => $user->id],
                ['name' => 'Saúde', 'type' => 'SAIDA','user_id' => $user->id],
                ['name' => 'Lazer', 'type' => 'SAIDA','user_id' => $user->id],
                ['name' => 'Academia', 'type' => 'SAIDA','user_id' => $user->id],
                ['name' => 'Salário', 'type' => 'ENTRADA','user_id' => $user->id],
                ['name' => 'Fatura cartão de crédito', 'type' => 'SAIDA','user_id' => $user->id],
                ['name' => 'Combustível', 'type' => 'SAIDA','user_id' => $user->id],
                ['name' => 'Supermercado', 'type' => 'SAIDA','user_id' => $user->id],
                ['name' => 'Viagem', 'type' => 'AMBOS','user_id' => $user->id],
                ['name' => 'Transportes', 'type' => 'AMBOS','user_id' => $user->id],
                ['name' => 'Casa', 'type' => 'AMBOS','user_id' => $user->id],
                ['name' => 'Consertos', 'type' => 'AMBOS','user_id' => $user->id],
                ['name' => 'Vendas', 'type' => 'AMBOS','user_id' => $user->id],
                ['name' => 'Serviços online', 'type' => 'AMBOS','user_id' => $user->id],
                ['name' => 'Benefícios', 'type' => 'ENTRADA','user_id' => $user->id],
                ['name' => 'Outros', 'type' => 'AMBOS','user_id' => $user->id],
            ];
            foreach($categories as $category){
                HelperModel::setData($category,Category::class);
            }
        }
    }
}
