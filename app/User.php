<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    use SoftDeletes;

    protected $primaryKey = 'id';
    public $incrementing = false;

    protected $fillable = [
        'id', 'name', 'email', 'password', 'is_sadmin', 'is_active','phone_number',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'is_sadmin' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function roles()
    {
        return $this->belongsToMany('App\Models\Roles', 'role_usres', 'user_id', 'role_id');
    }

    public function hasAccess(string $permissions)
    {
        // check if the permission in $role
        foreach ($this->roles as $role) {
            if (array_search($permissions, $role->permissions)) {
                return true;
            }
        }
        return false;
    }
}
