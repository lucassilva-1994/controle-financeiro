<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\Model as ModelTrait;

class Category extends Model
{
    use ModelTrait;
    protected $fillable = ['id', 'sequence', 'name', 'type', 'user_id','created_at','updated_at'];
    protected $table = 'categories';
    public $timestamps = false;
    protected $keyType = 'string';
    public $incrementing = false;

    public function getCreatedAtAttribute()
    {
        return date('d/m/Y H:i:s', strtotime($this->attributes['created_at']));
    }

    public function getUpdatedAtAttribute()
    {
        return date('d/m/Y H:i:s', strtotime($this->attributes['updated_at']));
    }

    public static function createUserCategory(string $user_id)
    {
        $categories = [
            ['name' => 'Alimentação', 'type' => 'SAIDA','user_id' => $user_id],
            ['name' => 'Saúde', 'type' => 'SAIDA','user_id' => $user_id],
            ['name' => 'Lazer', 'type' => 'SAIDA','user_id' => $user_id],
            ['name' => 'Academia', 'type' => 'SAIDA','user_id' => $user_id],
            ['name' => 'Salário', 'type' => 'ENTRADA','user_id' => $user_id],
            ['name' => 'Fatura cartão de crédito', 'type' => 'SAIDA','user_id' => $user_id],
            ['name' => 'Combustível', 'type' => 'SAIDA','user_id' => $user_id],
            ['name' => 'Supermercado', 'type' => 'SAIDA','user_id' => $user_id],
            ['name' => 'Viagem', 'type' => 'AMBOS','user_id' => $user_id],
            ['name' => 'Transportes', 'type' => 'AMBOS','user_id' => $user_id],
            ['name' => 'Casa', 'type' => 'AMBOS','user_id' => $user_id],
            ['name' => 'Consertos', 'type' => 'AMBOS','user_id' => $user_id],
            ['name' => 'Vendas', 'type' => 'AMBOS','user_id' => $user_id],
            ['name' => 'Serviços online', 'type' => 'AMBOS','user_id' => $user_id],
            ['name' => 'Benefícios', 'type' => 'ENTRADA','user_id' => $user_id],
            ['name' => 'Outros', 'type' => 'AMBOS','user_id' => $user_id],
        ];
        foreach($categories as $category){
            self::setData($category,self::class);
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function releases(){
        return $this->hasMany(Release::class);
    }
}
