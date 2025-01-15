<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Charter extends Model
{
    use HasFactory;

    protected $table = 'charters';

    protected $fillable = [
        'id',
        'category_id',
        'file',
        'title',
        'text',
        'fulltext'
    ];

    protected $casts = [
        'title' => 'array',
        'text' => 'array',
        'fulltext' => 'array'
    ];
}
