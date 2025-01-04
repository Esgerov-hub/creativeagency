<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthyEating extends Model
{
    use HasFactory;

    protected $table = 'healthy_eatings';
    protected $fillable = [
        'id',
        'image',
        'title',
        'slug',
        'link',
        'order_by',
        'status'
    ];

    protected $casts = [
        'title' => 'array',
        'slug' => 'array',
    ];
}
