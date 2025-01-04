<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    use HasFactory;

    protected $table = 'abouts';

    protected $fillable = [
        'id',
        'category_id',
        'slider_image',
        'title',
        'text',
        'fulltext'
    ];

    protected $casts = [
        'title' => 'array',
        'text' => 'array',
        'fulltext' => 'array',
        'slider_image' => 'array',
    ];
}
