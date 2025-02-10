<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TBBookbank extends Model
{
    protected $table = 'TBBookbank';
    public $timestamps = false; // ถ้าใช้ custom column สำหรับ Create_date และ Update_date

    protected $primaryKey = 'ID';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'ID',
        'Bookbanknumber',
        'Bankname',
        'Bookbankname',
        'Path_Image',
        'Used',
        'Active',
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
}