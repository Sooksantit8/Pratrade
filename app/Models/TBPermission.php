<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TBPermission extends Model
{
    use HasFactory;

    protected $table = 'TBPermission';
    protected $primaryKey = 'Permission_Code';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'Permission_Code',
        'Permission_Name',
        'Required_Package',
        'Active',
        'Create_by',
        'Create_date',
        'Update_by',
        'Update_date',
    ];

    protected $casts = [
        'Required_Package' => 'boolean',
        'Active' => 'boolean',
        'Create_date' => 'datetime',
        'Update_date' => 'datetime',
    ];

    // Relation กับ TBUser
    public function users()
    {
        return $this->hasMany(TBUser::class, 'Permission_Code', 'Permission_Code');
    }
}