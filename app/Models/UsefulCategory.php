<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsefulCategory extends Model
{
    use HasFactory;

    protected $table = 'useful_categories';

    protected $fillable = [
        'id',
        'parent_id',
        'sub_parent_id',
        'title',
        'slug',
        'order_by',
        'status',
        'page_type'
    ];

    public function scopeOrdered($query)
    {
        return $query->orderBy('order_by');
    }

    protected $casts = [
        'title' => 'array',
        'slug' => 'array',
    ];

    public function parentCategories()
    {
        return $this->hasMany(UsefulCategory::class,'parent_id','id')->whereNull('sub_parent_id')->with('subParentCategories');
    }

    public function subParentCategories()
    {
        return $this->hasMany(UsefulCategory::class,'sub_parent_id','id');
    }
}
