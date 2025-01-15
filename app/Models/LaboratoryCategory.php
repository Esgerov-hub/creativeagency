<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaboratoryCategory extends Model
{
    use HasFactory;

    protected $table = 'laboratory_categories';

    protected $fillable = [
        'id',
        'title',
        'slug',
        'order_by',
        'status'
    ];

    protected $casts = [
        'title' => 'array',
        'slug' => 'array',
    ];

    public function scopeOrdered($query)
    {
        return $query->orderBy('order_by');
    }

    public function laboratory()
    {
        return $this->hasMany(Laboratory::class,'category_id','id')->where('status',1);
    }
}
