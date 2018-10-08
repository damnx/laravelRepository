<?php
namespace App\Repositories\Role;

use App\Models\Roles;
use App\Repositories\EloquentRepository;
use Illuminate\Support\Facades\DB;

class RoleEloquentRepository extends EloquentRepository implements RoleRepositoryInterface
{
    public function getModel()
    {
        return Roles::class;
    }

    public function createRole(array $roles, $usres)
    {
        try {
            DB::beginTransaction();
            $result = EloquentRepository::create($roles);
            if (!$result) {
                return null;
            }
            $result->users()->sync($usres);
            DB::commit();
            return $result;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
            return null;
        }
    }

    public function updateRole($id, array $roles, $usres)
    {
        try {
            DB::beginTransaction();
            $result = EloquentRepository::update($id, $roles);
            if (!$result) {
                return null;
            }
            $result->users()->sync($usres);
            DB::commit();
            return $result;
        } catch (\Exception $e) {
            DB::rollBack();
            return null;
        }
    }

    public function getRolsPaginate(array $whereData, $columns = array('*'))
    {
        $result = EloquentRepository::with('users')->whereArray($whereData)->paginate();
        return $result;
    }

}
