<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Release extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'id',
        'sequence',
        'description',
        'details',
        'value',
        'date',
        'due_date',
        'type',
        'user_id',
        'status_pay',
        'category_id',
        'payment_id',
        'creditorsclients_id'
    ];
    protected $table = "releases";
    protected $keyType = 'string';
    public $incrementing = false;
    //Carregar a model já com os relacionamentos.
    protected $with = ['user', 'payment', 'category','files','creditorClient'];

    public function getValueAttribute()
    {
        return number_format($this->attributes['value'], 2, ",", ".");
    }

    public static function createOrUpdate(array $data)
    {
        isset($data['value']) ? $data['value'] =  self::formatCurrency($data['value']) : $data['value'];
        if (!isset($data['id'])) {
            $create = HelperModel::setData($data, Release::class);
            if ($create) {
                if (!empty($data['files'])) {
                    $files = $data['files'];
                    foreach ($files as $file) {
                        File::createFiles($data, $create->id, $create->user_id, $file);
                    }
                }
                return true;
            }
        }
        if(!empty($data['files'])){
            $files = $data['files'];
            unset($data['files']);
            foreach ($files as $file) {
                File::createFiles($data, $data['id'], auth()->user()->id, $file);
            }
        }
        HelperModel::updateData($data, Release::class, ['id' => $data['id']]);
        return true;
    }

    private static function formatCurrency($value)
    {
        $value = str_replace(['R$ ', ".", ','], ["", "", "."], $value);
        $value = number_format("" . $value, 2, ".", "");
        return $value;
    }

    public static function forDelete(string $id)
    {
        self::whereId($id)->delete();
        return true;
    }

    public static function whereLike(string $words){
        $releases = Release::leftJoin('payments','releases.payment_id','=','payments.id')
        ->leftJoin('categories','releases.category_id','=','categories.id')
        ->leftJoin('creditorsclients','releases.creditorsclients_id','=','creditorsclients.id')
        ->select('releases.*')
        ->orWhere('payments.name','like',"%$words%")
        ->orWhere('categories.name','like',"%$words%")
        ->orWhere('creditorsclients.name','like',"%$words%")
        ->orWhere('creditorsclients.type','like',"%$words%")
        ->orWhere('releases.description','like',"%$words%")
        ->orWhere('releases.type','like',"%$words%")
        ->orWhere('releases.details','like',"%$words%")
        ->latest('date')
        ->paginate(10);
        return $releases;
    }

    public function category()
    {
        return $this->hasOne(Category::class,'id','category_id')->withTrashed();
    }

    public function payment()
    {
        return $this->hasOne(Payment::class,'id','payment_id')->withTrashed();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function creditorClient(){
        return $this->hasOne(CreditorClient::class,'id','creditorsclients_id')->withTrashed();
    }

    public function files(){
        return $this->hasMany(File::class,'release_id','id');
    }
}
