<?php
namespace App\Repositories\Role;

interface RoleRepositoryInterface
{
    public function createRole(array $roles, $usres);

    public function updateRole($id, array $roles, $usres);

    public function getRolsPaginate($limit, array $whereData, $columns = array('*'));

    public function show($id);
}
