<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TBLookup extends Model
{
    use HasFactory;

    protected $table = 'TBLookup';
    protected $primaryKey = 'Lookup_code'; // กำหนด Primary Key
    public $timestamps = false; // หากไม่ใช้คอลัมน์ created_at / updated_at

    protected $fillable = [
        'Lookup_code',
        'Lookup_type',
        'Lookup_name',
        'Lookup_name2',
        'Lookup_name3',
        'Value',
        'Sort_order',
        'Create_by',
        'Create_date',
        'Update_by',
        'Update_date',
    ];

    protected $casts = [
        'Lookup_code' => 'string',  // เพื่อให้มั่นใจว่าเป็น string
    ];
}