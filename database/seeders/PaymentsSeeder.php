<?php

namespace Database\Seeders;

use App\Models\HelperModel;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class PaymentsSeeder extends Seeder
{
    public function run()
    {
        $payments = [
            "Dinheiro",
            "Cartão de Crédito",
            "Cartão de Débito",
            "Transferência Bancária",
            "Boleto Bancário",
            "Cheque",
            "Pix",
            "PayPal",
            "Apple Pay",
            "Google Pay",
            "Samsung Pay",
            "Criptomoedas (Bitcoin, Ethereum, etc.)",
            "Cartão Pré-pago",
            "Vale Refeição",
            "Vale Alimentação",
            "Voucher",
            "Débito Direto Autorizado (DDA)",
            "Pagamento por Aproximação (NFC)",
            "Pagamento por Código QR",
            "Transferência entre Contas (Peer-to-Peer)",
            "Pagamento Recorrente",
            "Cesta Básica",
            "Depósito em Conta",
            "Pagamento com Celular",
            "Domicílio Bancário",
            "Gestão de Despesas Corporativas",
            "Câmbio Online",
            "Pagamento Internacional",
            "Câmbio de Criptomoedas"
          ];
        $users = User::get();
        foreach($users as $user){
            foreach($payments as $payment){
                HelperModel::setData([
                    'name' => $payment,
                    'calculate' => Arr::random(['YES','NO']),
                    'user_id' => $user->id
                ],Payment::class);
            }
        }
    }
}
