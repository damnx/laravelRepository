<?php
namespace App\Repositories\Role;

interface RoleRepositoryInterface
{
    public function createRole(array $roles, array $usres);
}
