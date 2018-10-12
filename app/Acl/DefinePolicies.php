<?php
namespace App\Acl;

use Illuminate\Support\Facades\Gate;

class DefinePolicies
{
    private static $abilities = [
      
        //Roles
        'CREATE_ROLES' => 'App\Policies\RolePolicy@create',
        'UPDATE_ROLES' => 'App\Policies\RolePolicy@update',
        'LIST_ROLES' => 'App\Policies\RolePolicy@getRolesPaginate',
        'VIEW_ROLES' => 'App\Policies\RolePolicy@view',
        'DELETE_ROLES' => 'App\Policies\RolePolicy@destroy',
        
    ];

    public static function defineAbilities()
    {
        foreach (self::$abilities as $key => $value) {
            Gate::define($key, $value);
        }
    }
}
