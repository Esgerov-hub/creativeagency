<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermissionLabel extends Model
{
    use HasFactory;

    protected $table = 'permission_labels';
    protected $guarded = [];
    protected $fillable=[
        'label'
    ];
    public function permissions(){
        return $this->hasMany(Permisson::class,'label','label');
    }
}
