<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TBProduct_Category extends Model
{
    protected $table = 'TBProduct_Category';
    public $timestamps = false;

    protected $fillable = [
        'Product_ID', 
        'Category_ID', 
        'Create_by', 
        'Create_date', 
        'Update_by', 
        'Update_date',
    ];

    // ความสัมพันธ์กับ Product
    public function product()
    {
        return $this->belongsTo(TBProducts::class, 'Product_ID', 'ID');
    }

    // ความสัมพันธ์กับ Category
    public function category()
    {
        return $this->belongsTo(TBCategory::class, 'Category_ID', 'ID');
    }
}