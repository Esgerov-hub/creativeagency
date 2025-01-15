<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enlightenment extends Model
{
    use HasFactory;


    protected $table = 'enlightenments';

    protected $fillable = [
        'id',
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
}
