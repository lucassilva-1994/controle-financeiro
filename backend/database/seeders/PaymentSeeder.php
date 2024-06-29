<?php

namespace Database\Seeders;
use App\Models\Payment;
use App\Traits\ModelTrait;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    use ModelTrait;
    public function run(): void
    {
        foreach(self::payments() as $payment){
            self::createRecord(Payment::class, $payment);
        }
    }

    public static function payments(){
        return [
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
    }
}
