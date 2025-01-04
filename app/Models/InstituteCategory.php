<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstituteCategory extends Model
{
    use HasFactory;

    protected $table = 'institute_categories';

    protected $fillable = [
        'id',
        'title',
        'slug',
        'page_type',
        'order_by',
        'status'
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
