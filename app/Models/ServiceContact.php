<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceContact extends Model
{
    use HasFactory;

    protected $table = 'service_contacts';

    protected $fillable = [
        'id',
        'service_id',
        'full_name',
        'region_name',
        'tin_enterprise',
        'training_topic',
        'training_format',
        'employees_count',
        'contract_value',
        'application_example',
        'card_speed',
        'bank_visits',
        'power_of_attorney',
        'phone',
        'address',
        'note',
        'is_deleted',
        'datetime'
    ];
}
