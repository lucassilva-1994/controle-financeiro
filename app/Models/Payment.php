<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['id','sequence','user_id','name','calculate','created_at','updated_at'];
    protected $table = 'payments';
    public $timestamps = false;
    protected $keyType = 'string';
    public $incrementing = false;
    protected $with = ['releases'];

    public function getCreatedAtAttribute(){
        return date('d/m/Y H:i:s', strtotime($this->attributes['created_at']));
    }

    public function getUpdatedAtAttribute(){
        return date('d/m/Y H:i:s', strtotime($this->attributes['updated_at']));
    }

    public static function createOrUpdate(array $data){
        if(!isset($data['id'])){
            HelperModel::setData($data,Payment::class);
            return true;
        }
        HelperModel::updateData($data, Payment::class,['id' => $data['id']]);
        return true;
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
            HelperModel::setData($payment,Payment::class);
        }
    }

    public static function forDelete(string $id){
        self::whereId($id)->delete();
        return true;
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function releases(){
        return $this->hasMany(Release::class,'payment_id','id');
    }
}
