<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * @var UserRepositoryInterface|\App\Repositories\RepositoryInterface
     */

    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
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
    public function store(StoreUserRequest $request)
    {
        $uersRequest = $request->all();
        $uersRequest['id'] = uniqid(null, true);
        $uersRequest['password'] = bcrypt($request->password);
        $uers = $this->userRepository->create($uersRequest);
        if ($uers) {
            $results = [
                'status' => 0,
                "message" => "Registration Success",
                'error' => [],
                'data' => $uers,
            ];
            return response()->json($results);
        }

        $results = [
            'status' => 1,
            "message" => "Registration error",
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
    public function update(Request $request, $id)
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
        $uers = $this->userRepository->delete($id);
    }
}
