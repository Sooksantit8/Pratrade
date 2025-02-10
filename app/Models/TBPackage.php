<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TBPackage extends Model
{
    protected $table = 'TBPackage';

    // กำหนด primary key เป็น 'ID'
    protected $primaryKey = 'ID';

    // กำหนด key type เป็น string เนื่องจากใช้ UUID
    protected $keyType = 'string';

    // กำหนดคอลัมน์ที่สามารถเติมข้อมูลได้
    protected $fillable = [
        'Package_Name',
        'Qty_Post',
        'Price',
        'Type_Post',
        'Central_Function',
        'Active',
        'Create_by',
        'Create_date',
        'Update_by',
        'Update_date'
    ];

    // ไม่ต้องใช้ timestamps (created_at, updated_at)
    public $timestamps = false;

    protected static function boot()
    {
        parent::boot();

        // สร้าง UUID อัตโนมัติสำหรับ 'ID' เมื่อสร้างข้อมูลใหม่
        static::creating(function ($model) {
            $model->ID = (string) Str::uuid();
        });
    }

    public function lookupTypePost()
    {
        return $this->belongsTo(TBLookup::class, 'Type_Post', 'Lookup_code')
                    ->where('Lookup_type', 'Type_Post');
    }

    // Relation กับ TBUser
    public function users()
    {
        return $this->hasMany(TBUser::class, 'Package', 'ID');
    }
}