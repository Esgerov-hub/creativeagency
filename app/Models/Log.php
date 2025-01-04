<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $table = 'logs';

    protected $fillable = [
        'user_id', 'subj_id', 'subj_table', 'description', 'ip_address', 'datetime'
    ];


    public function cms_user(){
        return $this->hasOne(CmsUser::class,'id','user_id');
    }
}
