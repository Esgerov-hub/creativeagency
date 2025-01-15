<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;

    protected $table = 'complaints';

    protected $fillable = ['id', 'title', 'text', 'contact', 'block', 'file', 'created_at', 'updated_at'];

    protected $casts = [
        'title' => 'array',
        'text' => 'array',
        'contact' => 'array',
        'block' => 'array',
        'file' => 'array',
    ];
}
