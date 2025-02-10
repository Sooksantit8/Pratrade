<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TBStatusUser extends Model
{
    use HasFactory;

    // ระบุชื่อ table
    protected $table = 'TBStatus_User';

    // ระบุ primary key
    protected $primaryKey = 'Status_Code';

    // กำหนดว่า primary key ไม่ใช่ auto-increment
    public $incrementing = false;

    // กำหนดว่า primary key เป็น string
    protected $keyType = 'string';

    // เปิดการจัดการ timestamps
    public $timestamps = false;

    // กำหนดฟิลด์ที่สามารถกรอกข้อมูลได้
    protected $fillable = [
        'Status_Code',
        'Status_Name',
        'Sortorder',
        'Value',
        'Icon',
        'Active',
        'Create_by',
        'Create_date',
        'Update_by',
        'Update_date',
    ];

    // กำหนด casting สำหรับฟิลด์ที่มีประเภทข้อมูลเฉพาะ
    protected $casts = [
        'Sortorder' => 'integer',
        'Value' => 'integer',
        'Active' => 'boolean',
        'Create_date' => 'datetime',
        'Update_date' => 'datetime',
    ];

    // Relation กับ TBUser
    public function users()
    {
        return $this->hasMany(TBUser::class, 'Status', 'Status_Code');
    }
}