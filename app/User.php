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
        'id', 'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function roles()
    {
        return $this->belongsToMany('App\Models\Roles', 'role_users', 'user_id', 'role_id');
    }
}
