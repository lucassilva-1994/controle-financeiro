<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Helpers\Model as ModelTrait;

class Release extends Model
{
    use ModelTrait;
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
        'creditorsclients_id',
        'created_at',
        'updated_at'
    ];
    protected $table = 'releases';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    public function getValueAttribute()
    {
        return number_format($this->attributes['value'], 2, ',', '.');
    }

    public static function whereLike(string $words){
        $releases = Release::with('payment','category','creditorClient')->where('type','like',"%{$words}%")
        ->orWhere('status_pay','like',"%{$words}%")
        ->orWhere('description','like',"%{$words}%")
        ->orWhereHas('payment', function(Builder $query) use ($words){
            $query->where('name','like', "%{$words}%");
        })
        ->orWhereHas('creditorClient', function(Builder $query) use ($words){
            $query->where('name','like', "%{$words}%");
        })
        ->orWhereHas('category', function(Builder $query) use ($words){
            $query->where('name','like', "%{$words}%");
        })
        ->latest('date')
        ->paginate(10);
        return $releases;
    }

    public function category()
    {
        return $this->hasOne(Category::class,'id','category_id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class,'id','payment_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function creditorClient(){
        return $this->hasOne(CreditorClient::class,'id','creditorsclients_id');
    }

    public function files(){
        return $this->hasMany(File::class,'release_id','id');
    }

    protected static function booted()
    {
        static::addGlobalScope('users', function (Builder $builder) {
            if(auth()->check()){
                $builder->where('user_id', '=', auth()->user()->id);
            }
        });
    }
}
