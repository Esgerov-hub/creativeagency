<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;

    protected $table = 'positions';

    protected $fillable = [
        'id',
        'parent_id',
        'title',
        'order_by',
        'status'
    ];

    protected $casts = [
        'title' => 'array'
    ];

    public function parent(){
        return $this->hasMany(Position::class,'parent_id','id');
    }

    public function leaderShip(){
        return $this->hasMany(LeaderShip::class,'position_id','id')->with('parent');
    }
}
