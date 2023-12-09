<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['id', 'sequence', 'name', 'type', 'user_id','created_at','updated_at'];
    protected $table = 'categories';
    public $timestamps = false;
    protected $keyType = 'string';
    public $incrementing = false;
    protected $with = ['releases'];

    public function getCreatedAtAttribute()
    {
        return date('d/m/Y H:i:s', strtotime($this->attributes['created_at']));
    }

    public function getUpdatedAtAttribute()
    {
        return date('d/m/Y H:i:s', strtotime($this->attributes['updated_at']));
    }

    public static function createOrUpdate(array $data)
    {
        if (!isset($data['id'])) {
            HelperModel::setData($data, Category::class);
            return true;
        }
        HelperModel::updateData(
            ['name' => $data['name'], 'type' => $data['type']],
            Category::class,
            ['id' => $data['id']]
        );
        return true;
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
            HelperModel::setData($category,Category::class);
        }
    }

    public static function forDelete(string $id)
    {
        self::whereId($id)->delete();
        return true;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function releases(){
        return $this->hasMany(Release::class,'category_id','id');
    }
}
