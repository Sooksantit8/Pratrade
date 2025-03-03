<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TBCart_Product extends Model
{
    protected $table = 'TBCart_Product';
    public $timestamps = false; // ถ้าใช้ custom column สำหรับ Create_date และ Update_date

    protected $primaryKey = 'ID';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'ID',
        'Username',
        'Product_ID',
        'Shop_ID',
        'Qty',
        'Create_by',
        'Create_date',
        'Update_by',
        'Update_date',
    ];

    // กำหนด UUID ก่อนสร้าง record
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->ID)) {
                $model->ID = (string) Str::uuid();
            }
        });
    }

    public function product()
    {
        return $this->belongsTo(TBProducts::class, 'Product_ID', 'ID');
    }

    public function Shop()
    {
        return $this->belongsTo(TBUser::class, 'Shop_ID', 'Username');
    }
}