<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\DestroyRoleRequest;
use App\Http\Requests\ListRoleRequests;
use App\Http\Requests\StoreUpdateRoleRequest;
use App\Http\Requests\ViewRoleRequest;
use App\Repositories\Role\RoleRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * @var RoleRepositoryInterface|\App\Repositories\RepositoryInterface
     */

    protected $roleRepository;

    public function __construct(RoleRepositoryInterface $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function index()
    {
        //
    }

    public function getRolesPaginate(ListRoleRequests $request)
    {
        $whereData = [];
        $name = trim($request->input('name'));
        $pageSize = (int) $request->input('pageSize');
        if ($name) {
            $whereData[] = ['name', 'like', $name . '%'];
        }

        if ($pageSize) {
            $pageSize = $pageSize;
        } else {
            $pageSize = null;
        }

        $roles = $this->roleRepository->getRolsPaginate($pageSize, $whereData);
        $results = [
            'status' => 0,
            "message" => "Get Roles Success",
            'error' => [],
            'data' => $roles,
        ];
        return response()->json($results);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUpdateRoleRequest $request)
    {
        $request = $request->all();
        $idUser = Auth::id();
        $roleRequest = [
            'id' => uniqid(null, true),
            'name' => $request['name'],
            'description' => isset($request['description']) ? $request['description'] : null,
            'creator_id' => $idUser,
            'permissions' => isset($request['permissions']) ? array_combine($request['permissions'], $request['permissions']) : null,
        ];

        $idUsers = $request['groupUserId'];
        $roles = $this->roleRepository->createRole($roleRequest, $idUsers);

        if ($roles) {
            $results = [
                'status' => 0,
                "message" => "Create Role Success",
                'error' => [],
                'data' => $roles,
            ];
            return response()->json($results);
        }

        $results = [
            'status' => 1,
            "message" => "Create Role Error",
            'error' => [],
            'data' => [],
        ];

        return response()->json($results);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ViewRoleRequest $request, $id)
    {
        //
        $results = $this->roleRepository->show($id);
        if (!$results) {
            $results = [
                'status' => 1,
                "message" => "Get Role Error",
                'error' => [],
                'data' => [],
            ];
            return response()->json($results);
        }
        $results = [
            'status' => 0,
            "message" => "Update Role Success",
            'error' => [],
            'data' => $results,
        ];
        return response()->json($results);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUpdateRoleRequest $request, $id)
    {
        $request = $request->all();
        $idUser = Auth::id();
        $roleRequest = [
            'name' => $request['name'],
            'description' => isset($request['description']) ? $request['description'] : null,
            'creator_id' => $idUser,
            'permissions' => isset($request['permissions']) ? array_combine($request['permissions'], $request['permissions']) : null,
        ];

        $idUsers = $request['groupUserId'];
        $roles = $this->roleRepository->updateRole($id, $roleRequest, $idUsers);

        if ($roles) {
            $results = [
                'status' => 0,
                "message" => "Update Role Success",
                'error' => [],
                'data' => $roles,
            ];
            return response()->json($results);
        }

        $results = [
            'status' => 1,
            "message" => "Update Role Error",
            'error' => [],
            'data' => [],
        ];
        return response()->json($results);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DestroyRoleRequest $request, $id)
    {

        $role = $this->roleRepository->delete($id);
        if (!$role) {
            $results = [
                'status' => 1,
                "message" => "Delete Role Error",
                'error' => [],
                'data' => [],
            ];
            return response()->json($results);
        }

        $results = [
            'status' => 0,
            "message" => "Delete Role Success",
            'error' => [],
            'data' => $role,
        ];
        return response()->json($results);
    }
}
