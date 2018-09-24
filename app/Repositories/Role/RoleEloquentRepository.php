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

    public function createRole(array $roles, array $usres)
    {

        try {
            DB::beginTransaction();

            $result = $this->_model->create($roles);
            if (!$result) {
                return null;
            }
            $result->users()->sync($usres);
            DB::commit();
            return $result;
        } catch (\Exception $e) {
            DB::rollBack();
            // return $e->getMessage();
            return null;
        }
    }

}
