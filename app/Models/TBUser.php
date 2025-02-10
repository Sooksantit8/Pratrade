<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // ใช้สำหรับ Auth
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class TBUser extends Authenticatable
{
    use HasFactory;

    // กำหนดชื่อ Table และ Primary Key
    protected $table = 'TBUser'; // ชื่อ table
    protected $primaryKey = 'Username'; // Primary Key เป็น Username
    public $incrementing = false; // ปิดการเพิ่มค่าอัตโนมัติ
    protected $keyType = 'string'; // Primary Key เป็น String
    public $timestamps = false; // ไม่ใช้ฟิลด์ created_at และ updated_at อัตโนมัติ

    // ฟิลด์ที่อนุญาตให้เพิ่ม/แก้ไขข้อมูลได้
    protected $fillable = [
        'Username',
        'Firstname',
        'Lastname',
        'Password',
        'Email',
        'Tel',
        'Package',
        'Permission_Code',
        'Status',
        'Is_Reject',
        'Active',
        'Create_by',
        'Create_date',
        'Update_by',
        'Update_date',
    ];

    // การแปลงประเภทข้อมูล
    protected $casts = [
        'Is_Reject' => 'boolean',      // ฟิลด์ Is_Reject เป็น Boolean
        'Create_date' => 'datetime',  // ฟิลด์ Create_date เป็น datetime
        'Update_date' => 'datetime',  // ฟิลด์ Update_date เป็น datetime
    ];

    // ซ่อนรหัสผ่านเมื่อดึงข้อมูล
    protected $hidden = [
        'Password',
    ];

    /**
     * กำหนดฟังก์ชันสำหรับ Auth ให้ใช้ฟิลด์ Password
     */
    public function getAuthPassword()
    {
        return $this->Password;
    }

    /**
     * Boot method สำหรับกำหนด UUID ให้กับฟิลด์ ID ก่อนบันทึกข้อมูลใหม่
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            $user->ID = (string) Str::uuid(); // สร้าง UUID อัตโนมัติ
        });
    }

    /**
     * ความสัมพันธ์กับตาราง TBPackage
     */
    public function package()
    {
        return $this->belongsTo(TBPackage::class, 'Package', 'ID');
    }

    /**
     * ความสัมพันธ์กับตาราง TBPermission
     */
    public function permission()
    {
        return $this->belongsTo(TBPermission::class, 'Permission_Code', 'Permission_Code');
    }

    /**
     * ความสัมพันธ์กับตาราง TBStatus_User
     */
    public function status()
    {
        return $this->belongsTo(TBStatusUser::class, 'Status', 'Status_Code');
    }
}