<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $table = 'cities';

    protected $fillable = [
        'id',
        'name',
        'slug',
        'enable',
        'abbreviation',
        'path',
        'xPos',
        'yPos',
        'srcWidth',
        'srcHeight'
    ];

    protected $casts = [
        'name' => 'array',
        'slug' => 'array',
    ];

    public function mainLaboratory(){
        return $this->hasOne(Laboratory::class,'city_id','id')->where(['status' => 1])->with(['laboratoryCategory'])->orderBy('id','DESC');
    }
}
