<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TBImage_Product extends Model
{
    use HasFactory;

    // ตั้งชื่อ table ที่ใช้ในฐานข้อมูล
    protected $table = 'TBImage_Product';

    // กำหนด primary key
    protected $primaryKey = 'ID';

    // กำหนดว่าไม่ต้องการใช้ auto-increment
    public $incrementing = false;

    // ตั้งค่าคอลัมน์ที่สามารถถูก mass assigned ได้
    protected $fillable = [
        'ID',
        'ProductID',
        'Path_Image',
        'Type',
        'Name_old',
        'Name_new',
        'Active',
        'Create_by',
        'Create_date',
        'Update_by',
        'Update_date',
    ];

    // กำหนดว่าไม่ต้องการให้ Laravel จัดการกับ timestamps (created_at, updated_at)
    public $timestamps = false;

    // กำหนดค่าเริ่มต้นให้คอลัมน์ที่ไม่เป็น nullable
    protected $casts = [
        'Active' => 'boolean',
    ];

    // สร้าง UUID ให้กับ ID เมื่อสร้างข้อมูลใหม่
    public static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            $product->ID = (string) Str::uuid(); // สร้าง UUID และแปลงเป็น string
        });
    }

    // ความสัมพันธ์แบบ Belongs to (TBImage_Product -> TBProducts)
    public function product()
    {
        return $this->belongsTo(TBProducts::class, 'ProductID', 'ID');
    }
}