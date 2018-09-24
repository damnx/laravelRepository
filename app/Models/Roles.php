<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Roles extends Model
{
    use SoftDeletes;
    protected $table = 'roles';

    protected $primaryKey = 'id';
    public $incrementing = false;

    protected $fillable = [
        'id', 'name', 'permissions', 'description', 'creator_id',
    ];

    protected $casts = [
        'permissions' => 'array',
    ];

    public function users()
    {
        return $this->belongsToMany('App\User', 'role_usres', 'role_id', 'user_id');
    }

}
