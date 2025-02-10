<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TBUser_Package_History extends Model
{
    use HasFactory;

    // กำหนดชื่อ Table
    protected $table = 'TBUser_Package_History';

    // กำหนด Primary Key
    protected $primaryKey = 'ID';

    // ปิดการเพิ่มค่าอัตโนมัติ
    public $incrementing = false;

    // กำหนดประเภทข้อมูลสำหรับ Primary Key
    protected $keyType = 'string';

    // กำหนดว่าไม่ต้องการใช้ timestamps auto-generated (created_at, updated_at)
    public $timestamps = false;

    // กำหนดฟิลด์ที่อนุญาตให้เพิ่ม/แก้ไขข้อมูลได้
    protected $fillable = [
        'ID',
        'Username',
        'Package',
        'Approve_By',
        'Date_Start',
        'Date_Stop',
        'Payslip',
        'Status',
        'Active',
        'Is_Reject',
        'Coment',
        'Create_by',
        'Create_date',
        'Update_by',
        'Update_date',
    ];

    // กำหนดการแปลงประเภทข้อมูล
    protected $casts = [
        'Date_Start' => 'datetime',
        'Date_Stop' => 'datetime',
        'Create_date' => 'datetime',
        'Update_date' => 'datetime',
        'Active' => 'boolean',
        'Is_Reject' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        // สร้าง UUID อัตโนมัติสำหรับ 'ID' เมื่อสร้างข้อมูลใหม่
        static::creating(function ($model) {
            $model->ID = (string) Str::uuid();
        });
    }

    // ฟังก์ชันความสัมพันธ์กับ TBUser (สมมติว่า 'Username' เป็น FK)
    public function user()
    {
        return $this->belongsTo(TBUser::class, 'Username', 'Username');
    }

    // ฟังก์ชันความสัมพันธ์กับ TBPackage (สมมติว่า 'Package' เป็น FK)
    public function package()
    {
        return $this->belongsTo(TBPackage::class, 'Package', 'ID');
    }
}