<?php

namespace Database\Seeders;

use App\Helpers\HelperModel;
use App\Models\{Payment,User};
use Illuminate\Database\Seeder;

class PaymentsSeeder extends Seeder
{
    use HelperModel;
    public function run()
    {
        $users = User::get();
        foreach($users as $user){
            $payments = [
                ['name' => 'Dinheiro','calculate' => 'YES','user_id' => $user->id],
                ['name' => 'Cartão de crédito','calculate' => 'NO','user_id' => $user->id],
                ['name' => 'Cartão de débito','calculate' => 'YES','user_id' => $user->id],
                ['name' => 'Transferência bancária','calculate' => 'YES','user_id' => $user->id],
                ['name' => 'Boleto bancário','calculate' => 'YES','user_id' => $user->id],
                ['name' => 'Pix','calculate' => 'YES','user_id' => $user->id],
                ['name' => 'Vale alimentação','calculate' => 'YES','user_id' => $user->id],
                ['name' => 'Débito em conta','calculate' => 'YES','user_id' => $user->id],
            ];
            foreach($payments as $payment){
                self::setData($payment,Payment::class);
            }
        }
    }
}
