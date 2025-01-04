<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Structure extends Model
{
    use HasFactory;

    protected $table = 'structures';

    protected $fillable = [
        'id',
        'category_id',
        'position_id',
        'parent_position_id',
        'file',
        'full_name',
        'title',
        'slug',
        'text',
        'fulltext',
        'reception_days',
        'email',
        'phone',
        'order_by',
        'status'
    ];

    protected $casts = [
        'full_name' => 'array',
        'title' => 'array',
        'text' => 'array',
        'fulltext' => 'array',
        'slug' => 'array',
        'reception_days' => 'array',
    ];

    public function parent(){
        return $this->hasOne(Position::class,'id','parent_position_id');
    }
}
