<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TariffCategory extends Model
{
    use HasFactory;

    protected $table = 'tariff_categories';

    protected $fillable = [
        'id',
        'title',
        'slug',
        'image',
        'order_by',
        'status'
    ];

    protected $casts = [
        'title' => 'array',
        'slug' => 'array',
    ];

    public function tariffs(){
        return $this->hasMany(Tariff::class,'category_id','id')->where('status',1)->whereNull(['parent_id','sub_parent_id'])->with('parentTariff');
    }
}
