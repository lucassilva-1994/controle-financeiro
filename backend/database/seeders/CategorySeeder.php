<?php
namespace Database\Seeders;

use App\Helpers\HelperModel;
use Illuminate\Database\Seeder;
use App\Models\{Category,User};

class CategorySeeder extends Seeder {

    use HelperModel;
    public function run() {

        $users = User::get();
        foreach($users as $user){
            $categories = [
                ['name' => 'Alimentação', 'type' => 'EXPENSE','user_id' => $user->id],
                ['name' => 'Saúde', 'type' => 'EXPENSE','user_id' => $user->id],
                ['name' => 'Lazer', 'type' => 'EXPENSE','user_id' => $user->id],
                ['name' => 'Academia', 'type' => 'EXPENSE','user_id' => $user->id],
                ['name' => 'Salário', 'type' => 'INCOME','user_id' => $user->id],
                ['name' => 'Fatura cartão de crédito', 'type' => 'EXPENSE','user_id' => $user->id],
                ['name' => 'Combustível', 'type' => 'EXPENSE','user_id' => $user->id],
                ['name' => 'Supermercado', 'type' => 'EXPENSE','user_id' => $user->id],
                ['name' => 'Viagem', 'type' => 'BOTH','user_id' => $user->id],
                ['name' => 'Transportes', 'type' => 'BOTH','user_id' => $user->id],
                ['name' => 'Casa', 'type' => 'BOTH','user_id' => $user->id],
                ['name' => 'Consertos', 'type' => 'BOTH','user_id' => $user->id],
                ['name' => 'Vendas', 'type' => 'BOTH','user_id' => $user->id],
                ['name' => 'Serviços online', 'type' => 'BOTH','user_id' => $user->id],
                ['name' => 'Benefícios', 'type' => 'INCOME','user_id' => $user->id],
                ['name' => 'Outros', 'type' => 'BOTH','user_id' => $user->id],
            ];
            foreach($categories as $category){
                self::setData($category,Category::class);
            }
        }
    }
}
