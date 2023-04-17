<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Payment extends Model
{
    protected $fillable = ['id','sequence','user_id','name'];
    protected $table = "payments";
    protected $keyType = 'string';
    public $incrementing = false;

    public static function createUserPayment(string $user_id)
    {
        $payments = ["Cartão de débito", "Cartão de crédito", "Dinheiro", "Pix", "Transferência"];
        foreach ($payments as $payment) {
            $data['user_id'] = $user_id;
            $data['name'] = $payment;
            HelperModel::setData($data, Payment::class);
        }
    }

    public function releases(){
        return $this->hasMany(Release::class,'payment_id','id');
    }
}
