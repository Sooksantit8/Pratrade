<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TBCategory extends Model
{
    protected $table = 'TBCategory';

    // กำหนด primary key เป็น 'ID'
    protected $primaryKey = 'ID';

    // กำหนด key type เป็น string เนื่องจากใช้ UUID
    protected $keyType = 'string';

    // กำหนดคอลัมน์ที่สามารถเติมข้อมูลได้
    protected $fillable = [
        'Category_name','Active','Create_by', 'Create_date', 'Update_by', 'Update_date'
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

    // ไม่ต้องใช้ timestamps (created_at, updated_at)
    public $timestamps = false;
}