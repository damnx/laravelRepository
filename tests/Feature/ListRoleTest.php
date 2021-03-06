<?php

namespace Tests\Feature;

use App\Models\Roles;
use Tests\OAuthTestCase;

class ListRoleTest extends OAuthTestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */

    protected $data;
    private $tokenUpdateRole;

    public function setUp()
    {
        parent::setUp();
        $this->tokenUpdateRole = $this->tokenPermission(['LIST_ROLES' => 'LIST_ROLES']);
        $role = [
            'name' => 'damnx ' . $this->faker->name,
        ];
        $this->data = factory(Roles::class, 25)->create($role);
    }

    /**
     *
     * Chưa xác thực login
     * Data bất kỳ
     * input: token sai
     * output: trả về mã lỗi 401
     */

    public function testResponse401()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token . str_random(3),
        ])->get('api/roles/');
        $response->assertStatus(401);
    }

    /**
     *  Không phân quyền
     * pre data: user không có quyền
     * input: data
     * output: trả về mã lỗi 403
     */

    public function testResponse403()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token,
        ])->get('api/roles/');
        $response->assertStatus(403);
    }

    /**
     *  Không tìm thấy trang
     * pre data: user có quyền
     * input: data
     * output: trả về mã lỗi 404
     */

    public function testResponse404()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->tokenUpdateRole,
        ])->get('api/roless/');
        $response->assertStatus(404);
    }

    /**
     * get list role thành công phân trang số bản ghi constants.limit
     * pre data: user có quyền
     * output:
     *          status = 0
     *          count($content['data']['data']) = 20
     */
    public function testGetListPaginateSuccess()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->tokenUpdateRole,
        ])->get('api/roles/');

        $content = json_decode($response->content(), true);
        $this->assertEquals(config('constants.limit'), count($content['data']['data']));
    }

    /**
     * get list role page = 1, Search name like damnx% và limit = config('constants.limit')
     * pre data: user có quyền
     * output:
     *          status = 0
     *          count($content['data']['data']) = 20
     */
    public function testGetListSearchPaginateSuccess()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->tokenUpdateRole,
        ])->get('api/roles?name=damnx');

        $content = json_decode($response->content(), true);
        $this->assertEquals(config('constants.limit'), count($content['data']['data']));
    }
}
