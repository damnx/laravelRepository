<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleUsers extends Model
{
    protected $table = 'role_usres';
    protected $fillable = [
        'user_id', 'role_id',
    ];
}
