<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateRoleRequest;
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
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}