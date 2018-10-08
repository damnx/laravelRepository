<?php
namespace App\Repositories\Role;

interface RoleRepositoryInterface
{
    public function createRole(array $roles, $usres);

    public function updateRole($id, array $roles, $usres);

    public function getRolsPaginate(array $whereData, $columns = array('*'));
}
