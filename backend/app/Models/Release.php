<?php

namespace App\Models;

use App\Models\Scopes\UserScope;
use Illuminate\Database\Eloquent\{Model,Builder};

class Release extends Model
{
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
        'status',
        'category_id',
        'payment_id',
        'client_creditor_id',
        'created_at',
        'updated_at'
    ];
    protected $table = 'releases';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    public function setValueAttribute($value) {
        $value = str_replace(['R$ ', ".", ','], ["", "", "."], $value);
        $value = number_format("" . $value, 2, ".", "");
        $this->attributes['value'] = $value;
    }

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
        return $this->belongsTo(User::class);
    }

    public function clientOrCreditor(){
        return $this->hasOne(ClientCreditor::class,'id','client_creditor_id');
    }

    public function files(){
        return $this->hasMany(File::class);
    }

    protected static function booted(): void
    {
        static::addGlobalScope(new UserScope);
    }
}
