<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Career extends Model
{
    use HasFactory;

    protected $table = 'careers';

    protected $fillable = [
        'id',
        'title',
        'slug',
        'full_text',
        'datetime',
        'order_by',
        'status'
    ];

    protected $casts = [
        'title' => 'array',
        'slug' => 'array',
        'full_text' => 'array',
    ];
}
