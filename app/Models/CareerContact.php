<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CareerContact extends Model
{
    use HasFactory;
    protected $table = 'career_contacts';
    protected $fillable = [
        'id',
        'career_id',
        'name',
        'surname',
        'father_name',
        'birthday',
        'gender',
        'phone',
        'email',
        'address',
        'actual_address',
        'education',
        'experience',
        'language',
        'volunteer_expectations',
        'volunteer_differences',
        'is_volunteer',
        'voluntary_other_text',
        'voluntary_leaving_reason',
        'image',
        'resume',
        'datetime',
        'is_deleted',
        'is_vacancy',
    ];

    protected $casts = [
        'education' => 'array',
        'experience' => 'array',
        'language' => 'array',
    ];
}
