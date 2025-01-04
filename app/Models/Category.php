<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'id',
        'title',
        'slug',
        'order_by',
        'status'
    ];

    protected $casts = [
        'title' => 'array',
        'slug' => 'array',
    ];

    public function news()
    {
        return $this->hasMany(News::class,'category_id','id')->where(['status' => 1])->orderBy('datetime','DESC');
    }
}
