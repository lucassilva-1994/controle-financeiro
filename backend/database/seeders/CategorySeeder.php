<?php

namespace Database\Seeders;

use App\Helpers\HelperModel;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{

    use HelperModel;
    public function run(): void
    {
        foreach(self::categories() as $category){
            self::createRecord(Category::class,$category);
        }
    }


    public static function categories(){
        return [
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
        
    }
}
