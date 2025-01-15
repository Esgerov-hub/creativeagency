<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Useful extends Model
{
    use HasFactory;

    protected $table = 'useful';

    protected $fillable = [
        'id',
        'category_id',
        'parent_category_id',
        'sub_parent_category_id',
        'page_type',
        'file',
        'image',
        'slider_image',
        'title',
        'slug',
        'text',
        'fulltext',
        'order_by',
        'status',
        'datetime'
    ];

    protected $casts = [
        'title' => 'array',
        'text' => 'array',
        'slug' => 'array',
        'fulltext' => 'array',
        'slider_image' => 'array',
    ];

    public function category()
    {
        return $this->hasOne(UsefulCategory::class,'id','category_id')->where(['status' => 1,'parent_id' => null]);
    }

    public function parentCategory()
    {
        return $this->hasOne(UsefulCategory::class,'id','parent_category_id')->where(['status' => 1,'sub_parent_id' => null]);
    }

    public function subParentCategory()
    {
        return $this->hasOne(UsefulCategory::class,'id','sub_parent_category_id')->where(['status' => 1]);
    }
}
