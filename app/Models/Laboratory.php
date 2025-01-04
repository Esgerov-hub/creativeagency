<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laboratory extends Model
{
    use HasFactory;

    protected $table = 'laboratories';

    protected $fillable = [
        'id',
        'category_id',
        'city_id',
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

    public function city(){
        return $this->hasOne(City::class,'id','city_id')->where(['status' => 1]);
    }

    public function laboratoryCategory(){
        return $this->hasOne(LaboratoryCategory::class,'id','category_id')->where(['status' => 1]);
    }


}
