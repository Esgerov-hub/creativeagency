<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VirtualLaboratory extends Model
{
    use HasFactory;

    protected $table = 'virtual_laboratories';

    protected $fillable = [
        'id',
        'title',
        'slug',
        'link',
        'order_by',
        'status',
    ];

    public function scopeOrdered($query)
    {
        return $query->orderBy('order_by');
    }

    protected $casts = [
        'title' => 'array',
        'slug' => 'array',
    ];
}
