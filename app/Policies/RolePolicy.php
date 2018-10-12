<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function view(User $user)
    {
        return $user->hasAccess('VIEW_ROLES');
    }

    public function getRolesPaginate(User $user)
    {
        return $user->hasAccess('LIST_ROLES');
    }

    public function create(User $user)
    {
        return $user->hasAccess('CREATE_ROLES');
    }

    public function update(User $user)
    {
        return $user->hasAccess('UPDATE_ROLES');
    }

    public function destroy(User $user)
    {
        return $user->hasAccess('DELETE_ROLES');
    }
}
