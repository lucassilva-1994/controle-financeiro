<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\Model as ModelTrait;

class Payment extends Model
{
    use ModelTrait;
    protected $fillable = ['id','sequence','user_id','name','calculate','created_at','updated_at'];
    protected $table = 'payments';
    public $timestamps = false;
    protected $keyType = 'string';
    public $incrementing = false;

    public function getCreatedAtAttribute(){
        return date('d/m/Y H:i:s', strtotime($this->attributes['created_at']));
    }

    public function getUpdatedAtAttribute(){
        return date('d/m/Y H:i:s', strtotime($this->attributes['updated_at']));
    }

    public static function createUserPayment(string $user_id)
    {
        $payments = [
            ['name' => 'Dinheiro','calculate' => 'YES','user_id' => $user_id],
            ['name' => 'Cartão de crédito','calculate' => 'NO','user_id' => $user_id],
            ['name' => 'Cartão de débito','calculate' => 'YES','user_id' => $user_id],
            ['name' => 'Transferência bancária','calculate' => 'YES','user_id' => $user_id],
            ['name' => 'Boleto bancário','calculate' => 'YES','user_id' => $user_id],
            ['name' => 'Pix','calculate' => 'YES','user_id' => $user_id],
            ['name' => 'Vale alimentação','calculate' => 'YES','user_id' => $user_id],
            ['name' => 'Débito em conta','calculate' => 'YES','user_id' => $user_id],
        ];
        foreach($payments as $payment){
            self::setData($payment,self::class);
        }
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function releases(){
        return $this->hasMany(Release::class);
    }
}
