<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Role extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name',
        'guard_name'
    ];

    public function user(): BelongsToMany{
        return $this->hasOne(CmsUser::class);
    }

   /* public function permissions(): HasOne{
        return $this->hasOne(RolePermission::class);
    }*/
}
