<?php

namespace Database\Seeders;

use App\Helpers\HelperModel;
use App\Models\ClientCreditor;
use App\Models\User;
use Illuminate\Database\Seeder;

class ClientCreditorSeeder extends Seeder
{
    use HelperModel;
    public function run(): void
    {
        $users = User::get('id');
        foreach($users as $user){
            $clients_creditors = [
                ['name' => 'Americanas','type' => 'CREDITOR','user_id' => $user->id],
                ['name' => 'Assaí','type' => 'CREDITOR','user_id' => $user->id],
                ['name' => 'Avenida','type' => 'CREDITOR','user_id' => $user->id],
                ['name' => 'Nubank','type' => 'CREDITOR','user_id' => $user->id]
            ];
            foreach($clients_creditors as $cc){
                self::setData($cc,ClientCreditor::class);
            }
        }
    }
}
