<?php
namespace App\Repositories\Role;

interface RoleRepositoryInterface
{
    public function createRole(array $roles, array $usres);

    public function updateRole($id, array $roles, array $usres);

    public function getRolsPaginate(array $whereData, $columns = array('*'));
}
