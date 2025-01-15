<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tariff extends Model
{
    use HasFactory;

    protected $table = 'tariffs';

    protected $fillable = [
        'id',
        'category_id',
        'parent_id',
        'sub_parent_id',
        'title',
        'slug',
        'unit_of_measure',
        'service_charge',
        'order_by',
        'status'
    ];

    protected $casts = [
        'title' => 'array',
        'slug' => 'array',
        'unit_of_measure' => 'array',
        'service_charge' => 'array',
    ];


    public function parentTariff()
    {
        return $this->hasMany(Tariff::class,'parent_id','id')->whereNull('sub_parent_id')->with('subParentTariff');
    }

    public function subParentTariff()
    {
        return $this->hasMany(Tariff::class,'sub_parent_id','id');
    }
}
