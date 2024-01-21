<?php

namespace App\Jobs;

use App\Helpers\HelperModel;
use App\Models\{User,Payment};
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreatePaymentsAfterCreatedNewUser implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, HelperModel;

    public $tries = 5;
    protected $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }
    public function handle(): void
    {
        $payments = [
            ['name' => 'Dinheiro','calculate' => 'YES','user_id' => $this->user->id],
            ['name' => 'Cartão de crédito','calculate' => 'NO','user_id' => $this->user->id],
            ['name' => 'Cartão de débito','calculate' => 'YES','user_id' => $this->user->id],
            ['name' => 'Transferência bancária','calculate' => 'YES','user_id' => $this->user->id],
            ['name' => 'Boleto bancário','calculate' => 'YES','user_id' => $this->user->id],
            ['name' => 'Pix','calculate' => 'YES','user_id' => $this->user->id],
            ['name' => 'Vale alimentação','calculate' => 'YES','user_id' => $this->user->id],
            ['name' => 'Débito em conta','calculate' => 'YES','user_id' => $this->user->id],
        ];
        foreach($payments as $payment){
            self::setData($payment, Payment::class);
        }
    }
}
