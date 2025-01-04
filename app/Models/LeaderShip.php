<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaderShip extends Model
{
    use HasFactory;

    protected $table = 'leaderships';

    protected $fillable = [
        'id',
        'category_id',
        'position_id',
        'parent_position_id',
        'image',
        'full_name',
        'slug',
        'fulltext',
        'reception_days',
        'order_by',
        'status'
    ];

    protected $casts = [
        'full_name' => 'array',
        'slug' => 'array',
        'fulltext' => 'array',
        'reception_days' => 'array',
    ];

    public function position(){
        return $this->hasOne(Position::class,'id','position_id');
    }
    public function positionParent(){
        return $this->hasOne(Position::class,'id','parent_position_id');
    }
}
