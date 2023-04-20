<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Release extends Model
{
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

    public function getValueAttribute()
    {
        return number_format($this->attributes['value'], 2, ",", ".");
    }

    public static function createOrUpdate(array $data)
    {
        isset($data['value']) ? $data['value'] =  self::formatCurrency($data['value']) : $data['value'];
        if (!isset($data['id'])) {
            HelperModel::setData($data, Release::class);
            return true;
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

    public static function deleteRelease(string $id)
    {
        self::where('id', $id)->delete();
        return true;
    }

    public function category()
    {
        return $this->hasOne(Category::class, "id", "category_id");
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class, 'payment_id', 'id');
    }
}
