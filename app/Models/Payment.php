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
        $payments = ['Cartão de débito', 'Cartão de crédito', 'Dinheiro', 'Pix', 'Transferência'];
        foreach ($payments as $payment) {
            $data['user_id'] = $user_id;
            $data['name'] = $payment;
            HelperModel::setData($data, Payment::class);
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
