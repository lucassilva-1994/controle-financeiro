<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Release extends Model {
    protected $fillable = [
        'id',
        'sequence',
        'description',
        'details',
        'value',
        'date',
        'type',
        'user_id',
        'category_id',
        'payment_id'
    ];
    protected $table = "releases";
    protected $keyType = 'string';
    public $incrementing = false;

    public function getValueAttribute() {
        return number_format($this->attributes['value'], 2, ",", ".");
    }

    public static function createOrUpdate(array $data) {
        if(!isset($data['id'])){
            $data['value'] = self::formatCurrency($data['value']);
            HelperModel::setData($data,Release::class);
            return redirect()->back()->with('success','Lançamento cadastrado com sucesso.');
        }
        $data['value'] = self::formatCurrency($data['value']);
        HelperModel::updateData($data,Release::class,['id' => $data['id']]);
        return redirect()->back()->with('success','Lançamento atualizado com sucesso.');
    }

    private static function formatCurrency($value){
        $value = str_replace(['R$ ', ".", ','], ["", "", "."], $value);
        $value = number_format("" . $value, 2, ".", "");
        return $value;
    }

    public static function deleteRelease(string $id){
        self::where('id',$id)->delete();
        return redirect()->back()->with("success","Lançamento removido com sucesso.");
    }

    public function category() {
        return $this->hasOne(Category::class, "id", "category_id");
    }

    public function payment(){
        return $this->belongsTo(Payment::class,'payment_id','id');
    }

    protected static function booted() {
        self::addGlobalScope('session_user', function(Builder $queryBuilder) {
            $queryBuilder->where(['user_id' => session()->get('user_id')])->latest('id');
        });
    }
}
