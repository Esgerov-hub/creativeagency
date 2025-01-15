<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    protected $table = 'sliders';

    protected $fillable = [
        'id',
        'image',
        'link',
        'title',
        'text',
        'fulltext',
        'order_by',
        'status'
    ];

    protected $casts = [
        'title' => 'array',
        'text' => 'array',
    ];
}
