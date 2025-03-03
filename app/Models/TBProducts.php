<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str; // ใช้สำหรับ UUID

class TBProducts extends Model
{
    use HasFactory;

    protected $table = 'TBProducts'; // กำหนดชื่อตารางให้ตรงกับฐานข้อมูล

    // กำหนดคอลัมน์ที่สามารถกรอกข้อมูลได้
    protected $fillable = [
        'Product_name',
        'Product_model',
        'Product_materials',
        'Manufacturer',
        'Year_manufacture',
        'Bought_from',
        'Purchase_price',
        'Description',
        'Category',
        'Price',
        'Stock_qty',
        'Price_Preorder',
        'Preorder',
        'Preorder_date',
        'Active',
        'Create_by',
        'Create_date',
        'Update_by',
        'Update_date',
    ];

    // กำหนดคอลัมน์ที่ไม่ต้องการให้ Laravel ใส่ในการ Insert หรือ Update
    protected $guarded = ['ID'];

    // กำหนดว่าไม่ต้องการให้ Laravel จัดการกับ timestamps (created_at, updated_at)
    public $timestamps = false;

    // สร้าง UUID ให้กับ ID เมื่อสร้างข้อมูลใหม่
    public static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            $product->ID = (string) Str::uuid(); // สร้าง UUID และแปลงเป็น string
        });
    }

    // ความสัมพันธ์แบบ One to Many (TBProducts -> TBImage_Product)
    public function images()
    {
        return $this->hasMany(TBImage_Product::class, 'ProductID', 'ID');
    }

    public function categorys()
    {
        return $this->hasMany(TBProduct_Category::class, 'Product_ID', 'ID');
    }
}