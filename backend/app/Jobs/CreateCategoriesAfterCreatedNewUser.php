<?php

namespace App\Jobs;

use App\Helpers\HelperModel;
use App\Models\{Category,User};
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateCategoriesAfterCreatedNewUser implements ShouldQueue
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
        $categories = [
            ['name' => 'Alimentação', 'type' => 'EXPENSE','user_id' => $this->user->id],
            ['name' => 'Saúde', 'type' => 'EXPENSE','user_id' => $this->user->id],
            ['name' => 'Lazer', 'type' => 'EXPENSE','user_id' => $this->user->id],
            ['name' => 'Academia', 'type' => 'EXPENSE','user_id' => $this->user->id],
            ['name' => 'Salário', 'type' => 'INCOME','user_id' => $this->user->id],
            ['name' => 'Fatura cartão de crédito', 'type' => 'EXPENSE','user_id' => $this->user->id],
            ['name' => 'Combustível', 'type' => 'EXPENSE','user_id' => $this->user->id],
            ['name' => 'Supermercado', 'type' => 'EXPENSE','user_id' => $this->user->id],
            ['name' => 'Viagem', 'type' => 'BOTH','user_id' => $this->user->id],
            ['name' => 'Transportes', 'type' => 'BOTH','user_id' => $this->user->id],
            ['name' => 'Casa', 'type' => 'BOTH','user_id' => $this->user->id],
            ['name' => 'Consertos', 'type' => 'BOTH','user_id' => $this->user->id],
            ['name' => 'Vendas', 'type' => 'BOTH','user_id' => $this->user->id],
            ['name' => 'Serviços online', 'type' => 'BOTH','user_id' => $this->user->id],
            ['name' => 'Benefícios', 'type' => 'INCOME','user_id' => $this->user->id],
            ['name' => 'Outros', 'type' => 'BOTH','user_id' => $this->user->id],
        ];
        foreach($categories as $category){
            self::setData($category, Category::class);
        }   
    }
}
