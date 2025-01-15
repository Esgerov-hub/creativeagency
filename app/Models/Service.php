<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $table = 'services';

    protected $fillable = [
        'id',
        'image',
        'title',
        'slug',
        'text',
        'order_by',
        'status'
    ];

    protected $casts = [
        'title' => 'array',
        'text' => 'array',
        'slug' => 'array',
    ];

    public function scopeOrdered($query)
    {
        return $query->orderBy('order_by');
    }
}
