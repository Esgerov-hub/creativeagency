<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $table = 'news';

    protected $fillable = [
        'id',
        'category_id',
        'image',
        'slider_image',
        'title',
        'slug',
        'text',
        'fulltext',
        'order_by',
        'status',
        'is_main',
        'datetime'
    ];

    protected $casts = [
        'title' => 'array',
        'text' => 'array',
        'slug' => 'array',
        'fulltext' => 'array',
        'slider_image' => 'array',
    ];

    public function category(){
        return $this->hasOne(Category::class,'id','category_id')->where(['status'=>1]);
    }
}
