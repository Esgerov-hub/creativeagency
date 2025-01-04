<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accreditation extends Model
{
    use HasFactory;

    protected $table = 'accreditations';

    protected $fillable = [
        'id',
        'category_id',
        'image',
        'title',
        'slug',
        'order_by',
        'status',
    ];

    protected $casts = [
        'title' => 'array',
        'slug' => 'array'
    ];
}
